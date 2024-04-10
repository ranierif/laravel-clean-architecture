import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['./app/Infrastructure/Resources/css/app.css', './app/Infrastructure/Resources/js/app.js'],
            refresh: true,
        }),
    ],
});
