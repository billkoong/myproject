<template>
    <!-- <h1 id="font0">อัปเดตรายการขอซ่อมหลังจากการอนุมัติ</h1>
    <div class="tb1">
      <table>
        <tr>
          <th>ที่</th>
          <th>ทรัพย์สินที่ต้องการซ่อม</th>
          <th>หมายเลขครุภัณฑ์</th>
          <th>สภาพชำรุดโดยละเอียด</th>
          <th>สถานะ</th>
          <th>รายละเอียด</th>
        </tr>
        <tr v-for="(item, index) in getall" :key="index" class="tb-bt">
          <td style="text-align: center">{{ index + 1 }}</td>
          <td>
            <tr v-for="(item, index) in getall[index]" :key="index">
              <td style="text-align: left">{{ item.RP_property }}</td>
            </tr>
          </td>
          <td>
            <tr v-for="(item, index) in getall[index]" :key="index">
              <td style="text-align: center">{{ item.RP_property_number }}</td>
            </tr>
          </td>
          <td>
            <tr v-for="(item, index) in getall[index]" :key="index">
              <td style="text-align: left">{{ item.RP_disrepair }}</td>
            </tr>
          </td>
          <td style="text-align: center">{{ item[0].status }}</td>
  
          <td style="text-align: center">
            <button @click="adminReport2(item[0].ID_RP)" id="btn-tb1">
              อัปเดตรายการขอซ่อม
            </button>
          </td>
        </tr>
      </table>
    </div> -->
  
    <h1 id="font1">อัปเดตรายการขอซ่อมวัสดุในขั้นตอนสุดท้าย</h1>
    <div class="tb2">
      <table>
        <tr>
          <th>ที่</th>
          <th>ทรัพย์สินที่ต้องการซ่อม</th>
          <th>หมายเลขครุภัณฑ์</th>
          <th>สภาพชำรุดโดยละเอียด</th>
          <th>สถานะ</th>
          <th>รายละเอียด</th>
        </tr>
        <tr v-for="(item, index) in getall2" :key="index" class="tb-bt">
          <td>{{ index + 1 }}</td>
          <td>
            <tr v-for="(item, index) in getall2[index]" :key="index">
              <td>{{ item.RP_property }}</td>
            </tr>
          </td>
          <td>
            <tr v-for="(item, index) in getall2[index]" :key="index">
              <td>{{ item.RP_property_number }}</td>
            </tr>
          </td>
          <td>
            <tr v-for="(item, index) in getall2[index]" :key="index">
              <td>{{ item.RP_disrepair }}</td>
            </tr>
          </td>
          <td>{{ item[0].status }}</td>
  
          <td>
            <button @click="adminReport3(item[0].ID_RP)" id="btn-tb1">
              อัปเดตรายการขอซ่อม
            </button>
          </td>
        </tr>
      </table>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  import haderVue from "./hader.vue";
  // import footers from './footer.vue';
  export default {
    name: "EmployeeCheck",
    data() {
      return {
        getall: "",
        getall2: "",
        id: "",
      };
    },
    methods: {
      checklogin() {
        if (localStorage.getItem("pass") == "AO") {
        } else {
          this.$router.push({ name: "login" });
        }
      },
      getalldata() {
        axios
          .post("http://localhost:/PJ1/connect.php", {
            action: "MPYcheck",
          })
          .then((red) => {
            // console.log(red.data);
            if (red.data == "ไม่พบข้อมูล") {
            } else {
              this.getall = red.data;
            }
          });
        axios
          .post("http://localhost:/PJ1/connect.php", {
            action: "MPYcheck2",
          })
          .then((red) => {
            // console.log(red.data);
            if (red.data == "ไม่พบข้อมูล") {
            } else {
              this.getall2 = red.data;
            }
          });
      },
      adminReport2(ID_RP) {
        localStorage.setItem("ID_RP", ID_RP);
        localStorage.setItem("update", "update");
        this.$router.push({ name: "save" });
      },
      adminReport3(ID_RP) {
        localStorage.setItem("ID_RP", ID_RP);
        localStorage.setItem("update", "update2");
        this.$router.push({ name: "save" });
      },
    },
    created() {
      this.checklogin();
      this.getalldata();
      localStorage.removeItem("correct");
    },
    components: {
      haderVue,
      // footers,
    },
  };
  </script>
  <style scoped>
  @import url("https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,500;0,600;0,700;0,800;0,900;1,800&family=Noto+Sans+Thai+Looped:wght@100;200;300;400;500;600;700;800;900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap");
  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: "Kanit", sans-serif;
  }
  #font0 {
    display: flex;
    justify-content: center;
    position: relative;
    top: 10px;
    max-width: 100%;
    font-size: 140%;
  }
  
  #btn-tb1 {
    padding: 3px 15px;
    background: #fab317;
    border: #fab317;
    border-radius: 10px;
    color: #00204a;
    font-size: 90%;
  }
  #btn-tb1:hover {
    background: #00204a;
    border-radius: 10px;
    border: #00204a;
    color: #fab317;
  }
  #font1 {
    display: flex;
    justify-content: center;
    position: relative;
    top: 10px;
    max-width: 100%;
    font-size: 140%;
  }
  .tb2 {
    display: flex;
    justify-content: center;
  }
  
  .tb2 table {
    position: relative;
    width: 80%;
    top: 20px;
    border-collapse: collapse;
    border: 3px solid #00204a;
    border-radius: 10px;
  }
  .tb2 table th {
    background-color: #00204a;
    color: #ffffff;
    padding: 5px 10px;
    font-size: 110%;
    text-align: center;
    font-size: 100%;
    border-bottom: 3px solid #00204a;
  }
  .tb2 table td {
    padding: 5px 5px;
    font-size: 110%;
    text-align: center;
    font-size: 95%;
  }
  </style>