<template>
<haderVue/>
  
  <div class="research">
    <p id="search">ค้นหา <input type="text" v-model="searchs" id="ip1" /></p> <br>
    <p id="status">
      สถานะ
      <select name="" id="select" v-model="statuss">
        <option v-for="(item, index) in invite" :key="index">{{ item }}</option>
      </select>
      <button @click="search" id="btn">Search</button>
    </p>
  </div>

  <div v-if="searchall == ''" id="tb1">
    <p id="found">ไม่พบข้อมูล</p>
  </div>
  
  <div class="tb1">
    <table v-if="searchall == 'ค้นหา'">
      <tr>
        <th>ที่</th>
        <th>ทรัพย์สินที่ต้องการซ่อม</th>
        <th>หมายเลขครุภัณฑ์</th>
        <th>สภาพชำรุดโดยละเอียด</th>
        <th>สถานะ</th>
        <th>รายละเอียด</th>
      </tr>
      <tr v-for="(item, index) in getall" :key="index" class="tb-bt">
          <td style="text-align: center;">{{ index + 1 }}</td>
          <td>
            <tr v-for="(item, index) in getall[index]" :key="index" >
              <td>{{item.RP_property}}</td>
            </tr>
          </td>

          <td>
            <tr v-for="(item, index) in getall[index]" :key="index" style="text-align: center;">
              <td>{{item.RP_property_number}}</td>
            </tr>
          </td>
          <td>
            <tr v-for="(item, index) in getall[index]" :key="index">
              <td>{{item.RP_disrepair}}</td>
            </tr>
          </td>

          <td style="text-align: center;">
            <p v-if="item[0].status == 'ซ่อมสำเร็จ'" style="color: green;" > {{ item[0].status }}</p>
            <p v-if="item[0].status == 'กรรมการตรวจรับพัสดุเรียบร้อยแล้ว'" style="color: green;" > {{ item[0].status }}</p>
            <p v-if="item[0].status == 'ขอแจ้งซ่อมสำเร็จ'" style="color: #FF9500;" > {{ item[0].status }}</p>
            <p v-if="item[0].status == 'ช่างตรวจสอบแล้ว'" style="color: #FF9500;" > {{ item[0].status }}</p>
            <p v-if="item[0].status == 'รอการอนุมัติ'" style="color: #FF9500;" > {{ item[0].status }}</p>
            <p v-if="item[0].status == 'อนุมัติแล้วกำลังดำเนินการซ่อม'" style="color: #FF9500;" > {{ item[0].status }}</p>
            <p v-if="item[0].status == 'ไม่ผ่านการอนุมัติ'" style="color: #ff0000;" > {{ item[0].status }}</p>
          </td>
          <td ><button @click="check(item[0].ID_RP)" id="btn">ตรวจสอบ</button></td>
        </tr>
    </table>
    
    <table v-else-if="searchall != ''" class="tb2">
      <tr>
        <th>ที่</th>
        <th>ทรัพย์สินที่ต้องการซ่อม</th>
        <th>หมายเลขครุภัณฑ์</th>
        <th>สภาพชำรุดโดยละเอียด</th>
        <th>สถานะ</th>
        <th>รายละเอียด</th>
      </tr>
      <tr v-for="(item, index) in searchall" :key="index" >
        <td style="text-align: center;">{{ index + 1 }}</td>
        <td>{{ item.RP_property }}</td>
        <td style="text-align: center;">{{ item.RP_property_number }}</td>
        <td>{{ item.RP_disrepair }}</td>
        <td style="text-align: center;">            
            <p v-if="item.status == 'ซ่อมสำเร็จ'" style="color: green;" > {{ item.status }}</p>
            <p v-if="item.status == 'กรรมการตรวจรับพัสดุเรียบร้อยแล้ว'" style="color: green;" > {{ item.status }}</p>
            <p v-if="item.status == 'ขอแจ้งซ่อมสำเร็จ'" style="color: #FF9500;" > {{ item.status }}</p>
            <p v-if="item.status == 'ช่างตรวจสอบแล้ว'" style="color: #FF9500;" > {{ item.status }}</p>
            <p v-if="item.status == 'รอการอนุมัติ'" style="color: #FF9500;" > {{ item.status }}</p>
            <p v-if="item.status == 'อนุมัติแล้วกำลังดำเนินการซ่อม'" style="color: #FF9500;" > {{ item.status }}</p>
            <p v-if="item.status == 'ไม่ผ่านการอนุมัติ'" style="color: #ff0000;" > {{ item.status }}</p>
        </td>
        <td><button @click="check(item.ID_RP)" id="btn" >ตรวจสอบ</button></td>
      </tr>
    </table>
  </div> 
