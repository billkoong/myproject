<template>
  <haderVue/>

  <h2 id="font1">รายงานผลหลังการตรวจเช็กวัสดุ / ครุภัณฑ์</h2>
  <div class="detail" v-for="(item, index) in getdata.data1" :key="index">
    <p id="head">รายละเอียดการแจ้งซ่อมของผู้ใช้งาน</p>
    <p id="date">วันที่แจ้งซ่อม : {{ item.RP_date }}</p>
    <p id="place">ชื่อหน่วยงาน/สถานที่ : {{ item.RP_count_unit }}</p>
    <p id="reason">เหตุผลความจำเป็นในการจ้างซ่อมทรัพย์สิน : {{ item.RP_reason }}</p>
    
    <div class="tb1">
      <table>
        <tr>
          <th>ที่</th>
          <th>ทรัพย์สินที่ต้องการซ่อม</th>
          <th>หมายเลขครุภัณฑ์</th>
          <th>สภาพชำรุดโดยละเอียด</th>
        </tr>
        <tr>
          <td>{{ index + 1 }}</td>
          <td>
        <tr v-for="(item, index) in getdata.data22" :key="index">
          <td >
            {{ getdata.data22[index].RP_property }}
          </td>
        </tr>
        </td>

        <td>
          <tr v-for="(item, index) in getdata.data22" :key="index">
            <td >
            {{getdata.data22[index].RP_property_number}}
            </td>
          </tr>
        </td>
        <td>
          <tr v-for="(item, index) in getdata.data22" :key="index">
            <td v>{{
              getdata.data22[index].RP_disrepair
            }}</td>
          </tr>
        </td>
        </tr>
      </table>
      <p>กรรมการตรวจรับพัสดุ</p>
      <p v-if="getdata.data1[0].RP_director1 != ''">1 : {{ item.RP_director1 }}</p>
      <p v-if="getdata.data1[0].RP_director2 != ''">2 : {{ item.RP_director2 }}</p>
      <p v-if="getdata.data1[0].RP_director3 != ''">3 : {{ item.RP_director3 }}</p>
    </div>
    <br />
  </div>

  <div class="for-rpman">
    <form action="">
      <label id="name-rpman" for="">ชื่อผู้ตรวจเช็ก :
        <input id="p1" type="text" v-model="adminName" required /><br /></label>

        <div v-if="checked == checked2 " id="choose">* กรุณาเลือกเพียงตัวเลือกเดียว</div>
        <input type="checkbox" v-model="checked" class="checkbox">
        <label for="checkbox" class="checkboxx">เห็นควรจ้างร้าน</label>

        <input type="checkbox" class="checkbox2" v-model="checked2">
        <label for="checkbox" class="checkboxx2">สามารถซ่อมเองได้</label>

        <label id="result" for="">ตรวจสอบการชำรุดแล้วพบว่า :
        <textarea id="p3" type="text" v-model="adminData" required></textarea> <br />

      </label>


    </form>
  </div>

  <button v-if="correct" @click="save" type="submit" id="btn">save</button>
  <button v-if="!correct" @click="submitfromdata" type="submit" id="btn">Submit</button>


</template>

