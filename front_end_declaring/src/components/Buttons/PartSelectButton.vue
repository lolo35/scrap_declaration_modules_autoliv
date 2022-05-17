<template>
    <button 
        class="bg-sky-500 hover:bg-sky-700 text-white px-6 py-4 font-bold rounded-sm"
        :class="{'bg-sky-400': part.part === selected_part}"
        @click="setSelectedPart()"
        >
        {{ part.part }} - {{ part.description }}
    </button>
</template>

<script>
import { mainStore } from '../../store/index';
import { storeToRefs } from 'pinia';
export default {
    name: "PartSelectButton",
    setup() {
        const store = mainStore();
        const { selected_part } = storeToRefs(store);

        return {
            selected_part,
        }
    },
    props: {
        part: Object,
    },
    methods: {
        async setSelectedPart(){
            this.selected_part = this.part.part;
            await this.$localforage.setItem('selected_part', this.part.part);
        }
    }
}
</script>

<style>

</style>