<template>
    <div class="spotdog">
        <button v-on:click='show()'>Pupper spotted!</button>
        <modal name="spotdog-modal" :adaptive="true" :height="430">
            <dog-form />
        </modal>
    </div>
</template>

<script>
	import DogForm from "./DogForm"
    export default {
		components: {
			DogForm,
		},
        data: () => ({
            spotdog: false
        }),
        methods: {
            show () {
                this.$modal.show('spotdog-modal');
            }
        }
    }
</script>
