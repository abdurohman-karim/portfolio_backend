<template>
    <div class="section skills" id="skills">
        <div class="container">
            <h2>Skills</h2>
            <div class="skills-card__items">
                <a v-for="skill in skills" :key="skill.id" href="#" class="item">{{ skill.name }}</a>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const skills = ref([])

onMounted(async () => {
    let { data } = await axios.get('/api/skills') // Laravel route
    skills.value = data
})
</script>
