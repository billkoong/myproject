<template>
<haderVue/>
<samp >
    <p v-if="getdata[0].status == 'ขอแจ้งซ่อมสำเร็จ'  " id="head1" style="color: red;">แจ้งซ่อมสำเร็จ</p>
    <p v-if="getdata[0].status == 'ช่างตรวจสอบแล้ว'  " id="head1" style="color: red;">ช่างตรวจสอบแล้ว</p>
    <p v-if="getdata[0].status == 'รอการอนุมัติ'  " id="head1" style="color: orange;">รอพิมพ์เอกสาร</p>
    <p v-if="getdata[0].status == 'อนุมัติแล้วกำลังดำเนินการซ่อม'  " id="head1" style="color: red;">อนุมัติแล้วกำลังดำเนินการซ่อม</p>
    <p v-if="getdata[0].status == 'กรรมการตรวจรับพัสดุเรียบร้อยแล้ว'  " id="head1" style="color: green;">กรรมการตรวจรับพัสดุเรียบร้อยแล้ว</p>
    <p v-if="getdata[0].status == 'ไม่ผ่านการอนุมัติ'  " id="head1" style="color: red;">ไม่ผ่านการอนุมัติ</p>
    <p v-if="getdata[0].status == 'ซ่อมสำเร็จ'  " id="head1" style="color: green;">ซ่อมสำเร็จ</p>
</samp> 
    <div class="sum">
    <p id="head1">สรุปรายละเอียดการขอซ่อม</p>
    <!-- <h2>ชื่อ-สกุลผู้แจ้ง : {{}}</h2> -->
    <p id="date">วันที่ : {{ getdata[0].RP_date }}</p>
    <p id="place">ชื่อหน่วยงาน/สถานที่ : {{ getdata[0].RP_count_unit }}</p>
    <p id="reason">
      เหตุผลความจำเป็นในการจ้างซ้อมทรัพย์สิน : {{ getdata[0].RP_reason }}
    </p>
    <p id="head2">ตารางแสดงรายการ</p>
    <div class="tb1">
      <table >
        <tr>
          <th>ที่</th>
          <th>ทรัพย์สินที่ต้องการซ่อม</th>
          <th>หมายเลขครุภัณฑ์</th>
          <th>สภาพชำรุดโดยละเอียด</th>
          <th>วงเงินที่จะซ่อม</th>
          <th>ราคาซ่อมครั้งสุดท้าย</th>
        </tr>
        <tr>
          <td>1</td>
          <td>
        <tr v-for="(item, index) in getdata[0]" :key="index">
          <td v-if="getdata[0][index].RP_property"><br>{{ getdata[0][index].RP_property }} </td>
        </tr>
        </td>
        <td>
          <tr v-for="(item, index) in getdata[0]" :key="index">
            <td v-if="getdata[0][index].RP_property"><br>{{ getdata[0][index].RP_property_number }}</td>
          </tr>
        </td>
        <td>
          <tr v-for="(item, index) in getdata[0]" :key="index">
            <td v-if="getdata[0][index].RP_property"><br>{{ getdata[0][index].RP_disrepair }}</td>
          </tr>
        </td>
        <td >
          <tr v-for="(item, index) in getdata[0]" :key="index" >
            <td v-if="getdata[0][index].RP_property" ><br>{{ getdata[0][index].RC_limit }}</td>
          </tr>
        </td>
        <td>
          <tr v-for="(item, index) in getdata[0]" :key="index">
            <td v-if="getdata[0][index].RP_property"><br>{{ getdata[0][index].RC_latest_limit }}</td>
          </tr>
        </td>
        </tr>
      </table>
    </div>
    <br>
    <p id="namerpman">ชื่อผู้ตรวจเซ็ก : {{ getdata[0].RC_name }}</p>
    <p id="datecheck">วันที่ตรวจสอบ : {{ getdata[0].RC_date }}</p>
    <!-- <h2>เวลาที่ตรวจสอบ :{{getdataMPY[0].adminName}}</h2> -->
    <p id="result">ตรวจสอบการชำรุดแล้วพบว่า :   {{ getdata[0].RC_result }} </p>
    <p id="name">คณะกรรมการตรวจรับพัสดุ :</p>
    <p id="n1" v-if="getdata[0].RP_director1 != ''">
      1 : {{ getdata[0].RP_director1 }}
    </p>
    <p id="n2" v-if="getdata[0].RP_director2 != ''">
      2 : {{ getdata[0].RP_director2 }}
    </p>
    <p id="n3" v-if="getdata[0].RP_director3 != ''">
      3 : {{ getdata[0].RP_director3 }}
    </p>
  </div>

  <div v-if="update != 'update'">
    <button v-if="getdata[0].status == 'รอการอนุมัติ'" @click="print" type="print" id="btn4">พิมพ์</button>
  </div>

  <div v-if="update == 'update'" class="btn" >
    <button @click="confirn" id="btn1">อนุมัติผ่านแล้ว กำลังดำเนินการซ่อม</button> 
    <button @click="unconfirn" id="btn2" >ไม่ผ่านการอนุมัติ</button>
  </div>

  <div class="boxreason">
    <textarea  v-if="unconfirns == 1" name="" id="brs" cols="60" rows="4" v-model="Comments" placeholder="เห็นควรแก้ไข / ไม่เห็นชอบเนื่องจาก......."></textarea>

  <div v-if=" update == 'update2'" class="boxreason2">
    
    <textarea name="" id="brs2" cols="60" rows="2" v-model="Comments" placeholder="หมายเหตุ..."></textarea>
  </div>
