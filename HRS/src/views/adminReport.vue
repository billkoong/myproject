<template>
<haderVue/>

  <h1 id="font0">รายการการตรวจเช็กซ่อมวัสดุ / ครุภัณฑ์ เพื่อขออนุมัติการซ่อมบำรุง</h1>
  <div class="tb1">
    <table>
      <tr>
        <th>ลำดับที่</th>
        <th>ทรัพย์สินที่แจ้งซ่อม</th>
        <th>ส่งรายละเอียดหลังการตรวจเช็ก</th>
      </tr>
      <tr v-for="(item, index) in getall" :key="index" class="tb-bt">
        <td>{{ index + 1 }}</td>
        <td>
      <tr v-for="(item, index) in getall[index]" :key="index">
        <td >{{
          item.RP_property
        }}</td>
      </tr>
      </td>
      <td>
        <button @click="adminReport2(item[0].ID_RP)" id="btn-tb1">รายงานการตรวจเช็ก</button>
      </td>
      </tr>
    </table>
  </div>
  <h1 id="font">รายการการส่งรายละเอียดหลังการตรวจเช็ก (สามารถแก้ไขได้)</h1>
  <div class="tb2">
    <table>
      <tr>
        <th>ลำดับที่</th>
        <th>ทรัพย์สินที่แจ้งซ่อม</th>
        <th>ส่งรายละเอียดการตรวจเช็ก</th>
      </tr>
      <tr v-for="(item, index) in getall2" :key="index" class="tb-bt">
        <td>{{ index + 1 }}</td>
        <td><tr v-for="(item, index) in getall2[index]" :key="index">
        <td >{{
          item.RP_property
        }}</td>
      </tr></td>
        <td><button @click="correct(item[0].ID_RP)" id="btn-tb2">แก้ไข</button></td>
      </tr>
    </table>
  </div>
<div class="m"></div>
</template>

<script>
import axios from "axios";
import adminReport2 from "./adminReport2.vue";
import haderVue from "./hader.vue";
// import footers from "./footer.vue";

export default {
  name: "adminReport",
  data() {
    return {
      getall: "",
      getall2: "",
      id: "",
      url: 'https://repairhiresystem.000webhostapp.com/con2.php'
    };
  },
  methods: {
    // checklogin() {
    //   if (localStorage.getItem("pass") == "ครุภัณฑ์ทั่วไป เช่น พัดลม แอร์ หน้าต่าง" || localStorage.getItem("pass") == "ครุภัณฑ์อิเล็กทรอนิกส์ เช่น คอมพิวเตอร์ โน็ตบุ๊ก TV") {
    //   } else {
    //     this.$router.push({ name: "login" });
    //   }
    // },
    getalldata() {
      const options = {
      params: {
        action: "statusdata",
          pass: localStorage.getItem("pass")
       }
      };

      axios
        .get(this.url, options)
        .then((red) => {
          if (red.data == "ไม่พบข้อมูล") {
            this.getall = 0;
          } else {
            this.getall = red.data;
            console.log(this.getall);
          }
        });


        const options2 = {
      params: {
        action: "statusdata2",
          pass: localStorage.getItem("pass")
       }
      };

      axios
        .get(this.url , options2)
        .then((red) => {
          if (red.data == "ไม่พบข้อมูล") {
            this.getall2 = 0;
          } else {
            this.getall2 = red.data;
            console.log(this.getall2);
          }
        });
    },
    adminReport2(ID) {
      localStorage.setItem("ID", ID);
      this.$router.push({ name: "adminReport2" });
    },
    correct(ID) {
      localStorage.setItem("correct", "correct");
      localStorage.setItem("ID", ID);
      this.$router.push({ name: "adminReport2" });
    },
  },
  created() {
    // this.checklogin();
    this.getalldata();
    localStorage.removeItem("correct");
  },
  components: {
    adminReport2,haderVue,
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

.tb1 {
  justify-content: center;
  display: flex;
}
.tb1 table {
  position: relative;
  width: 60%;
  top: 40px;
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

#font {
  display: flex;
  justify-content: center;
  position: relative;
  top: 50px;
  max-width: 100%;

  font-size: 150%;
  font-family: "Kanit", sans-serif;
}

#font0 {
  display: flex;
  justify-content: center;
  position: relative;
  top: 20px;
  max-width: 100%;
  font-size: 150%;
}

.tb2 {
  display: flex;
  justify-content: center;
}

.tb2 table {
  position: relative;
  width: 60%;
  top: 70px;
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

#btn-tb2 {
  position: relative;
  /* right: 5px; */
  width: auto;
  height: auto;
  padding: 3px 25px;

  border: 2px;
  background-color: #fab317;
  border-radius: 10px;
  color: #00204a;
  font-size: 90%;
  font-family: "Kanit", sans-serif;
}

#btn-tb2:hover {
  background-color: #00204a;
  border-radius: 10px;
  color: #fab317;
  font-size: 90%;
  font-family: "Kanit", sans-serif;
}

#btn-tb3 {
  position: relative;
  width: auto;
  height: auto;
  padding: 3px 15px;
  left: 5px;

  border: 2px;
  background-color: #fab317;
  border-radius: 10px;
  color: #f6f3f3;
  font-size: 90%;
  font-family: "Kanit", sans-serif;
}

#btn-tb3:hover {
  background-color: #00204a;
  border-radius: 10px;
  color: #ffffff;
  font-size: 90%;
  font-family: "Kanit", sans-serif;
}
</style>