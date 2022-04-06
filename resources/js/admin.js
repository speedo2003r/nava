require('./bootstrap');

window.Vue = require('vue');

import Multiselect from 'vue-multiselect';
import * as VueGoogleMaps from 'vue2-google-maps';
import socketio from 'socket.io-client';
import VueSocketIO from 'vue-socket.io';

// Libraries
Vue.component('multiselect', Multiselect);
Vue.use(VueGoogleMaps, {
    load: {
        key: 'AIzaSyArqxjb1ObPE7H-KcaCr1RExwCLnajHDcU',
        libraries: 'places',
        language: 'ar'
    }
});

Vue.use(VueSocketIO, socketio(process.env.MIX_SOCKET_URL || 'http://localhost:8080'));

// Local components
Vue.component('image-input', require('./components/ImageInput.vue').default);
Vue.component('single-select', require('./components/SingleSelect.vue').default);
Vue.component('select-branch', require('./components/SelectBranch.vue').default);
Vue.component('select-multi-branches', require('./components/SelectMultipleBranches.vue').default);
Vue.component('select-user', require('./components/SelectUser.vue').default);
Vue.component('create-coupon', require('./components/CreateCoupon.vue').default);
Vue.component('tracker', require('./components/Tracker.vue').default);

const app = new Vue({
    el: '#admin'
});
