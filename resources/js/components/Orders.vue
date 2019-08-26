<template>
<div class="container">
    <form @submit.prevent="addorder" class="mb-3">
  <div class="form-group">
    <label for="name">Order Number</label>
    <input type="text" class="form-control" id="name" placeholder="Enter order Name" v-model="order.order_number">
  </div>
  <button type="submit" class="btn btn-light btn-block">Submit</button>
</form>
<table class="table table-dark">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Order Number</th>
      <th scope="col">Date Added</th>
      <th scope="col">Date Updated</th>
      <th scope="col">Date Archived</th>     
    </tr>
  </thead>
  <tbody>
    <tr v-for="order in orders" v-bind:key="order.id">
      <th scope="row">{{ order.id }}</th>
      <td>{{ order.order_number }}</td>
      <th>{{ order.created_at }}</th>
      <th>{{ order.updated_at }}</th>
      <th><button @click="editOrder(order)" class="btn btn-warning mb-2">Edit</button></th>
      <th><button @click="archiveOrder(order.id)" class="btn btn-warning">Archive</button></th>
    </tr>
  </tbody>
</table>
<center><h2 class="center">View Archived orders Below </h2></center>
<table class="table table-dark">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">order Name</th>
      <th scope="col">Date Added</th>
      <th scope="col">Date Archived</th>
      <th scope="col">Delete Permanent</th>   
    </tr>
  </thead>
  <tbody>
    <tr v-for="order in archives" v-bind:key="order.id">
      <th scope="row">{{ order.id }}</th>
      <td>{{ order.order_number }}</td>
      <th>{{ order.created_at }}</th>
      <th>{{ order.deleted_at }}</th>
      <th><button @click="restoreOrder(order.id)" class="btn btn-info">Restore</button></th>
      <th><button @click="deleteOrder(order.id)" class="btn btn-danger">Delete</button></th>
    </tr>
  </tbody>
</table>

</div>
      
      
</template>

<script>
export default {
  data() {
    return {
      orders: [],
      archives: [],
      order: {
        id: '',
        name: ''
      },
      order_id: '',
      edit: false
    };
  },

  created() {
    this.fetchOrders();
    this.fetchArchivedOrders();
  },

  methods: {
    fetchOrders() {
      let page_url = '/api/v1/orders';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.orders = res.data;
        })
        .catch(err => console.log(err));
    },
    fetchArchivedOrders() {
      let page_url = '/api/v2/orders/softdeleted';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.archives = res.data;
        })
        .catch(err => console.log(err));
    },
    archiveOrder(id) {
      if (confirm('Are You Sure?')) {
        fetch(`api/v1/orders/soft/${id}`, {
          method: 'delete'
        })
          .then(res => res.json())
          .then(data => {
            alert('Article Removed');
            this.fetchArchivedOrders();
          })
          .catch(err => console.log(err));
      }
    },
    deleteOrder(id) {
      if (confirm('Are You Sure?')) {
        fetch(`api/v1/orders/${id}`, {
          method: 'delete'
        })
          .then(res => res.json())
          .then(data => {
            alert('Article Removed');
            this.fetchArchivedOrders();
          })
          .catch(err => console.log(err));
      }
    },
    restoreOrder(id) {
      if (confirm('Are You Sure?')) {
        fetch(`api/v1/orders/restore/${id}`, {
          method: 'PATCH'
        })
          .then(res => res.json())
          .then(data => {
            alert('order Restored');
            this.fetchOrders();
          })
          .catch(err => console.log(err));
      }
    },
    addorder() {
      if (this.edit === false) {
        // Add
        fetch('/api/v1/orders', {
          method: 'post',
          body: JSON.stringify(this.order),
          headers: {
            'content-type': 'application/json'
          }
        })
          .then(res => res.json())
          .then(data => {
            this.clearForm();
            alert('Article Added');
            this.fetchOrders();
          })
          .catch(err => console.log(err));
      } else {
        // Update
        fetch('/api/v1/orders', {
          method: 'put',
          body: JSON.stringify(this.order),
          headers: {
            'content-type': 'application/json'
          }
        })
          .then(res => res.json())
          .then(data => {
            this.clearForm();
            alert('Article Updated');
            this.fetchOrders();
          })
          .catch(err => console.log(err));
      }
    },
    editArticle(order) {
      this.edit = true;
      this.order.id = order.id;
      this.order.name = order.order_number;
    },
    clearForm() {
      this.edit = false;
      this.order.id = null;
      this.order.name = null;
    }
  }
};
</script>

