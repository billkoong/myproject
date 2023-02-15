import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import ReportUser from '@/views/ReportUser.vue'
import adminReport from '@/views/adminReport.vue'
import statusdata from '@/views/statusdata.vue'
import adminReport2 from '@/views/adminReport2.vue'
import EmployeeHome from '@/views/EmployeeHome.vue'
import EmployeeReport from '@/views/EmployeeReport.vue'
import EmployeeReport2 from '@/views/EmployeeReport2.vue'
import Homeuser from '@/views/Homeuser.vue'
import login from '@/views/login.vue'
import register from '@/views/ragister.vue'
import loginAO from '@/views/loginAO.vue'
import save from "@/views/save.vue"
import loginRP from '@/views/loginRP.vue'
import savepdf from '@/components/savepdf.vue'
// import PprintPDF from '@/PprintPDF.vue'
import pdfMake from '@/views/pdfMake'
const routes = [
  {
    path: '/pdfMake',
    name: 'pdfMake',
    component: pdfMake
  },
  {
    path: '/home',
    name: 'home',
    component: HomeView
  },
  {
    path: '/save',
    name: 'save',
    component: save
  },
  {
    path: '/register',
    name: 'register',
    component: register
  },
  {
    path: '/',
    name: 'login',
    component: login
  }, 
  {
    path: '/loginRP',
    name: 'loginRP',
    component: loginRP
  }, 
  {
    path: '/loginAO',
    name: 'loginAO',
    component: loginAO
  },
  {
    path: '/Homeuser',
    name: 'Homeuser',
    component: Homeuser
  },
  // {
  //   path: '/about',
  //   name: 'about',
  //   component: () => import( '../views/footer.vue')
  // },
  {
    path: '/Report',
    name: 'ReportUser',
    component: ReportUser
  },
  {
    path: '/adminReport',
    name: 'adminReport',
    component: adminReport
  },
  {
    path: '/statusdata',
    name: 'statusdata',
    component: statusdata
  },
  {
    path: '/adminReport2',
    name: 'adminReport2',
    component: adminReport2
  },
  {
    path: '/EmployeeHome',
    name: 'EmployeeHome',
    component: EmployeeHome
  },
  {
    path: '/EmployeeCheck',
    name: 'EmployeeCheck',
    component: () => import( '../views/EmployeeCheck.vue')
  },
  {
    path: '/EmployeeReport',
    name: 'EmployeeReport',
    component: EmployeeReport
  },
  {
    path: '/EmployeeReport2',
    name: 'EmployeeReport2',
    component: EmployeeReport2
  },
  {
    path: '/savepdf',
    name: 'savepdf',
    component: savepdf
  },

]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
