<template>
    <div class="flex flex-row justify-center space-x-3 flex-wrap" v-if="partsLoaded">
        <part-select-button v-for="part in parts" :key="part.id" :part="part"></part-select-button>
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
        const { selected_line } = storeToRefs(store);

        return {
            selected_line,
        }
    },
    data() {
        return {
            parts: [],
            partsLoaded: false,
        }
    },
    created() {
        
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
        async fetchParts(){
            try {
                console.log(this.selected_line.length);
                const response = await this.$axios.get(`parts/?line=${this.selected_line}`);
                if(process.env.NODE_ENV === "development") console.log(response.data);
                if(response.data.success) {
                    this.parts = response.data.parts;
                    this.partsLoaded = true;
                }
            } catch (exception) {
                throw new Error(exception);
            }
        }
    }
}
</script>

<style>

</style>