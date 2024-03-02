import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({

    plugins: [
        vue(),
        laravel({
            input: [

                'resources/scss/main.scss',
                'resources/scss/views/main_dashboard.scss',
                'resources/js/hrms/app.js',
            ],
            refresh: ['resources/views/**'],
        }),
    ],
    resolve: {
        dedupe: ['vue', 'vue-router'],
    },
});
