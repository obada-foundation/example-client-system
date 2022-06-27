import '../../base';

import Vue from 'vue';

Vue.component('edit-device', require('../../components/devices/edit/index.vue').default);

window.Events = new Vue({});

window._app = new Vue({
    el: '#app'
});
