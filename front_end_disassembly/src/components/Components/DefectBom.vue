<template>
    <div class="flex flex-col w-full h-full items-center justify-center">
        <div class="flex flex-col bg-white shadow border px-3 py-1.5 w-2/3 space-y-3">
            <h2 class="font-bold text-xl text-center">BOM-ul defectului</h2>
            <table>
                <thead class="bg-gray-50 border px-3 py-1.5">
                    <th class="text-gray-600 font-bold tracking-wider text-left px-3 py-1.5">Finit</th>
                    <th class="text-gray-600 font-bold tracking-wider text-left px-3 py-1.5">Linia</th>
                    <th class="text-gray-600 font-bold tracking-wider text-left px-3 py-1.5">Part-number</th>
                    <th class="text-gray-600 font-bold tracking-wider text-left px-3 py-1.5">Cod defect</th>
                    <th class="text-gray-600 font-bold tracking-wider text-left px-3 py-1.5">Nr. Eticheta</th>
                    <th class="text-gray-600 font-bold tracking-wider text-left px-3 py-1.5">Statia</th>
                    <th class="text-gray-600 font-bold tracking-wider text-left px-3 py-1.5">Numar scanari</th>
                    <th class="text-gray-600 font-bold tracking-wider text-left px-3 py-1.5">Status</th>
                </thead>
                <tbody class="divide-y divide-gray-200 border">
                    <defect-component v-for="component in scanned_component" :key="component.id" :component="component"></defect-component>
                </tbody>
            </table>
            <button class="bg-blue-500 px-4 py-3 text-white hover:bg-blue-600 rounded-sm" @click="saveStatus()" v-if="areAllComponentsSorted">Salveaza</button>
        </div>
    </div>
</template>

<script>
import { mainStore } from '../../store/index';
import { storeToRefs } from 'pinia';
import DefectComponent from './DefectComponent.vue';

export default {
    name: "DefectBom",
    setup() {
        const store = mainStore();
        const { scanned_component, ok_components, scrap_components, isScanned } = storeToRefs(store);

        return {
            scanned_component,
            ok_components,
            scrap_components,
            isScanned,
        }
    },
    components: {
        DefectComponent,
    },
    methods: {
        async saveStatus() {
            try {
                let scrap = JSON.stringify(this.scrap_components);
                let ok = JSON.stringify(this.ok_components);
                let body = {
                    scrap: scrap,
                    ok: ok
                };

                const response = await this.$axios.post(`disassembly/save_status`, body);
                if(process.env.NODE_ENV === "development") console.log(response.data);
                if(response.data.success) {
                    this.scrap_components = [];
                    this.ok_components = [];
                    this.scanned_component = [];
                    this.isScanned = false;
                }
            } catch (exception) {   
                throw new Error(exception);
            }
        }
    },
    computed: {
        areAllComponentsSorted() {
            return (this.scrap_components.length + this.ok_components.length) == this.scanned_component.length ? true : false;
        }
    }
}
</script>

<style>

</style>