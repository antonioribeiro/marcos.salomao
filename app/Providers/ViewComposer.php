<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewComposer extends ServiceProvider {

	public function register()
	{
		app('view')->composer('*', function($view)
		{
			$view->with('homeUrl', env('SITE_URL'));
		});
	}

}
