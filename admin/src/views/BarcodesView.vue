<template>
    <div class="flex flex-row">
        <router-link to="/login" class="bg-green-500 text-white px-3 py-1.5 ml-2 mt-2 rounded-sm">
            <i class="fa-solid fa-link"></i>
            Login
        </router-link>
    </div>
    <form class="flex flex-col" @submit.prevent="fetchScrapData()">
        <div class="flex flex-row w-full justify-center">
            <div class="flex flex-col px-3 py-1 items-center justify-center">
                <label for="departament" class="text-lg font-bold">Departament</label>
                <select id="departament" class="border border-gray-200 px-4 py-2 rounded" v-model="selected_departament" required>
                    <option :value="departament.departament" v-for="departament in departaments" :key="departament.id">{{ departament.departament }}</option>
                </select>
            </div>
            <div class="flex flex-col px-3 py-1 items-center justify-center">
                <label for="shift" class="text-lg font-bold">Schimbul</label>
                <select id="shift" class="border border-gray-200 px-4 py-2 rounded" v-model="selected_shift" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>
            </div>
            <div class="flex flex-col px-3 py-1 items-center justify-center">
                <label for="" class="font-bold text-lg">Alege data</label>
                <Datepicker v-model="date" :format="format"></Datepicker>
            </div>
        </div>
        <div class="flex flex-row w-full justify-center">
            <button type="submit" class="bg-blue-500 text-white px-3 py-2 hover:bg-blue-600 w-1/4 rounded-sm">Incarca datele</button>
        </div>
    </form>
    <div class="flex flex-col mt-5 px-3 py-5" v-if="dataLoaded">
        <table>
            <thead class="bg-gray-50 p-3 rounded-sm">
                <tr>
                    <th>Part-number</th>
                    <th>Cantitate</th>
                    <th>Locatie</th>
                    <th>Cod Movex</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <barcode-row v-for="row in scrap_data" :key="row.id" :row="row"></barcode-row>
            </tbody>
        </table>
    </div>
</template>

<script>
import { storeToRefs } from 'pinia';
import { mainStore } from '../store/index';
import { ref } from 'vue';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import BarcodeRow from '../components/Barcodes/BarcodeRow.vue';

export default {
    name: "BarcodesView",
    setup() {
        const store = mainStore();
        const { departaments, selected_departament, selected_shift, scrap_data } = storeToRefs(store);
        const date = ref(new Date());

        const format = (date) => {
            let day = date.getDate();
            if(day.toString().lenght < 2) { 
                day = `0${day}`;
            }
            let month = date.getMonth() + 1;
            if(month.toString().length < 2) {
                month = `0${month}`;
            }
            const year = date.getFullYear();
            return `${year}-${month}-${day}`;
        }

        return {
            departaments,
            selected_departament,
            selected_shift,
            date,
            format,
            scrap_data
        }
    },
    data() {
        return {
            dataLoaded: false,
        }
    },
    components: {
        Datepicker,
        BarcodeRow,
    },
    created() {
        try {
            this.fetchDepartaments();
        } catch (exception) {
            if(process.env.NODE_ENV === "development") {
                console.error(exception);
            }
        }
    },
    methods: {
        async fetchDepartaments() {
            try {
                const response = await this.$axios.get(`departaments`);
                if(process.env.NODE_ENV === "development") console.log(response.data);
                if(response.data.success) this.departaments = response.data.departaments;
            } catch (exception) {
                throw new Error(exception);
            }
        },
        async fetchScrapData() {
            try {
                let date = new Date(this.date);
                let month = date.getMonth() + 1;
                if(month.toString().length < 2) {
                    month = `0${month}`;
                }
                let day = date.getDate();
                if(day.toString().length < 2) {
                    day = `0${day}`;
                }
                let year = date.getFullYear();

                date = `${year}-${month}-${day}`;
                const response = await this.$axios.get(`admin/scrap_data?date=${date}&departament=${this.selected_departament}&shift=${this.selected_shift}`);
                if(process.env.NODE_ENV === "development") console.log(response.data);
                if(response.data.success) {
                    this.scrap_data = response.data.data;
                    this.dataLoaded = true;
                }
            } catch (exception) {
                if(process.env.NODE_ENV === "development") {
                    console.error(exception);
                }
            }
        }
    }
}
</script>

<style>

</style>