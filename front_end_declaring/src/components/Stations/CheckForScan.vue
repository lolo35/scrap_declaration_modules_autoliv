<template>
    <div class="flex flex-row w-full flex-wrap" v-if="scanSteps > 0">
        <div class="flex flex-row w-full" v-for="(component,index) in components" :key="component[0].id">
            <div class="flex flex-col w-full items-center justify-center space-y-2" v-if="index === scanStep">
                <h2 class="text-xl font-bold">Scaneaza "<span class="italic text-blue-700">{{ component[0].description }} - {{ component[0].part_number }}</span>"</h2>
                <input type="text" v-model="scanned[component[0].part_number]" class="px-6 py-4 w-full" autofocus :placeholder="component[0].description">
                <div class="bg-red-200 px-6 py-4 w-full" v-if="fetchString(component[0].part_number, component[0].label_formula) !== component[0].label_formula && isSomethingScanned(component[0].part_number)">
                    <h2 class="font-bold text-red-500 text-center text-xl">
                        <i class="fa-solid fa-triangle-exclamation animate-pulse"></i>
                        Codul scanat nu este corect
                    </h2>
                </div>
                <button @click="nextStep()" v-if="fetchString(component[0].part_number, component[0].label_formula) === component[0].label_formula" class="bg-green-500 hover:bg-green-700 text-white font-bold w-full px-3 py-5 rounded-sm">
                    <i class="fa-solid fa-shoe-prints mr-3" v-if="index < (scanSteps - 1)"></i>
                    <i class="fa-solid fa-trash-can mr-3" v-if="index >= (scanSteps - 1)"></i>
                    <span v-if="index < (scanSteps - 1)">Urmatorul pas</span>
                    <span v-if="index >= (scanSteps - 1)">Declara defectul</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { mainStore } from '../../store/index';
import { storeToRefs } from 'pinia';

export default {
    name: "CheckForScan",
    setup() {
        const store = mainStore();
        const { 
            produced_station, 
            identified_station, 
            defectCode, 
            declare_step,
            selected_part,
            selected_line,
            declared_successfully
        } = storeToRefs(store);

        return {
            produced_station,
            identified_station,
            defectCode,
            declare_step,
            selected_part,
            selected_line,
            declared_successfully
        }
    },
    data(){
        return {
            components: [],
            scanStep: 0,
            scanned: {}
        }
    },
    created() {
        try {
            this.checkForScan();
        } catch (exception) {
            if(process.env.NODE_ENV === "development") {
                console.error(exception);
            }
        }
    },
    methods: {
        fetchString(index, formula){
            if(typeof this.scanned[index] !== 'undefined'){
                let string = this.scanned[index];
                //console.log(string.slice(0, formula.length));
                return string.slice(0, formula.length);
            }
        },
        isSomethingScanned(index){
            if(typeof this.scanned[index] !== 'undefined'){
                let string = this.scanned[index];
                if(string.length > 0) {
                    return true;
                }
            }
            return false;
        },
        async checkForScan(){
            try {
                const response = await this.$axios.get(`check_for_scan/?station_id=${this.identified_station.id}`);
                if(process.env.NODE_ENV === "development") console.log(response.data);
                if(response.data.success && response.data.data.length > 0) {
                    this.components = response.data.data;
                } else {
                    this.declareDefect();
                }
            } catch (exception) {
                throw new Error(exception);
            }
        },
        nextStep() {
            this.scanStep++;
            if(this.scanStep === this.scanSteps){
                this.declareDefect();
            }
        },
        async declareDefect() {
            try {
                let formData = {
                    'finit': this.selected_part.part,
                    'line': this.selected_line.linecode,
                    'defect_code': this.defectCode.code,
                    'identified_station': this.identified_station.id,
                    'produced_station': this.produced_station.id,
                    'label': this.jsonScanned,
                };

                const response = await this.$axios.post(`declare_scrap`, formData);
                if(process.env.NODE_ENV === "development") console.log(response.data);
                if(response.data.success) {
                    this.declare_step = 1;
                    this.produced_station = {};
                    this.identified_station = {};
                    this.defectCode = {};
                    this.declared_successfully = true;
                }
            } catch (exception) {
                throw new Error(exception);
            }
        },
    },
    computed: {
        scanSteps() {
            return this.components.length;
        },
        jsonScanned(){
            return JSON.stringify(this.scanned);
        }
    }
}
</script>

<style>

</style>