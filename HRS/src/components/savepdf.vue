<template>
  <img src="../assets/asd.png" class="img">
  <p class="head">แบบ-พด.-05</p>
  <p class="title">แบบขอแจ้งซ่อม โดยวิธีเฉพาะเจาะจง</p>
  <table class="box1">
    <tr>
      <th>ผู้ส่งเอกสาร</th>
      <th>ผู้รับเอกสาร</th>
    </tr>
    <tr>
      <td>
        วันที่ ....................... <br />
        เวลา ....................... <br />
        ลงชื่อ...................... <br />
      </td>
      <td>
        วันที่ ....................... <br />
        เวลา ....................... <br />
        ลงชื่อ...................... <br />
      </td>
    </tr>
  </table>

  <p class="faculty">
    <b>ส่วนงาน</b> &nbsp; คณะพยาบาลศาสตร์
    .........................................................................................
    โทร. 48243,150
  </p>

  <p class="num">
    <b>ที่</b> อว
    660301.5.1.2../........................................................
    วันที่
    .....................................................................
  </p>
  <p class="num1">{{ getdata[0].RP_date }}</p>
  <p class="to">
    <b>เรียน คณบดีคณะพยาบาลศาสตร์ </b>
    ..................................................................................................................
    <b>(หัวหน้าหน่วยงาน)</b>
  </p>

  <p class="count_unit">
    ด้วย ชื่อหน่วยงาน
    ................................................................................................................
    มีความประสงค์จะจ้างซ่อมทรัพย์สินดังรายการต่อไปนี้
  </p>
  <p class="count_unit1">{{ getdata[0].RP_count_unit }}</p>
  <p class="for">
    เพื่อ <b>(เหตุผลความจำเป็นในการจ้างซ่อมทรัพย์สิน)</b>
    ................................................................................................................................................
  </p>

  <table  class="table01">
    <tr >
      <th>ที่</th>
      <th>ทรัพย์สินที่ต้องการซ่อม</th>
      <th>หมายเลขครุภัณฑ์</th>
      <th>สภาพชำรุดโดยละเอียด</th>
      <th>วงเงินที่จะซ่อม</th>
      <th>ราคาซ่อมครั้งสุดท้าย</th>
    </tr>
    <tr>
      <td>1</td>
      <td>............................................ <br> ............................................</td>
      <td>............................................ <br> ............................................</td>
      <td>............................................ <br> ............................................</td>
      <td>.................................</td>
      <td>...................................</td>
    </tr>
    <tr>
      <td>2</td>
      <td>............................................ <br> ............................................</td>
      <td>............................................ <br> ............................................</td>
      <td>............................................ <br> ............................................</td>
      <td>.................................</td>
      <td>...................................</td>
    </tr>
  </table>
  <p class="result">
    <b>งานช่างได้ตรวจสอบการชำรุดแล้วปรากฎว่า</b>
    ..................................................................................................................................
    <br>......................................................................................................................................................................................
  </p>

  <div class="checkbox">
    <label for="checkbox" id="cb_one"><input type="checkbox" id="checkbox" checked> เห็นควรจะจ้างร้าน</label>
    <label for="checkbox" id="cb_two"><input type="checkbox" id="checkbox" > สามารถซ่อมเองได้</label>
    <label for="" id="cb_tre"><input type="checkbox" name=""> อื่นๆ
      ระบุ.......................................................................</label>
  </div>

  <p class="foraccept">
    เพื่อให้สามารถใช้งานต่อไปได้ตามปกติ จึงใครขออนุมัติดำเนินการจ้างซ่อมวัสดุ / ครุภัณฑ์ดังกล่าวด้วย
  </p>

  <p class="plsaccept">
    <b>จึงเรียนมาเพื่อโปรดพิจารณาหากเห็นชอบโปรดอนุมัติ</b>
  </p>

  <p class="sign">
    <b>............................................ <br> (..........................................)</b>
  </p>

  <p class="sign2">
    <b>............................................ <br> (..........................................)</b>
  </p>

  <p class="receive">
    <b>ขอเสนอรายชื่อเพื่อแต่งตั้งเป็นคณะกรรมการตรวจรับพัสดุ และได้แจ้งผู้ถูกเสนอชื่อให้ทราบทุกท่านแล้ว</b>
  </p>

  <p class="list">
    1) .......................................................................
    2) .......................................................................
    3) .......................................................................
  </p>

  <table class="table2">
    <tr>
      <th>สำหรับเจ้าหน้าที่ผู้รับผิดชอบ/เจ้าของโครการ</th>
      <th>ความเห็นหัวหน้างานยุทธศาสตร์และการคลัง</th>
    </tr>
    <tr>
      <td>
        <p id="b1"><b>เรียน คณบดี/ผู้อำนวยการ</b></p>
        <p id="b2">เพื่อโปรดพิจารณาให้ความเห็นชอบในการจัดซื้อวัสดุ</p>
        <p id="b3">ลงชื่อ.....................................................................</p>
        <p id="b4">(....................................................................)</p>
        <p id="b5">ตำแหน่ง.....................................................................</p>
        <p id="b6">วันที่......................................................................</p>
        <p id="b7">โทรศัพท์มือถือ......................................โทรภายใน..............</p>
      </td>
      <td>
        <p id="c1"><b>เรียน คณบดี ผ่านผู้อำนวยการกองบริหารงานคณะฯ</b></p>
        <p id="c2"><input type="checkbox"> พิจารณาแล้ว เห็นควรดำเนินการจัดซื้อวัสดุต่อไป</p>
        <p id="c3"><input type="checkbox"> เห็นควรแก้ไข/ตรวจสอบ เนื่องจาก.............................</p>
        <p id="c4">ลงชื่อ..................................................................... </p>
        <p id="c5">(นางสาวนภัทร นามสีฐาน)</p>
        <p id="c6">นักวิชาการแผนและสารสนเทศ ชำนาญการ</p>
        <p id="c7">รักษาการแทนหัวหน้างานยุทธศาสตร์และการคลัง</p>
        <p id="c8">วันที่.............................................................................</p>
      </td>
    </tr>
    <tr>
      <th>ความเห็นหัวหน้าเจ้าหน้าที่/ผู้อำนวยการ</th>
      <th>คณบดี</th>
    </tr>
    <tr>
      <td>
        <p id="d1"><b>เรียน (&nbsp;&nbsp;) คณบดีคณะพยาบาลศาสตร์</b></p>
        <p id="d2"><input type="checkbox"> พิจารณาแล้ว เห็นควรดำเนินการจัดจ้างต่อไป</p>
        <p id="d3"><input  type="checkbox"> เห็นควรแก้ไข/ตรวจสอบ...........................................</p>
        <p id="d4">ลงชื่อ................................................................... </p>
        <p id="d5">(นายสุวิต ผิวพันคำ)</p>
        <p id="d6">ผู้อำนวยการกองบริหารงานคณะ คณะพยาบาลศาสตร์</p>
        <p id="d7">วันที่...............................................................................</p>
      </td>
      <td>
        <p id="e1"><input type="checkbox"> เห็นชอบ และดำเนินการต่อไป</p>
        <p id="e2"><input type="checkbox"> ไม่เห็นชอบ เนื่องจาก....................................................</p>
        <p id="e3">ลงชื่อ......................................................................</p>
        <p id="e4">(ผู้ช่วยศาสตราจารย์พักตร์วิไล ศรีแสง)</p>
        <p id="e5">คณบดีคณะพยาบาลศาสตร์</p>
        <p id="e6">วันที่........................................................................</p>
      </td>
    </tr>
  </table>
 <p class="reason">{{ getdata[0].RP_reason }}</p>
 <p class="pro1">{{ getdata[0][0].RP_property }}</p>
 <p class="pro2">{{ getdata[0][0].RP_property_number }}</p>
 <p class="pro3">{{ getdata[0][0].RP_disrepair }}</p>
 <p class="pro4">{{ getdata[0][0].RC_limit }}</p>
 <p class="pro5">{{ getdata[0][0].RC_latest_limit }}</p>
 <div v-if="getdata[0][1]">
 <p class="pro11">{{ getdata[0][1].RP_property }}</p>
 <p class="pro21">{{ getdata[0][1].RP_property_number }}</p>
 <p class="pro31">{{ getdata[0][1].RP_disrepair }}</p>
 <p class="pro41">{{ getdata[0][1].RC_limit }}</p>
 <p class="pro51">{{ getdata[0][1].RC_latest_limit }}</p>
 </div>
 <p class="da1">{{ getdata[0].RC_result }}</p>
 <p class="da2">{{ getdata[0].RC_name }}</p>

 <p class="da3">{{ getdata[0].RP_director1 }}</p>
 <p v-if="getdata[0].RP_director2 != '' " class="da4">{{ getdata[0].RP_director2 }}</p>
 <p v-if="getdata[0].RP_director3 != '' " class="da5">{{ getdata[0].RP_director3 }}</p>
 <p class="names">{{ getdata[0].Fname }} {{ getdata[0].Lname }}</p>
 
 <p class="too1">{{ getdata[0].RP_date }}</p>
 <p class="too2">{{ getdata[0].RP_time }}</p>
 <p class="too3">{{ getdata[0].Fname }}</p>

 <p class="too11">{{ getdata[0].RC_date_AO }}</p>
 <p class="too22">{{ getdata[0].RC_time_AO }}</p>
 <p class="too33">{{ getdata[0].ID_AO }}</p>
