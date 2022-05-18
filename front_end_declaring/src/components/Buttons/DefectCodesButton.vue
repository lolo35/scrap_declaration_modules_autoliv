<template>
    <button 
        class="bg-blue-500 w-full hover:bg-blue-700 px-10 py-6 text-white font-bold rounded-sm mr-2 mt-2"
        :class="{'bg-green-500': defectCode.id === defect_code.id}"
        @click="defectCode = defect_code">
        {{ defect_code.code }} - {{ defect_code.description }}
    </button>
</template>

<script>
import { mainStore } from '../../store/index';
import {storeToRefs} from 'pinia';
export default {
    name: "DefectCodesButton",
    setup() {
        const store = mainStore();
        const { defectCode } = storeToRefs(store);

        return {
            defectCode,
        }
    },
    props: {
        defect_code: {
            type: Object,
            required: true
        }
    }

}
</script>

<style>

</style>