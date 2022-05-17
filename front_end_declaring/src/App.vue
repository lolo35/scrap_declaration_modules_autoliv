<script>
import SelectLine from './components/Line/SelectLine.vue';

export default {
  name: "App",
  data(){
    return {
      lineSelected: false,
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
        if(!line) this.lineSelected = false; else this.lineSelected = true;
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
  <select-line v-if="!lineSelected"></select-line>
</template>

<style>

</style>
