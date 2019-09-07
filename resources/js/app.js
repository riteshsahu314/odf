/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


window.Vue = require('vue');

import InstantSearch from 'vue-instantsearch';

window.Vue.use(InstantSearch);

// a method that we want to share across all Vue instances
// window.Vue.prototype.authorize = function (handler) {
//     let user = window.App.user;
//
//     return user ? handler(user) : false;
//
//     // if (!user) return false;
//     //
//     // return handler(user);
// };
let authorizations = require('./authorizations');

window.Vue.prototype.authorize = function (...params) {
    if (!window.App.signedIn) return false;

    if (typeof params[0] === 'string') {
        return authorizations[params[0]](params[1]);
    }

    return params[0](window.App.user);
};

window.Vue.prototype.signedIn = window.App.signedIn;

require('./bootstrap');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/Flash.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.config.ignoredElements = ['trix-editor'];

Vue.component('flash', require('./components/Flash.vue').default);  // global component
Vue.component('thread-view', require('./pages/Thread.vue').default);  // global component
Vue.component('paginator', require('./components/Paginator.vue').default);  // global component
Vue.component('user-notifications', require('./components/UserNotifications.vue').default);  // global component
Vue.component('avatar-form', require('./components/AvatarForm.vue').default);  // global component
Vue.component('wysiwyg-editor', require('./components/WysiwygEditor.vue').default);  // global component
Vue.component('search', require('./components/Search.vue').default);  // global component
Vue.component('chart', require('./components/Chart.vue').default);  // global component
Vue.component('scroll-to', require('./components/ScrollTo.vue').default);  // global component

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
