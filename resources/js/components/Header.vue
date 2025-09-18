<template>
    <header :class="{ open: menuOpen }" class="header">
        <div class="container">
            <a href="#" class="header__logo"><b>m</b>eth<b>O</b>d</a>
            <nav class="nav header__nav">
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#skills">Skills</a></li>
                    <li><a href="#projects">Projects</a></li>
                    <li><a href="#questions">Questions</a></li>
                </ul>
            </nav>
            <div class="actions header__actions">
                <button class="actions__button" @click="$emit('toggleDark')">
                    <span v-if="darkMode">🌞</span>
                    <span v-else>🌙</span>
                </button>
                <button class="actions__button" @click="menuOpen = !menuOpen">☰</button>
            </div>
        </div>
    </header>
</template>

<script setup>
import { ref } from 'vue'
defineProps({ darkMode: Boolean })
const menuOpen = ref(false)
</script>
