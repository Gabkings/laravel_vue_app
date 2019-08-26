<template>
<div class="container">
    <form @submit.prevent="addorder_detail" class="mb-3">
  <div class="form-group">
    <label for="name">Order Reference</label>
    <input type="text" class="form-control" id="name" placeholder="Enter order_detail Name" v-model="order_detail.order_id">
  </div>
    <div class="form-group">
    <label for="name">Product Reference</label>
    <input type="text" class="form-control" id="name" placeholder="Enter order_detail Name" v-model="order_detail.product_id">
  </div>
  <button type="submit" class="btn btn-light btn-block">Submit</button>
</form>
<table class="table table-dark">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Order Reference</th>
      <th scope="col">Product Reference</th>
      <th scope="col">Date Added</th>
      <th scope="col">Date Updated</th>
      <th scope="col">Date Archived</th>     
    </tr>
  </thead>
  <tbody>
    <tr v-for="order_detail in order_details" v-bind:key="order_detail.id">
      <th scope="row">{{ order_detail.id }}</th>
      <td>{{ order_detail.order_id }}</td>
      <td>{{ order_detail.product_id }}</td>
      <th>{{ order_detail.created_at }}</th>
      <th>{{ order_detail.updated_at }}</th>
      <th><button @click="editorder_detail(order_detail)" class="btn btn-warning mb-2">Edit</button></th>
      <th><button @click="archiveOrderDetail(order_detail.id)" class="btn btn-warning">Archive</button></th>
    </tr>
  </tbody>
</table>
<center><h2 class="center">View Archived order_details Below </h2></center>
<table class="table table-dark">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">order</th>
      <th scope="col">Product</th>
      <th scope="col">Date Archived</th>
      <th scope="col">Delete Permanent</th>   
    </tr>
  </thead>
  <tbody>
    <tr v-for="order_detail in archives" v-bind:key="order_detail.id">
      <th scope="row">{{ order_detail.id }}</th>
      <td>{{ order_detail.order_id }}</td>
      <td>{{ order_detail.product_id }}</td>
      <th>{{ order_detail.created_at }}</th>
      <th>{{ order_detail.deleted_at }}</th>
      <th><button @click="restoreOrderDetail(order_detail.id)" class="btn btn-info">Restore</button></th>
      <th><button @click="deleteOrderDetail(order_detail.id)" class="btn btn-danger">Delete</button></th>
    </tr>
  </tbody>
</table>

</div>
      
      
</template>

<script>
export default {
  data() {
    return {
      order_details: [],
      archives: [],
      order_detail: {
        id: '',
        order_detail_id: '',
        product_id: ''
      },
      order_detail_id: '',
      edit: false
    };
  },

  created() {
    this.fetchOrderDetails();
    this.fetchArchivedOrderDetails();
  },

  methods: {
    fetchOrderDetails() {
      let page_url = '/api/v1/order_details';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.order_details = res.data;
        })
        .catch(err => console.log(err));
    },
    fetchArchivedOrderDetails() {
      let page_url = '/api/v2/order_details/softdeleted';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.archives = res.data;
        })
        .catch(err => console.log(err));
    },
    archiveOrderDetail(id) {
      if (confirm('Are You Sure?')) {
        fetch(`api/v1/order_details/soft/${id}`, {
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
    deleteOrderDetai(id) {
      if (confirm('Are You Sure?')) {
        fetch(`api/v1/order_details/${id}`, {
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
        fetch(`api/v1/order_details/restore/${id}`, {
          method: 'PATCH'
        })
          .then(res => res.json())
          .then(data => {
            alert('order_detail Restored');
            this.fetchOrderDetails();
          })
          .catch(err => console.log(err));
      }
    },
    addorder_detail() {
      if (this.edit === false) {
        // Add
        fetch('/api/v1/order_details', {
          method: 'post',
          body: JSON.stringify(this.order_detail),
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
        fetch('/api/v1/order_details', {
          method: 'put',
          body: JSON.stringify(this.order_detail),
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
    editArticle(order_detail) {
      this.edit = true;
      this.order_detail.id = order_detail.id;
      this.order_detail.order_id = order_detail.order_id;
      this.order_detail.product_id = order_detail.product_id;
    },
    clearForm() {
      this.edit = false;
      this.order_detail.id = null;
      this.order_detail.order_id = null;
      this.order_detail.product_id = null;
    }
  }
};
</script>

