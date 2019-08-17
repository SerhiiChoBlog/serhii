let mix = require('laravel-mix');

mix.js('js/main.js', 'assets/main.js')
    .options({
        processCssUrls: false,
        uglify: {
            uglifyOptions: {
                compress: {
                    drop_console: true
                }
            }
        }
    })
    .sourceMaps()