<template>
    <div class="section hero" id="home">
        <div class="container">
            <div class="hero__banner">
                <p>echo <i class="shine">"Welcome!"</i>;</p>
            </div>
            <div class="hero__ellipse">
                <img src="../../assets/ellipse.jpg"  alt=""/>
            </div>
            <p class="hero__author">Abdurohman Karim</p>
            <p class="hero__title job">{{ text }}</p>
            <a href="#" class="hero__button">Apply</a>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const texts = ["Web Developer", "Full Service!", "and Web Designer", "Develop for all!", "Full-Stack Developer"]
const text = ref("")
let i = 0, j = 0

function typeEffect() {
    if (j < texts[i].length) {
        text.value = texts[i].substring(0, j + 1)
        j++
        setTimeout(typeEffect, 100)
    } else {
        setTimeout(() => {
            j = 0
            i = (i + 1) % texts.length
            typeEffect()
        }, 1500)
    }
}

onMounted(() => {
    typeEffect()
})
</script>
