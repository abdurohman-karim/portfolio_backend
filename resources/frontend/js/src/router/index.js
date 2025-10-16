import { createRouter, createWebHistory } from 'vue-router'
import Home from '../pages/Home.vue'
import Application from '../pages/Application.vue'

const routes = [
    { path: '/', name: 'home', component: Home },
    { path: '/application', name: 'application', component: Application },
]

const router = createRouter({
    history: createWebHistory('/app'),
    routes,
})

export default router
