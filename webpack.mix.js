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
   .copyDirectory('resources/js/content', 'public/js/content')
   .sass('resources/sass/content/index.scss', 'public/css/content/index.css')
   .sass('resources/sass/app.scss', 'public/css');
