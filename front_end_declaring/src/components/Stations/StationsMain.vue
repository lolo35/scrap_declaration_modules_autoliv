<template>
    <div class="flex flex-col items-center justify-center w-full px-3 py-1.5">
        <div class="flex flex-col items center justify-center w-2/3 px-3 py-1.5 space-y-3">
            <div class="flex flex-row bg-white shadow border px-4 py-5 w-full items-center justify-center space-x-3">
                <h2 class="text-2xl font-bold text-center">Pasul <span class="italic">{{ declare_step }}</span></h2>
                <button 
                class="bg-red-500 w-6 h-6 text-white rounded-full transform transition-all hover:bg-red-600 hover:w-32 duration-75" 
                @click="resetSteps()"
                @mouseenter="showFullResetButton = true" 
                @mouseleave="showFullResetButton = false">
                    <i class="fa-solid fa-rotate-left"></i>
                    <span v-if="showFullResetButton">Resetare pasi</span>
                </button>
            </div>
            <produced-station v-if="declare_step === 1"></produced-station>
            <identified-station v-if="declare_step === 2"></identified-station>
            <defect-codes v-if="declare_step === 3"></defect-codes>
            <check-for-scan v-if="declare_step === 4"></check-for-scan>
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
                    <i class="fa-solid fa-shoe-prints"></i>
                    Pasul urmator
                </button>
            </div>
        </div>
    </div>
    <div class="fixed -top-10 bottom-0 right-0 left-0 bg-black opacity-30 z-10" v-if="declared_successfully"></div>
    <div class="fixed -top-10 bottom-0 right-0 left-0 z-20" v-if="declared_successfully">
        <div class="flex flex-col w-full h-full items-center justify-center ">
            <div class="flex flex-col w-1/3 bg-white px-3 py-6 shadow border rounded-sm space-y-5">
                <div class="flex flex-row justify-center w-full items-center space-x-5">
                    <i class="fa-solid fa-circle-check fa-2x text-green-500"></i>
                    <h3 class="text-xl font-bold">Defectul a fost declarat</h3>
                </div>
                <div class="flex flex-row px-3 py-1">
                    <button class="bg-green-500 text-white px-3 py-2 font-bold text-lg w-full" @click="declared_successfully = false">Ok</button>
                </div>
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
import CheckForScan from './CheckForScan.vue';

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
            declared_successfully,
            } = storeToRefs(store);

        return {
            selected_line,
            selected_part,
            stations,
            declare_step,
            produced_station,
            identified_station,
            defect_codes,
            defectCode,
            declared_successfully
        }
    },
    components: {
        ProducedStation,
        IdentifiedStation,
        DefectCodes,
        CheckForScan,
    },
    data() {
        return {
            showFullResetButton: false,
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
        nextStep(){
            this.declare_step++;
        },
        resetSteps() {
            this.declare_step = 1;
            this.produced_station = {};
            this.identified_station = {};
            this.defectCode = {};
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