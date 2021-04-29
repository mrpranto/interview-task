<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
    <div class="container">
      <a class="navbar-brand" href="/">Vue Client</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">

          <template v-if="!token">
            <li class="nav-item"><router-link to="/login" class="nav-link" >Login</router-link></li>
            <li class="nav-item"><router-link to="/register" class="nav-link" href="#!">Register</router-link></li>
          </template>
          <template v-else>
            <li class="nav-item"><router-link to="/users" class="nav-link">Users</router-link></li>
            <li class="nav-item"><router-link to="/roles" class="nav-link">Roles</router-link></li>
            <li class="nav-item"><router-link to="/profile" class="nav-link">Profile</router-link></li>
            <li class="nav-item"><a @click="logout" class="nav-link" href="#">Logout</a></li>
          </template>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  name: "Navbar",
  data(){
    return{
      token: localStorage.getItem('token')
    }
  },

  methods:{
    logout(){
      this.axios.post('logout',).then((response) => {

      if (response.data.success){
        localStorage.removeItem('token')
        this.$router.push({ path: '/login' })
      }

      }).catch(error => {
        console.log(error.response.data.message)
      })
    }
  }
}
</script>

<style scoped>

</style>