import { defineStore } from 'pinia';

export const mainStore = defineStore('main', {
    state: () => {
        return {
            selected_line: "",
            selected_departament: "",
            show_line_select: true,
            selected_part: "",
        }
    }
});