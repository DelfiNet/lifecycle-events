<?php namespace DelfiNet\LifecycleEvents\Adapter;

use DelfiNet\LifecycleEvents\Exception\ServiceException;
use DelfiNet\LifecycleEvents\ServiceInterface;

class CustomerioAdapter implements ServiceInterface
{

	private $api;

	public function __construct(\Customerio\Api $api)
	{
		$this->api = $api;
	}

	public function identifyNewUser(array $user, array $extraParams)
	{
		$response = $this->api->createCustomer(
			$user['id'],
			$user['email'],
			$extraParams
		);
		$this->validateResponse($response);
	}

	public function identifyExistingUser(array $user, array $extraParams)
	{
		$response = $this->api->updateCustomer(
			$user['id'],
			$user['email'],
			$extraParams
		);
		$this->validateResponse($response);
	}

	public function fire($event, array $user, array $extraParams)
	{
		$response = $this->api->fireEvent(
			$user['id'],
			$event,
			$extraParams
		);
		$this->validateResponse($response);
	}

	public function validateResponse($response)
	{
		if (!$response->success()) {
			throw new ServiceException($response->message());
		}
	}
}
