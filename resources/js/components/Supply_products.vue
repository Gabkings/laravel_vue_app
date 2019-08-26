<template>
<div class="container">
    <form @submit.prevent="addsupply_product" class="mb-3">
  <div class="form-group">
    <label for="name">Supplier</label>
    <input type="text" class="form-control" id="name" placeholder="Enter supply_product Name" v-model="supply_product.supply_id">
  </div>
    <div class="form-group">
    <label for="name">Product</label>
    <input type="text" class="form-control" id="name" placeholder="Enter supply_product Name" v-model="supply_product.product_id">
  </div>
  <button type="submit" class="btn btn-light btn-block">Submit</button>
</form>
<table class="table table-dark">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Supplier</th>
      <th scope="col">Product</th>
      <th scope="col">Date Added</th>
      <th scope="col">Date Updated</th>
      <th scope="col">Archived</th>     
    </tr>
  </thead>
  <tbody>
    <tr v-for="supply_product in supply_products" v-bind:key="supply_product.id">
      <th scope="row">{{ supply_product.id }}</th>
      <td>{{ supply_product.supply_id }}</td>
      <td>{{ supply_product.product_id }}</td>
      <th>{{ supply_product.created_at }}</th>
      <th>{{ supply_product.updated_at }}</th>
      <th><button @click="editSupplyProduct(supply_product)" class="btn btn-warning mb-2">Edit</button></th>
      <th><button @click="archiveOrderDetail(supply_product.id)" class="btn btn-warning">Archive</button></th>
    </tr>
  </tbody>
</table>
<center><h2 class="center">View Archived supply_products Below </h2></center>
<table class="table table-dark">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Supplier</th>
      <th scope="col">Product</th>
      <th scope="col">Date Archived</th>
      <th scope="col">Delete Permanent</th>   
    </tr>
  </thead>
  <tbody>
    <tr v-for="supply_product in archives" v-bind:key="supply_product.id">
      <th scope="row">{{ supply_product.id }}</th>
      <td>{{ supply_product.supply_id }}</td>
      <td>{{ supply_product.product_id }}</td>
      <th>{{ supply_product.created_at }}</th>
      <th>{{ supply_product.deleted_at }}</th>
      <th><button @click="restoreOrderDetail(supply_product.id)" class="btn btn-info">Restore</button></th>
      <th><button @click="deleteOrderDetail(supply_product.id)" class="btn btn-danger">Delete</button></th>
    </tr>
  </tbody>
</table>

</div>
      
      
</template>

<script>
export default {
  data() {
    return {
      supply_products: [],
      archives: [],
      supply_product: {
        id: '',
        supplier_id: '',
        product_id: ''
      },
      supply_product_id: '',
      edit: false
    };
  },

  created() {
    this.fetchOrderDetails();
    this.fetchArchivedOrderDetails();
  },

  methods: {
    fetchOrderDetails() {
      let page_url = '/api/v1/supply_products';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.supply_products = res.data;
        })
        .catch(err => console.log(err));
    },
    fetchArchivedOrderDetails() {
      let page_url = '/api/v2/supply_products/softdeleted';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.archives = res.data;
        })
        .catch(err => console.log(err));
    },
    archiveOrderDetail(id) {
      if (confirm('Are You Sure?')) {
        fetch(`api/v1/supply_products/soft/${id}`, {
          method: 'delete'
        })
          .then(res => res.json())
          .then(data => {
            alert('Article Removed');
            this.fetchArchivedOrderDetails();
          })
          .catch(err => console.log(err));
      }
    },
    deleteOrderDetail(id) {
      if (confirm('Are You Sure?')) {
        fetch(`api/v1/supply_products/${id}`, {
          method: 'delete'
        })
          .then(res => res.json())
          .then(data => {
            alert('Article Removed');
            this.fetchArchivedOrderDetails();
          })
          .catch(err => console.log(err));
      }
    },
    restoreOrderDetail(id) {
      if (confirm('Are You Sure?')) {
        fetch(`api/v1/supply_products/restore/${id}`, {
          method: 'PATCH'
        })
          .then(res => res.json())
          .then(data => {
            alert('supply_product Restored');
            this.fetchOrderDetails();
          })
          .catch(err => console.log(err));
      }
    },
    addsupply_product() {
      if (this.edit === false) {
        // Add
        fetch('/api/v1/supply_products', {
          method: 'post',
          body: JSON.stringify(this.supply_product),
          headers: {
            'content-type': 'application/json'
          }
        })
          .then(res => res.json())
          .then(data => {
            this.clearForm();
            alert('Article Added');
            this.fetchOrderDetails();
          })
          .catch(err => console.log(err));
      } else {
        // Update
        fetch('/api/v1/supply_products', {
          method: 'put',
          body: JSON.stringify(this.supply_product),
          headers: {
            'content-type': 'application/json'
          }
        })
          .then(res => res.json())
          .then(data => {
            this.clearForm();
            alert('Article Updated');
            this.fetchOrderDetails();
          })
          .catch(err => console.log(err));
      }
    },
    editSupplyProduct(supply_product) {
      this.edit = true;
      this.supply_product.id = supply_product.id;
      this.supply_product.supply_id = supply_product.supply_id;
      this.supply_product.product_id = supply_product.product_id;
    },
    clearForm() {
      this.edit = false;
      this.supply_product.id = null;
      this.supply_product.supply_id = null;
      this.supply_product.product_id = null;
    }
  }
};
</script>

