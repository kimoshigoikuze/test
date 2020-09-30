<template>
  <div id="app">
    <div class="search-row">
      <DxSelectBox :items="sofs"
                   :accept-custom-value="true"
                   :search-enabled="true"
                   :search-expr="null"
                   :search-timeout="500"
                   ref="select"
                   value-expr="id"
                   search-mode="contains"
                   display-expr="DAD_DA_Reference"
                   @value-changed="handleSearchChange($event)"
      />
      <dx-button
          text="Search"
          @click="handleSearchClick()"/>
    </div>
    <div class="table" v-if="events.length > 0">
      <DxDataGrid
          :data-source="events"
          :show-borders="true"
      >
        <DxSearchPanel
            :visible="true"
            :width="240"
            placeholder="Search..."
        />
        <DxPaging :page-size="10"/>
        <DxPager
            :show-page-size-selector="true"
            :allowed-page-sizes="[10, 20, 100]"
            :show-info="true"
        />
        <DxColumn data-field="DATE_TIME"/>
        <DxColumn data-field="ORIGINAL_EVENT"/>
        <DxColumn data-field="STD_EVENT_NAME"/>
        <DxColumn data-field="STD_EVENT_CODE"/>
      </DxDataGrid>
    </div>
  </div>
</template>

<script>
import DxSelectBox from 'devextreme-vue/select-box';
import DxButton from "devextreme-vue/button";
import {DxDataGrid, DxColumn, DxPager, DxPaging, DxSearchPanel} from 'devextreme-vue/data-grid';

export default {
  name: 'App',
  components: {
    DxSelectBox,
    DxButton,
    DxDataGrid,
    DxColumn,
    DxPager,
    DxPaging,
    DxSearchPanel
  },
  computed: {
    select: function () {
      return this.$refs.select.instance;
    }
  },
  data() {
    return {
      baseUrl: process.env.NODE_ENV === 'development' ? 'http://localhost:8080/' : '/',
      sofs: [],
      events: [],
      sofId: null,
      activeSof: null,
      debounce: null
    }
  },
  beforeMount() {
    this.getReferences().then(this.setReferences);
  },
  methods: {
    handleSearchChange(event) {
      this.sofId = event.value
    },
    handleSearchClick() {
      if (this.sofId) {
        this.getSOFEvents(this.sofId).then(this.setSOFEvents);
      }
    },
    getSOFEvents(id) {
      return this.$http.post(`${this.baseUrl}api/sofs/events?id=${id}`)
    },
    getReferences() {
      return this.$http.post(`${this.baseUrl}api/sofs`)
    },
    setSOFEvents(response) {
      this.setPayload(response, 'events');
    },
    setReferences(response) {
      this.setPayload(response, 'sofs');
    },
    setPayload(response, target) {
      let data = response.data

      if (data.payload) {
        this[target] = data.payload
      }
    }
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}

.search-row {
  display: flex;
  justify-content: center;
}

.table {
  margin: 2rem auto;
  width: 80%;
}

.dx-button {
  margin-left: 2rem;
}
</style>
