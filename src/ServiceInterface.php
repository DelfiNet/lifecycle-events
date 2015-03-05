<?php namespace DelfiNet\LifecycleEvents;

interface ServiceInterface
{

	public function identifyNewUser(array $user, array $extraParams);

	public function identifyExistingUser(array $user, array $extraParams);

	public function fire($event, array $user, array $extraParams);
}
