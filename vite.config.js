import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/scss/main.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        vue(),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
            '~scss': path.resolve(__dirname, 'resources/scss'),
        },
    },
    css: {
        preprocessorOptions: {
            scss: {
                additionalData: `
                @import "~scss/inc/variables";
                @import "~scss/inc/mixins";
                @import "~scss/inc/fonts";
              `,
            },
        },
    }
});
