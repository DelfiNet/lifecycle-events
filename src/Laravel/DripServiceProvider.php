<?php namespace DelfiNet\LifecycleEvents\Laravel;

use DelfiNet\LifecycleEvents\Adapter\DripAdapter;
use Drip_Api;

class DripServiceProvider extends LifecycleEventsServiceProvider {

	public function register()
	{
		parent::register();

		$this->app->singleton('LifecycleEventsAdapter', function($app) {
			return new DripAdapter(
				$app['config']->get('services.drip.account_id'),
				new Drip_Api($app['config']->get('services.drip.api_token'))
			);
		});
	}

}
