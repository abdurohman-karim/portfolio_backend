<template>
    <Heading
        id="projects"
        :icon="codeBranch"
        title="console.log(<i>'Projects'</i>)"
        subtitle="A selection of my recent work showcasing creativity and technical expertise."
    />

    <div class="section projects">
        <div class="container">
            <div class="projects__section">
                <div
                    v-for="project in projects"
                    :key="project.id"
                    class="projects__card"
                    data-tilt
                    data-tilt-glare
                    data-tilt-max-glare="0.8"
                    @click="openModal(project)"
                >
                    <img :src="project.image" class="projects__img" alt="" />
                </div>
            </div>

            <!-- пагинация -->
            <div class="projects__pagination" v-if="pagination.total > 1">
                <div class="pagination">
                    <button @click="prevPage" :disabled="pagination.page === 1">Prev</button>
                    <span>Page {{ pagination.page }} / {{ pagination.total }}</span>
                    <button @click="nextPage" :disabled="pagination.page === pagination.total">Next</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ✅ МОДАЛКА -->
    <div v-if="showModal" class="modal-overlay" @click.self="closeModal">
        <div class="modal">
            <h2 class="modal-title">{{ selectedProject?.title }}</h2>

            <div class="modal-actions">
                <a
                    :href="selectedProject?.link"
                    target="_blank"
                    class="modal-btn visit-btn"
                >
                    Visit Project
                </a>
                <button @click="closeModal" class="modal-btn close-btn">
                    Close
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, nextTick } from 'vue'
import axios from 'axios'
import VanillaTilt from 'vanilla-tilt'
import Heading from "./Heading.vue"
import codeBranch from "../../assets/code-branch.png"

const projects = ref([])
const pagination = ref({ page: 1, total: 1 })
const showModal = ref(false)
const selectedProject = ref(null)

async function loadProjects(page = 1) {
    const { data } = await axios.get(`/api/projects?page=${page}`)
    projects.value = data.data
    pagination.value = { page: data.current_page, total: data.last_page }

    await nextTick()
    initTilt()
}

function initTilt() {
    const cards = document.querySelectorAll('[data-tilt]')
    VanillaTilt.init(cards, {
        max: 25,
        speed: 400,
        glare: true,
        'max-glare': 0.8
    })
}

function nextPage() {
    if (pagination.value.page < pagination.value.total) {
        loadProjects(pagination.value.page + 1)
    }
}

function prevPage() {
    if (pagination.value.page > 1) {
        loadProjects(pagination.value.page - 1)
    }
}

function openModal(project) {
    selectedProject.value = project
    showModal.value = true
}

function closeModal() {
    showModal.value = false
    selectedProject.value = null
}

onMounted(() => {
    loadProjects()
})
</script>

<style scoped>
/* --- стили модалки --- */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.9);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.modal {
    background: var(--light);
    color: #333;
    border-radius: 16px;
    padding: 2rem;
    max-width: 400px;
    width: 90%;
    text-align: center;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    animation: fadeIn 0.25s ease-in-out;
}

.modal-title {
    color: var(--text-dark);
    font-family: PoppinsRegular;
    font-size: 14px;
    margin-bottom: 1.5rem;
    text-align: start;
}

.modal-actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
}

.modal-btn {
    font-family: UbuntuBold;
    padding: 0.6rem 1.2rem;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: 0.2s;
}

.visit-btn {
    background: var(--secondary-color);
    color: #fff;
}

.visit-btn:hover {
    background: var(--primary-color);
}

.close-btn {
    font-family: UbuntuBold;
    background: #ccc;
}

.close-btn:hover {
    background: #aaa;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
