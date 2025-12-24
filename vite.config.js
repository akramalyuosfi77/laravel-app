import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/welcome.css',
                'resources/js/welcome.js',
                'resources/css/animations.css',
                'resources/js/animations.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        host: '0.0.0.0',
        cors: true,
        hmr: {
            host: 'localhost',
        },
    },
    build: {
        outDir: 'public/build',
        manifest: true,
        emptyOutDir: true,
    },
    base: process.env.APP_URL ? process.env.APP_URL + '/' : '/',
});
