require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('navbar', require('./components/navbar.vue').default);
Vue.component('products', require('./components/Products.vue').default);
Vue.component('suppliers', require('./components/Suppliers.vue').default);
Vue.component('supply_products', require('./components/Supply_products.vue').default);
Vue.component('orders', require('./components/Orders.vue').default);
Vue.component('order_details', require('./components/Order_details.vue').default);

const app = new Vue({
  el: '#app'
});

//Vue.component('thing', require('libs/components/thing.vue').default);