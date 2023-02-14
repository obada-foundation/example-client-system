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
mix.js('resources/js/modules/devices/edit.js', 'public/js/devices_edit.js');
mix.js('resources/js/modules/devices/show.js', 'public/js/devices_show.js');
mix.js('resources/js/modules/nft/transfer.js', 'public/js/nft_transfer.js');
mix.js('resources/js/modules/wallet/index.js', 'public/js/wallet_index.js');

mix.version();
