import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
    plugins: [
        laravel([
            // main
            'resources/css/main/app.css',
            'resources/ts/main/app.ts',
            // admin
            'resources/css/admin/app.css',
            'resources/css/admin/font-awesome.css',
            'resources/ts/admin/app.ts',
            // user
            'resources/css/user/app.css',
            'resources/ts/user/app.ts',
        ]),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],

    build: {
        sourcemap: true,
    },

    server: {
        host: 'localhost',
    },

    resolve: {
        alias: {
            '@': '/resources/ts/main',
            '@admin': '/resources/ts/admin',
            '@user': '/resources/ts/user',
            '@shared': '/resources/ts/shared',
        },
    },
})
