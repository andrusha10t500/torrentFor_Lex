require('./bootstrap');

// window.Vue = require('vue');

import Vue from 'vue'

import App from './components/LoginComponent'
import Torrent from './components/TorrentComponent'

const app = new Vue({
    el: '#app',
    components: {App, Torrent}

    // props: ['innerHTML'],
    // template: '<div class="col-md-1 offset-md-1">122</div>'
});
