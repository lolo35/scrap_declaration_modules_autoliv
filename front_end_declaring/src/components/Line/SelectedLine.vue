<template>
    <div class="flex flex-row w-full justify-center">
        <div class="flex flex-row bg-white shadow border px-4 py-5 mt-2 rounded-sm">
            <h3 class="text-4xl font-bold text-center">{{ selected_line.linecode }} - {{ selected_departament }}</h3>
        </div>
    </div>
</template>

<script>
import { mainStore } from '../../store/index';
import { storeToRefs } from 'pinia';
export default {
    name: "SelectedLine",
    setup() {
        const store = mainStore();
        const { selected_line, selected_departament } = storeToRefs(store);

        return {
            selected_line,
            selected_departament
        }
    },
    created() {
        this.fetchLineData();
    },
    methods: {
        async fetchLineData(){
            try {
                const data = await this.$localforage.getItem('line');
                const linedata = JSON.parse(data.line);
                this.selected_line = linedata;
                this.selected_departament = data.zone;
            } catch (exception) {
                throw new Error(exception);
            }
        }
    }
}
</script>

<style>

</style>