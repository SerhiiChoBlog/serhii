const mix = require('laravel-mix')
const webpack = require('webpack')

mix.ts('resources/ts/app.ts', 'public/js/app.js')
    .vue()
    .sass('resources/sass/app.sass', 'public/css/app.css')
    .copyDirectory('resources/fonts', 'public/fonts')
    .webpackConfig({
        plugins: [
            new webpack.DefinePlugin({
                __VUE_OPTIONS_API__: true,
                __VUE_PROD_DEVTOOLS__: false,
            }),
        ],
    })

mix.ts('resources/ts/admin/app.ts', 'public/js/admin.js')
    .sass('resources/sass/admin/app.sass', 'public/css/admin.css')
    .webpackConfig({
        module: {
            rules: [
                {
                    test: /\.tsx?$/,
                    loader: 'ts-loader',
                    options: { appendTsSuffixTo: [/\.vue$/] },
                    exclude: /node_modules/
                }
            ]
        },
        resolve: {
            extensions: ['*', '.js', '.jsx', '.vue', '.ts', '.tsx']
        }
    })

mix.disableSuccessNotifications()
