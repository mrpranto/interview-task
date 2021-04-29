<template>
  <div class="container">
    <div class="col-12 mt-5">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">User List</h4>
        </div>
        <div class="card-body">
          <div class="alert alert-success" v-if="successMessage">{{ successMessage }}</div>

            <table class="table table-bordered" id="users_table">
              <tr>
                <th>SL</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>City</th>
                <th>District</th>
                <th>Address</th>
                <th>Role</th>
                <th>Action</th>
              </tr>

              <tr v-for="(user, index) in users" :key="index">
                <td>{{ (index + 1) }}</td>
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.profile ? user.profile.phone : '-' }}</td>
                <td>{{ user.profile ? user.profile.city : '-' }}</td>
                <td>{{ user.profile ? user.profile.district : '-' }}</td>
                <td>{{ user.profile ? user.profile.address : '-' }}</td>
                <td>{{ user.role ? user.role.name : 'No Role assign yet' }}</td>
                <td>
                  <button type="button" class="btn btn-sm btn-primary" @click="addRole(user)">{{ user.role ? 'Edit Role' : 'Assign Role' }}</button>
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
            <h5 class="modal-title" id="exampleModalLabel">Add Role to user</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="assignRole">
            <div class="modal-body">

              <div class="form-group">
                <label for="role">Role</label>
                <select class="form-control" id="role" v-model="formData.role_id">
                  <option value="">- Select Role -</option>

                  <option v-for="(role, index) in roles" :key="index" :value="role.id" selected="">{{ role.name }}</option>

                </select>
                <span class="text-danger" v-if="errors.role_id">{{ errors.role_id[0] }}</span>
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
  name: "Users",
  data(){
    return {
      users:{},
      roles:{},
      formData: {
        role_id:''
      },
      successMessage:'',
      errors:{
        role_id: '',
      },
      assignUrl:''
    }
  },
  created() {

    if (localStorage.getItem('token')){

      this.getUsers()

      this.axios.get('roles').then((response) => {

        this.roles = response.data.roles;

      }).catch(error => {

        console.log(error.response.data.message)

      })

    }else {

      this.$router.push({ path: '/login' })

    }
  },

  methods:{

    addRole(user){

      this.formData.role_id = user.role_id
      this.assignUrl = 'users/'+user.id+'/assign-role'

      $('#exampleModal').modal('show')
    },

    assignRole(){

      this.axios.put(this.assignUrl, this.formData).then((response) => {

        if (response.data.success){
          this.getUsers()
          this.successMessage = response.data.message
          $('#exampleModal').modal('hide')
        }

      }).catch(error => {

        this.errors.role_id = error.response.data.errors.role_id;

      })
    },

    getUsers(){
      this.axios.get('users').then((response) => {

        this.users = response.data.users;

      }).catch(error => {

        console.log(error.response.data.message)

      })
    }


  }

}
</script>

<style scoped>

</style>