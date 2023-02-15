import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import save from '@/views/save.vue'

createApp(save).use(router).mount('#save')
createApp(App).use(router).mount('#app')
