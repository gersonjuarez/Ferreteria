

const mix = require('laravel-mix');
const VuetifyLoaderPlugin = require('vuetify-loader/lib/plugin');
		var webpackConfig = {
    			plugins: [
        			new VuetifyLoaderPlugin()
        			// other plugins ...
    			]
			// other webpack config ...
		}
		mix.webpackConfig(webpackConfig);

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

 mix.styles([
    'resources/coreui/css/font-awesome.min.css',
    'resources/coreui/css/simple-line-icons.css',
    'resources/coreui/css/style.min.css',
    'resources/coreui/css/pace.min.css',


], 'public/css/plantilla.css')
.scripts([
    'resources/coreui/js/jquery.min.js',
    'resources/coreui/js/popper.min.js',
    'resources/coreui/js/bootstrap.min.js',
    'resources/coreui/js/pace.min.js',
    'resources/coreui/js/perfect-scrollbar.min.js',
    'resources/coreui/js/coreui.min.js'
], 'public/js/plantilla.js')
.js(['resources/js/app.js'], 'public/js/app.js');