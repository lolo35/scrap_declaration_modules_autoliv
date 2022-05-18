<template>
    <button 
        class="bg-blue-500 w-full hover:bg-blue-700 px-10 py-6 text-white font-bold rounded-sm mr-2 mt-2" 
        :class="{'bg-green-500': this.produced_station.id === this.station.id}"
        @click="selectStation()">
        <i class="fa-solid fa-gear"></i>
        {{ station.l2l_station }} - Statia {{ station.station_number }}
    </button>
</template>

<script>
import { mainStore } from '../../store/index';
import { storeToRefs } from 'pinia';
export default {
    name: "StationsButton",
    setup() {
        const store = mainStore();
        const { produced_station } = storeToRefs(store);

        return {
            produced_station,
        }
    },
    props: {
        station: Object,
        produced: {
            type: Boolean,
            default: true,
        }
    },
    methods: {
        selectStation() {
            this.produced_station = this.station;
        }
    }
}
</script>

<style>

</style>