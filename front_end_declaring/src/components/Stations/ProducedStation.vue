<template>
    <h3 class="font-bold text-lg text-center">Alege statia unde s-a produs defectul</h3>
    <div class="flex flex-row flex-wrap w-full">
        <div class="flex flex-row w-1/2" v-for="station in stations" :key="station.id">
            <stations-button :station="station"></stations-button>
        </div>
    </div>
</template>

<script>
import { mainStore } from '../../store/index.js';
import { storeToRefs } from 'pinia';
import StationsButton from '../Buttons/StationsButton.vue';
export default {
    name: "ProducedStation",
    setup() {
        const store = mainStore();
        const { stations } = storeToRefs(store);

        return {
            stations,
        }
    },
    components: {
        StationsButton,
    }
}
</script>

<style>

</style>