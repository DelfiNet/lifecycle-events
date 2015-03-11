<?php namespace DelfiNet\LifecycleEvents\Laravel;

use Customerio\Api;
use Customerio\Request;
use DelfiNet\LifecycleEvents\Adapter\CustomerioAdapter;

class CustomerioServiceProvider extends LifecycleEventsServiceProvider
{

	public function register()
	{
		parent::register();

		$this->app->singleton('LifecycleEventsAdapter', function ($app) {
			return new CustomerioAdapter(new Api(
				$app['config']->get('services.customerio.site_id'),
				$app['config']->get('services.customerio.api_secret'),
				new Request
			));
		});
	}

}