</template>

<script>
import { assertDebuggerStatement } from '@babel/types';
import axios from 'axios';

export default {

  name: "savePDF",
  data() {
    return {
      id: "",
      getdata: "",
      getdataMPY: "",
      
    };
  },
  mounted() {
    // alert("เซ็กก่อนทำการ save ทุกครั้ง")
    setTimeout("window.print();", 1000);
  },
  methods: {
    getID() {

      this.id = localStorage.getItem("ID_RP");
    
      axios
        .post("http://localhost:/PJ1/connect.php", {
          id: this.id,
          action: "savedata",
        })
        .then((red) => {
          this.getdata = red.data;
          console.log(this.getdata);
        
        });

    },
   
  },
  created() {
    this.getID();
  },

};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,500;0,600;0,700;0,800;0,900;1,800&family=Noto+Sans+Thai+Looped:wght@100;200;300;400;500;600;700;800;900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Sarabun:ital,wght@0,100;0,200;0,500;0,600;1,100&display=swap');

* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}
.too1{
  position: absolute;
  left: 715px;
  top: 55px;
}
.too2{
  position: absolute;
  left: 715px;
  top: 80px;
}
.too3{
  position: absolute;
  left: 715px;
  top: 105px;
}
.too11{
  position: absolute;
  left: 855px;
  top: 55px;
}
.too22{
  position: absolute;
  left: 855px;
  top: 80px;
}
.too33{
  position: absolute;
  left: 855px;
  top: 105px;
}
.names{
  position: absolute;
  left: 630px;
  top: 675px;
}
.da5{
  position: absolute;
  left: 630px;
  top: 815px;
}
.da4{
  position: absolute;
  left: 330px;
  top: 815px;
}
.da3{
  position: absolute;
  left: 30px;
  top: 815px;
}
.da2{
  position: absolute;
  left: 630px;
  top: 740px;
  line-height: 2;
}
.da1{
  position: absolute;
  left: 300px;
  top: 495px;
  line-height: 2;
  max-width: 630px;
  word-wrap: break-word ;
}
.pro51{
  position: absolute;
  left: 800px;
  top: 435px;
  border-collapse: collapse;
  max-width: 210px;
}
.pro41{
  position: absolute;
  left: 650px;
  top: 435px;
  border-collapse: collapse;
  max-width: 210px;
}
.pro31{
  position: absolute;
  left: 450px;
  top: 430px;
  border-collapse: collapse;
  max-width: 170px;
  max-height: 70px;
  word-wrap: break-word ;
  /* background-color: aqua; */
}
.pro11{
  position: absolute;
  left: 70px;
  top: 430px;
  border-collapse: collapse;
  max-width: 210px;
}
.pro21{
  position: absolute;
  left: 270px;
  top: 430px;
  border-collapse: collapse;
  max-width: 210px;
}
.pro5{
  position: absolute;
  left: 800px;
  top: 355px;
  border-collapse: collapse;
  max-width: 210px;
}
.pro4{
  position: absolute;
  left: 650px;
  top: 355px;
  border-collapse: collapse;
  max-width: 210px;
}
.pro3{
  position: absolute;
  left: 450px;
  top: 350px;
  border-collapse: collapse;
  max-width: 170px;
  max-height: 70px;
  word-wrap: break-word ;
  /* background-color: aqua; */
}
.pro1{
  position: absolute;
  left: 70px;
  top: 350px;
  border-collapse: collapse;
  max-width: 210px;
}
.pro2{
  position: absolute;
  left: 270px;
  top: 350px;
  border-collapse: collapse;
  max-width: 210px;
}
.reason{
  position: absolute;
  left: 330px;
  top: 240px;
  max-width: 930px;
}
body {
  display: block;
  font-family: 'Sarabun', sans-serif;
  font-weight: 300;
}

