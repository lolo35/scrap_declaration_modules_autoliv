import { defineStore } from 'pinia';

export const mainStore = defineStore('main', {
    state: () => {
        return {
            departaments: [],
            selected_departament: "",
            selected_shift: 1,
            scrap_data: []
        }
    }
});