<template>
    <div class="absolute top-0 bottom-0 right-0 left-0 z-10 bg-black opacity-30"></div>
    <div class="absolute top-0 bottom-0 right-0 left-0 z-20">
        <div class="flex flex-col w-full h-full items-center justify-center">
            <div class="flex flex-col w-1/3 bg-white rounded-sm shadow-xl">
                <div class="flex flex-row rounded-t-sm bg-gray-200 px-3 py-1.5">
                    <h3 class="text-xl font-bold text-gray-800">
                        Alege zona de lucru
                    </h3>
                </div>
                <div class="flex flex-col w-full items-center space-y-2">
                    <div class="flex flex-row px-3 py-1.5 w-full items-center justify-between">
                        <div class="flex flex-col">
                            <h3 class="text-xl font-bold text-gray-700">Departamente</h3>
                            <p class="text-sm font-bold text-gray-500 italic">Alege departamentul</p>
                        </div>
                        <div class="flex flex-row space-x-3" v-if="selected_departament.length > 0">
                            <h3 class="text-lg font-semibold">Departamentul ales: </h3>
                            <h3 class="text-lg font-bold italic text-gray-500">{{ selected_departament }}</h3>
                        </div>
                    </div>
                    <div class="flex flex-row px-3 py-1.5 flex-wrap w-full items-center space-x-2">
                        <departament-button v-for="departament in departaments" :key="departament.id" :departament="departament"></departament-button>
                    </div>
                    <div class="flex flex-row px-3 py-1.5 w-full items-center justify-between" v-if="lines_loaded">
                        <div class="flex flex-col">
                            <h3 class="text-xl font-bold text-gray-700">Linii</h3>
                            <p class="font-bold text-sm text-gray-500 italic">Alege linia</p>
                        </div>
                        <div class="flex flex-row space-x-3" >
                            <h3 class="text-lg font-semibold">Linia aleasa: </h3>
                            <h3 class="text-lg font-bold italic text-gray-500">{{ selected_line.linecode }}</h3>
                        </div>
                    </div>
                    <div class="flex flex-row px-3 py-1.5 flex-wrap w-full items-center" v-if="lines_loaded">
                        <lines-button v-for="line in lines" :key="line.id" :line="line"></lines-button>
                    </div>
                    <div class="flex flex-row-reverse w-full px-3 py-1.5">
                        <button class="px-3 py-1.5 w-32 bg-emerald-500 text-white hover:bg-emerald-700 font-bold" @click="saveWorkZone()">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import DepartamentButton from '../Buttons/DepartamentButton.vue';
import LinesButton from '../Buttons/LinesButton.vue';
import { mainStore } from '../../store/index';
import { storeToRefs } from 'pinia';

export default {
    name: "SelectLine",
    setup() {
        const store = mainStore();
        const { selected_departament, selected_line, show_line_select } = storeToRefs(store);

        return {
            selected_departament,
            selected_line,
            show_line_select
        }
    },
    data() {
        return {
            departaments: [],
            lines: [],
            lines_loaded: false,
        }
    },
    components: {
        DepartamentButton,
        LinesButton,
    },
    watch: {
        dep_change_w: function(){
            try {
                this.fetchLines();
            } catch (exception) {
                if(process.env.NODE_ENV === "development") console.error(exception);
            }
        }
    },
    created() {
        try {
            this.fetchDepartaments();
            if(this.dep_change_w.length > 0) {
                this.fetchLines();
            }
        } catch (exception) {
            if(process.env.NODE_ENV === "development") console.error(exception);
        }
    },
    methods: {
        async saveWorkZone() {
            try {
                await this.$localforage.setItem('line', {zone: this.selected_departament, line: JSON.stringify(this.selected_line)});
                this.show_line_select = false;
            } catch (exception) {
                throw new Error(exception);
            }
        },
        async fetchDepartaments(){
            try {
                const response = await this.$axios.get(`departaments`);
                if(process.env.NODE_ENV === "development") console.log(response.data);
                if(response.data.success) this.departaments = response.data.departaments;
            } catch (exception) {
                if(process.env.NODE_ENV === "development") throw new Error(exception);
            }
        },
        async fetchLines(){
            try {
                const response = await this.$axios.get(`lines?zone=${this.dep_change_w}`);
                if(process.env.NODE_ENV === "development") console.log(response.data);
                if(response.data.success) {
                    this.lines = response.data.lines;
                    this.lines_loaded = true;
                }
            } catch (exception) {
                if(process.env.NODE_ENV === "development") throw new Error(exception);
            }
        }
    },
    computed: {
        dep_change_w(){
            return this.selected_departament;
        }
    }
}
</script>

<style>

</style>