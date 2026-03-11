import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    build: {
        outDir: 'public/build',
        manifest: true,
    },
    server: {
        host: '0.0.0.0',
        port: 5174,
        // Disable HMR in production/Railway
        hmr: false,
    },
});
