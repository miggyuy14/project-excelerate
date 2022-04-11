/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue'

// Import vue select
import 'vue-select/dist/vue-select.css';
import vSelect from 'vue-select';
Vue.component('v-select', vSelect);

// Import modals
import VModal from 'vue-js-modal';
Vue.use(VModal, {
    dynamic: true,
    injectModalsContainer: true,
});

// Import Pagination
Vue.component('Paginate', require('vuejs-paginate'));

// Import bootstrap vue
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

// Import Bootstrap an BootstrapVue CSS files (order is important)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)

import { createInertiaApp } from '@inertiajs/inertia-vue'
import { InertiaProgress } from '@inertiajs/progress'
Vue.mixin({ methods: { route: window.route } })
InertiaProgress.init()

 createInertiaApp({
   resolve: name => require(`./Pages/${name}`),
   setup({ el, App, props, plugin }) {
     Vue.use(plugin)

     new Vue({
       render: h => h(App, props),
     }).$mount(el)
   },
 })
