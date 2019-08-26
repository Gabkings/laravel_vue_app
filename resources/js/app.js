require('./bootstrap');

//window.Vue = require('vue');
import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('navbar', require('./components/navbar.vue').default);
// Vue.component('products', require('./components/Products.vue').default);
// Vue.component('suppliers', require('./components/Suppliers.vue').default);
// Vue.component('supply_products', require('./components/Supply_products.vue').default);
// Vue.component('orders', require('./components/Orders.vue').default);
// Vue.component('order_details', require('./components/Order_details.vue').default);

import Products from './components/Products'
import Suppliers from './components/Suppliers'
import Supply_products from './components/Supply_products'
import Orders from './components/Orders'
import Order_details from './components/Order_details'
import Home from './components/Home'
import App from './components/App'


const router = new VueRouter({
  mode: 'history',
  routes: [
      {
          path: '/',
          name: 'home',
          component: Home
      },
      {
          path: '/products',
          name: 'products',
          component: Products,
      },
      {
        path: '/orders',
        name: 'orders',
        component: Orders,
    },
    {
      path: '/order_detail',
      name: 'order_detail',
      component: Order_details,
  },
  {
    path: '/suppliers',
    name: 'suppliers',
    component: Suppliers,
  },
  {
    path: '/supply_details',
    name: 'supply_details',
    component: Supply_products,
},
  ],
});


const app = new Vue({
  el: '#app',
  components: {App},
  router
});

//Vue.component('thing', require('libs/components/thing.vue').default);