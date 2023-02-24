<template>
<haderVue/>
  <div class="al" v-if="al == 1"><img src="../assets/Circles-menu-3.gif" alt=""> <br> <p class="loading">กำลังส่งข้อมูล</p> </div>
  <div class="al2" v-if="al == 2"> ส่งข้อมูลสำเร็จ </div>

  <h2 id="font1">กำหนดวงเงินในการซ่อม</h2>
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
          <th>วงเงินที่จะซ่อม</th>
          <th>ราคาที่ซ่อมครั้งสุดท้าย</th>
        </tr>
        <tr>
          <td>{{ index + 1 }}</td>

          <td>
        <tr v-for="(item, index) in getdata.data2" :key="index">
          <td><br>{{ getdata.data2[index].RP_property }} </td>
        </tr>
        </td>

        <td>
          <tr v-for="(item, index) in getdata.data2" :key="index">
            <td><br>{{ getdata.data2[index].RP_property_number }}</td>
          </tr>
        </td>

        <td>
          <tr v-for="(item, index) in getdata.data2" :key="index">
            <td><br>{{ getdata.data2[index].RP_disrepair }}</td>
          </tr>
        </td>

        <td>
          <tr v-for="(item, index) in getdata.data2" :key="index">
            <td><br><input type="number" v-model="RC_limit[index]"></td>
          </tr>
        </td>
        <td>
          <tr v-for="(item, index) in getdata.data2" :key="index">
            <td><br><input type="number" v-model="RC_latest_limit[index]"></td>
          </tr>
        </td>
        </tr>
      </table>
      <p>ตรวจสอบการชำรุดแล้วพบว่า : {{ item.RC_result }}</p>    
      <p>ผู้ตรวจ : {{item.RC_name}}</p>

      <p>กรรมการตรวจรับพัสดุ</p>
      <p v-if="getdata.data1[0].RP_director1 != ''">1 : {{ item.RP_director1 }}</p>
      <p v-if="getdata.data1[0].RP_director2 != ''">1 : {{ item.RP_director2 }}</p>
      <p v-if="getdata.data1[0].RP_director3 != ''">1 : {{ item.RP_director3 }}</p>
      </div>
    <br />
  </div>
  <button @click="save(id)" type="button" id="btn" >Save</button>
  <br />

</template>
  
<script>
import axios from "axios";
import haderVue from "./hader.vue";
// import footers from './footer.vue';

export default {
  name: "adminReport2",
  data() {
    return {
      id: "",
      getdata: "",
      getdataMPY: "",
      addfromupdate: [],
      dd: "",
      RC_limit: [],
      RC_latest_limit: [],
      ID_item: [],
      name_item: [],
      correct:localStorage.getItem("correct"),
      al:'',
      url: 'https://repairhiresystem.000webhostapp.com/con2.php'
    };
  },
  methods: {
    checklogin() {
      if (localStorage.getItem("pass") == "AO") {
      } else {
        this.$router.push({ name: "loginRP" });
      }
    },
    getID() {
      if (localStorage.getItem("ID")) {
        this.id = localStorage.getItem("ID");

        const options = {
      params: {
        id: this.id,
            action: "searchdataMPY",
        }
      };
        axios
          .get(this.url , options)
          .then((red) => {
            this.getdata = red.data;
            // console.log(this.getdata);
            for (let index = 0; index < this.getdata.data2.length; index++) {
              let element = this.getdata.data2[index];
             this.ID_item.push(element.ID_item)
              if (this.correct == "correct") {
                this.RC_latest_limit.push(element.RC_latest_limit)
                this.RC_limit.push(element.RC_limit)
                
              }
              this.name_item.push(element.RP_property)
            }
            const options2 = {
      params: {
        name_item: this.name_item,
                action: "searchdataMPY2",
        }
      };
            axios
              .get(this.url , options2)
              .then((red) => {
                // this.getdata = red.data;
                // console.log(red.data);
                for (let index = 0; index < red.data.length; index++) {
                  let element = red.data[index];
                  if (this.correct != "correct") {
                    this.RC_latest_limit.push(element.RC_limit)
                  }
                }
              });

          });

      }
    },

    save(ID) {
      this.al = 1
      const options2 = {
      params: {
        RC_limit: this.RC_limit,
          RC_latest_limit: this.RC_latest_limit,
          ID_item: this.ID_item,
          id: this.id,
          ID_AO: localStorage.getItem("username"),
          status: "รอการอนุมัติ",
          action: "MPYsave",
        }
      };
      axios
        .get(this.url , options2)
        .then((red) => {
          this.al = 2
          if(this.al == 2){
             alert("แจ้งไปยังผู้ขอแจ้งซ่อมแล้ว");
          localStorage.setItem("ID_RP", ID);
          this.$router.push({ name: "EmployeeHome" });
          }
         
        });
    },
  },
  created() {
    this.checklogin();
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
.al{
 margin-left: 44%;
  padding: 20px;
  margin-right: 44%;
  text-align: center;
  font-size: x-large;
}
.loading {
  position: relative;
  top: -20px;
  font-size: 80%;
  color: #fcac00;
}
.al2{
  /* background-color: #21f135; */
  margin-left: 44%;
  padding: 40px;
  margin-right: 44%;
  text-align: center;
  font-size: x-large;
  
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


.detail {
  display: block;
  justify-content: center;
  position: relative;
  top: 40px;
  width: 70%;
  left: 15%;
  font-family: "Kanit", sans-serif;
  border: 4px solid #fab317;
  border-radius: 10px;
}

#font1 {
  display: flex;
  justify-content: center;
  position: relative;
  top: 20px;
  font-size: 150%;
  font-family: "Kanit", sans-serif;
}

#head {
  justify-content: center;
  display: flex;
  font-size: 140%;
  font-weight: 600;
  line-height: 3.5;
}


#date, #place, #reason  {
  justify-content: left;
  display: flex;
  font-size: 110%;
  position: relative;
  left: 23%;
  line-height: 2;
}
input {
  text-align: center;
  width: 80%;
  border: 2px solid #000000;
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
  display: flex;
  position: relative;
  top: 10px;
  line-height: 2;
}

#name-rpman {
  font-size: 110%;
  position: relative;
  left: 70%;
  line-height: 3;
}

#p1 {
  font-size: 90%;
  width: 70%;
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
  left: 70%;
  color: red;
  line-height: 2;
  font-size: 90%;
}
#result {
  position: relative;
  left: 70%;
  top: 20px;
}
#p3 {   
  position: relative;
  left: 1%;
  width: 46%;
  padding: 5px 10px;
  border-radius: 5px;
  border: 2px solid rgb(0, 0, 0);
  font-size: 90%;
}
#btn {
  display: flex;
  justify-content: center;
  font-size: 110%;
  position: relative;
  top: 60px;
  left: 48%;
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
}
</style> 