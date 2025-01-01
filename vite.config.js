import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        port: 3000,
        watch: {
            usePolling: true,
        },
    },
    css: {
        postcss: './postcss.config.cjs',
    },
});
