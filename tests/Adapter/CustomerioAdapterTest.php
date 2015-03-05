<?php namespace DelfiNet\LifecycleEvents\Adapter;

class CustomerioAdapterTest extends \PHPUnit_Framework_TestCase
{

	public function testIdentifyNewCustomer()
	{
		$api = $this->getMockApi();
		$adapter = new CustomerioAdapter($api);

		$api->expects($this->once())
			->method('createCustomer')
			->with(123, 'tester@example.com', array('extra' => 'params'))
			->will($this->returnValue($this->getMockResponse()));

		$adapter->identifyNewUser(
			array('id' => 123, 'email' => 'tester@example.com'),
			array('extra' => 'params')
		);
	}

	public function testIdentifyExistingCustomer()
	{
		$api = $this->getMockApi();
		$adapter = new CustomerioAdapter($api);

		$api->expects($this->once())
			->method('updateCustomer')
			->with(123, 'tester@example.com', array('extra' => 'params'))
			->willReturn($this->getMockResponse());

		$adapter->identifyExistingUser(
			array('id' => 123, 'email' => 'tester@example.com'),
			array('extra' => 'params')
		);
	}

	public function testFire()
	{
		$api = $this->getMockApi();
		$adapter = new CustomerioAdapter($api);

		$api->expects($this->once())
			->method('fireEvent')
			->with(123, 'Error', array('extra' => 'params'))
			->willReturn($this->getMockResponse());

		$adapter->fire(
			'Error',
			array('id' => 123, 'email' => 'tester@example.com'),
			array('extra' => 'params')
		);
	}

	private function getMockApi()
	{
		return $api = $this->getMockBuilder('\Customerio\Api')
						   ->disableOriginalConstructor()
						   ->getMock();
	}

	private function getMockResponse($errorMessage = null)
	{
		$response = $this->getMockBuilder('Customerio\Response')
						 ->disableOriginalConstructor()
						 ->getMock();
		$response->expects($this->once())
				 ->method('success')
				 ->willReturn(empty($errorMessage));

		if (!empty($errorMessage)) {
			$response->expects($this->once())
					 ->method('message')
					 ->willReturn($errorMessage);
		}

		return $response;
	}
}
