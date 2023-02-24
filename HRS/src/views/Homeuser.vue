<template>
  <haderVue />
  <p id="head1">ประวัติการขอจ้างซ่อมของคุณ ' {{ username }} '</p>

  <div>
    <div class="btn1" >
      <button @click="status" id="btn">ค้นหารายการแจ้งซ่อมทั้งหมด</button>
    </div>

    <div v-if="getall == 'ไม่พบข้อมูล' " class="notfound">ไม่มีประวัติการซ่อมของคุณ</div>
    <div class="tb1" v-if="getall != 'ไม่พบข้อมูล' ">
      <table>
        <tr>
          <th>ที่</th>
          <th>ทรัพย์สินที่ต้องการซ่อม</th>
          <th>หมายเลขครุภัณฑ์</th>
          <th>สภาพชำรุดโดยละเอียด</th>
          <th>สถานะ</th>
          <th>รายละเอียด</th>
        </tr>
        <tr v-for="(item, index) in getall" :key="index" class="tb-bt" >
          <td style="text-align: center" >{{ index + 1 }}</td>
          <td class="tb-l">
            <tr v-for="(item, index) in getall[index]" :key="index" >
              <td  >{{ item.RP_property }}
              </td>
            </tr>
          </td>
          <td class="tb-l" >
            <tr v-for="(item, index) in getall[index]" :key="index" style="text-align: center;" >
              <td style="text-align: center" >{{ item.RP_property_number }}</td>
            </tr>
          </td>
          <td class="tb-l">
            <tr v-for="(item, index) in getall[index]" :key="index">
              <td>{{ item.RP_disrepair }}</td>
            </tr>
          </td>
          <td style="text-align: center" class="tb-l">{{ item[0].status }}</td>
          <td style="text-align: center" class="tb-l">
            <button @click="check(item[0].ID_RP)">ตรวจสอบ</button>
          </td>
        </tr>
      </table>
    </div>
  </div>
  
  <div class="v"></div>
</template>
  
<script>
import axios from "axios";
import haderVue from "./hader.vue";

export default {
  name: "homeuser",
  data() {
    return {
      username: localStorage.getItem("username"),
      id_user: localStorage.getItem("id_user"),
      getall: "",
      invite: [
        "ทั้งหมด",
        "ขอแจ้งซ่อมสำเร็จ",
        "ช่างตรวจสอบแล้ว",
        "รอการอนุมัติ",
        "อนุมัติแล้วกำลังดำเนินการซ่อม",
        "กรรมการตรวจรับพัสดุเรียบร้อยแล้ว",
        "ไม่ผ่านการอนุมัติ",
        "ซ่อมสำเร็จ",
      ],
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
    getalldatame() {
      const options = {
      params: {
          id_user: this.id_user,
          action: "getalldataMB",
       }
      };
      axios
        .get(this.url, options )
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
            console.log(this.searchall);
          });
      } else {
        const options = {
      params: {
        search: this.searchs,
            action: "searcalldata",
       }
      };
        axios
          .post(this.url, options)
          .then((red) => {
            this.searchall = red.data;
            console.log(this.searchall);
          });
      }
    },
    status() {
      this.$router.push({ name: "statusdata" });
    },
    check(ID_RP) {
      localStorage.setItem("ID_RP", ID_RP);
      this.$router.push({ name: "save" });
    },
  },
  created() {
    this.getalldatame();
    this.checklogin();
    localStorage.removeItem("update");
  },
  components: {
    haderVue,
  },
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,500;0,600;0,700;0,800;0,900;1,800&family=Noto+Sans+Thai+Looped:wght@100;200;300;400;500;600;700;800;900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap");
.tb-l {
  border-left: 3px solid #00204a;
  border-collapse: collapse;
}
.notfound {
  display: flex;
  justify-content: center;
  color: red;
  font-family: "Kanit", sans-serif;
  font-size: 110%;
  position: relative;
  top: 50px;
}
#head1 {
  display: flex;
  justify-content: center;
  position: relative;
  font-family: "Kanit", sans-serif;
  font-size: 150%;
  text-transform: uppercase;
  font-weight: 600;
}
.tb1 {
  justify-content: center;
  display: flex;
}
.tb1 table {
  position: relative;
  width: 80%;
  top: 10px;
  border-collapse: collapse;
  border: 3px solid #00204a;
  border-radius: 10px;
}
.tb1 table th {
  padding: 5px 10px;
  font-size: 110%;
  text-align: center;
  font-size: 100%;
  font-family: "Kanit", sans-serif;
  border-bottom: 3px solid #00204a;
  color: #ffffff;
  background-color: #00204a;
}
.tb1 table td {
  padding: 5px 5px;
  font-size: 110%;
  font-size: 95%;
  font-family: "Kanit", sans-serif;
}
.tb1 .tb-bt {
  border-bottom: 3px solid #00204a;
}
.btn1 {
  display: flex;
  justify-content: right;
  position: relative;
  width: 80%; 
  left: 10%;
}
#btn {
  position: relative;
  left: 0;  
}
button {
  align-items: center;
  font-family: "Kanit", sans-serif;
  background: #fab317;
  border: #fab317;
  border-radius: 10px;
  padding: 5px 20px;
  color: #00204a;
  font-weight: 600;
  font-size: 100%;
}
button:hover {
  background: #00204a;
  border: #00204a;
  color: #fab317;
}
</style>
