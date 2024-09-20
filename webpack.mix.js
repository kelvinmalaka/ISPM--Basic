const mix = require("laravel-mix");
require("laravel-mix-purgecss");
require("mix-tailwindcss");

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

mix.copyDirectory("node_modules/bootstrap-icons/font/fonts", "public/css/fonts")
    .copyDirectory("resources/css/fonts", "public/css/fonts")

    .js("resources/js/app.js", "public/js/app.min.js")
    .sass("resources/sass/app.scss", "public/css/app.min.css")

    .copy("resources/js/landing/vendors.min.js", "public/js/vendors.min.js")
    .copy("resources/css/landing/vendors.min.css", "public/css/vendors.min.css")
    .js("resources/js/landing/script.js", "public/js/home.min.js")
    .sass("resources/sass/landing.scss", "public/css/home.min.css")

    .js("resources/js/laravel-views.js", "public/js")
    .css("resources/css/laravel-views.css", "public/css")

    .tailwind("./tailwind.config.js")
    .setPublicPath("public")
    .purgeCss({
        extend: {
            safelist: { deep: [/^bi-/] },
        },
    })
    .sourceMaps()
    .version();
