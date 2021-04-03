const mix = require('laravel-mix');

mix.js('resources/ts/app.ts', 'public/js')
    .sass('resources/sass/app.sass', 'public/css')
    .options({
        processCssUrls: false,
        uglify: {
            uglifyOptions: {
                compress: {
                    drop_console: false
                }
            }
        }
    })
    .sourceMaps()
    .disableNotifications()
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
