import { defineConfig } from 'vite';
import laravel from 'vite-plugin-laravel';
import postcss from './postcss.config.js';

export default defineConfig({
    plugins: [
        laravel(),
    ],
    css: {
        postcss,
    },
});
