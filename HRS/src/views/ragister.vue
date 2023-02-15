<template>
   <div class="logo">
    <img src="../assets/logoNU.png" alt="logo_nu" />
  </div>
  <div class="loginbox">
    <p id="p01">Please sign up</p>
  </div>
  <!-- <V-alert style="background-color: aqua;">{{ output }}</V-alert> -->

  <p id="username">Username :<input type="text" ref="username" required id="ip1"></p>
  <p id="password">Password :<input type="password" ref="password1" required id="ip1"></p>
  <p id="cfpassword">confirm password :<input type="password" ref="password2" required id="ip1"></p>
  <p id="email">Email :<input type="email" ref="email" required id="ip1"></p>
  <!-- <h3>status : <select name="" id="" ref="status"> -->
        <!-- <option v-for="(item, index) in invite" :key="index">{{ item }}</option>
      </select></h3> -->
      <button @click.prevent="signup" type="add" id="btn1">Sign up</button>
      
      <p id="h-ac">
        You have account &nbsp; <router-link to="/">Sign in ?</router-link>
      </p>
       
</template>

<script>
import axios from 'axios';
import haderVue from "./hader.vue";
export default {
    name:"ragister",
    data(){
        return{
            // invite: ["Student/Personnel", "technician", "Employee"],
            
            username:"",
            password1:"",
            password2:"",
            email:"",
            // status:"",

            output:""
        }
    },
    methods:{
        signin(){
            this.$router.push({ name: "login" });
        },
        signup(){
            this.username = this.$refs.username.value,
            this.password1 = this.$refs.password1.value,
            this.password2 = this.$refs.password2.value,
            this.email = this.$refs.email.value,
            // this.status = this.$refs.status.value
            axios
        .post("http://localhost:/PJ1/connect.php", {
          user: this.username,
          pass1: this.password1,
          pass2: this.password2,
          email: this.email,
          // status: this.status,
          action: "signup",
        })
        .then((red) => {
          this.output = red.data;
          alert(red.data)
          // alert(red.data)
          if(red.data == "สมัครสมาชิกเรียบร้อย"){
            this.$router.push({ name: "login" });
            // alert(red.data)
          }
        });
        }
    },
    components: {
    haderVue,
  },
}
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,500;0,600;0,700;0,800;0,900;1,800&family=Noto+Sans+Thai+Looped:wght@100;200;300;400;500;600;700;800;900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap");
button {
  padding: 9px 25px;
  background-color: #5c7392;
  border: none;
  border-radius: 50px;
  cursor: pointer;
  transition: all 0.2s ease 0s;
}

button:hover {
  background-color: #1900ff;
}
.logo {
  justify-content: center;
  position: relative;
  display: flex;
  top:50px;
}

.loginbox {
  display: flex;
  justify-content: center;
  position: relative;
  top: 50px;
}

.loginbox #p01 {
  display: flex;
  justify-content: center;
  position: relative;
  top: 20px;
  height: 40px;

  font-family: "Roboto", sans-serif;
  font-size: 200%;
  font-weight: 600;
  line-height: 0px;
  text-align: center;

  color: #00204a;
  border-radius: 10px;
}
#username {
  display: flex;
  justify-content: center;
  position: relative;
  right: 20px;
  top: 20px;

  font-style: normal;
  font-weight: 500;
  font-size: 20px;
  line-height: 24px;
  text-align: center;
  font-family: "Roboto", sans-serif;
  color: #00204a;
}

#ip1 {
  display: flex;
  justify-content: center;
  position: relative;
  left: 20px;
  width: 15%;
  
  padding: 3px 10px;
  font-size: 18px;
  font-family: "Roboto", sans-serif;
  background: #ffffff;
  border-radius: 5px;
}

#password {
  display: flex;
  justify-content: center;
  position: relative;
  left: -20px;
  top: 20px;

  font-style: normal;
  font-weight: 500;
  font-size: 20px;
  line-height: 24px;
  text-align: center;
  font-family: "Roboto", sans-serif;
  color: #00204a;
}
#cfpassword {
  display: flex;
  justify-content: center;
  position: relative;
  left: -55px;
  top: 20px;

  font-style: normal;
  font-weight: 500;
  font-size: 20px;
  line-height: 24px;
  text-align: center;
  font-family: "Roboto", sans-serif;
  color: #00204a;
}
#email {
  display: flex;
  justify-content: center;
  position: relative;
  top: 20px;

  font-style: normal;
  font-weight: 500;
  font-size: 20px;
  line-height: 24px;
  text-align: center;
  font-family: "Roboto", sans-serif;
  color: #00204a;
}
.bt {
  display: flex;
  justify-content: center;
}
#btn1 {
  position: relative;
  top: 20px;
  left: 47%;
  width: auto;
  height: auto;
  padding: 5px 20px;

  font-size: 20px;
  font-family: "Roboto", sans-serif;
  font-weight: 600;

  background: #fab317;
  border: #fab317;
  border-radius: 20px;
}

#btn1:hover {
  background-color: #00204a;
  color: #ffff;
}

#h-ac {
  display: flex;
  justify-content: center;
  position: relative;
  top: 20px;
  font-family: "Roboto", sans-serif;
  font-style: normal;
  font-weight: 400;
  font-size: 16px;
  line-height: 19px;
  text-align: center;

  color: #000000;
}


</style>