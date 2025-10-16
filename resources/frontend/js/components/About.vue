<template>
    <Heading
        id="about"
        :icon="barChart"
        title="$_GET(<i>'About'</i>)"
        subtitle="Crafting digital experiences with precision and purpose."
    />
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
                        <p class="info-card__motiv" ref="motivText">
                            You can more than you think.
                        </p>
                    </div>
                </div>

                <div
                    class="ic-info about__info-card"
                    v-for="info in infos"
                    :key="info.id"
                >
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
import SplitText from "gsap/SplitText";
import Heading from "./Heading.vue";
import barChart from "../../assets/bar-chart.png";

// регистрация GSAP плагинов
gsap.registerPlugin(ScrollTrigger, SplitText);

const stats = ref([]);
const infos = ref([]);
const animatedCard = ref(null);
const motivText = ref(null);

onMounted(async () => {
    const { data } = await axios.get("/api/about");
    stats.value = data.stats;
    infos.value = data.infos;

    await nextTick();
    const statNumbers = animatedCard.value.querySelectorAll(".stat-number");

    statNumbers.forEach((numEl) => {
        const split = new SplitText(numEl, { type: "chars" });
        gsap.set(split.chars, { y: 50, opacity: 0 });

        ScrollTrigger.create({
            trigger: numEl,
            start: "top 85%",
            once: true,
            onEnter: () => {
                gsap.to(split.chars, {
                    y: 0,
                    opacity: 1,
                    duration: 0.8,
                    ease: "back.out(1.7)",
                    stagger: 0.05,
                });
            },
        });
    });

    if (motivText.value) {
        gsap.to(motivText.value, {
            ease: "none",
            scrollTrigger: {
                trigger: motivText.value,
                start: "top 85%",
                end: "bottom 15%",
                scrub: true,
                onUpdate: (self) => {
                    const progress = self.progress * 100;
                    motivText.value.style.backgroundImage = `linear-gradient(to right, var(--secondary-color) ${progress}%, var(--primary-color) ${progress}%)`;
                },
            },
        });
    }
});
</script>
