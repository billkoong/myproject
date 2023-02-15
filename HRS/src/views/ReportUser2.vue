<template>
  <!-- <nav>
    <router-link to="/">หน้าหลัก</router-link> |
    <router-link to="/Report">ขอแจ้งซ่อม</router-link> |
    <router-link to="/statusdata">เซ็คสถานะ</router-link> |
    <router-link to="/about">เกี่ยวกับเรา</router-link> 
  </nav>   -->
  <div class="result">
    <table>
      <tr>
        <th>ที่</th>
        <th>ทรัพย์สินที่ต้องการซ่อม</th>
        <th>หมายเลขครุภัณฑ์</th>
        <th>สภาพชำรุดโดยละเอียด</th>
        <th>ลบข้อมูล</th>
      </tr>
      <tr v-for="(item, index) in addfroms" :key="index">
        <td>{{ index + 1 }}</td>
        <td>{{ item.RP_property }}</td>
        <td>{{ item.RP_property_number }}</td>
        <td>{{ item.RP_disrepair }}</td>
        <td><button @click="deletedata(index)" id="delete-btn">ลบ</button></td>
      </tr>
    </table>
    <button @click="submitfromdata" type="submit" id="submit">Submit</button>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "ReportUser2",
  data() {
    return {
      id_user: localStorage.getItem("id_user"),
    };
  },
  props: ["addfroms"],
  // props: ["types"],
  methods: {
    deletedata(index) {
      this.$emit("deletedata", index);
    },
    submitfromdata(e) {
      e.preventDefault();
      if (this.addfroms == 0) {
        alert("กรุณา add");
      } else {
        axios
          .post("http://localhost:/PJ1/connect.php", {
            addfroms: this.addfroms,
            id_user: this.id_user,
            type: localStorage.getItem("type"),
            status: "ขอแจ้งซ่อมสำเร็จ",
            action: "submitfromdata",
          })
          .then((red) => {
            if (red.data == "completed") {
              alert(red.data);
              this.$router.push({ name: "Homeuser" });
            } else {
              alert(red.data);
            }
          });
      }
    },
  },
  created() {
    // console.log(this.id_user)
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
body {
  display: block;
  justify-content: center;

  font-weight: 500;
}.result {
  position: relative;
  width: 100%;
}
.result table {
  position: relative;
  width: 100%;
  padding: 5px 20px;
  background-color: #00204a;
  border-radius: 10px;
  border-color: #ffffff;
}
table tr th {
  position: relative;
  font-size: 90%;
  color: #ffffff;
}
table tr td {
  align-items: center;
  text-align: center;
  color: #ffffff;
}

#submit {
  font-size: large;
  margin-left: auto;
  padding:7px 15px;
  position: relative;
  left: 90%;
  top: 10px;
  border-radius: 20px;
  color: #00204a;
  background-color: #ffbc30;
  border: #ffbc30;
  font-family: "Roboto", sans-serif;
  font-weight: 700;
}
#submit:hover {
  color: #fab317;
  background-color: #00204a;
  border: #00204a;
}
#delete-btn {
  justify-content: center;
  position: relative;
  width: auto;
  height: auto;
  padding: 3px 15px;
  
  font-size: 90%;
  background: #fab317;
  border: 0px solid #fab317;
  border-radius: 10px;
}
#delete-btn:hover {
  color: #00204a;
  background: #ffffff;
  border-radius: 10px;
}
</style>