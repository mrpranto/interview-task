<template>
  <div class="container">
    <div class="col-6 offset-3 mt-5">
      <div class="card">
        <div class="card-header">
          Register
        </div>
        <div class="card-body">
          <form @submit.prevent="register">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control" v-model="formData.name" id="name" aria-describedby="emailHelp" placeholder="Enter name">
              <span class="text-danger" v-if="errors.name">{{ errors.name[0] }}</span>
            </div>
            <div class="form-group">
              <label for="email">Email address</label>
              <input type="email" class="form-control" v-model="formData.email" id="email" aria-describedby="emailHelp" placeholder="Enter email">
              <span class="text-danger" v-if="errors.email">{{ errors.email[0] }}</span>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" v-model="formData.password" id="password" placeholder="Password">
              <span class="text-danger" v-if="errors.password">{{ errors.password[0] }}</span>
            </div>
            <div class="form-group">
              <label for="confirm_password">Confirm Password</label>
              <input type="password" class="form-control" v-model="formData.password_confirmation" id="confirm_password" placeholder="Confirm Password">
              <span class="text-danger" v-if="errors.password_confirmation">{{ errors.password_confirmation[0] }}</span>
            </div>
            <button type="submit" class="btn btn-primary float-right">Register</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Register",
  data(){
    return{
      formData: {
        name: '',
        email:'',
        password:'',
        password_confirmation:''
      },
      errors:{
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      }
    }
  },
  created() {

    if (localStorage.getItem('token')){
      this.$router.push({ path: '/home' })
    }

  },

  methods:{
    register(){
      this.axios.post('register', this.formData).then((response) => {

        localStorage.setItem('token', response.data.token)
        this.$router.push({ path: '/home' })

      }).catch(error => {

        this.errors.name = error.response.data.errors.name;
        this.errors.email = error.response.data.errors.email;
        this.errors.password = error.response.data.errors.password;
        this.errors.password_confirmation = error.response.data.errors.password_confirmation;

      })
    }
  }
}
</script>

<style scoped>

</style>