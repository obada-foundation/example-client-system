import '../../base';

import Vue from 'vue';

Vue.component('nft-transfer', require('../../components/nft/transfer/index.vue').default);

window.Events = new Vue({});

window._app = new Vue({
    el: '#app'
});