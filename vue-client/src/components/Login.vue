<template>
  <div class="container">
    <div class="col-6 offset-3 mt-5">
      <div class="card">
        <div class="card-header">
          Login
        </div>
        <div class="card-body">
          <form @submit.prevent="login">
            <div class="form-group">
              <label for="email">Email address</label>
              <input type="email" class="form-control" v-model="formData.email" id="email" placeholder="Enter email">
              <span class="text-danger" v-if="errors.email">{{ errors.email[0] }}</span>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" v-model="formData.password" id="password" placeholder="Password">
              <span class="text-danger" v-if="errors.password">{{ errors.password[0] }}</span>
            </div>
            <button type="submit" class="btn btn-primary float-right">Login</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  name: "Login",
  data(){
    return{
      formData: {
        email: '',
        password: '',
      },
      errors:{
        email: '',
        password: ''
      }
    }
  },

  created() {

    if (localStorage.getItem('token')){
      this.$router.push({ path: '/home' })
    }

  },

  methods:{
    login(){

      this.axios.post('login', this.formData).then((response) => {

        localStorage.setItem('token', response.data.token)
        this.$router.push({ path: '/home' })

      }).catch(error => {

        this.errors.email = error.response.data.errors.email;
        this.errors.password = error.response.data.errors.password;

      })

    }
  }
}
</script>

<style scoped>

</style>