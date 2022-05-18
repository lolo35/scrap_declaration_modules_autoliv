<template>
  <div class="flex flex-col space-y-3">
    <selected-line v-if="!show_line_select"></selected-line>
    <part-select v-if="!show_line_select"></part-select>
    <stations-main v-if="partSelected"></stations-main>
  </div>
</template>

<script>
// @ is an alias to /src
import SelectedLine from '../components/Line/SelectedLine.vue';
import PartSelect from '../components/Part/PartSelect.vue';
import StationsMain from '../components/Stations/StationsMain.vue';

import { mainStore } from '../store/index';
import { storeToRefs } from 'pinia';

export default {
  name: 'HomeView',
  setup() {
    const store = mainStore();
    const { show_line_select, partSelected } = storeToRefs(store);

    return {
      show_line_select,
      partSelected
    }
  },
  components: {
    SelectedLine,
    PartSelect,
    StationsMain
  }
}
</script>