<script>
import haderVue from "./hader.vue";
import axios from "axios";
// import footers from "./footer.vue";
export default {
  name: "adminReport2",
  data() {
    return {
      correct:localStorage.getItem("correct"),
      id: "",
      getdata: "",
      getdata2: "",
      addfromupdate: [],
      adminName: "",
      adminData: "",
      checked: false,
      checked2: false,
      url: 'https://repairhiresystem.000webhostapp.com/con2.php'
    };
  },
  methods: {

    getID() {
      if (localStorage.getItem("ID")) {
        this.id = localStorage.getItem("ID");
        // เอาข้อมูลมาแสดงผล
        const options = {
      params: {
        id: this.id,
            
            id_rc: localStorage.getItem("id_user"),
            action: "searchdata",
       }
      };
        axios
          .get(this.url , options)
          .then((red) => {
            console.log(red.data);
            this.getdata = red.data;
            
            console.log(this.getdata.data22);
            if (!this.getdata.data1[0].RC_name) {
              this.adminName = this.getdata.data1[0].Fname + " " + this.getdata.data1[0].Lname
            } else {
              this.adminName = this.getdata.data1[0].RC_name,
                this.adminData = this.getdata.data1[0].RC_result
            }
            if(this.getdata.data1[0].RC_status == "เห็นควรจ้างร้าน"){
              this.checked  = true
            }else if(this.getdata.data1[0].RC_status == "สามารถซ่อมเองได้"){
              this.checked2  = true
            }
            console.log(this.getdata.data1);
          });
     
      }
    },
    submitfromdata() {
      if (
        this.adminData == "" ||
        this.adminName == ""
      ) {
        alert("กรุณาใส่ข้อมูลให้ครบ");
      } else {
          const addfromnew1 = {
            adminName: this.adminName,
            adminData: this.adminData,
          };
          this.addfromupdate.push(addfromnew1);
          const options = {
      params: {
        id: this.id,
        RC_status: this.checked,
              type: this.getdata.data1[0].type,
              agency: this.getdata.data1[0].agency,
              RP_count_unit:this.getdata.data1[0].RP_count_unit,
              adminName: this.adminName,
              adminData: this.adminData,
              id: this.id,
              RC_ID: localStorage.getItem("id_user"),
              status: "ช่างตรวจสอบแล้ว",
              action: "submitfromdataupdate",
       }
      };
          axios
            .get(this.url , options)
            .then((red) => {
              alert(red.data);
              this.$router.push({ name: "adminReport" });
            });
        
      }
    },
    save() {
      if (
        this.adminData == "" ||
        this.adminName == ""
      ) {
        alert("กรุณาใส่ข้อมูลให้ครบ");
      } else {
          const addfromnew1 = {
            adminName: this.adminName,
            adminData: this.adminData,
          };
          this.addfromupdate.push(addfromnew1);
          const options = {
      params: {
        RC_status: this.checked,
              type: this.getdata.data1[0].type,
              agency: this.getdata.data1[0].agency,
              RP_count_unit:this.getdata.data1[0].RP_count_unit,
              adminName: this.adminName,
              adminData: this.adminData,
              id: this.id,
              RC_ID: localStorage.getItem("id_user"),
              status: "ช่างตรวจสอบแล้ว",
              action: "savefromdataupdate",
       }
      };
          axios
            .get(this.url, options)
            .then((red) => {
              alert(red.data);
              this.$router.push({ name: "adminReport" });
            });
        
      }
    },
  },
  created() {

    this.getID();
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
#font1 {
  display: flex;
  justify-content: center;
  position: relative;
  top: 20px;
  font-size: 150%;
  font-family: "Kanit", sans-serif;
}

.detail {
  display: block;
  justify-content: center;
  position: relative;
  top: 40px;
  width: 70%;
  left: 15%;
  padding: 20px 0px;
  font-family: "Kanit", sans-serif;
  border: 4px solid #fab317;
  border-radius: 10px;
}
#head {
  justify-content: center;
  display: flex;
  font-size: 140%;
  font-weight: 600;
}
#date, #place, #reason  {
  justify-content: left;
  display: flex;
  font-size: 110%;
  position: relative;
  left: 23%;
  line-height: 2;
}
.tb1 {
  justify-content: center;
  display: block;
  position: relative;
  width: 105%;
  top: 10px;
  left: 23%;
  font-size: 110%;
}
.tb1 table {
  position: relative;
  width: 55%;
  border: 3px solid #00204a;
  border-radius: 10px;
  border-collapse: collapse;
}
.tb1 table th {
  position: relative;
  width: auto;

  padding: 5px 10px;
  font-size: 110%;
  text-align: center;
  font-size: 100%;
  border-bottom: 3px solid #00204a;
}
.tb1 table td {
  padding: 5px 5px;
  font-size: 110%;
  text-align: center;
  font-size: 95%;
}
.tb1 p {
  position: relative;
  top: 10px;
  line-height: 2;
}
.for-rpman {
  justify-content: left;
  display: flex;
  position: relative;
  width: auto;
  top: 50px;
  left: 31%;
}
#name-rpman {
  font-size: 110%;
  position: relative;
  line-height: 3;
}
#p1 {
  width: auto;
  font-size: 90%;
  padding: 5px 10px;
  border-radius: 5px;
  border: 2px solid rgb(0, 0, 0);
}
#result {
  justify-content: left;
  display: flex;
  font-size: 110%;

  position: relative;
  top: 60px;
  width: 260%;
}
#choose {
  position: relative;
  color: red;
  line-height: 2;
  font-size: 90%;
}
.checkbox{
  position: relative;
} 
.checkbox2 {
  position: relative;
  left: 5%;
}
.checkboxx {
  position: relative;
  font-size: 110%;  
  left: 1%;
}
.checkboxx2 {
  position: relative;
  font-size: 110%;  
  left: 6%;
}
#result {
  position: relative;
  top: 20px;
}
#p3 {   
  position: relative;
  left: 1%;
  width: 35%;
  padding: 5px 10px;
  border-radius: 5px;
  border: 2px solid rgb(0, 0, 0);
  font-size: 90%;
}
#btn {
  display: flex;
  font-size: 110%;
  position: relative;
  left: 78%;
  top: 90px;
  padding: 10px 20px;
  background: #fab317;
  color: #00204a;
  border: #fab317;
  border-radius: 20px;
}

#btn:hover {
  background: #00204a;
  color: #fab317;
  border: #00204a;
  border-radius: 20px;
}
</style>