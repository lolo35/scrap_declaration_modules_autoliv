import { defineStore } from 'pinia';

export const mainStore = defineStore('main', {
    state: () => {
        return {
            isScanned: false,
            scanned_component: {},
            ok_components: [],
            scrap_components: [],
            moreToScan: false,
            moreToScanValues: []
        }
    }
});