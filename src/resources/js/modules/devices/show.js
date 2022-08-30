import '../../base';

import Vue from 'vue';

Vue.component('mint-device', require('../../components/devices/show/mint.vue').default);
Vue.component('update-metadata', require('../../components/devices/show/update-metadata.vue').default);
Vue.component('network-fees-modal', require('../../components/modals/network-fees.vue').default);

window.Events = new Vue({});

window._app = new Vue({
    el: '#app'
});
