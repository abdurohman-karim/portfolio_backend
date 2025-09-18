<template>
    <div class="section about" id="about">
        <div class="container">
            <!-- статистика -->
            <div class="stat_row">
                <div v-for="stat in stats" :key="stat.id" class="about__stat-card">
                    <p class="stat-number">{{ stat.value }}</p>
                    <p class="stat-text">{{ stat.label }}</p>
                </div>
            </div>

            <!-- инфо-блоки -->
            <div class="info_row">
                <div class="ic-info about__info-card" v-for="info in infos" :key="info.id">
                    <p class="info-card__title">{{ info.title }}</p>
                    <p class="info-card__text">{{ info.text }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const stats = ref([])
const infos = ref([])

onMounted(async () => {
    let { data } = await axios.get('/api/about')
    stats.value = data.stats
    infos.value = data.infos
})
</script>
