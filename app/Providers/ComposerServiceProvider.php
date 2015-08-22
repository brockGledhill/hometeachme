<?php
namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class ComposerServiceProvider extends ServiceProvider {
	public function boot(Router $router) {
		view()->composer('*', 'App\Http\ViewComposers\ViewComposer');
	}
}