<script setup>
import { ref, onMounted } from 'vue'
import Header from './components/Header.vue'
import Preloader from './components/Preloader.vue'
import Hero from './components/Hero.vue'
import About from './components/About.vue'
import Skills from './components/Skills.vue'
import Projects from './components/Projects.vue'
import Questions from './components/Questions.vue'
import Footer from "./components/Footer.vue";

const darkMode = ref(localStorage.getItem('darkMode') === 'enabled')
const loading = ref(true)

function applyTheme() {
    document.documentElement.classList.toggle('dark-theme', darkMode.value)
}

function toggleDarkMode() {
    loading.value = true

    darkMode.value = !darkMode.value
    localStorage.setItem('darkMode', darkMode.value ? 'enabled' : 'disabled')
    applyTheme()

    setTimeout(() => {
        loading.value = false
    }, 1000)
}

onMounted(() => {
    applyTheme()

    setTimeout(() => {
        loading.value = false
    }, 1000)
})
</script>

<template>
    <div id="app">
        <Preloader v-if="loading" />
        <Header :darkMode="darkMode" @toggleDark="toggleDarkMode" />
        <Hero />
        <About />
        <Skills />
        <Projects />
        <Questions />
        <Footer />
    </div>
</template>

<style>
@import "../scss/main.scss";
</style>
