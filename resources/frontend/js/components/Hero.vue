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
            <router-link to="/application" class="hero__button">Apply</router-link>

            <svg style="display:none">
                <filter id="filter-noise">
                    <feTurbulence type="fractalNoise" baseFrequency="0 0" numOctaves="1" result="turbulence"/>
                    <feDisplacementMap in2="turbulence" in="SourceGraphic" scale="10"/>
                </filter>
            </svg>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import gsap from 'gsap'

const texts = [
    'Web Developer',
    'Full Service!',
    'and Web Designer',
    'Develop for all!',
    'Full-Stack Developer',
]

const text = ref('')
let i = 0
let j = 0

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
    const feTurbulenceElement = document.querySelector('feTurbulence')
    const button = document.querySelector('.hero__button')

    gsap.set(button, { filter: 'url(#filter-noise)' })

    const animationDuration = 0.4

    const tl = gsap.timeline({ repeat: -1, repeatDelay: 2.6 })
    tl.to(feTurbulenceElement, {
        duration: animationDuration / 2,
        attr: { baseFrequency: '0 0.8' },
        ease: 'power2.inOut',
    }).to(feTurbulenceElement, {
        duration: animationDuration / 2,
        attr: { baseFrequency: '0 0' },
        ease: 'power2.inOut',
    })

    typeEffect()
})
</script>

<style scoped>
.hero__button {
    padding: 1rem 2rem;
    font-size: 1.2rem;
    color: #fff;
    background-color: #1e40af;
    border: none;
    border-radius: 0.5rem;
    cursor: pointer;
    transition: transform 0.2s;
}

.hero__button:hover {
    transform: scale(1.05);
}
</style>
