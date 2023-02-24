<template>
<haderVue/>
  <div class="btn">
    <div class="btn1"><button @click="RP" class="imposes"><p> รายการขออนุมัติวงเงินการซ่อมวัสดุ / ครุภัณฑ์ </p> 
      <div class="num" v-if="getall !=0 "><samp  class="warn">{{ getall }}</samp> 
      </div> 
    </button>
  </div>
    <div class="btn1"><button @click="RP2" class="imposes"><p> อัปเดตรายการขอซ่อมวัสดุ / ครุภัณฑ์ </p>
      <div class="num" v-if="getall2 !=0 "><samp  class="warn" >{{ getall2 }} </samp>
      </div>
    </button> 
  </div>
    <div class="btn1"><button @click="RP3" class="imposes"><p> อัปเดตรายการขอซ่อมวัสดุในขั้นตอนสุดท้าย </p>
      <div class="num" v-if="getall3 !=0 "><samp  class="warn" >{{ getall3 }}</samp>
      </div>
    </button> 
  </div>
  </div>
  <p id="warning" v-if="windows != 1 && windows !=2 && windows !=3">** กรุณาเลือกเพื่อเปิดตารางข้อมูลที่ท่านต้องการ **</p>
  <div v-if="windows == 1"> <EmployeeReport /> </div>
  <div v-if="windows == 2"> <EmployeeCheck /> </div>
  <div v-if="windows == 3"> <employee-check-2 /> </div>


</template>

<script>  

import EmployeeReport from './EmployeeReport.vue';
import EmployeeCheck from './EmployeeCheck.vue';
import EmployeeCheck2 from './EmployeeCheck2.vue';
import haderVue from "./hader.vue";
import axios from 'axios';
export default {
  name: "EmployeeHome",
  data() {
    return {
      getall: "",
      getall2: "",
      getall3: "",
      id: "",
      windows: '',
      url: 'https://repairhiresystem.000webhostapp.com/con2.php'
    };
  },
  components: {
    EmployeeReport,
    EmployeeCheck,
    EmployeeCheck2,
    haderVue,
  },
  methods: {
    checklogin() {
      if (localStorage.getItem("pass") == "AO") {
      } else {
        this.$router.push({ name: "login" });
      }
    },
    RP(){
      this.windows = 1
    },
    RP2(){
      this.windows = 2
    },
    RP3(){
      this.windows = 3
    },
    getalldata() {
      const options = {
      params: {
          action: "statusdataemployee22",
          
        }
      };
      const options2 = {
      params: {
          
          action: "MPYcheck",
          
        }
      };
      const options3 = {
      params: {
         
          action: "MPYcheck2",
        }
      };
      axios
        .get(this.url, options)
        .then((red) => {
          if (red.data == "ไม่พบข้อมูล") {
            this.getall = 0;
          } else {
            this.getall = red.data.length;

          }
        });
        axios
        .get(this.url, options2)
        .then((red) => {
          // console.log(red.data);
          if (red.data == "ไม่พบข้อมูล") {

          } else {
            this.getall2 = red.data.length;

          }

        });
        axios
        .get(this.url, options3)
        .then((red) => {
          // console.log(red.data);
          if (red.data == "ไม่พบข้อมูล") {
          } else {
            this.getall3 = red.data.length;
          }
        });
      },
},
created() {
    this.checklogin();
    this.getalldata();
    localStorage.removeItem("correct");
    localStorage.removeItem("update");
  },

}
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,500;0,600;0,700;0,800;0,900;1,800&family=Noto+Sans+Thai+Looped:wght@100;200;300;400;500;600;700;800;900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap");
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-family: "Kanit", sans-serif;
}
header {
  background-color: #00204a;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 5px 10%;
}
.num {
  justify-content: right;
  display: flex;
  width: 120%;
  position: relative;
  top: -60px;
  /* border: 2px solid green; */
}
.warn{
  display: flex;
  justify-content: center;
  background-color: red;
  color: #ffffff;
  width: 13%;
  padding: 5px 10px;
  border-radius: 50px;
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
.btn {
  justify-content: center;
  display: flex;
  
  padding: 25px 0px;
}
.btn1, .btn2 {
  padding: 10px 30px;
}
.imposes {
  width: 100%;
  height: 55%;
  padding: 10px 30px;
  background: #fab317;
  color: #00204a; 
  border-radius: 20px;
}
.imposes:hover {
  background: #00204a;
  color: #fab317;
}
.imposes:focus{
  background: #00204a;
  color: #fab317;
}

button {
  border-radius: 20px;
  border: 0px;
  height: 0;
}

#warning {
  display: flex;
  justify-content: center;
  color: #ff0000;
  font-size: 80%;
  position: relative;
  top: -50px;
}
</style>