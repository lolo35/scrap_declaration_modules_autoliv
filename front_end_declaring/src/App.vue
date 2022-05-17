<script>
import SelectLine from './components/Line/SelectLine.vue';
import { mainStore } from './store/index';
import { storeToRefs } from 'pinia';

export default {
  name: "App",
  setup() {
    const store = mainStore();
    const { show_line_select } = storeToRefs(store);

    return {
      show_line_select
    }
  },
  data(){
    return {
      
    }
  },
  components: {
    SelectLine,
  },
  methods: {
    async checkForLine(){
      try {
        const line = await this.$localforage.getItem('line');
        if(process.env.NODE_ENV === "development") console.log(`Line is ${line}`);
        if(!line) this.show_line_select = true; else this.show_line_select = false;
      } catch (exception) {
        if(process.env.NODE_ENV === "development") throw new Error(exception);
      }
    }
  },
  created(){
    try {
      this.checkForLine();
    } catch(exception) {
      console.error(exception);
    }
  }
}
</script>
<template>
  <router-view/>
  <select-line v-if="show_line_select"></select-line>
</template>

<style>

</style>
