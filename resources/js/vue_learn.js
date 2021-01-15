require('./bootstrap');

// window.Vue = require('vue');

import Vue from 'vue'
// import Vuex from 'vuex'
// Vue.use(Vuex)

import App from './components/LoginComponent'
import Torrent from './components/TorrentComponent'
import Upload from './components/UploadComponent'


// const store = new Vuex.Store({
//     state: {
//         reload : false
//     },
//     mutations : {
//         reloadF (state) {
//             state.reload = !state.reload;
//         }
//     }
// });

const app = new Vue({
    el: '#app',
    components: { App, Torrent, Upload}
    // ,    store: store

    // props: ['innerHTML'],
    // template: '<div class="col-md-1 offset-md-1">122</div>'
});