<div class="c"></div>
</template>

<script>
import axios from "axios";
import haderVue from "./hader.vue";
export default {
  name: "status",
  data() {
    return {
      invite: [
        "ทั้งหมด",
        "ขอแจ้งซ่อมสำเร็จ",
        "ช่างตรวจสอบแล้ว",
        "รอการอนุมัติ",
        "อนุมัติแล้วกำลังดำเนินการซ่อม",
        "กรรมการตรวจรับพัสดุเรียบร้อยแล้ว",
        "ไม่ผ่านการอนุมัติ",
        "ซ่อมสำเร็จ"
      ],
      getall: "",
      searchall: "ค้นหา",
      searchs: "",
      statuss: "ทั้งหมด",
      url: 'https://repairhiresystem.000webhostapp.com/con2.php'
    };
  },
  methods: {
    checklogin() {
      if (!localStorage.getItem("username")) {
        this.$router.push({ name: "login" });
      } else {
      }
    },
    getalldata() {
      const options = {
      params: {
        action: "getalldata",
       }
      };
      axios
        .get(this.url, options)
        .then((red) => {
          this.getall = red.data;
          console.log(this.getall);
        });
    },
    search() {
      if (this.statuss != "ทั้งหมด") {
        const options = {
      params: {
        search: this.searchs,
            status: this.statuss,
            action: "searcdata",
       }
      };
        axios
          .get(this.url, options)
          .then((red) => {
            this.searchall = red.data;
            // console.log(this.searchall);
          });
      } else {
        const options = {
      params: {
        search: this.searchs,
            action: "searcalldata",
       }
      };
        axios
          .get(this.url, options)
          .then((red) => {
            this.searchall = red.data;
            // console.log(this.searchall);
          });
      }
    },
    check(ID_RP) {
      localStorage.setItem("ID_RP", ID_RP);
      this.$router.push({ name: "save" });
    }
  },
  created() {
    this.getalldata();
    this.checklogin();
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

.research {
  display: block;
  justify-content: center;
  position: relative;
  top: 20px;
  width: 40%;
  left: 10%;
  font-size: 110%;
}
#search,
#status {
  display: flex;
  justify-content: left;
  line-height: 2;
  font-size: 110%;
  font-weight: 600;
}
#ip1 {
  display: flex;
  justify-content: left;
  position: relative;
  width: 70%;
  left: 1%;

  padding: 4px 15px;
  font-family: "Kanit", sans-serif;
  font-size: 80%;
  border-radius: 5px;
  border: 2px solid black;
}
#select {
  display: flex;
  justify-content: left;
  position: relative;
  width: 50%;
  left: 0.5%;

  padding: 4px 15px;
  font-family: "Kanit", sans-serif;
  font-size: 80%;
  border-radius: 5px;
  border: 2px solid black;
}
#btn {
  display: flex;
  justify-content: center;
  position: relative;
  width: auto;
  height: auto;
  left: 2%;
  padding: 5px 25px;

  border: 2px;
  background-color: #fab317;
  border-radius: 10px;
  color: #00204a;
  font-size: 100%;
  font-family: "Kanit", sans-serif;
}
#btn:hover {
  background-color: #00204a;
  border-radius: 10px;
  color: #fab317;
  font-family: "Kanit", sans-serif;
}

.tb1 {
  justify-content: center;
  display: flex;
}
.tb1 table {
  position: relative;
  width: 80%;
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
.tb1 table td {
  padding: 5px 5px;
  font-size: 110%;
  font-size: 95%;
}
.tb1 .tb-bt {
  border-bottom: 3px solid #00204a;
}
.tb2 tr{
  border-bottom: 3px solid #00204a;

}
#found {
  text-align: center;
  position: relative;
  top: 50px;

  font-size: 120%;
  color: #ff0000;
}
#btn {
  padding: 3px 15px;
  background-color: #fab317;
  border-radius: 10px;
  color: #00204a;
}
#btn:hover {
  background-color: #00204a;
  border-radius: 10px;
  color:#fab317 ;
}
</style>