</div>

  <div class="btn-up"> 
    <button v-if="update == 'update' || update == 'update2' " @click="update1" type="print" id="btn3">อัปเดต</button>
    </div>
    <div class="a"></div>
</template>

<script>
import haderVue from "./hader.vue";
import axios from "axios";
export default {
  name: "save",
  data() {
    return {
      id: "",
      getdata: "",
      getdataMPY: "",
      update: localStorage.getItem("update"),
      unconfirns: '',
      Comments: '',
      action: '',
      url: 'https://repairhiresystem.000webhostapp.com/con2.php'
      // getdatasave:"",
      // addfromupdate: [],
    };
  },
  methods: {
    getID() {
      this.id = localStorage.getItem("ID_RP");

      const options2 = {
      params: {
        id: this.id,
          action: "savedata",
        }
      };
      axios
        .get(this.url , options2)
        .then((red) => {
          this.getdata = red.data;
          if(this.getdata[0].status == "อนุมัติแล้วกำลังดำเนินการซ่อม"){
            this.action = "กรรมการตรวจรับพัสดุเรียบร้อยแล้ว"
          }
          
        });

    },
    update1() {
      if (confirm("ยืนยันการอัปเดตสถานะเป็น "+this.action)) {
        const options2 = {
      params: {
            id: this.id,
            comments: this.Comments,
            action: this.action,
          }
      };
        axios
          .get(this.url , options2 )
          .then((red) => {
            alert(red.data)
            this.$router.push({ name: "EmployeeHome" });
          });
      } else {

      }
    },
    confirn() {
      this.unconfirns = ''
      this.action = "อนุมัติแล้วกำลังดำเนินการซ่อม"

    },
    unconfirn() {
      this.unconfirns = 1
      this.action = "ไม่ผ่านการอนุมัติ"
    },
    print() {
      localStorage.setItem("ID_RP", this.id);
      // this.$router.push({ name: "savepdf" });
      window.open("https://repairhiresystem.vercel.app/savepdf");
    },
  },
  created() {
    this.getID();

  },
  components: {
   haderVue,
  }
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

.sum {
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

#head1 {
  justify-content: center;
  display: flex;
  font-size: 140%;
  font-weight: 600;
}

#date,
#place,
#reason,
#head2 {
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
  display: flex;
  position: relative;
  top: 10px;
  line-height: 2;
}

#result,
#name,
#datecheck,
#namerpman,#n1,
#n2,
#n3 {
  justify-content: left;
  display: flex;
  font-size: 110%;
  position: relative;
  left: 23%;
  line-height: 2;
  width: 60%;
}
.btn, .btn-up {
  position: relative;
  top: 60px;
  padding: 10px ;
  display: flex;
  justify-content: center;
}
#btn1 {
  position: relative;
  right: 1%;
  background-color: #fab317;
  border-radius: 20px;
  color: #00204a;
  padding: 5px 20px;
  border: 2px solid #fab317;
  font-family: "Kanit", sans-serif;
  font-size: 100%;
  font-weight: 600;
}
#btn1:hover {
  background-color: #00204a;
  color: #fab317;
  border: 2px solid #00204a;
}
#btn1:focus {
  background-color: #00204a;
  color: #fab317;
  border: 2px solid #00204a;
}
#btn2 {
  position: relative;
  left: 1%;
  background-color: #fab317;
  border-radius: 20px;
  color: #00204a;
  padding: 5px 80px;
  border: 2px solid #fab317;
  font-family: "Kanit", sans-serif;
  font-size: 100%;
  font-weight: 600;
}
#btn2:hover {
  background-color: #00204a;
  color: #fab317;
  border: 2px solid #00204a;
}
#btn2:focus {
  background-color: #00204a;
  color: #fab317;
  border: 2px solid #00204a;
}
#btn3 {
  background-color: #fab317;
  border-radius: 20px;
  color: #00204a;
  padding: 5px 20px;
  border: 2px solid #fab317;
  font-family: "Kanit", sans-serif;
  font-size: 100%;
  font-weight: 600;
}
#btn3:hover {
  background-color: #00204a;
  color: #fab317;
  border: 2px solid #00204a;
}
.boxreason {
  display: flex;
  justify-content: center;
  position: relative;
  top: 60px;
}
.boxreason2 {
  display: flex;
  justify-content: center;
  position: relative;
  top: 60px;
}
#brs {
  font-size: 100%;
  padding: 15px 15px ;
    border: 2px solid #00204a;
}
#brs2 {
  font-size: 100%;
  padding: 15px 15px ;
  position: relative;
  top: -65px;
  border: 2px solid #00204a;
}


#btn4 {
  background-color: #fab317;
  border-radius: 20px;
  color: #00204a;
  padding: 5px 20px;
  border: 2px solid #fab317;
  font-family: "Kanit", sans-serif;
  position: relative;
  /* display: flex;
  justify-content: center; */
  left: 48%;
  top: 70px;
  font-size: 100%;
  font-weight: 600;
}
#btn4:hover {
  background-color: #00204a;
  color: #fab317;
  border: 2px solid #00204a;
}

</style>