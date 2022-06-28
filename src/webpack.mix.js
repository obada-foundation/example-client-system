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

mix.js('resources/js/base.js', 'public/js')
    .sass('resources/sass/base.scss', 'public/css');

mix.js('resources/js/base-vue.js', 'public/js');

mix.js('resources/js/modules/devices/list/index.js', 'public/js/devices_list.js')
    .sass('resources/js/modules/devices/list/index.scss', 'public/css/devices_list.css');
mix.js('resources/js/modules/devices/detail.js', 'public/js/devices_detail.js');
mix.js('resources/js/modules/devices/edit.js', 'public/js/devices_edit.js');

mix.version();
