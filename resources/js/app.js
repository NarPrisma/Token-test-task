
require('./bootstrap');
window.Vue = require('vue').default;
import VueRouter from  'vue-router';
import routes from  './router/index';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import {Vuelidate} from "vuelidate";
import VueSimpleAlert from "vue-simple-alert";
Vue.use(VueSimpleAlert);
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.component('app', require('./pages/App.vue').default);
Vue.use(VueRouter);
Vue.use(Vuelidate);

const app = new Vue({
    el: '#app',
    router: new VueRouter(routes)
});
