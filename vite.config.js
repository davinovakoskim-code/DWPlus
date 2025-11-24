import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { quasar, transformAssetUrls } from '@quasar/vite-plugin';
import path from 'path'; // <--- ADICIONADO AQUI

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),

        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),

        quasar({
            // Usando path.resolve para pegar o caminho completo no seu PC
            sassVariables: path.resolve(__dirname, 'resources/css/quasar-variables.sass'),
        }),
    ],
});