var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
	mix.less('app.less');
	mix.coffee([
		'test.coffee',
		'test2.coffee',
		'controllers/test.coffee',
		'controllers/test2.coffee'
	],'public/js/temp/')
	.scriptsIn('public/js/temp', 'public/js/main.js');
});
