<template>
  <h1 id="font0">รายการขออนุมัติวงเงินการซ่อมวัสดุ / ครุภัณฑ์</h1>
  <div class="tb1">
    <table>
      <tr>
        <th>ลำดับที่</th>
        <th>ทรัพย์สินที่แจ้งซ่อม</th>
        <th>กำหนดวงเงินในการซ่อม</th>
      </tr>
      <tr v-for="(item, index) in getall" :key="index" class="tb-bt">
        <td>{{ index + 1 }}</td>
        <td class="tb-l">
          <tr v-for="(item, index) in getall[index]" :key="index">
        <td style="text-align: left;">{{item.RP_property}}</td>
      </tr>
      </td>
      <td class="tb-l">
        <button @click="adminReport2(item[0].ID_RP)" id="btn-tb1">
          กำหนดวงเงินการซ่อม
        </button>
      </td>
      </tr>
    </table>
  </div>

 
  <div v-if="getall2 != 0">
     <h1 id="font">แก้ไขรายการขออนุมัติวงเงินการซ่อมวัสดุ / ครุภัณฑ์</h1>
     <div class="tb2">
    <table>
      <tr>
        <th>ลำดับที่</th>
        <th>ทรัพย์สินที่แจ้งซ่อม</th>
        <th>รายละเอียดการขอซ่อม</th>
      </tr>
      <tr v-for="(item, index) in getall2" :key="index" class="tb-bt">
        <td>{{ index + 1 }}</td>
        <td class="tb-l">
          <tr v-for="(item, index) in getall2[index]" :key="index" style="justify-items: center;">
        <td style="text-align: left;" >{{item.RP_property}}</td>
      </tr>
      </td>
      <td class="tb-l">
        <!-- <button @click="printPDF(item[0].ID_RP)" id="btn-tb2">พิมพ์</button> -->
        <button @click="correct(item[0].ID_RP)" id="btn-tb3" >แก้ไข</button>
      </td>
      </tr>
    </table>
  </div>
</div>
<div class="c"></div>
</template>

<script>
import axios from "axios";
import haderVue from "./hader.vue";
export default {
  name: "EmployeeReport",
  data() {
    return {
      getall: "",
      getall2: "",
      id: "",
      url: 'https://repairhiresystem.000webhostapp.com/con2.php'
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
      const options = {
      params: {
        action: "statusdataemployee22",
        }
      };
      axios
        .get(this.url , options)
        .then((red) => {
          console.log(red.data);
          if (red.data == "ไม่พบข้อมูล") {
            this.getall = 0;
          } else {
            this.getall = red.data;
          }
        });
        const options2 = {
      params: {
        action: "statusdataemployee2",
        }
      };
      axios
        .get(this.url , options2)
        .then((red) => {
          console.log(red.data);
          if (red.data == "ไม่พบข้อมูล") {
            this.getall2 = 0;
          } else {
            this.getall2 = red.data;
          }
        });
    },
    adminReport2(ID) {
      localStorage.setItem("ID", ID);
      this.$router.push({ name: "EmployeeReport2" });
    },
    printPDF(ID) {
      localStorage.setItem("ID_RP", ID);
      this.$router.push({ name: "save" });
   
    },
    correct(ID) {
      localStorage.setItem("ID", ID);
      localStorage.setItem("correct", "correct");
      this.$router.push({ name: "EmployeeReport2" });
    },
  },
  created() {
    this.checklogin();
    this.getalldata();
    localStorage.removeItem("correct");
  },
  components: {
    haderVue,
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
.tb-l {
  border-left: 3px solid #00204a;
  border-collapse: collapse;
}

#font {
  display: flex;
  justify-content: center;
  position: relative;
  top: 40px;
  max-width: 100%;
  
  font-size: 140%;
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
.tb1 {
  justify-content: center;
  display: flex;
}
.tb1 table {
  position: relative;
  width: 60%;
  top: 20px;
  border-collapse: collapse;
  border: 3px solid #00204a;
  border-radius: 10px;
}
.tb1 table th {
  background-color: #00204a;
  color: #ffffff;
  padding: 5px 10px;
  font-size: 110%;
  text-align: center;
  font-size: 100%;
  border-bottom: 3px solid #00204a;
}
.tb-bt {
  border-bottom: 3px solid #00204a;
}
.tb1 table td {
  padding: 5px 5px;
  font-size: 110%;
  text-align: center;
  font-size: 95%;
}

#btn-tb1 {
  position: relative;
  width: auto;
  height: auto;
  padding: 3px 15px;

  border: 2px;
  background-color: #fab317;
  border-radius: 10px;
  color: #00204a;
  font-size: 90%;
  font-family: "Kanit", sans-serif;
}
#btn-tb1:hover {
  background-color: #00204a;
  border-radius: 10px;
  color: #fab317;
  font-size: 90%;
  font-family: "Kanit", sans-serif;
}
.tb2 {
  display: flex;
  justify-content: center;
}

.tb2 table {
  position: relative;
  width: 60%;
  top: 50px;
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
#btn-tb3 {
  position: relative;
  right: 5px;
  width: auto;
  height: auto;
  padding: 3px 15px;

  border: 2px;
  background-color: #fab317;
  border-radius: 10px;
  color: #00204a;
  font-size: 90%;
  font-family: "Kanit", sans-serif;
}
#btn-tb3:hover {
  background-color: #00204a;
  border-radius: 10px;
  color: #fab317;
  font-size: 90%;
  font-family: "Kanit", sans-serif;
}
</style>