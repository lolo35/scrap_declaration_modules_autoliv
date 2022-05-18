<template>
    <h3 class="font-bold text-lg text-center">Alege codul de defect</h3>
    <div class="flex flex-row flex-wrap w-full">
        <div class="flex flex-row w-1/2" v-for="code in defect_codes" :key="code.id">
            <defect-codes-button :defect_code="code"></defect-codes-button>
        </div>
    </div>
</template>

<script>
import { storeToRefs } from 'pinia';
import { mainStore } from '../../store/index';
import DefectCodesButton from '../Buttons/DefectCodesButton.vue';
export default {
    name: "DefectCodes",
    setup() {
        const store = mainStore();
        const { defect_codes } = storeToRefs(store);

        return {
            defect_codes,
        }
    },
    components: {
        DefectCodesButton,
    }
}
</script>

<style>

</style>