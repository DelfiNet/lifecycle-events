<?php namespace DelfiNet\LifecycleEvents;

class LifecycleEventsTest extends \PHPUnit_Framework_TestCase
{

	private $adapter;

	protected function setUp()
	{
		parent::setUp();

		$this->adapter = $this->getMock('DelfiNet\LifecycleEvents\ServiceInterface');
	}

	public function testIdentifyNewUserImplicit()
	{
		$user = array('id' => 123, 'email' => 'tester@example.com');
		$drip = new LifecycleEvents($this->adapter, $user);

		$this->adapter->expects($this->once())
					  ->method('identifyNewUser')
					  ->with($user, array());

		$drip->identifyNewUser();
	}

	public function testIdentifyNewUserExplicit()
	{
		$user = array('id' => 123, 'email' => 'tester@example.com');
		$drip = new LifecycleEvents($this->adapter);

		$this->adapter->expects($this->once())
					  ->method('identifyNewUser')
					  ->with($user, array());

		$drip->identifyNewUser(array(), $user);
	}

	public function testIdentifyNewUserOverrideImplicit()
	{
		$firstUser = array('id' => 123, 'email' => 'first@example.com');
		$secondUser = array('id' => 123, 'email' => 'second@example.com');
		$drip = new LifecycleEvents($this->adapter, $firstUser);

		$this->adapter->expects($this->once())
					  ->method('identifyNewUser')
					  ->with($secondUser, array());

		$drip->identifyNewUser(array(), $secondUser);
	}

	public function testIdentifyNewUserWithoutUser()
	{
		$drip = new LifecycleEvents($this->adapter);

		$this->setExpectedException('DelfiNet\LifecycleEvents\Exception\UserRequiredException');
		$drip->identifyNewUser();
	}

	public function testIdentifyNewUserWithoutEmail()
	{
		$drip = new LifecycleEvents($this->adapter, array('id' => 123, 'no' => 'email'));

		$this->setExpectedException('DelfiNet\LifecycleEvents\Exception\EmailRequiredException');
		$drip->identifyNewUser();
	}

	public function testIdentifyExistingUserImplicit()
	{
		$user = array('id' => 123, 'email' => 'tester@example.com');
		$drip = new LifecycleEvents($this->adapter, $user);

		$this->adapter->expects($this->once())
					  ->method('identifyExistingUser')
					  ->with($user, array());

		$drip->identifyExistingUser();
	}

	public function testIdentifyExistingUserExplicit()
	{
		$user = array('id' => 123, 'email' => 'tester@example.com');
		$drip = new LifecycleEvents($this->adapter);

		$this->adapter->expects($this->once())
					  ->method('identifyExistingUser')
					  ->with($user, array());

		$drip->identifyExistingUser(array(), $user);
	}

	public function testIdentifyExistingUserOverrideImplicit()
	{
		$firstUser = array('id' => 123, 'email' => 'first@example.com');
		$secondUser = array('id' => 123, 'email' => 'second@example.com');
		$drip = new LifecycleEvents($this->adapter, $firstUser);

		$this->adapter->expects($this->once())
					  ->method('identifyExistingUser')
					  ->with($secondUser, array());

		$drip->identifyExistingUser(array(), $secondUser);
	}

	public function testIdentifyExistingUserWithoutUser()
	{
		$drip = new LifecycleEvents($this->adapter);

		$this->setExpectedException('DelfiNet\LifecycleEvents\Exception\UserRequiredException');
		$drip->identifyExistingUser();
	}

	public function testIdentifyExistingUserWithoutEmail()
	{
		$drip = new LifecycleEvents($this->adapter, array('id' => 123, 'no' => 'email'));

		$this->setExpectedException('DelfiNet\LifecycleEvents\Exception\EmailRequiredException');
		$drip->identifyExistingUser();
	}

	public function testFireValidUser()
	{
		$user = array('id' => 123, 'email' => 'user@example.com');
		$drip = new LifecycleEvents($this->adapter, $user);

		$this->adapter->expects($this->once())
					  ->method('fire')
					  ->with('Registered', $user, array());
		$drip->fire('Registered');
	}

	public function testFireUserWithoutEmail()
	{
		$drip = new LifecycleEvents($this->adapter, array('id' => 123, 'no' => 'email'));

		$this->setExpectedException('DelfiNet\LifecycleEvents\Exception\EmailRequiredException');
		$drip->fire('Registered');
	}

	public function testFireUserWithoutId()
	{
		$drip = new LifecycleEvents($this->adapter, array('no' => 'id', 'email' => 'test@example.com'));

		$this->setExpectedException('DelfiNet\LifecycleEvents\Exception\IdRequiredException');
		$drip->fire('Registered');
	}
}
