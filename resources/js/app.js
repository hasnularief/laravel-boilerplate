
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import './filters.js';

import datePicker from 'vue-bootstrap-datetimepicker';
Vue.use(datePicker);

Vue.prototype.$onAjaxError = function(error) {
	if(error.response && error.response.status == 422 && error.response.data.field){
		alertify.error("Error " + error.response.status + ': ' + error.response.data.text);
		var validation = {};
		validation[error.response.data.field] = true;
		return validation;
	}
	else if(error.response && error.response.status == 422) {
		alertify.error("Error " + error.response.status + ': ' + error.response.data.message);
		return error.response.data.errors;
	}
	else {
		alertify.error("Error " + error.response.status + ': ' + error.response.data);
		return {};
	}
}

var VueCookie = require('vue-cookie');

var Cookie = require('tiny-cookie');
VueCookie.getOr =  (function (name, defaultValue, parseJson = false) { return Cookie.get(name) ? (parseJson ? JSON.parse(Cookie.get(name)) : Cookie.get(name)) : defaultValue })

Vue.use(VueCookie);

import selectize from "vue2-selectize"
Vue.component('selectize', selectize);

Vue.component('content-header', require('./components/includes/ContentHeader.vue'));
Vue.component('loading', require('./components/includes/LoadingBox.vue'));
Vue.component('modal', require('./components/includes/Modal.vue'));
Vue.component('modal-small', require('./components/includes/ModalSmall.vue'));
Vue.component('pagination', require('./components/includes/pagination.vue'));
Vue.component('select2', require('./components/includes/Select2.vue'));
Vue.component('v-date-picker', require('./components/includes/DatePicker.vue'));
Vue.component('img-preview', require('./components/includes/ImagePreview.vue'));
Vue.component('select-user', require('./components/includes/SelectUser.vue'));

Vue.component('box-component', require('./components/BoxComponent.vue'));

Vue.component('users-component', require('./components/Users.vue'));
Vue.component('permissions-component', require('./components/Permissions.vue'));
Vue.component('roles-component', require('./components/Roles.vue'));
Vue.component('profile-component', require('./components/Profile.vue'));

const app = new Vue({
    el: '#app'
});
