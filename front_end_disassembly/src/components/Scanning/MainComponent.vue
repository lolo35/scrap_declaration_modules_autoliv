<template>
    <div class="flex flex-col w-full h-full items-center justify-center">
        <form @submit.prevent="fetchDefect()" class="bg-white shadow border px-3 py-1.5 flex flex-col w-1/3 space-y-3">
            <h2 class="text-xl font-bold text-center">Scaneaza componentul pentru a incepe</h2>
            <input type="text" class="border px-4 py-3 text-lg bg-gray-50" autofocus required v-model="scanned_code">
            <button type="submit" class="bg-blue-500 text-white px-3 py-2 font-bold">
                <i class="fa-solid fa-play"></i>
                Incepe
            </button>
        </form>
    </div>
</template>

<script>
import { mainStore } from '../../store/index';
import { storeToRefs } from 'pinia';
export default {
    name: "MainComponent",
    setup() {
        const store = mainStore();
        const { isScanned, scanned_component, moreToScan, moreToScanValues } = storeToRefs(store);

        return {
            isScanned,
            scanned_component,
            moreToScan,
            moreToScanValues
        }
    },
    data() {
        return {
            scanned_code: ""
        }
    },
    methods: {
        async fetchDefect() {
            try {
                const response = await this.$axios.get(`disassembly/defect?label=${this.scanned_code}`);
                if(process.env.NODE_ENV === "development") console.log(response.data);
                if(response.data.success && !response.data.moreToScan) {
                    this.scanned_component = response.data.data;
                    this.isScanned = true;
                } else if(response.data.success && response.data.moreToScan) {
                    this.isScanned = true;
                    this.moreToScan = true;
                    this.moreToScanValues = response.data.toBeScanned;
                    this.scanned_component = response.data.data;
                }
            } catch (exception) {
                throw new Error(exception);
            }
        }
    }
}
</script>

<style>

</style>