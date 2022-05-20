<template>
    <div class="flex flex-col w-full h-full items-center justify-center">
        <form @submit.prevent="checkScannedComponent()" class="bg-white shadow border px-3 py-1.5 flex flex-col w-1/3 space-y-3">
            <h3 class="font-semibold text-xl text-center">Scaneaza componentele aditionale</h3>
            <div class="flex w-full" v-for="(component, index) in moreToScanValues" :key="component">
                <input type="text" v-if="scanStep === index" class="border px-4 py-3 text-lg bg-gray-50 w-full" autofocus required v-model="scanned_component">
            </div>
            <div class="flex flex-row w-full bg-red-200 px-3 py-1.5 rounded-sm items-center justify-center space-x-3" v-if="wrong_code">
                <i class="fa-solid fa-triangle-exclamation text-red-500 animate-pulse"></i>
                <h3 class="text-lg font-bold text-red-500 ">Eticheta scanata este gresita</h3>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-3 py-2 font-bold">
                <i class="fa-solid fa-shoe-prints"></i>
                Pasul urmator
            </button>
        </form>
    </div>
</template>

<script>
import { mainStore } from '../../store/index';
import { storeToRefs } from 'pinia';
export default {
    name: "AdditionalScans",
    setup() {
        const store = mainStore();
        const { moreToScan, moreToScanValues } = storeToRefs(store);

        return {
            moreToScan,
            moreToScanValues
        }
    },
    data() {
        return {
            scanStep: 0,
            scanned_component: "",
            wrong_code: false,
        }
    },
    methods: {
        checkScannedComponent() {
            if(this.scanned_component === this.moreToScanValues[this.scanStep]) {
                this.wrong_code = false;
                this.scanStep++;
                console.log(this.moreToScanValues[this.scanStep]);
                if(this.scanStep === this.scanSteps) {
                    this.moreToScan = false;
                } else {
                    this.scanned_component = "";
                }
            } else {
                this.wrong_code = true;
            }
        }
    },  
    computed: {
        scanSteps() {
            return this.moreToScanValues.length;
        }
    }
}
</script>

<style>

</style>