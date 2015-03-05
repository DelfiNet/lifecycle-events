<?php namespace DelfiNet\LifecycleEvents\Adapter\DripAdapter;

use DelfiNet\LifecycleEvents\Adapter\DripAdapter;

class DripAdapterTest extends \PHPUnit_Framework_TestCase
{

	public function testIdentifyNewUser()
	{
		$adapter = $this->expectAdapterSubscription(
			array('email' => 'newUser@example.com'),
			array('custom' => 'field')
		);

		$adapter->identifyNewUser(
			array('email' => 'newUser@example.com'),
			array('custom' => 'field')
		);
	}

	private function expectAdapterSubscription($user, $extra)
	{
		$api = $this->getMockApi();
		$adapter = new DripAdapter(123, $api);

		$api->expects($this->once())
			->method('create_or_update_subscriber')
			->with(
				array(
					'account_id' => 123,
					'email' => $user['email'],
					'custom_fields' => $extra,
				)
			);

		return $adapter;
	}

	private function getMockApi()
	{
		return $api = $this->getMockBuilder('Drip_Api')
						   ->disableOriginalConstructor()
						   ->getMock();
	}

	public function testIdentifyNewUserException()
	{
		$api = $this->getMockApi();
		$adapter = new DripAdapter(123, $api);

		$api->expects($this->once())
			->method('create_or_update_subscriber')
			->will($this->throwException(new \Exception('Message')));
		$this->setExpectedException('DelfiNet\LifecycleEvents\Exception\ServiceException', 'Message');

		$adapter->identifyNewUser(array('email' => 'exception@example.com'), array());
	}

	public function testIdentifyExistingUser()
	{
		$adapter = $this->expectAdapterSubscription(
			array('email' => 'newUser@example.com'),
			array('custom' => 'field')
		);

		$adapter->identifyExistingUser(
			array('email' => 'newUser@example.com'),
			array('custom' => 'field')
		);
	}

	public function testRecordEvent()
	{
		$api = $this->getMockApi();
		$adapter = new DripAdapter(123, $api);

		$api->expects($this->once())
			->method('record_event')
			->with(
				array(
					'account_id' => 123,
					'action' => 'Registered',
					'email' => 'fire@example.com',
					'properties' => array('extra' => 'properties'),
				)
			);

		$adapter->fire('Registered', array('email' => 'fire@example.com'), array('extra' => 'properties'));
	}

	public function testRecordEventException()
	{
		$api = $this->getMockApi();
		$adapter = new DripAdapter(123, $api);

		$api->expects($this->once())
			->method('record_event')
			->will($this->throwException(new \Exception('Message')));

		$this->setExpectedException('DelfiNet\LifecycleEvents\Exception\ServiceException', 'Message');

		$adapter->fire('Error', array('email' => 'exception@example.com'), array());
	}
}
