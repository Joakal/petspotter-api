<script>
export default {
    props: {
        lat: { type: Number, required: true },
        lng: { type: Number, required: true },
        icon: { type: String },
        breed: { type: String }
    },
    data: () => ({
        marker: null,
        url: '//petspotter.joakal.com/image/'
    }),
    mounted() {
        this.$parent.getMap(map => {
            const fullUrl = this.url + this.icon;
            this.marker = new google.maps.Marker({
                position: { lat: this.lat, lng: this.lng },
                icon: {
                    url: this.url + this.icon,
                    scaledSize: new google.maps.Size(30, 30),
                },
                map
            });

        });
    },
    beforeDestroy() {
        this.marker.setMap(null);
        google.maps.event.clearInstanceListeners(this.marker);
    },
    render() {
        return null;
    }
};
</script>
