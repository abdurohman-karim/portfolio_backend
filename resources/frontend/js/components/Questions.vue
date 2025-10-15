<template>
    <Heading
        id="about"
        :icon="dev"
        title="cout<<<i>'Questions'</i>;"
        subtitle="Got a question? Here are some quick answers that might help!"
    />
    <div class="section questions" id="questions">
        <div class="container">
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
import dev from "../../assets/development.png";
import Heading from "./Heading.vue";

const questions = ref([])

onMounted(async () => {
    let { data } = await axios.get('/api/questions')
    questions.value = data
})
</script>
