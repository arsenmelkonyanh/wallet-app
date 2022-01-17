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

mix.js('resources/js/app.js', 'public/js').postCss('resources/css/app.css', 'public/css', [
    require('postcss-import'),
    require('tailwindcss'),
    require('autoprefixer'),
]);

mix.babel([
    'resources/js/wallet-app/wallets/create-wallet.js',
    'resources/js/wallet-app/wallets/delete-wallet.js',
    'resources/js/wallet-app/records/create-record.js',
    'resources/js/util/error-handler.js'
], 'public/js/app.js');
