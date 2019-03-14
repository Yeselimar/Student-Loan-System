let mix = require("laravel-mix");

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

mix.js("resources/assets/js/app.js", "public/js");
mix.js("resources/assets/js/vue/mentorias/relacionBecarioMentor.vue", "public/js");
mix.js("resources/assets/js/vue/editor/editorNoti.vue", "public/js");
mix.js("resources/assets/js/components/loading.vue", "public/js");

