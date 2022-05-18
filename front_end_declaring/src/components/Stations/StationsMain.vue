<template>
    <div class="flex flex-col items-center justify-center w-full px-3 py-1.5">
        <div class="flex flex-col items center justify-center w-2/3 px-3 py-1.5 space-y-3">
            <h2 class="text-2xl font-bold text-center">Pasul <span class="italic">{{ declare_step }}</span></h2>
            <produced-station v-if="declare_step === 1"></produced-station>
            <identified-station v-if="declare_step === 2"></identified-station>
            <defect-codes v-if="declare_step === 3"></defect-codes>
            <div class="flex flex-row">
                <button class="bg-green-500 hover:bg-green-700 text-white font-bold w-full px-3 py-5 rounded-sm" @click="nextStep()" v-if="isProducedStationSelected && declare_step === 1">
                    <i class="fa-solid fa-shoe-prints"></i>
                    Pasul urmator
                </button>
                <button class="bg-green-500 hover:bg-green-700 text-white font-bold w-full px-3 py-5 rounded-sm" @click="nextStep()" v-if="isIdentifiedStationSelected && declare_step === 2">
                    <i class="fa-solid fa-shoe-prints"></i>
                    Pasul urmator
                </button>
                <button class="bg-green-500 hover:bg-green-700 text-white font-bold w-full px-3 py-5 rounded-sm" @click="nextStep()" v-if="isDefectCodeSelected && declare_step === 3">
                    <i class="fa-solid fa-trash-can"></i>
                    Declara Scrap
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { storeToRefs } from 'pinia';
import { mainStore } from '../../store/index';
import ProducedStation from './ProducedStation.vue';
import IdentifiedStation from './IdentifiedStation.vue';
import DefectCodes from './DefectCodes.vue';

export default {
    name: "StationsMain",
    setup() {
        const store = mainStore();
        const { 
            selected_line, 
            selected_part, 
            stations,
            declare_step,
            produced_station,
            identified_station,
            defect_codes,
            defectCode,
            } = storeToRefs(store);

        return {
            selected_line,
            selected_part,
            stations,
            declare_step,
            produced_station,
            identified_station,
            defect_codes,
            defectCode
        }
    },
    components: {
        ProducedStation,
        IdentifiedStation,
        DefectCodes
    },
    data() {
        return {

        }
    },
    created() {
        try {
            this.fetchStationsForPart();
            this.fetchDefectCodes();
        } catch (exception) {
            if(process.env.NODE_ENV === "development") console.error(exception);
        }
    },
    methods: {
        async fetchStationsForPart(){
            try {
                const response = await this.$axios.get(`stations/?line_id=${this.selected_line.id}&part_id=${this.selected_part.id}`);
                if(process.env.NODE_ENV === "development") console.log(response.data);
                if(response.data.success) {
                    this.stations = response.data.stations;
                }
            } catch (exception) {
                throw new Error(exception);
            }
        },
        async fetchDefectCodes(){
            try {
                const response = await this.$axios.get(`defect_codes/`);
                if(process.env.NODE_ENV === "development") console.log(response.data);
                if(response.data.success) {
                    this.defect_codes = response.data.defect_codes;
                }
            } catch (exception) {
                throw new Error(exception);
            }
        },
        async declareDefect() {
            this.declare_step = 1;
            this.produced_station = {};
            this.identified_station = {};
            this.defectCode = {};
        },
        nextStep(){
            this.declare_step++;
        }
    },
    computed: {
        isProducedStationSelected(){
            return Object.keys(this.produced_station).length === 0 ? false : true;
        },
        isIdentifiedStationSelected() {
            return Object.keys(this.identified_station).length === 0 ? false : true;
        },
        isDefectCodeSelected() {
            return Object.keys(this.defectCode).length === 0 ? false : true;
        }
    }
}
</script>

<style>

</style>