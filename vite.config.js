import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import glob from 'glob';

const assetFiles = glob.sync('resources/assets/**/*.{js,css}');

export default defineConfig({
    plugins: [
        laravel({
            input: assetFiles,
            refresh: true,
        }),
    ],
});
