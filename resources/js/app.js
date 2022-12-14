/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
/*
require('bootstrap-datepicker');
require('bootstrap-select');
/**
import Vue from 'vue';
import VueBootstrapTypeahead from 'vue-bootstrap-typeahead';

window.Vue = Vue;


import VueChatScroll from 'vue-chat-scroll'
Vue.use(VueChatScroll);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 /

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('vue-bootstrap-typeahead', VueBootstrapTypeahead);

Vue.component('search-form', require('./components/Search/SearchForm.vue').default);
Vue.component('search-row', require('./components/Search/SearchRow.vue').default);
Vue.component('subscribe', require('./components/Search/Subscribe.vue').default);
Vue.component('flight', require('./components/Search/Flight.vue').default);
Vue.component('chats', require('./components/ChatsComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 /

const app = new Vue({
    el: '#app'
});

/* Anchor smooth scrolling /
$(document).on('click', '.main-search a[href^="#"]', function (event) {
    event.preventDefault();

    $('html, body').animate({
        scrollTop: $($.attr(this, 'href')).offset().top
    }, 500);
});

/* Popover /
$(function () {
    $('[data-toggle="popover"]').popover()
})

$('.calendar').datepicker({
});

$('.profile').datepicker({
});

$('.companion').datepicker({
});
**/
// $('.dateranger').datepicker({
//     format: 'yyyy-mm-dd',
// });

import {createApp} from 'vue'
import ChatComponent from './components/ChatsComponent'
// import AdminChatComponent from './components/AdminChatsComponent'
import VueChatScroll from 'vue-chat-scroll'

const app = createApp({});
app.use(VueChatScroll);
// app.component('chats', ChatComponent);
// app.component('admin-chat', AdminChatComponent);
app.mount('#app');
