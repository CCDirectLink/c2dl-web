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

mix.setPublicPath('public/www-c2dl/');

mix.js('resources/js/app.js', 'public/www-c2dl/js')
   .sass('resources/sass/app.scss', 'public/www-c2dl/css')
   .sass('resources/sass/colorset/dark.scss', 'public/www-c2dl/css/colorset')
   .sass('resources/sass/colorset/light.scss', 'public/www-c2dl/css/colorset')
   .copyDirectory('resources/fonts', 'public/www-c2dl/fonts')
   .copyDirectory('resources/images', 'public/www-c2dl/images');

if (mix.inProduction()) {
    mix.version();
}
