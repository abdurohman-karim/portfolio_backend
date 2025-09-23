import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/frontend/scss/main.scss',
                'resources/frontend/js/app.js',
                'resources/css/app.css', // admin bootstrap
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        vue(),
    ],
});
