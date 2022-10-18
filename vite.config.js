import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
    plugins: [
        laravel([
            // public
            'resources/css/app.css',
            'resources/vue/app.ts',
            // admin
            'resources/admin/app.ts',
            'resources/css/admin/admin.css',
            'resources/css/admin/font-awesome.css',
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

    resolve: {
        alias: {
            '@': '/resources/vue',
            '@@': '/resources/admin',
        }
    },
})
