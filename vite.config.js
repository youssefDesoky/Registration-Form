import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/regForm.css',
                'resources/css/rtl.css',
                'resources/js/app.js',
                'resources/js/regForm.js',
                'resources/js/validation.js',
                'resources/js/imageUpload.js',
                'resources/js/translations.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
