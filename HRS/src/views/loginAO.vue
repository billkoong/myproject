<template>
  <!-- <header>
    <router-link to="/home"> <p class="logonav">Hire Repair System</p></router-link>
    <nav>
      <ul class="nav_links">
        <li>
          <router-link to="/home">Home</router-link>
        </li>
        <li>
          <router-link to="/Homeuser">My report</router-link>
        </li>
        <li>
          <router-link to="/-">Help</router-link>
        </li>
        <li>
          <router-link to="/" id="logout">Logout</router-link>
        </li>
      </ul>
    </nav>
  </header> -->
  <div class="header">
    <p id="head">Access</p>
    <p id="dt-head">for open Impose Limit and Accept page</p>
  </div>
  <div class="verify-code-box">
    <img src="../assets/pic7.png" alt="" id="pic7" />
    <div class="box-verify">
      <p id="verify">Verification Code</p>
      <form action="">
      <input type="password" ref="pass" id="password" /> <br>
      <button @click="next" id="next" >NEXT</button>
      </form>
    </div>
  </div>
</template>


<script>
import haderVue from './hader.vue';
export default {
    name:"loginMPY",
    data(){
        return{
            pass:"",
        }
    },
    methods:{
        next(){
            this.pass = this.$refs.pass.value
            // กำหนดรหัสของ MPY ตรงนี้นะจ้ะ
            if(this.pass == "1234"){
                localStorage.setItem("pass" , "pass");
                this.$router.push({ name: "EmployeeReport" });
            }else {
                alert("รหัสไม่ถูกต้อง");
                // this.$router.push({ name: "loginRP" });
            }
        }
    },
    created() {
        localStorage.removeItem("pass");
    },
    components:{
    haderVue
  }
  
}
</script>

<style scoped>
header {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  background-color: #00204a;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 5px 10%;
}

li,
a,
button {
  font-family: "Roboto", sans-serif;
  font-weight: 600;
  font-size: 18px;
  color: #ffffff;
  text-decoration: none;
}

.logonav {
  cursor: pointer;
  margin-right: auto;
  color: #ffffff;
  font-family: "Roboto", sans-serif;
  font-weight: 800;
  font-size: 22px;
}

.nav_links {
  list-style: none;
}

.nav_links li {
  display: inline-block;
  padding: 0px 20px;
}

.nav_links li a {
  transition: all 0.2s ease 0s;
}
.nav_links li a:hover {
  color: #fab317;
}

.nav_links li #logout {
  border-radius: 50px;
  padding: 9px 20px;
  transition: all 0.2s ease 0s;
}
.nav_links li #logout:hover {
  background-color: rgb(197, 0, 39);
  border-radius: 50px;
  padding: 9px 20px;
  color: #ffffff;
}

.header #head {
  display: flex;
  justify-content: center;

  font-family: "Roboto", sans-serif;
  font-style: normal;
  font-size: 45px;
  font-weight: 800;
  line-height: 70px;
  text-align: center;
  text-transform: uppercase;

  color: #00204a;
}

.header #dt-head {
  display: flex;
  justify-content: center;
  position: relative;
  top: -50px;
  font-family: "Roboto", sans-serif;
  font-style: normal;
  font-size: 20px;
  font-weight: 800;
  line-height: 70px;
  text-align: center;
  text-transform: uppercase;

  color: #00204a;
}
.verify-code-box {
  display: flex;
  position: relative;
  justify-content: center;

  font-family: "Kanit", sans-serif;
  font-style: normal;
  font-weight: 100;
  font-size: 110%;
  line-height: 50px;
}

.verify-code-box #pic7 {
  display: flex;
  position: relative;
  top: -100px;
  width: 25%;
  height: 30%;
  right: 5%;
}

.box-verify {
  display: inline;
  justify-content: center;
  position: relative;
  right: 5%;
  width: 15%;
  height: 10%;

  padding: 15px 25px 25px;
  font-family: "Kanit", sans-serif;
  font-style: normal;
  text-align: center;
  line-height: 20px;
  background: #00204a;
  border-radius: 15px;
}

.box-verify #verify {
  justify-content: center;
  font-size: 130%;
  font-weight: 500;
  font-family: "Roboto", sans-serif;
  color: #ffffff;
}

.box-verify #password {
  position: relative;
  width: 50%;
  padding: 5px 15px;
  border: 2px solid #fab317;
  border-radius: 10px;
}

#next {
  position: relative;
  width: auto;
  height: auto;
  padding: 3px 15px;
  
  top: 10px;

  font-size: 90%;
  font-family: "Roboto", sans-serif;
  color: #ffffff;
  background-color: #fab317;
  border-radius: 10px;
  border: #fab317;
}

#next:hover {
  color: #ffffff;
  background-color: #278aca;
  border-radius: 10px;
}
</style>