import { defineStore } from 'pinia';

export const mainStore = defineStore('main', {
    state: () => {
        return {
            selected_line: "",
            selected_departament: "",
            show_line_select: true,
            selected_part: "",
            partSelected: false,
            stations: {},
            produced_station: {},
            identified_station: {},
            defectCode: {},
            defect_codes: {},
            declare_step: 1,
        }
    }
});