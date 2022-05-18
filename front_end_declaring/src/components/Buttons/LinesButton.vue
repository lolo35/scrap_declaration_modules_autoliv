<template>
    <button 
        class="bg-sky-600 hover:bg-sky-500 text-white px-5 w-32 py-3 font-bold rounded-sm mr-2 mt-2" 
        @click="selected_line = line"
        :class="{'bg-sky-500': selected_line === line.linecode}"
        >
        {{ line.linecode }}
    </button>
</template>

<script>
import { mainStore } from '../../store/index';
import { storeToRefs } from 'pinia';

export default {
    name: "LinesButton",
    setup() {
        const store = mainStore();
        const { selected_line } = storeToRefs(store);

        return {
            selected_line,
        }
    },
    props: {
        line: Object,
    }
}
</script>

<style>

</style>