b {
  font-weight: 500;
}

.head {
  position: absolute;
  left: 755px;
  /* top: 25px; */
}
.img{
  position: absolute;
  height: 120px;
  width: 70px;
}

.title {
  justify-content: center;
  position: relative;
  top: 55px;
  left: 25%;

  font-size: 130%;
  font-weight: 500;
}

.box1 {
  font-weight: 300;
  position: relative;
  left: 670px;
  top: 3px;
  border-collapse: collapse;
}

.box1 tr th {
  position: relative;
  padding: 2px 5px;
  border: 1px solid black;

}

.box1 tr td {
  padding: 5px 5px;
  border: 1px solid black;
  line-height: 1.5;
}

.faculty {
  position: absolute;
  /* left: 20px; */
  top: 125px;
}

.num {
  position: absolute;
  /* left: 20px; */
  top: 155px;
}
.num1 {
  position: absolute;
  left: 500px;
  top: 150px;
}


.to {
  position: absolute;
  /* left: 20px; */
  top: 185px;
}

.count_unit {
  position: absolute;
  left: 20px;
  top: 215px;
}
.count_unit1 {
  position: absolute;
  left: 200px;
  top: 210px;
}

.for {
  position: absolute;
  /* left: 20px; */
  top: 245px;
  max-width: 930px;
}
.table01 {
  position: absolute;
  /* left: 20px; */
  top: 285px;
  border-collapse: collapse;
  max-width: 930px;
}

