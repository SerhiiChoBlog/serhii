const mix = require('laravel-mix')
const webpack = require('webpack')
const purgecss = require('@fullhuman/postcss-purgecss')
const path = require('path')
const sassOptions = []

if (mix.inProduction()) {
    sassOptions.push(
        purgecss({
            content: [
                'app/**/*.php',
                'resources/**/*.ts',
                'resources/**/*.php',
                'resources/**/*.vue',
                'resources/purge-ignore.html',
            ],
            css: [
                'public/css/font-awesome.css',
            ],
        })
    )
}

mix.ts('resources/vue/app.ts', 'public/js/app.js')
    .alias({
        '@': path.join(__dirname, 'resources/vue')
    })
    .vue()
    .postCss("resources/css/app.css", "public/css", [
        require("tailwindcss"),
    ])
    .options({
        autoprefixer: {
            options: {
                browsers: ['last 6 versions']
            },
        },
    })
    .copyDirectory('resources/fonts', 'public/fonts')
    .webpackConfig({
        plugins: [
            new webpack.DefinePlugin({
                __VUE_OPTIONS_API__: true,
                __VUE_PROD_DEVTOOLS__: false,
            }),
        ],
    })

mix.ts('resources/admin/app.ts', 'public/js/admin.js')
    .vue()
    .webpackConfig({
        plugins: [
            new webpack.DefinePlugin({
                __VUE_OPTIONS_API__: true,
                __VUE_PROD_DEVTOOLS__: false,
            }),
        ],
    })
    .postCss("resources/css/admin/admin.css", "public/css", [
        require("tailwindcss"),
    ])
    .webpackConfig({
        module: {
            rules: [
                {
                    test: /\.tsx?$/,
                    loader: 'ts-loader',
                    options: { appendTsSuffixTo: [/\.vue$/] },
                    exclude: /node_modules/
                }
            ],
        },
        resolve: {
            extensions: ['*', '.js', '.jsx', '.vue', '.ts', '.tsx']
        }
    })

mix.css('resources/css/admin/font-awesome.css', 'public/css/font-awesome.css', {}, sassOptions)

mix.disableSuccessNotifications()
