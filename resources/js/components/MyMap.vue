<template>
    <div id="map" ref="map">
        <map-marker v-for="location in locations" :key="location.id" :lat="location.lat" :lng="location.lon" :icon="location.breed.image" :breed="location.breed.name"></map-marker>
    </div>
</template>

<script>
	import MapMarker from "./MapMarker"
	import API from "../api"
    export default {
		components: {
			MapMarker,
		},
        data() {
            return {
                checking: false,
                map: null,
                locations: []
            };
        },
		methods: {
			getMap(callback) {
				let vm = this
				function checkForMap() {
					if (vm.map) callback(vm.map)
					else setTimeout(checkForMap, 200)
				}
				checkForMap()
			},
            getLocations (neLat = null, neLng = null, swLat = null, swLng = null) {
                if (!this.checking) {
                    this.checking = true;
                    API.get(`locations/box?nelat=${neLat}&nelng=${neLng}&swlat=${swLat}&swlng=${swLng}`)
                    .then(response => this.locations = response.data)
                    .catch(err => console.error("Fail", err))
                    .finally(() => this.checking = false);
                }
            },
            getCurrentPosition() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            const pos = {
                                lat: position.coords.latitude,
                                lng: position.coords.longitude,
                            };
                            this.map.setCenter(pos);
                            this.handleViewChange();
                        },
                        () => {
                            console.error("Error: The Geolocation service failed.")
                        }
                    );
                } else {
                    console.error("Error: Your browser doesn't support geolocation.")
                }
            },
            handleViewChange() {
                const bounds = this.map.getBounds();
                const center = this.map.getCenter();

                if (bounds) {
                    const ne = bounds.getNorthEast(); // LatLng of the north-east corner
                    const sw = bounds.getSouthWest(); // LatLng of the south-west corder

                    // update the locations here
                    this.getLocations(ne.lat(), ne.lng(), sw.lat(), sw.lng());
                }
                
                if (center) {
                    this.$store.commit('updateLocation', { lat: center.lat(), lng: center.lng()} )
                }
            }
		},
        mounted() {
            // The location of Uluru
            const uluru = { lat: -25.344, lng: 131.036 };
            // The map, centered at Uluru
            this.map = new google.maps.Map(this.$refs["map"], {
                zoom: 13,
                center: uluru,
            });

            this.getCurrentPosition();

            google.maps.event.addListener(this.map, 'idle', () => this.handleViewChange());
            
        },
    }
</script>
