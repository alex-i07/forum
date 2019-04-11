
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
 * Eg. ./components/FlashComponent.vue -> <flash-component></flash-component>
 */

Vue.component('flash-component', require('./components/FlashComponent.vue'));

Vue.component('thread-view-component', require('./components/ThreadViewComponent.vue'));

// Vue.component('replies-component', require('./components/RepliesComponent.vue'));

// Vue.component('reply-component', require('./components/ReplyComponent.vue'));

// Vue.component('favorite-component', require('./components/FavoriteComponent.vue'));

// const files = require.context('./', true, /\.vue$/i)

// files.keys().map(key => {
//     return Vue.component(_.last(key.split('/')).split('.')[0], files(key))
// })

Vue.prototype.authorize = function (handler) {
    return handler(window.user);
};

window.events = new Vue();

window.flash = function(message){
    window.events.$emit('flash', message);
};

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});
