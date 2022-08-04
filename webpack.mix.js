const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */
 
mix.webpackConfig(webpack => {
    return {
        plugins: [
            new webpack.ProvidePlugin({
                $: 'jquery',
                jQuery: 'jquery',
            }),
        ]
    };
});

mix.setResourceRoot('../');

mix.js('resources/js/app.js', 'public/js')
.scripts([
    'resources/js/common.js',
], 'public/js/common.js')
.sass('resources/sass/app.scss', 'public/css')
.sass('resources/sass/admin_app.scss', 'public/admin_assets/css')
.vue();