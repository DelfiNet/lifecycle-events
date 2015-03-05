<?php namespace DelfiNet\LifecycleEvents\Adapter;

use DelfiNet\LifecycleEvents\Exception\ServiceException;
use DelfiNet\LifecycleEvents\ServiceInterface;

class DripAdapter implements ServiceInterface
{

	private $accountId;
	private $api;

	public function __construct($accountId, \Drip_Api $api)
	{
		$this->accountId = $accountId;
		$this->api = $api;
	}

	public function identifyNewUser(array $user, array $extraParams)
	{
		$this->subscribeUser($user, $extraParams);
	}

	private function subscribeUser(array $user, array $extraParams)
	{
		try {
			$this->api->create_or_update_subscriber(
				array(
					'account_id' => $this->accountId,
					'email' => $user['email'],
					'custom_fields' => $extraParams,
				)
			);
		} catch (\Exception $ex) {
			throw new ServiceException($ex->getMessage(), $ex->getCode(), $ex);
		}
	}

	public function identifyExistingUser(array $user, array $extraParams)
	{
		$this->subscribeUser($user, $extraParams);
	}

	public function fire($event, array $user, array $extraParams)
	{
		try {
			$this->api->record_event(
				array(
					'account_id' => $this->accountId,
					'action' => $event,
					'email' => $user['email'],
					'properties' => $extraParams,
				)
			);
		} catch (\Exception $ex) {
			throw new ServiceException($ex->getMessage(), $ex->getCode(), $ex);
		}
	}
}
