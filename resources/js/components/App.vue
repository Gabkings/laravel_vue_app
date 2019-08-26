<template>
    <div>
        <div class="container mb-3">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Simple Inventory</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <router-link class="nav-link" :to="{ name: 'home' }">Home</router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" :to="{ name: 'products' }">Products</router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" :to="{ name: 'suppliers' }">Suppliers</router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" :to="{ name: 'orders' }">Orders</router-link>
            </li>
             <li class="nav-item">
                <router-link class="nav-link" :to="{ name: 'order_detail' }">Order Details</router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" :to="{ name: 'supply_details' }">Supply Products</router-link>
            </li>
            </ul>
        </div>
        </nav>
        </div>

        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    export default {}
</script>
