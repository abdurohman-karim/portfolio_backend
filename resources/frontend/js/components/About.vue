<template>
    <Heading id="about" :icon="barChart" title="$_GET(<i>'About'</i>)" subtitle="Utility classes help you work within the constraints of a system..."/>
    <div class="section about" id="about" ref="animatedCard">
        <div class="container">
            <!-- статистика -->
            <div class="stat_row">
                <div
                    v-for="stat in stats"
                    :key="stat.id"
                    class="about__stat-card"
                >
                    <p class="stat-number">{{ stat.value }}</p>
                    <p class="stat-text">{{ stat.label }}</p>
                </div>
            </div>

            <!-- инфо-блоки -->
            <div class="info_row">
                <div class="ic-info about__info-card">
                    <div class="card-inner">
                        <p class="info-card__motiv">You can more than you think.</p>
                    </div>
                </div>

                <div class="ic-info about__info-card" v-for="info in infos" :key="info.id">
                    <p class="info-card__title">{{ info.title }}</p>
                    <p class="info-card__text">{{ info.text }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, nextTick } from "vue";
import axios from "axios";
import gsap from "gsap";
import ScrollTrigger from "gsap/ScrollTrigger";
import Heading from "./Heading.vue";
import barChart from "../../assets/bar-chart.png";

gsap.registerPlugin(ScrollTrigger);

const stats = ref([]);
const infos = ref([]);
const animatedCard = ref(null);

onMounted(async () => {
    const { data } = await axios.get("/api/about");
    stats.value = data.stats;
    infos.value = data.infos;

    await nextTick();
});
</script>
