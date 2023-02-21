<template>

  <haderVue/>
  <div class="header">
    <p id="p1">ยินดีต้อนรับคุณ{{ user }} <br /></p>
    <p id="p2">สู่เว็บไซต์จ้างซ่อมวัสดุและครุภัณฑ์ <br> คณะพยาบาลศาสตร์ มหาวิทยาลัยขอนแก่น
    </p>
  </div>
<div class="menu">
  <div class="gt-report">
    <img src="../assets/pic1.png" alt="" id="pic1" />
    <div class="detail01">
    <p id="p01">เข้าสู่หน้ากรอกฟอร์มขอจ้างซ่อม</p>
    <p id="p02">
      สำหรับบุคลากร <br />
      คณะพยาบาลศาสตร์ มหาวิทยาลัยขอนแก่น
    </p>
    <p id="p03">
      เพื่อแจ้งและระบุรายละเอียดเกี่ยวกับ <br />
      การขอแจ้งซ่อมวัสดุและครุภัณฑ์
    </p>
    <button @click="Report">ไปที่หน้ารายงาน</button>
  </div>
</div>

<div v-if="pass == 'ครุภัณฑ์อิเล็กทรอนิกส์ เช่น คอมพิวเตอร์ โน็ตบุ๊ก TV' || pass == 'ครุภัณฑ์ทั่วไป เช่น พัดลม แอร์ หน้าต่าง' ">
  <div class="gt-recheck">
    <img src="../assets/pic2.png" alt="" id="pic2" />
    <div class="detail02">
    <p id="p01">ผลการตรวจสอบ</p>
    <p id="p02">สำหรับช่างซ่อม</p>
    <p id="p03">
      รายงานผลการหลังตรวจสอบวัสดุและครุภัณฑ์ <br />
      เพื่อส่งรายงานให้หน่วยงานพัสดุ<br />
    </p>
    <button @click="adminReport">ไปที่หน้ารายงานผลตรวจสอบ</button>
    </div>
  </div>
</div>

<div v-if="pass == 'AO'">
  <div class="gt-accept">
    <img src="../assets/pic3.png" alt="" id="pic3" />
    <div class="detail03">
    <p id="p01">กำหนดวงเงิน</p>
    <p id="p02">
      สำหรับพนักงานหน่วยพัสดุ <br />
      คณะพยาบาลศาสตร์ มหาวิทยาลัยขอนแก่น
    </p>
    <p id="p03">
      เพื่อกำหนดงบประมาณในการซ่อม <br />
      พร้อมทั้งดำเนินการในขั้นตอนถัดไป
    </p>
    <button @click="EmployeeReport">ไปที่หน้ากำหนดวงเงิน</button>
    </div>
  </div>
</div>


  <div class="gt-check">
    <img src="../assets/pic4.png" alt="" id="pic4" />
    <div class="detail04">
      <p id="p01">ตรวจสอบสถานะปัจจุบัน</p>
      <p id="p02">สำหรับผู้ใช้งานทุกคน</p>
      <p id="p03">เพื่อตรวจสอบสถานะปัจจุบันของการจ้างซ่อม</p>
      <button @click="statusdata">คลิกที่นี่</button>
    </div>
  </div>
</div>
  <footers/>
</template>



<script>
import haderVue from "./hader.vue";
import footers from "./footer.vue";
export default {
  name: "home",
  data() {
    return {
      user: "",
      pass: localStorage.getItem("pass"),
    };
  },
  methods: {
    checklogin() {
      if (!localStorage.getItem("username")) {
        this.$router.push({ name: "login" });
      } else {
      }
    },
    Report() {
      this.$router.push({ name: "ReportUser" });
    },
    adminReport() {
      this.$router.push({ name: "adminReport" });
    },
    statusdata() {
      this.$router.push({ name: "statusdata" });
    },
    EmployeeReport() {
      this.$router.push({ name: "EmployeeHome" });
    },
    logout() {
      localStorage.clear();
      this.$router.push({ name: "login" });
    },

    // staet(){
    //     this.$router.push({ name: "login" });
    // },
  },
  created() {
    // console.log(this.user);
    this.user = localStorage.getItem("username");
    this.checklogin();
    // if(this.user == '1' ){
    //   console.log(this.user);
    //     this.$router.push({ name: "login" });
    //   }
  },
  components: {
    haderVue,
    footers,
  },
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,500;0,600;0,700;0,800;0,900;1,800&family=Noto+Sans+Thai+Looped:wght@100;200;300;400;500;600;700;800;900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap");
* {
  justify-content: center;
  position: relative;
  display: block;
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-family: "Roboto", sans-serif;
}
.header {
  position: relative;
  padding: 30px 80px ;

}

#p1 {
  display: flex;
  justify-content: center;
  position: relative;
  line-height: 1;
  font-family: "Kanit", sans-serif;

  font-size: 300%;
  font-weight: 700;
  line-height: 1.5;
  color: #00204a;
}
#p2 {
  display: flex;
  justify-content: center;
  position: relative;
  font-family: "Kanit", sans-serif;
  text-align: center;
  font-size: 150%;
  font-weight: 600;
  color: #00204a;
}
.menu {
  position: relative;
  padding: 0px 80px;
}
.gt-report {
  /* border: 2px solid darkblue; */
  display: flex;
}
.detail01 {
  padding: 7% 0px 0px 40px;
  line-height: 1.25;
  color: #00204a;
}
.gt-recheck {
  display: flex;
}
.detail02 {
  padding: 6% 4% 0px 40px;
  line-height: 1.25;
  color: #00204a;
}
.gt-accept {
  display: flex;
}
.detail03 {
  padding: 6% 0% 0px 40px;
  line-height: 1.25;
  color: #00204a;
}
.gt-check {
  display: flex;
}
.detail04 {  
  display: block;
  padding: 10% 0%;
  line-height: 1.25;
  color: #00204a;
}
#p01 {
  font-family: "Kanit", sans-serif;
  font-size: 170%;
  font-weight: 700;
}
#p02 {
  font-family: "Kanit", sans-serif;
  font-size: 140%;
  font-weight: 600;
}

#p03 {
  font-family: "Kanit", sans-serif;
  font-size: 120%;
}

#pic1{
  display: block;
  position: relative;
  padding: 50px 10px;
  width: 25%;
  height: 35%;
}
#pic2 {
  padding: 50px 10px;
  display: block;
  position: relative;
  width: 25%;
  height: 35%;
}
#pic3{
  padding: 50px 10px;
  display: block;
  position: relative;
  width: 25%;
  height: 35%;
}
#pic4 {
  display: block;
  position: relative;
  padding: 50px 10px;
  width: 25%;
  height: 35%;
  right: 3%;
}

button {
  top: 10px;
  padding: 5px 25px;
  font-size: 100%;
  font-weight: 600;
  font-family: "Kanit", sans-serif;
  background: #fab317;
  border: #fab317;
  border-radius: 20px;
  color: #00204a;
}

button:hover {
  background-color: #00204a;
  color: #fab317;
}
</style>