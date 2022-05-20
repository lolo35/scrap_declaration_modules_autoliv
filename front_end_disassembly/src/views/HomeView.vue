<template>
  <div class="flex flex-col w-full h-full">
    <main-component v-if="!isScanned"></main-component>
    <defect-bom v-if="isScanned && !moreToScan"></defect-bom>
    <additional-scans v-if="isScanned && moreToScan"></additional-scans>
  </div>
</template>

<script>
import { storeToRefs } from 'pinia';
import { mainStore } from '../store/index';
import MainComponent from '../components/Scanning/MainComponent.vue';
import DefectBom from '../components/Components/DefectBom.vue';
import AdditionalScans from '../components/Scanning/AdditionalScans.vue';
// @ is an alias to /src

export default {
  name: 'HomeView',
  setup() {
    const store = mainStore();
    const { isScanned, moreToScan } = storeToRefs(store);

    return {
      isScanned,
      moreToScan
    }
  },
  components: {
    MainComponent,
    DefectBom,
    AdditionalScans,
  }
}
</script>
