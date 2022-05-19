<template>
    <div class="flex flex-row justify-center space-x-3 flex-wrap" v-if="partsLoaded && !partSelected">
        <part-select-button v-for="part in parts" :key="part.id" :part="part" v-on:part_selected="partSelected = !partSelected"></part-select-button>
    </div>
    <div class="flex flex-row justify-center" v-if="partSelected">
        <div class="flex flex-row bg-white shadow px-4 py-5 rounded-sm">
            <h3 class="text-xl font-bold">{{ selected_part.part }} - {{ selected_part.description }}</h3>
        </div>
    </div>
    <div class="flex flex-row px-3 py-1.5" v-if="partSelected">
        <button class="bg-sky-500 px-3 py-1.5 hover:bg-sky-700 text-white rounded-sm" @click="showParts()">
            Schimbare part-number
            <i class="fa-solid fa-angles-right"></i>
        </button>
    </div>
</template>

<script>
import PartSelectButton from '../Buttons/PartSelectButton.vue';
import { mainStore } from '../../store/index';
import { storeToRefs } from 'pinia';
export default {
    name: "PartSelect",
    components: {
        PartSelectButton,
    },
    setup() {
        const store = mainStore();
        const { selected_line, selected_part, partSelected } = storeToRefs(store);

        return {
            selected_line,
            selected_part,
            partSelected
        }
    },
    data() {
        return {
            parts: [],
            partsLoaded: false,
        }
    },
    created() {
        try {
            this.checkForSelected();
        } catch (exception) {
            if(process.env.NODE_ENV === "development") console.error(exception);
        }
    },
    watch: {
        selected_line: function() {
            try {
                this.fetchParts();
            } catch (exception) {
                if(process.env.NODE_ENV === "development") console.error(exception);
            }
        }
    },
    methods: {
        showParts(){
            this.fetchParts();
            this.partSelected = !this.partSelected;
        },
        async fetchParts(){
            try {
                const response = await this.$axios.get(`parts/?line=${this.selected_line.linecode}`);
                if(process.env.NODE_ENV === "development") console.log(response.data);
                if(response.data.success) {
                    this.parts = response.data.parts;
                    this.partsLoaded = true;
                }
            } catch (exception) {
                throw new Error(exception);
            }
        },
        async checkForSelected(){
            try {
                const part = await this.$localforage.getItem('selected_part');
                if(!part) {
                    this.partSelected = false;
                    return 0;
                }
                this.selected_part = JSON.parse(part);
                this.partSelected = true;
            } catch (exception) {
                throw new Error(exception);
            }
        }
    }
}
</script>

<style>

</style>