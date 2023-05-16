import './base';

import Vue from 'vue';

window.Vue = require('vue').default;

Vue.component('obit-mapper', require('./components/obits/mapper/index.vue').default);
Vue.component('usn-generator', require('./utils/GenerateUsn.vue').default);
Vue.component('checksum-generator', require('./utils/GenerateChecksum.vue').default);

window.Events = new Vue({})

window._app = new Vue({
    el: '#app'
})
