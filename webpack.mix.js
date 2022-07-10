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
    .js('resources/js/materias.js', 'public/js')
    .js('resources/js/materias-archived.js', 'public/js')
    .js('resources/js/alumnos.js', 'public/js')
    .js('resources/js/alumnos-en-materia.js', 'public/js')
    .js('resources/js/alumnos-archived.js', 'public/js')
    .js('resources/js/contenido-admin.js', 'public/js')
    .js('resources/js/contenido-alumno.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');
