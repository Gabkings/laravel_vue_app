<template>
<div class="container">
    <form @submit.prevent="addsupplier" class="mb-3">
  <div class="form-group">
    <label for="name">Supplier Number</label>
    <input type="text" class="form-control" id="name" placeholder="Enter supplier Name" v-model="supplier.name">
  </div>
  <button type="submit" class="btn btn-light btn-block">Submit</button>
</form>
<table class="table table-dark">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Supplier Number</th>
      <th scope="col">Date Added</th>
      <th scope="col">Date Updated</th>   
    </tr>
  </thead>
  <tbody>
    <tr v-for="supplier in suppliers" v-bind:key="supplier.id">
      <th scope="row">{{ supplier.id }}</th>
      <td>{{ supplier.name }}</td>
      <th>{{ supplier.created_at }}</th>
      <th>{{ supplier.updated_at }}</th>
      <th><button @click="editSupplier(supplier)" class="btn btn-warning mb-2">Edit</button></th>
      <th><button @click="archiveSupplier(supplier.id)" class="btn btn-warning">Archive</button></th>
    </tr>
  </tbody>
</table>
<center><h2 class="center">View Archived suppliers Below </h2></center>
<table class="table table-dark">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">supplier Name</th>
      <th scope="col">Date Added</th>
      <th scope="col">Date Archived</th>
      <th scope="col">Delete Permanent</th>   
    </tr>
  </thead>
  <tbody>
    <tr v-for="supplier in archives" v-bind:key="supplier.id">
      <th scope="row">{{ supplier.id }}</th>
      <td>{{ supplier.supplier_number }}</td>
      <th>{{ supplier.created_at }}</th>
      <th>{{ supplier.deleted_at }}</th>
      <th><button @click="restoreSupplier(supplier.id)" class="btn btn-info">Restore</button></th>
      <th><button @click="deleteSupplier(supplier.id)" class="btn btn-danger">Delete</button></th>
    </tr>
  </tbody>
</table>

</div>
      
      
</template>

<script>
export default {
  data() {
    return {
      suppliers: [],
      archives: [],
      supplier: {
        id: '',
        name: ''
      },
      supplier_id: '',
      edit: false
    };
  },

  created() {
    this.fetchSuppliers();
    this.fetchArchivedSuppliers();
  },

  methods: {
    fetchSuppliers() {
      let page_url = '/api/v1/suppliers';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.suppliers = res.data;
        })
        .catch(err => console.log(err));
    },
    fetchArchivedSuppliers() {
      let page_url = '/api/v2/suppliers/softdeleted';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.archives = res.data;
        })
        .catch(err => console.log(err));
    },
    archiveSupplier(id) {
      if (confirm('Are You Sure?')) {
        fetch(`api/v1/suppliers/soft/${id}`, {
          method: 'delete'
        })
          .then(res => res.json())
          .then(data => {
            alert('Article Removed');
            this.fetchSuppliers();
          })
          .catch(err => console.log(err));
      }
    },
    deleteSupplier(id) {
      if (confirm('Are You Sure?')) {
        fetch(`api/v1/suppliers/${id}`, {
          method: 'delete'
        })
          .then(res => res.json())
          .then(data => {
            alert('Article Removed');
            this.fetchArchivedSuppliers();
          })
          .catch(err => console.log(err));
      }
    },
    restoreSupplier(id) {
      if (confirm('Are You Sure?')) {
        fetch(`api/v1/suppliers/restore/${id}`, {
          method: 'PATCH'
        })
          .then(res => res.json())
          .then(data => {
            alert('supplier Restored');
            this.fetchSuppliers();
          })
          .catch(err => console.log(err));
      }
    },
    addsupplier() {
      if (this.edit === false) {
        // Add
        fetch('/api/v1/suppliers', {
          method: 'post',
          body: JSON.stringify(this.supplier),
          headers: {
            'content-type': 'application/json'
          }
        })
          .then(res => res.json())
          .then(data => {
            this.clearForm();
            alert('Article Added');
            this.fetchSuppliers();
          })
          .catch(err => console.log(err));
      } else {
        // Update
        fetch('/api/v1/suppliers', {
          method: 'put',
          body: JSON.stringify(this.supplier),
          headers: {
            'content-type': 'application/json'
          }
        })
          .then(res => res.json())
          .then(data => {
            this.clearForm();
            alert('Article Updated');
            this.fetchSuppliers();
          })
          .catch(err => console.log(err));
      }
    },
    editSupplier(supplier) {
      this.edit = true;
      this.supplier.id = supplier.id;
      this.supplier.name = supplier.name;
    },
    clearForm() {
      this.edit = false;
      this.supplier.id = null;
      this.supplier.name = null;
    }
  }
};
</script>

