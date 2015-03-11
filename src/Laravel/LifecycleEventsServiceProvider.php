<?php namespace DelfiNet\LifecycleEvents\Laravel;


use App;
use Config;
use DelfiNet\LifecycleEvents\Adapter\NullAdapter;
use DelfiNet\LifecycleEvents\LifecycleEvents;
use Illuminate\Support\ServiceProvider;

class LifecycleEventsServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton('LifecycleEventsAdapter', function($app) {
			return new NullAdapter();
		});

		$this->app->bind('LifecycleEvents', function($app) {
			return new LifecycleEvents($app->make('LifecycleEventsAdapter'));
		});
	}


}
