import './bootstrap.js';
import { createApp } from 'vue'
import App from './App.vue'
import '../scss/main.scss'
import router from './src/router'

createApp(App).use(router).mount('#app')
