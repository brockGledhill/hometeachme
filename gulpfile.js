var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function (mix) {
	mix.sass(['**'], 'public/css/style.css');

	mix.scripts([
		'jquery/**',
		'*.js'
	], 'public/js/script.js');

	mix.scripts([
		'charts/Chart.js'
	], 'public/js/chart.js');

	mix.scripts([
		'comments/Comments.js'
	], 'public/js/comments.js')
});
