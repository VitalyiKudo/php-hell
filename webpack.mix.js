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
/*
mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/client/client.scss', 'public/css/app.css')
   .sass('resources/sass/admin/admin.scss', 'public/css/admin.css');
*/
/*
mix.override((config) => {
    delete config.watchOptions;
});
*/
if (mix.inProduction()) {
    mix.version();
}
//mix.js('resources/js/app.js', 'public/js');
mix.js('resources/js/app.js', 'public/js').vue();

mix.minify(['public/css/app.css', 'public/css/admin.css']);

