<template>
    <tr>
        <td class="whitespace-nowrap text-center">
            <div class="flex flex-row justify-center">
                <vue-barcode :value="row.part_number"></vue-barcode>
            </div>
        </td>
        <td class="whitespace-nowrap text-center">
            <div class="flex flex-row justify-center">
                <vue-barcode :value="row.total"></vue-barcode>
            </div>
        </td>
        <td class="whitespace-nowrap text-center">
            <div class="flex flex-row justify-center">
                <vue-barcode value="5700"></vue-barcode>
            </div>
        </td>
        <td class="whitespace-nowrap text-center">
            <div class="flex flex-row justify-center">
                <vue-barcode :value="movexCode"></vue-barcode>
            </div>
        </td>
    </tr>
</template>

<script>
import { storeToRefs } from 'pinia';
import { mainStore } from '../../store/index';
export default {
    name: "BarcodeRow",
    setup() {
        const store = mainStore();
        const { selected_departament } = storeToRefs(store);

        return {
            selected_departament,
        }
    },
    props: {
        row: {
            type: Object,
            required: true,
        }
    },
    components: {
        
    },
    computed: {
        movexCode() {
            let code = "";
            switch(this.selected_departament){
                case "AMG9": code = "009"; break;
            }
            return code;
        }
    }
}
</script>

<style>

</style>