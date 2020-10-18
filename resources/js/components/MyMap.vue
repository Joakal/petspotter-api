<template>
    <div id="map" ref="map">
        <map-marker v-for="location in locations" :key="location.id" :lat="location.lat" :lng="location.lon"></map-marker>
    </div>
</template>

<script>
	import MapMarker from "./MapMarker"
    export default {
		components: {
			MapMarker,
		},
        data() {
            return {
                map: null,
                locations: [{
                    id: 1,
                    lat: -25.344, lon: 131.036
                }]
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
			}
		},
        mounted() {
            // The location of Uluru
            // TODO set location to browser location or default to uluru
            const uluru = { lat: -25.344, lng: 131.036 };
            // The map, centered at Uluru
            this.map = new google.maps.Map(this.$refs["map"], {
                zoom: 4,
                center: uluru,
            });

            // TODO get locations from backend
        },
    }
</script>
