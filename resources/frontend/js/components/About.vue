<template>
    <Heading id="about" :icon="barChart" title="$_GET(<i>'About'</i>)" subtitle="Utility classes help you work within the constraints of a system..."/>
    <div class="section about" id="about">
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
                <div class="ic-info about__info-card" ref="animatedCard">
                    <div class="card-inner">
                        <p class="info-card__motiv">Успех приходит к тем, кто действует!</p>
                        <p class="info-card__motiv">Каждый шаг — это победа над собой.</p>
                        <p class="info-card__motiv">Не жди момента, создай его.</p>
                        <p class="info-card__motiv">Трудности делают тебя сильнее.</p>
                        <p class="info-card__motiv">Сегодняшние усилия — завтрашний результат.</p>
                        <p class="info-card__motiv">Дисциплина побеждает мотивацию.</p>
                        <p class="info-card__motiv">Ты можешь больше, чем думаешь.</p>
                        <p class="info-card__motiv">Фокусируйся на цели, а не на страхе.</p>
                        <p class="info-card__motiv">Каждый день — новый шанс.</p>
                        <p class="info-card__motiv">Только вперёд!</p>
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

    const el = animatedCard.value;
    if (!el) return;
    const inner = el.querySelector(".card-inner");
    const slides = document.querySelectorAll(".card-inner .info-card__motiv");
    const numSlides = slides.length;

    ScrollTrigger.refresh();

    // Пин карточки
    gsap.to(el, {
        scrollTrigger: {
            trigger: el,
            start: "center center",
            end: "+=2200",
            scrub: true,
            pin: true,
            pinSpacer: true,
            pinType: "transform",
            pinReparent: true,
            anticipatePin: 1,
            markers: true,
        },
        scale: 1.2,
        rotateX: -30,
        rotateY: -20,
        zIndex: 1000,
        ease: "power2.out",
        transformOrigin: "center center",
    });

    gsap.to(inner, {
        xPercent: -100 * (numSlides - 1),
        ease: "none",
        scrollTrigger: {
            trigger: el,
            pin: true,
            scrub: 1,
            start: "top top",
            end: () => "+=" + window.innerHeight * (numSlides - 1),
        }
    });

    const handle = () => ScrollTrigger.refresh();
    window.addEventListener("resize", handle);
});
</script>

<style scoped>
.about__info-card--animation{
    perspective: 1000px;
    transform-origin: center center;
    overflow: hidden;
    backface-visibility: hidden;
    min-height: 320px; /* у тебя базово 370px — ок */
}
.card-3d{ will-change: transform; }
.card-inner{ display:flex; flex-direction:column; gap:10px; padding:20px; }

/* pin-ячейка в потокe, чтобы spacer корректно работал во flex/grid */
.pin-slot{
    width:100%;
    max-width:633px; /* под твой about__info-card */
    flex:0 0 auto;
}
</style>

<!-- НЕ scoped — чтобы стилизовать .pin-spacer, который GSAP вставляет динамически -->
<style>
.info_row{ align-items: stretch; }

/* spacer во flex/grid-строке — даём реальную ширину/высоту,
   чтобы пока идёт pin, СТРАНИЦА НЕ ПРОКРУЧИВАЛАСЬ ДАЛЬШЕ */
.info_row > .pin-spacer{
    display:block !important;
    width:100% !important;
    max-width:633px;
    flex:0 0 auto !important;
    align-self:stretch;
    /* если .info_row — grid, чтобы занять всю строку: */
    grid-column:1 / -1;
}
</style>
