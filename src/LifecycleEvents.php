<?php namespace DelfiNet\LifecycleEvents;

use DelfiNet\LifecycleEvents\Exception\EmailRequiredException;
use DelfiNet\LifecycleEvents\Exception\IdRequiredException;
use DelfiNet\LifecycleEvents\Exception\UserRequiredException;

class LifecycleEvents
{

	private $adapter;
	private $user;

	public function __construct(ServiceInterface $adapter, $user = null)
	{
		$this->adapter = $adapter;
		$this->user = $user;
	}

	public function identifyNewUser($extraParams = null, $user = null)
	{
		$this->adapter->identifyNewUser(
			$this->getEventUser($user),
			empty($extraParams) ? array() : $extraParams
		);
	}

	public function identifyExistingUser($extraParams = null, $user = null)
	{
		$this->adapter->identifyExistingUser(
			$this->getEventUser($user),
			empty($extraParams) ? array() : $extraParams
		);
	}

	public function fire($event, $extraParams = null, $user = null)
	{
		$this->adapter->fire(
			$event,
			$this->getEventUser($user),
			empty($extraParams) ? array() : $extraParams
		);
	}

	public function __call($name, $arguments)
	{
		$this->fire(
			$name,
			array_pop($arguments), // extra params
			array_pop($arguments) // user
		);
	}

	private function getEventUser($overrideUser)
	{
		if (!empty($overrideUser)) {
			$this->validateUser($overrideUser);

			if (empty($this->user)) {
				$this->user = $overrideUser;
			}
			return $overrideUser;
		}

		if (!empty($this->user)) {
			$this->validateUser($this->user);

			return $this->user;
		}

		throw new UserRequiredException('A user is required to send drip events.');
	}

	private function validateUser($user)
	{
		if (empty($user['id'])) {
			throw new IdRequiredException('A user must contain an "id" entry.');
		}

		if (empty($user['email'])) {
			throw new EmailRequiredException('A user must contain an "email" entry.');
		}
	}
}
