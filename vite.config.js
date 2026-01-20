import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import basicSsl from '@vitejs/plugin-basic-ssl';
import tailwindcss from "@tailwindcss/vite";

// 002 set the Laravel host and the port
const host = '10.10.9.147';
const port = '8000';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
        basicSsl()
    ],
    server: {
        cors: true,
        https: true,
        proxy: {
            '^(?!(\/\@vite|\/resources|\/node_modules))': {
                target: `http://${host}:${port}`,
            }
        },
        host,
        port: 5100,
        watch: {
            ignored: ['**/storage/framework/views/**'],

        // 007 be sure that you have the Hot Module Replacement
        hmr: { host },
        },
    },
});
