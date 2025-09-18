<template>
    <div id="app">
        <Preloader v-if="loading" />
        <Header :darkMode="darkMode" @toggleDark="toggleDarkMode" />
        <Hero />
        <About />
        <Skills />
        <Projects />
        <Questions />
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import Header from './components/Header.vue'
import Preloader from './components/Preloader.vue'
import Hero from './components/Hero.vue'
import About from './components/About.vue'
import Skills from './components/Skills.vue'
import Projects from './components/Projects.vue'
import Questions from './components/Questions.vue'

const darkMode = ref(localStorage.getItem('darkMode') === 'enabled')
const loading = ref(true)

function toggleDarkMode() {
    darkMode.value = !darkMode.value
    localStorage.setItem('darkMode', darkMode.value ? 'enabled' : 'disabled')
    document.documentElement.classList.toggle('dark-theme', darkMode.value)
}

onMounted(() => {
    setTimeout(() => {
        loading.value = false
    }, 1000)
})
</script>

<style>
@import "../scss/main.scss";
</style>
