import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/carrito.css',
                'resources/js/app.js',
                'resources/js/carrito.js',
            ],
            refresh: true,
        }),
    ],
});