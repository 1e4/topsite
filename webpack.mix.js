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

// Frontend styles
mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .version();

// Admin styles SB Admin 2
mix.copy('resources/js/admin/', 'public/js/admin/')
    .sass('resources/sass/admin/admin.scss', 'public/css/admin')
    .version();

mix.copy('resources/js/helpers.js', 'public/js')
    .version();

// Jquery stuff
mix.copy('node_modules/jquery/dist/jquery.min.js', 'public/js')
    .copy('node_modules/bootstrap/dist/js/bootstrap.bundle.min.js', 'public/js/admin')
    .copy('node_modules/jquery.easing/jquery.easing.min.js', 'public/js')
    .copy('node_modules/chart.js/dist/Chart.min.js', 'public/js')
    .copy('node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js', 'public/js/admin')
    .copy('node_modules/datatables.net/js/jquery.dataTables.min.js', 'public/js/admin')
    .version();
