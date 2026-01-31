//Run 'npm install @vitejs/plugin-basic-ssl' in the terminal and modify the vite js file on the root directory as below.
//After that 'npm run dev' will set the https as proxy to the http server, hosted via 'php artisan serve' command.

/*Where you have to:

    001 import the basicSsl Vite plugin
    002 set the Laravel host and the port
    003 load the basicSsl plugin
    004 set the server section
    005 enabling the HTTPS (https: true)
    006 setting the proxy with Laravel as target (origin) (target)
    007 be sure that you have the Hot Module Replacement (hmr)

*/

import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
// 001 import the basicSsl Vite plugin
import basicSsl from '@vitejs/plugin-basic-ssl';
import tailwindcss from "@tailwindcss/vite";

// 002 set the Laravel host and the port
const host = '10.10.1.5';
const port = '8000';


export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
        // 003 enable the basicSsl plugin
        basicSsl()
    ],
    // 006 setting the proxy with Laravel as target (origin) (target)
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
        },
        // 007 be sure that you have the Hot Module Replacement
        hmr: { host },
    },
});
