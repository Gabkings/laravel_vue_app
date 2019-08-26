<template>
<div class="container">
    <form @submit.prevent="addProduct" class="mb-3">
  <div class="form-group">
    <label for="name">Product Name</label>
    <input type="text" class="form-control" id="name" placeholder="Enter Product Name" v-model="product.name">
  </div>
  <div class="form-group">
    <label for="description">Product Description</label>
    <input type="text" class="form-control" id="description" placeholder="Product Description" v-model="product.description">
  </div>
  <div class="form-group">
  <label for="quantity">Quantity</label>
    <input type="text" class="form-control" id="quantity" placeholder="Product Qantity" v-model="product.quantity">
  </div>
  <button type="submit" class="btn btn-light btn-block">Submit</button>
</form>
<table class="table table-dark">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Product Name</th>
      <th scope="col">Product Description</th>
      <th scope="col">Quantity</th>
      <th scope="col">Date Added</th>
      <th scope="col">Date Updated</th>
      <th scope="col">Date Archived</th>
      <th colspan="3">Actions</th>     
    </tr>
  </thead>
  <tbody>
    <tr v-for="product in products" v-bind:key="product.id">
      <th scope="row">{{ product.id }}</th>
      <td>{{ product.name }}</td>
      <td>{{ product.description }}</td>
      <td>{{ product.quantity }}</td>
      <th>{{ product.created_at }}</th>
      <th>{{ product.updated_at }}</th>
      <th><button @click="editArticle(product)" class="btn btn-warning mb-2">Edit</button></th>
      <th><button @click="archiveProduct(product.id)" class="btn btn-warning">Archive</button></th>
    </tr>
  </tbody>
</table>
<center><h2 class="center">View Archived Products Below </h2></center>
<table class="table table-dark">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Product Name</th>
      <th scope="col">Product Description</th>
      <th scope="col">Quantity</th>
      <th scope="col">Date Added</th>
      <th scope="col">Date Archived</th>
      <th scope="col">Delete Permanent</th>   
    </tr>
  </thead>
  <tbody>
    <tr v-for="product in archives" v-bind:key="product.id">
      <th scope="row">{{ product.id }}</th>
      <td>{{ product.name }}</td>
      <td>{{ product.description }}</td>
      <td>{{ product.quantity }}</td>
      <th>{{ product.created_at }}</th>
      <th>{{ product.deleted_at }}</th>
      <th><button @click="restoreProduct(product.id)" class="btn btn-info">Restore</button></th>
      <th><button @click="deleteProduct(product.id)" class="btn btn-danger">Delete</button></th>
    </tr>
  </tbody>
</table>

</div>
      
      
</template>

<script>
export default {
  data() {
    return {
      products: [],
      archives: [],
      product: {
        id: '',
        name: '',
        description: '',
        quantity:''
      },
      product_id: '',
      edit: false
    };
  },

  created() {
    this.fetchArticles();
    this.fetchArchivedArticles();
  },

  methods: {
    fetchArticles() {
      let page_url = '/api/v1/products';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.products = res.data;
        })
        .catch(err => console.log(err));
    },
    fetchArchivedArticles() {
      let page_url = '/api/v2/products/softdeleted';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.archives = res.data;
        })
        .catch(err => console.log(err));
    },
    archiveProduct(id) {
      if (confirm('Are You Sure?')) {
        fetch(`api/v1/products/soft/${id}`, {
          method: 'delete'
        })
          .then(res => res.json())
          .then(data => {
            alert('Article Removed');
            this.fetchArticles();
          })
          .catch(err => console.log(err));
      }
    },
    deleteProduct(id) {
      if (confirm('Are You Sure?')) {
        fetch(`api/v1/products/${id}`, {
          method: 'delete'
        })
          .then(res => res.json())
          .then(data => {
            alert('Article Removed');
            this.fetchArchivedArticles();
          })
          .catch(err => console.log(err));
      }
    },
    restoreProduct(id) {
      if (confirm('Are You Sure?')) {
        fetch(`api/v1/products/restore/${id}`, {
          method: 'PATCH'
        })
          .then(res => res.json())
          .then(data => {
            alert('Product Restored');
            this.fetchArticles();
          })
          .catch(err => console.log(err));
      }
    },
    addProduct() {
      if (this.edit === false) {
        // Add
        fetch('/api/v1/products', {
          method: 'post',
          body: JSON.stringify(this.product),
          headers: {
            'content-type': 'application/json'
          }
        })
          .then(res => res.json())
          .then(data => {
            this.clearForm();
            alert('Article Added');
            this.fetchArticles();
          })
          .catch(err => console.log(err));
      } else {
        // Update
        fetch('/api/v1/products', {
          method: 'put',
          body: JSON.stringify(this.product),
          headers: {
            'content-type': 'application/json'
          }
        })
          .then(res => res.json())
          .then(data => {
            this.clearForm();
            alert('Article Updated');
            this.fetchArticles();
          })
          .catch(err => console.log(err));
      }
    },
    editArticle(product) {
      this.edit = true;
      this.product.id = product.id;
      this.product.name = product.name;
      this.product.description = product.description;
      this.product.quantity = product.quantity
    },
    clearForm() {
      this.edit = false;
      this.product.id = null;
      this.product.name = null;
      this.product.description = '';
      this.product.quantity = '';
    }
  }
};
</script>

