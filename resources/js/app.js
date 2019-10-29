require('./bootstrap');
import Vue from 'vue';
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import axios from 'axios';

import ExampleCompnent from './components/ExampleCompnent.vue';
import UserPage from './components/Users.vue';

Vue.use(VueRouter);
Vue.use(VueAxios, axios);
// Vue.component('example-component', require('./components/ExampleCompnent.vue').default);
// Vue.component('users', require('./components/Users.vue'));




const routes = [
   {
        name: 'home',
        path: '/',
        component: ExampleCompnent ,
    },
    {
        name: 'Users',
        path: '/users/show',
        component: UserPage ,
    },
]
const router = new VueRouter({ mode: 'history', routes: routes});
const app = new Vue({
    el: '#app',
    router ,
    components: { ExampleCompnent }
    
});
