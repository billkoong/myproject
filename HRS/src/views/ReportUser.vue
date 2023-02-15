<template>
 <haderVue/>
  <i id="logo"><img src="../assets/logoNU.png" alt="" ></i>
    <div class="box-detail">
        <p class="title">แบบฟอร์มขอจ้างซ่อม</p>
        <p class="unit"> ชื่อหน่วยงาน
            <input type="text" ref="RP_count_unit" name="" id="unit" placeholder="Enter your Count unit">
        </p>

        <p class="reason"> เหตุผลความจำเป็นในการจ้างซ่อมทรัพย์สิน 
            <textarea rows="2" ref="RP_reason" id="reason" placeholder="Enter your reason..."></textarea>
        </p>

        <p class="nominate"> เสนอรายชื่อเพื่อแต่งตั้งเป็นคณะกรรมการตรวจรับพัสดุ และได้แจ้งผู้ถูกเสนอชื่อให้ทราบทุกคนแล้ว<br>
           <div class="namenominate">
            1) <input type="text" ref="RP_director1" name="name1" id="name" placeholder="First Nominate ">
            2) <input type="text" ref="RP_director2" name="name2" id="name" placeholder="Second Nominate ">
            3) <input type="text" ref="RP_director3" name="name3" id="name" placeholder="Third Nominate ">
           </div> 
        </p>

        <p class="choose-type">เลือกประเภทของครุภัณฑ์  
          <select name="" id="type" ref="invee" placeholder="Enter your reason...">
            <option value="" style="color: gray;" >--Plese choose your property type--</option>
            <option v-for="(item, index) in invite" :key="index">{{ item }}</option>
          </select>
        </p> 

        <div class="addbox">
            <div class="box">
                <p class="property"> ทรัพย์สินที่ต้องการซ่อม <br>
                    <input type="text" ref="RP_property"  name="" id="property" placeholder="Durable articles or your property">
                </p>
                <p class="property"> หมายเลขครุภัณฑ์ <br>
                    <input type="number" ref="RP_property_number" name="" id="property" placeholder="Number of Durable articles">
                </p>
                <p class="property"> สภาพชำรุดโดยละเอียด <br>
                    <input type="text"  ref="RP_disrepair" name="" id="property" placeholder="Cause of dilapidation">
                </p>
                <a > <button @click.prevent="addfrom" type="add" class="btn1">Add</button></a>
            </div> 
        </div>

        <report-user-2  :addfroms="addfroms" @deletedata="deletedata" class="showtable" />
      </div>
      <br><br />
<div class="s">
  
</div>
</template>

<script>
import haderVue from "./hader.vue";
import ReportUser2 from "./ReportUser2.vue";

export default {
  name: "ReportUser",

  data() {
    return {
      invite: ["ครุภัณฑ์ทั่วไป เช่น พัดลม แอร์ หน้าต่าง","ครุภัณฑ์อิเล็กทรอนิกส์ เช่น คอมพิวเตอร์ โน็ตบุ๊ก TV" ],
      invee: 'ครุภัณฑ์ทั่วไป เช่น พัดลม แอร์ หน้าต่าง',
      fromdate: {
       
        id: 0,
        RP_count_unit: '',
        RP_reason: '',
        RP_property: '',
        RP_property_number: '',
        RP_disrepair: '',
        RP_director1: '',
        RP_director2: '',
        RP_director3: '',
        
      },
      addfroms: [],
    };
  },
  components: {
    ReportUser2,
    haderVue,
  },
  methods: {
    addfrom() {

      if (this.$refs.RP_count_unit.value == "" || this.$refs.RP_reason.value == "" || this.$refs.RP_director1.value == "") {
        alert("กรุณาใส่ข้อมูลให้ครบ")
      } else {
        const addfromnew = {
          RP_count_unit: this.$refs.RP_count_unit.value,
          RP_reason: this.$refs.RP_reason.value,
          RP_property: this.$refs.RP_property.value,
          RP_property_number: this.$refs.RP_property_number.value,
          RP_disrepair: this.$refs.RP_disrepair.value,
          RP_director1: this.$refs.RP_director1.value,
          RP_director2: this.$refs.RP_director2.value,
          RP_director3: this.$refs.RP_director3.value,
          
        };
        
        this.invee = this.$refs.invee.value
        this.addfroms.push(addfromnew);
        this.cle()
        localStorage.setItem("type" , this.invee)
      }
    },


    deletedata(index) {

      if (confirm("ยืนยันการลบ")) {
        this.addfroms.splice(index, 1)
      } else {

      }
    },
    cle() {
      
        this.$refs.RP_property.value = '',
        this.$refs.RP_property_number.value = '',
        this.$refs.RP_disrepair.value = ''
       
    },

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

#logo {
  justify-content: center;
  position: relative;
  display: flex;
  top: 10px;
}
.box-detail {
  position: relative;
  top: 20px;
  width: 80%;
  height: auto;
  left: 10%;

  line-height: 2;

  padding: 30px 150px;
  box-shadow: 0px 0px 20px 5px rgba(0, 0, 0, 0.25);
  border: 3px solid rgb(255, 255, 255);
  border-radius: 20px;
  font-size: 120%;
  font-weight: 500;
}

.title {
  position: relative;
  text-align: center;
  font-size: 130%;
  font-weight: 600;
  line-height: 3;
  padding: 0px 20px;
}

.unit {
  padding: 5px 0px;
  position: relative;
  line-height: 2;
  /* left: 21%; */
}

#unit {
  font-size: 90%;
  width: 68%;
  position: relative;

  border-radius: 5px;
  padding: 5px 15px;
  border: 2px solid black;
}
.reason {
  top: -10px;
  padding: 5px 0px;
  position: relative;
  line-height: 2;
}
#reason {
  font-size: 90%;
  width: 62%;
  top: 20px;
  position: relative;
  border-radius: 5px;
  padding: 5px 15px;
  border: 2px solid black;
}
.choose-type {
  top: -10px;
  padding: 5px 0px;
  position: relative;
  line-height: 2;
}
#type {
  font-size: 90%;
  width: 40%;
  position: relative;
  border-radius: 5px;
  padding: 5px 15px;
  border: 2px solid black;
}
.nominate {
  padding: 5px 0px;
  position: relative;
  line-height: 2.5;
}
.namenominate {
  display: block;
  margin-bottom: 10px;
  width: 100%;
  line-height: 2;
}
#name {
  font-size: 90%;
  width: 30.2%;
  position: relative;
  border-radius: 5px;
  padding: 5px 15px;
  border: 2px solid black;
}
.addbox {
  padding: 15px 10px;
  position: relative;
  line-height: 2;
  color: white;
  border-radius: 10px;
}

.box {
  margin: auto;
  font-weight: 500;
  width: 100%;
  border-radius: 10px;
  padding: 30px 60px;
  background-color: #00204a;
  box-shadow: 0px 0px 20px 5px rgba(0, 0, 0, 0.25);
}

#property {
  width: 95%;
  position: relative;
  left: 5%;
  border-radius: 5px;
  padding: 5px 15px;
  font-size: 90%;
}


.btn1 {
  font-size: large;
  margin-left: auto;
  padding: 5px 15px;
  position: relative;
  left: 90%;
  top: 10px;
  border-radius: 20px;
  color: #00204a;
  background-color: #ffbc30;
  border: #ffbc30;
}
.btn1:hover {
  color: #00204a;
  background-color: #ffffff;
  border: #00204a;
}

</style>