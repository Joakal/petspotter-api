<template>
    <form method="post" v-on:submit="onSubmit">
        <h2>Pupper details</h2>
        <input type="hidden" name="_token" :value="this.spotdog">
        <div class="form-field">
            <label for="name">Pupper's name</label>
            <input type="text" placeholder="Name of Pupper" v-model.trim="location.name" />
        </div>
        <div class="form-field">
            <label for="breed">Pupper's breed</label>
            <SearchDropdown @on-item-selected="dropdownSelection = $event" @on-item-reset="dropdownSelection = {}" v-model="location.breed_id" placeholder="Find the breed" apiUrl="breeds" imageUrl="//petspotter.joakal.com/image/" />
        </div>
        <div class="form-field">
            <label for="time">When did you see this pupper?</label>
            <span>
                <input type="time" v-model="location.time" step="any"/>
                <input type="date" v-model="location.date" />
            </span>
        </div>
        <input type="submit" class="submit-button" />
    </form>
</template>

<script>
    import API from "../api"
    import SearchDropdown from "./SearchDropdown";

    export default {
        data: () => ({
            spotdog: false,
            dropdownSelection: {},
            location: {
                name: '',
                breed_id: null,
                time: new Date().toTimeString().split(" ")[0],
                date: new Date().toISOString().slice(0, 10),
                datetime: ''
            },
            submission: false
        }),
        methods: {
            onSubmit(event) {
                event.preventDefault();
                const { lat, lng: lon } = this.$store.state.currentLocation;

                this.location.datetime = new Date(this.location.date + ' ' + this.location.time).toISOString();
                this.location.breed_id = this.dropdownSelection.id;
                
                this.submission = true;
                API.post(`locations`, {...this.location, lat, lon})
                .then(res => this.hide())
                .catch(err => {
                    console.error("Fail", err)}
                )
                .finally(() => {this.submission = false;});

            },
            hide () {
                this.$modal.hide('spotdog-modal');
            }
        },
        components: {
            SearchDropdown
        }
    }
</script>
