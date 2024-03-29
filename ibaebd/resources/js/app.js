/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('empty-space',require('./components/EmptySpace.vue').default);

Vue.component('home-page',require('./components/HomePage.vue').default);

Vue.component('matricula-page',require('./components/MatriculaPage.vue').default);
Vue.component('lista-matriculados',require('./components/ListaMatriculados.vue').default);

Vue.component('matricula-manhaDivertida',require('./components/MatriculaManhaDivertida.vue').default);
Vue.component('lista-manha-divertida',require('./components/ListaManhaDivertida.vue').default);

Vue.component('matricula-casais',require('./components/MatriculaSoPraCasais.vue').default);
Vue.component('lista-casais',require('./components/ListaSoPraCasais.vue').default);

Vue.component('matricula-cafeComunhao',require('./components/MatriculaCafeComunhao.vue').default);
Vue.component('lista-cafe-comunhao',require('./components/ListaCafeComunhao.vue').default);

Vue.component('matricula-ebdMusicos',require('./components/MatriculaEbdMusicos.vue').default);
Vue.component('lista-ebd-musicos',require('./components/ListaEbdMusicos.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
