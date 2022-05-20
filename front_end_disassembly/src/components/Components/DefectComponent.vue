<template>
    <tr class="" :class="{'bg-green-200': ok, 'bg-red-200': scrap}">
        <td class="px-3 py-1.5 font-semibold">{{ component.finit }}</td>
        <td class="px-3 py-1.5 font-semibold">{{ component.line }}</td>
        <td class="px-3 py-1.5 font-semibold">{{ component.part_number }}</td>
        <td class="px-3 py-1.5 font-semibold">{{ component.defect_code }}</td>
        <td class="px-3 py-1.5 font-semibold">{{ component.label }}</td>
        <td class="px-3 py-1.5 font-semibold whitespace-nowrap">{{ component.l2l_station }} - {{ component.station_number }}</td>
        <td class="px-3 py-1.5 font-semibold">{{ times_scaned }}</td>
        <td class="px-3 py-1.5 font-semibold">
            <div class="flex flex-row space-x-5">
                <button class="bg-green-500 hover:bg-green-600  text-white px-4 py-3 rounded-sm w-64" @click="declareOk()" v-if="!scrap">Recuperabil</button>
                <button class="bg-red-500 hover:bg-red-600  text-white px-4 py-3 rounded-sm w-64" @click="declareScrap()" v-if="!ok">Scrap</button>
            </div>
        </td>
    </tr>
</template>

<script>
import { mainStore } from '../../store/index';
import { storeToRefs } from 'pinia';
export default {
    name: "DefectComponent",
    setup(){ 
        const store = mainStore();
        const { ok_components, scrap_components } = storeToRefs(store);

        return {
            ok_components,
            scrap_components,
        }
    },
    props: {
        component: Object,
    },
    data() {
        return {
            scrap: false,
            ok: false,
            times_scaned: "",
            
        }
    },
    created() {
        try {
            this.checkTimesScanned();
        } catch (exception) {
            if(process.env.NODE_ENV === "development") {
                console.error(exception);
            }
        }
    },
    methods: {
        async checkTimesScanned(){
            try {
                if(this.component.label) {
                    const response = await this.$axios.get(`disassembly/times_scanned?label=${this.component.label}`);
                    if(process.env.NODE_ENV === "development") console.log(`times scanned = `, response.data);
                    if(response.data.success) {
                        this.times_scaned = response.data.count[0].total;
                        if(this.times_scaned >= 3) {
                            this.declareScrap();
                        }
                    }
                }
            } catch (exception) {
                throw new Error(exception);
            }
        },
        declareOk(){
            if(!this.ok) {
                this.ok_components.push(this.component);
                this.scrap = false;
                this.ok = true;
            } else {
                this.ok = false;
                if(this.ok_components.length > 0) {
                    for (let i = 0; i < this.ok_components.length; i++){
                        if(this.component.id === this.ok_components[i].id) {
                            this.ok_components.splice(i, 1);
                        }
                    }
                }
            }
        },
        declareScrap(){
            if(!this.scrap) {
                this.scrap_components.push(this.component);
                this.scrap = true;
                this.ok = false;
            } else {
                if(this.scrap_components.length > 0) {
                    for(let i = 0; i < this.scrap_components.length; i++) {
                        if(this.component.id === this.scrap_components[i].id){
                            this.scrap_components.splice(i, 1);
                        }
                    }
                }
                this.scrap = false;
            }
        }
    }
}
</script>

<style>

</style>