<template>
  <div class="login">
  <div class="logo">
    <img src="../assets/logoNU.png" alt="logo_nu" />
  </div>
  <div class="loginbox">
    <p id="p01">Please sign in</p>
    
    <p><input id="ip1" type="text" ref="username" placeholder="E-mail or Username"/></p>
    <p><input id="ip2" type="password" ref="password"  placeholder="Password"/></p>
    <a><button @click="signin" id="btn1">Sign in</button></a>
  </div>
</div>
<!-- <footers/> -->
<div class="s"></div>
</template>

<script>
import axios from 'axios';
import footers from "./footer.vue";

export default {
  
  name: "login",
  data() {
    return {
      username: "",
      password: "",
      output: ""
    }
  },
  methods: {
    signin() {
      this.username = this.$refs.username.value,
        this.password = this.$refs.password.value,
        axios
          .post("http://localhost:/PJ1/connect.php", {
            username: this.username,
            pass: this.password,
            action: "signin",
          })
          .then((red) => {
            this.output = red.data;
            // console.log(red.data);
            if (red.data == "username หรือ password ไม่ถูกต้อง" ||red.data == "กรุณาใส่ username" ||red.data == "กรุณาใส่ password") {
             alert(red.data);
          }else if(red.data[0].username = this.username ) {
              localStorage.setItem("username", red.data[0].Fname);
              if(red.data[0].agency == "หน่วยพัสดุ"){
                localStorage.setItem("id_user", red.data[0].ID_MB);
                localStorage.setItem("pass" , "AO");
                this.$router.push({ name: "EmployeeHome" });
              }else if(red.data[0].agency == "หน่วยเทคโนโลยีและสารสนเทศ"){
                localStorage.setItem("id_user", red.data[0].ID_MB);
                localStorage.setItem("pass" , "ครุภัณฑ์อิเล็กทรอนิกส์ เช่น คอมพิวเตอร์ โน็ตบุ๊ก TV");
                this.$router.push({ name: "adminReport" });
              }else if(red.data[0].agency == "หน่วยงานอาคารและสถานที่"){
                localStorage.setItem("id_user", red.data[0].ID_MB);
                localStorage.setItem("pass" , "ครุภัณฑ์ทั่วไป เช่น พัดลม แอร์ หน้าต่าง");
                this.$router.push({ name: "adminReport" });
              }else{
                localStorage.setItem("id_user", red.data[0].ID_MB);
                this.$router.push({ name: "home" });
              }
            }
          });
    },
    adminReport2(ID) {
      localStorage.setItem("ID", ID);
      this.$router.push({ name: "EmployeeReport2" });
    },
    register() {
      this.$router.push({ name: "register" });
    }
    
  },
  created(){
    localStorage.clear();
  },
  components: {
    footers,
  },
}
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,500;0,600;0,700;0,800;0,900;1,800&family=Noto+Sans+Thai+Looped:wght@100;200;300;400;500;600;700;800;900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap");
* {
  display: flex;
  justify-content: center;
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-family: "Roboto", sans-serif;
  align-items: center;
}
.login {
  display: block;
  justify-content: center;
  position: relative;
  top: 100px;
}
.logo {
  justify-content: center;
  position: relative;
  display: flex;
  top: 50px;
}

.loginbox {
  display: block;
  position: relative;
  top: 50px;
  padding: 20px 0px;
}

#p01 {
  font-size: 200%;
  font-weight: 800;
  line-height: 2;
}

#ip1 {
  position: relative;
  width: 15%;
  height: auto;
  padding: 5px 10px;
  font-size: 100%;
  font-weight: 500;
  border: 2px solid #00204a;
  border-radius: 5px;
}

#ip2 {
  position: relative;
  width: 15%;
  top: 15px;
  height: auto;
  padding: 5px 10px;
  font-size: 100%;
  font-weight: 500;
  border: 2px solid #00204a;
  border-radius: 5px;
}

#btn1 {
  position: relative;
  top: 30px;
  padding: 5px 20px;

  font-size: 120%;
  font-family: "Roboto", sans-serif;
  font-weight: 800;

  background: #fab317;
  border: #fab317;
  border-radius: 20px;
}

#btn1:hover {
  background-color: #00204a;
  color: #fab317;
}
</style>