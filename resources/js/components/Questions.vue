<template>
    <div class="section questions" id="questions">
        <div class="container">
            <h2>Questions</h2>
            <div class="questions__cards">
                <div v-for="q in questions" :key="q.id" class="questions__card">
                    <p class="card__title">{{ q.title }}</p>
                    <p class="card__text">{{ q.text }}</p>
                    <img v-if="q.image" :src="q.image" />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const questions = ref([])

onMounted(async () => {
    let { data } = await axios.get('/api/questions')
    questions.value = data
})
</script>
