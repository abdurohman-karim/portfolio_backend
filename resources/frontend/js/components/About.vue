<template>
    <Heading
        id="about"
        :icon="barChart"
        title="$_GET(<i>'About'</i>)"
        subtitle="Utility classes help you work within the constraints of a system..."
    />
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
                <!-- АНИМИРУЕМАЯ КАРТА -->
                <div class="pin-slot" ref="pinSlot">
                    <!-- карточка -->
                    <div class="ic-info about__info-card about__info-card--animation" ref="animatedCard">
                        <!-- 3D/scale анимируем на отдельном слое -->
                        <div class="card-3d">
                            <div class="card-inner">
                                <p class="info-card__title">📺 Тестовый телек</p>
                                <p class="info-card__text">Во время пина страница замирает, а внутри идёт скролл.</p>
                                <p v-for="i in 30" :key="i">Контент строки № {{ i }} — Lorem ipsum dolor sit amet…</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- остальные карты -->
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
import { ref, onMounted, nextTick, onBeforeUnmount } from "vue";
import axios from "axios";
import gsap from "gsap";
import ScrollTrigger from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

const stats = ref([]), infos = ref([]);
const pinSlot = ref(null);
const animatedCard = ref(null);

onMounted(async () => {
    const { data } = await axios.get("/api/about");
    stats.value = data.stats;
    infos.value = data.infos;

    await nextTick();

    const slot  = pinSlot.value;
    const el    = animatedCard.value;
    if (!slot || !el) return;

    const inner = el.querySelector(".card-inner");
    const card3d = el.querySelector(".card-3d");

    // Если скролл не по window (а по контейнеру с overflow:auto) — раскомментируй:
    // ScrollTrigger.defaults({ scroller: document.querySelector('#appMain') });

    const pinDistance = () => Math.max(1000, inner.scrollHeight - el.offsetHeight + 1);

    let spacer = null;
    const fixCard = () => {
        if (el.classList.contains('is-fixed')) return;
        const r = el.getBoundingClientRect();
        // фиксируем габариты, чтобы при fixed не прыгало
        el.style.width  = r.width + 'px';
        el.style.height = r.height + 'px';
        el.classList.add('is-fixed');

        // проставка в поток, чтобы страница реально «стояла», пока карта fixed
        if (!spacer) {
            spacer = document.createElement('div');
            spacer.className = 'pin-manual-spacer';
            spacer.style.height = pinDistance() + 'px';
            slot.parentNode.insertBefore(spacer, slot.nextSibling);
        }
    };

    const unfixCard = () => {
        el.classList.remove('is-fixed');
        el.style.width  = '';
        el.style.height = '';
        if (spacer) { spacer.remove(); spacer = null; }
    };

    // Триггерим «фиксировать в центре» на время внутреннего скролла
    const pinST = ScrollTrigger.create({
        trigger: slot,
        start: "center center",           // как только слот в центре — фиксируем
        end: () => "+=" + pinDistance(),  // держим, пока «крутим» внутренний контент
        onEnter: fixCard,
        onEnterBack: fixCard,
        onLeave: unfixCard,
        onLeaveBack: unfixCard,
        invalidateOnRefresh: true,
        // markers: true,
    });

    // 3D/scale — на дочернем слое, чтобы не конфликтовать с фикс-позицией
    const tiltTween = gsap.to(card3d, {
        scale: 1.18,
        rotateX: -8,
        rotateY: 10,
        transformOrigin: "center center",
        ease: "power2.out",
        force3D: true,
        immediateRender: false,
        scrollTrigger: {
            trigger: slot,
            start: "center center",
            end:   () => "+=" + pinDistance(),
            scrub: true,
            invalidateOnRefresh: true,
        },
    });

    // Внутренний «телек»-скролл, пока карта фиксирована
    const innerTween = gsap.to(inner, {
        y: () => -(inner.scrollHeight - el.offsetHeight),
        ease: "none",
        immediateRender: false,
        scrollTrigger: {
            trigger: slot,
            start: "center center",
            end:   () => "+=" + pinDistance(),
            scrub: true,
            invalidateOnRefresh: true,
        },
    });

    const onResize = () => ScrollTrigger.refresh();
    window.addEventListener("resize", onResize);

    onBeforeUnmount(() => {
        window.removeEventListener("resize", onResize);
        pinST.kill();
        tiltTween.scrollTrigger.kill();
        innerTween.scrollTrigger.kill();
        unfixCard();
    });

    ScrollTrigger.refresh();
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
