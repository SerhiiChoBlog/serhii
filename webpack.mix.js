const mix = require('laravel-mix')

mix.ts('resources/ts/app.ts', 'public/js')
    .sass('resources/sass/app.sass', 'public/css')
    .disableSuccessNotifications()
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
