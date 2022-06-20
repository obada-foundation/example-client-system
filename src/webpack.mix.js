const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

mix.js('resources/js/app-vue.js', 'public/js')
    .sass('resources/sass/app-vue.scss', 'public/css');

mix.js('resources/js/modules/devices/list.js', 'public/js/devices_list.js');
mix.js('resources/js/modules/devices/detail.js', 'public/js/devices_detail.js');

mix.version();
