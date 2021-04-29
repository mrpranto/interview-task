<template>
  <div class="container">
    <div class="col-6 offset-3 mt-5">
      <div class="row">
        <div class="col-12 text-center">
          <img :src="'https://ui-avatars.com/api/?name='+userInfo.name" class="img-thumbnail" height="100px">
        </div>
        <div class="col-12 text-center">
            <p>Name: {{ userInfo.name }}</p>
            <p>Role: {{ userInfo.role }}</p>
            <p>Email: {{ userInfo.email }}</p>
            <p>Phone: {{ userInfo.phone }}</p>
            <p>City: {{ userInfo.city }}</p>
            <p>District: {{ userInfo.district }}</p>
            <p>Address: {{ userInfo.address }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  name: "Profile",
  data(){
    return{
      userInfo:{
        email:'',
        name:'',
        phone:'',
        city:'',
        district:'',
        address:'',
        role:'',
      }
    }
  },

  created() {

    if (localStorage.getItem('token')){

      this.axios.get('user').then((response) => {

        this.userInfo.email = response.data.email;
        this.userInfo.name = response.data.name;
        this.userInfo.phone = response.data.profile.phone;
        this.userInfo.city = response.data.profile.city;
        this.userInfo.district = response.data.profile.district;
        this.userInfo.address = response.data.profile.address;
        this.userInfo.role = response.data.role.name;

      }).catch(error => {

        console.log(error.response.data.message)

      })

    }else {

      this.$router.push({ path: '/login' })

    }

  },

  methods:{



  }
}
</script>

<style scoped>

</style>