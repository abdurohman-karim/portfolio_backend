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

function applyTheme() {
    document.documentElement.classList.toggle('dark-theme', darkMode.value)
}

function toggleDarkMode() {
    // включаем прелоадер
    loading.value = true

    // переключаем тему
    darkMode.value = !darkMode.value
    localStorage.setItem('darkMode', darkMode.value ? 'enabled' : 'disabled')
    applyTheme()

    // выключаем прелоадер через 1 секунду
    setTimeout(() => {
        loading.value = false
    }, 1000)
}

onMounted(() => {
    applyTheme()

    // убираем прелоадер при первой загрузке
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
    </div>
</template>

<style>
@import "../scss/main.scss";
</style>
