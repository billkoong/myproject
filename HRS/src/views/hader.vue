<template>
    <header>
    <router-link to="/home">
      <p class="logonav">Repair Hire System</p>
    </router-link>
    <nav>
      <ul class="nav_links">
        <li>
          <router-link to="/home">Home</router-link>
        </li>
        <li>
          <router-link to="/Homeuser">My report</router-link>
        </li>
        <li>
          <router-link to="#">Help</router-link>
        </li>
        <li>
          <router-link to="/" id="logout">Logout</router-link>
        </li>
      </ul>
    </nav>
  </header>
</template> 

<script>
export default {
    data() {
    return {
      out:'',
      picture: "",
      size: 150,
      user: "",
    };
  },
}
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,500;0,600;0,700;0,800;0,900;1,800&family=Noto+Sans+Thai+Looped:wght@100;200;300;400;500;600;700;800;900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap");
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-family: "Kanit", sans-serif;
  padding: 8px ;
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
  font-size: 120%;
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
  padding: 10px 20px;
  color: #ffffff;
}

</style>