.table01 tr th {
  /* width: 1000px; */
  /* height: 50px; */
  padding: 5px 10px;
  border: 1px solid black;
}

.table01 tr td {
  width: 1100px;
  height: 80px;
  text-align: center;
  /* padding: 5px 15px; */
  border: 1px solid black;
}

.result {
  position: absolute;
  /* left: 20px; */
  top: 500px;
  line-height: 2;
  max-width: 930px;
}

.checkbox label {
  position: absolute;
  left: 80px;
  top: 560px;
  line-height: 1.5;
}

.checkbox #cb_one {
  position: absolute;
  left: 80px;
}

.checkbox #cb_two {
  position: absolute;
  left: 280px;
}

.checkbox #cb_tre {
  position: absolute;
  left: 500px;
}

.foraccept {
  position: absolute;
  /* left: 20px; */
  top: 590px;
}

.plsaccept {
  position: absolute;
  left: 80px;
  top: 620px;
}

.sign {
  position: absolute;
  left: 600px;
  top: 650px;
  line-height: 1.7;
}

.sign2 {
  position: absolute;
  left: 600px;
  top: 720px;
  line-height: 1.7;
}

.receive {
  position: absolute;
  /* left: 20px; */
  top: 790px;
}

.list {
  position: absolute;
  /* left: 20px; */
  top: 820px;
}

.table2 {
  position: absolute;
  /* left: 20px; */
  top: 850px;
  /* width: 930px; */
  border-collapse: collapse;
  border: 1px solid black;
}
.table2 tr th{
  position: relative;
  height: auto;
  width: 455px;
  line-height: 1.5;
  padding: 5px 15px;
  border: 1px solid black;
}
.table2 tr  td {
  position: relative;
  height: auto;
  width: 455px;
  line-height: 1.5;
  padding: 10px 15px;
  border: 1px solid black;
}

#b2 {
  position: relative;
  left: 40px;
  line-height: 2;
}

#b3 {
  position: relative;
  left: 90px;
  line-height: 2;
}

#b4 {
  position: relative;
  left: 120px;
}

#b5 {
  position: relative;
  left: 70px;
}

#b6 {
  position: relative;
  left: 92px;
}

#b7 {
  position: relative;
  left: 30px;
}

#c2 {
  position: relative;
  left: 40px;
  line-height: 2;
}

#c3 {
  position: relative;
  left: 40px;
  line-height: 2;
}

#c4 {
  position: relative;
  left: 90px;
}

#c5 {
  position: relative;
  left: 150px;
}

#c6 {
  position: relative;
  left: 92px;
}

#c7 {
  position: relative;
  left: 70px;
}

#c8 {
  position: relative;
  left: 70px;
}

#d2 {
  position: relative;
  left: 40px;
  line-height: 2;
}

#d3 {
  position: relative;
  left: 40px;
  line-height: 2;
}

#d4 {
  position: relative;
  left: 90px;
}

#d5 {
  position: relative;
  left: 165px;
}

#d6 {
  position: relative;
  left: 50px;
}

#d7 {
  position: relative;
  left: 50px;
}

#e1 {
  position: relative;
  left: 40px;
  line-height: 2;
}

#e2 {
  position: relative;
  left: 40px;
  line-height: 2;
}

#e3 {
  position: relative;
  left: 90px;
  line-height: 2;
}

#e4 {
  position: relative;
  left: 120px;
}

#e5 {
  position: relative;
  left: 150px;
}

#e6 {
  position: relative;
  left: 90px;
}
</style> 
