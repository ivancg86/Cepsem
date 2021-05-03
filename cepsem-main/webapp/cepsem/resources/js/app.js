/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import BootstrapVue from 'bootstrap-vue' //Importing

Vue.use(BootstrapVue) // Telling Vue to use this in whole application

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('table-component', require('./components/TableComponent.vue').default);
Vue.component('alertant-component', require('./components/AlertantComponent.vue').default);
Vue.component('incidencies-component', require('./components/IncidenciaComponent.vue').default);
Vue.component('incidenciaform-component', require('./components/IncidenciaFormComponent.vue').default);
Vue.component('header-component', require('./components/HeaderComponent.vue').default);
Vue.component('usuari-component', require('./components/UsuariComponent.vue').default);
Vue.component('menucard-component', require('./components/MenuCardComponent.vue').default);
Vue.component('recurs-component', require('./components/RecursosComponent.vue').default);
Vue.component('afectat-component', require('./components/AfectatComponent.vue').default);
Vue.component('afectatitem-component', require('./components/AfectatItemComponent.vue').default);
Vue.component('recursmobil-component', require('./components/IncidenciaHasRecursComponent.vue').default);
Vue.component('recursitem-component', require('./components/AsignarAfectatComponent.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
