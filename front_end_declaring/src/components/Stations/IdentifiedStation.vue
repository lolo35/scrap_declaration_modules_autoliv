<template>
    <h3 class="font-bold text-lg text-center">Alege statia unde s-a identificat defectul</h3>
    <div class="flex flex-row flex-wrap w-full">
        <div class="flex flex-row w-1/2" v-for="station in stations" :key="station.id">
            <identified-station-button :station="station"></identified-station-button>
        </div>
    </div>
</template>

<script>
import { mainStore } from '../../store/index.js';
import { storeToRefs } from 'pinia';
import IdentifiedStationButton from '../Buttons/IdentifiedStationButton.vue';
export default {
    name: "IdentifiedStation",
    setup() {
        const store = mainStore();
        const { stations } = storeToRefs(store);

        return {
            stations,
        }
    },
    components: {
        IdentifiedStationButton,
    }
}
</script>

<style>

</style>