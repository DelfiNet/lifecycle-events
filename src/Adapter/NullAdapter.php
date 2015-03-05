<?php namespace DelfiNet\LifecycleEvents\Adapter;

use DelfiNet\LifecycleEvents\ServiceInterface;

class NullAdapter implements ServiceInterface
{

	public function identifyNewUser(array $user, array $extraParams)
	{
		// Do nothing.
	}

	public function identifyExistingUser(array $user, array $extraParams)
	{
		// Do nothing.
	}

	public function fire($event, array $user, array $extraParams)
	{
		// Do nothing.
	}

}
