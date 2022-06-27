// require('../vendor/js/plugins/bootstrap-tagsinput.js');
// require('../vendor/js/plugins/jasny-bootstrap.min.js');
// require('../vendor/js/plugins/jquery.flexisel.js');
// require('../vendor/js/plugins/bootstrap-datetimepicker.min.js');
// require('../vendor/js/plugins/nouislider.min.js');

let token = document.head.querySelector('meta[name="csrf-token"]')

import Vue from 'vue';

Vue.component('edit-device', require('./components/devices/edit/index.vue').default);
Vue.component('obit-mapper', require('./components/obids/mapper/index.vue').default);
Vue.component('usn-generator', require('./utils/GenerateUsn.vue').default);
Vue.component('checksum-generator', require('./utils/GenerateChecksum.vue').default);

window.Events = new Vue({})

window._app = new Vue({
    el: '#app'
})
