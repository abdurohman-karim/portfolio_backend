<template>
    <Heading
        id="about"
        :icon="cubePng"
        title="print(<i>'Skills'</i>)"
        subtitle="Utility classes help you work within the constraints of a system..."
    />
    <div class="section skills" id="skills">
        <div class="container">
            <div class="skills-card">
                <img src="../../assets/skills.png" class="skills-card__img" alt="">
                <div class="skills-card__items">
                    <p v-for="skill in skills" :key="skill.id" class="item">{{ skill.name }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios';
import Heading from "./Heading.vue";
import cubePng from "../../assets/cube.png";

const skills = ref([])

onMounted(async () => {
    let { data } = await axios.get('/api/skills') // Laravel route
    skills.value = data
})
</script>
