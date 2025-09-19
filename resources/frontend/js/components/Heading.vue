<script setup lang="ts">
defineProps<{
    id: string
    icon: string
    title: string
    subtitle?: string
}>()
</script>

<template>
    <div class="heading" :id="id">
        <div class="container">
            <div class="heading__icon">
                <img :src="icon" :alt="title" />
            </div>
            <p class="heading__title" v-html="title"></p>
            <p class="heading__text" v-if="subtitle">
                {{ subtitle }}
            </p>
        </div>
    </div>
</template>

<style scoped>
</style>
