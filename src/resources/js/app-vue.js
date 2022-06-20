// require('../vendor/js/plugins/bootstrap-tagsinput.js');
// require('../vendor/js/plugins/jasny-bootstrap.min.js');
// require('../vendor/js/plugins/jquery.flexisel.js');
// require('../vendor/js/plugins/bootstrap-datetimepicker.min.js');
// require('../vendor/js/plugins/nouislider.min.js');

let token = document.head.querySelector('meta[name="csrf-token"]')

import Vue from 'vue';
import { BootstrapVue } from 'bootstrap-vue';

Vue.use(BootstrapVue);

Vue.component('device-obit-detail', require('./components/devices/obid-detail/index.vue').default);
Vue.component('device-row', require('./components/devices/row/index.vue').default);
Vue.component('edit-device', require('./components/devices/edit/index.vue').default);
Vue.component('obit-list', require('./components/obids/list/index.vue').default);
Vue.component('obit-detail', require('./components/obids/detail/index.vue').default);
Vue.component('obit-mapper', require('./components/obids/mapper/index.vue').default);
Vue.component('usn-generator', require('./utils/GenerateUsn.vue').default);
Vue.component('checksum-generator', require('./utils/GenerateChecksum.vue').default);

window.Events = new Vue({})

window._app = new Vue({
    el: '#app'
})
