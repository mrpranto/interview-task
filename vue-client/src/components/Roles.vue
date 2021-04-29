<template>
  <div class="container">
    <div class="col-12 mt-5">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Role List</h4>
          <div class="card-tools" style="position: absolute;right: 1rem; top: 1rem">
            <button type="button" class="btn btn-dark btn-sm" id="show-modal" @click="addRole">Add New Role</button>
          </div>
        </div>
        <div class="card-body">
          <div class="alert alert-success" v-if="successMessage">{{ successMessage }}</div>

            <table class="table table-bordered">
              <tr>
                <th>SL</th>
                <th>Name</th>
                <th>Description</th>
                <th>Action</th>
              </tr>
              <tr v-for="(role, index) in roles" :key="index">
                <td>{{ index+1 }}</td>
                <td>{{ role.name }}</td>
                <td>{{ role.description }}</td>
                <td>
                  <div class="btn-group">
                    <button class="btn btn-sm btn-primary" @click="editRole(role)">Edit Role</button>
                    <button class="btn btn-sm btn-danger" @click="deleteRole(role)">Delete Role</button>
                  </div>
                </td>
              </tr>

            </table>
        </div>
      </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{ editMode ? 'Edit Role' : 'Add Role' }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editMode ? update() : store()">
            <div class="modal-body">

              <div class="form-group">
                <label for="role">Name</label>
                <input type="text" id="role" v-model="formData.name" class="form-control">
                <span class="text-danger" v-if="errors.name">{{ errors.name[0] }}</span>
              </div>

              <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" v-model="formData.description" class="form-control"></textarea>
                <span class="text-danger" v-if="errors.description">{{ errors.description[0] }}</span>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>



  </div>
</template>

<script>
import $ from 'jquery'
export default {
  name: "Roles",
  data(){
    return{
      editMode:false,
      roles:{},
      formData: {
        name:'',
        description:''
      },
      successMessage:'',
      errors:{
        name: '',
        description: '',
      },
      updateUrl:''
    }
  },

  created() {

    if (localStorage.getItem('token')){

      this.getRoles()

    }else {

      this.$router.push({ path: '/login' })

    }
  },

  methods:{
    addRole(){
      this.editMode = false;
      this.formData.name = '';
      this.formData.description = '';
      this.errors.name = '';
      this.errors.description = '';
      $('#exampleModal').modal('show')
    },

    getRoles(){
      this.axios.get('roles').then((response) => {

        this.roles = response.data.roles;

      }).catch(error => {

        console.log(error.response.data.message)

      })
    },

    editRole(role){
      this.editMode = true;
      this.formData.name = role.name;
      this.formData.description = role.description;
      this.errors.name = '';
      this.errors.description = '';

      this.updateUrl = 'roles/'+role.id;
      $('#exampleModal').modal('show')
    },

    store(){
      this.axios.post('roles', this.formData).then((response) => {

        if (response.data.success){
          this.getRoles()
          this.successMessage = response.data.message
          $('#exampleModal').modal('hide')
        }

      }).catch(error => {

        this.errors.name = error.response.data.errors.name;
        this.errors.description = error.response.data.errors.description;

      })
    },
    update(){
      this.axios.put(this.updateUrl, this.formData).then((response) => {

        if (response.data.success){
          this.getRoles()
          this.successMessage = response.data.message
          $('#exampleModal').modal('hide')
        }

      }).catch(error => {

        this.errors.name = error.response.data.errors.name;
        this.errors.description = error.response.data.errors.description;

      })

    },
    deleteRole(role){

      if (confirm("Are you sure ? you want to delete?")){

        this.axios.delete('roles/'+role.id).then((response) => {

          if (response.data.success){
            this.getRoles()
            this.successMessage = response.data.message
            $('#exampleModal').modal('hide')
          }

        }).catch(error => {

          this.errors.name = error.response.data.errors.name;
          this.errors.description = error.response.data.errors.description;

        })

      }

    },



  }
}
</script>

<style scoped>

</style>