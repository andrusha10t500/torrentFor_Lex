require('./bootstrap');

// window.Vue = require('vue');

import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import App from './components/AppComponent'
import Login from './components/LoginComponent'
import Signin from './components/SigninComponent'
import Torrent from './components/TorrentComponent'
import Upload from './components/UploadComponent'

import Authorizedclients from '../assets/js/components/passport/AuthorizedClients'
import Clients from '../assets/js/components/passport/Clients'
import Personalaccesstokens from '../assets/js/components/passport/PersonalAccessTokens'

const routes = [
    {
        path : '/login',
        name : 'login',
        component: Login
    },
    {
        path : '/signin',
        name : 'signin',
        component: Signin
    },
    {
        path : '/upload',
        name : 'upload',
        component: Upload
    }
]

const router = new VueRouter ({
    mode: 'history',
    routes : routes
})

const app = new Vue({
    el: '#app',
    components: { App, Torrent, Authorizedclients, Clients, Personalaccesstokens },
    router
});


