import 'devextreme/dist/css/dx.common.css';
import 'devextreme/dist/css/dx.light.css';
import axios from 'axios';
import VueAxios from 'vue-axios';

import Vue from 'vue'
import App from './App.vue'

Vue.config.productionTip = false
Vue.use(VueAxios, axios)

new Vue({
  render: h => h(App),
}).$mount('#app')
