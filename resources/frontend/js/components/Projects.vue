<template>
    <Heading
        id="about"
        :icon="codeBranch"
        title="console.log(<i>'Projects'</i>)"
        subtitle="A selection of my recent work showcasing creativity and technical expertise."
    />
    <div class="section projects" id="projects">
        <div class="container">
            <div class="projects__section">
                <a v-for="project in projects"
                   :key="project.id"
                   :href="project.link"
                   class="projects__card"
                   data-tilt data-tilt-glare data-tilt-max-glare="0.8">
                    <img :src="project.image" class="projects__img"  alt=""/>
                </a>
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
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import Heading from "./Heading.vue";
import codeBranch from "../../assets/code-branch.png";

const projects = ref([])
const pagination = ref({ page: 1, total: 1 })

async function loadProjects(page = 1) {
    let { data } = await axios.get(`/api/projects?page=${page}`)
    projects.value = data.data
    pagination.value = { page: data.current_page, total: data.last_page }
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

onMounted(() => {
    loadProjects()
})
</script>
