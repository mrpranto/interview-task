import Vue from 'vue'
import App from './App.vue'
import BootstrapVue from 'bootstrap-vue'
require('./apiUrl');
import 'jquery';
import 'bootstrap';

import VueRouter from 'vue-router'

import axios from 'axios'
import VueAxios from 'vue-axios'

import Login from "@/components/Login";
import Register from "@/components/Register";
import Users from "@/components/Users";
import Roles from "@/components/Roles";
import HelloWorld from "@/components/HelloWorld";
import Home from "@/components/Home";
import Profile from "@/components/Profile";

Vue.use(VueRouter)
Vue.use(VueAxios, axios)
Vue.use(BootstrapVue)

Vue.config.productionTip = false
window.$ = window.jQuery = require('jquery')

const routes = [
  { path: '/', component: HelloWorld },
  { path: '/home', component: Home },
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  { path: '/users', component: Users },
  { path: '/roles', component: Roles },
  { path: '/profile', component: Profile },
]

const router = new VueRouter({
  mode: 'history',
  routes // short for `routes: routes`
})

new Vue({
  router,
  render: h => h(App),
  data: {
    showModal: false
  }
}).$mount('#app')
