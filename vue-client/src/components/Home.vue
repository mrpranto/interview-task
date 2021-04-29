<template>
  <div class="container">
    <div class="col-12 mt-5 text-center" v-if="userInfo">
      <h4>Hello, Mr. <template v-if="userInfo.name">{{ userInfo.name }}</template> </h4>
      <h5>Welcome to Dashboard</h5>
    </div>
  </div>
</template>

<script>

export default {
  name: 'Home',
  data(){
    return{
        userInfo:{
          name:'',
          email:''
        }
    }
  },

  created() {

    if (localStorage.getItem('token')){

      this.axios.get('user').then((response) => {

        this.userInfo.email = response.data.email;
        this.userInfo.name = response.data.name;

      }).catch(error => {

        console.log(error.response.data.message)

      })

    }else {

      this.$router.push({ path: '/login' })

    }

  }

}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h3 {
  margin: 40px 0 0;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
</style>
