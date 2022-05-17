<template>
    <button 
        class="bg-sky-600 hover:bg-sky-500 text-white px-5 py-3 font-bold rounded-sm"
        :class="{'bg-sky-400': selected_departament === departament.departament}"
        @click="selected_departament = departament.departament">
        {{ departament.departament }}
    </button>
</template>

<script>
import { mainStore } from '../../store/index.js';
import { storeToRefs } from 'pinia';
export default {
    name: "DepartamentButton",
    setup() {
        const store = mainStore();
        const { selected_departament } = storeToRefs(store);

        return {
            selected_departament
        }
    },
    props: {
        departament: {
            type: Object,
            required: true,
        }
    }
}
</script>

<style>

</style>