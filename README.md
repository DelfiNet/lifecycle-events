LifecycleEvents - A consistent interface to email services
==========================================================

Installation / Usage
--------------------

1. Add `delfinet/lifecycle-events` and service library (see below) to your composer.json file requirements.
3. Run `composer update`


Usage with Customer.io (http://customer.io/)
--------------------------------------------

Add `"userscape/customerio": "~1.0.0"` to your composer.json requirements.

Sample usage adding a user and firing an event:

```
use DelfiNet\LifecycleEvents\Adapter\CustomerioAdapter;
use DelfiNet\LifecycleEvents\LifecycleEvents;

$api = new Customerio\Api('site id', 'api secret', new Customerio\Request);
$adapter = new CustomerioAdapter($api);

$lifecycle = new LifecycleEvents($adapter);
$lifecycle->identifyExistingUser(array(), array('id' => '123', 'email' => 'scott+drip@delfi-net.com'));
$lifecycle->fire('Tested', array('LifecyleEvents' => 'Success'));
```


Usage with Drip (https://www.getdrip.com/)
------------------------------------------

Add the following to your composer.json repositories:

```
"drip-email-php-api": {
  "type": "package",
  "package": {
	"name": "drip-email/drip-php",
	"version": "1.0",
	"source": {
	  "url": "git@github.com:DripEmail/drip-php.git",
	  "type": "git",
	  "reference": "origin/master"
	},
	"autoload": {
	  "classmap": ["Drip_API.class.php"]
	}
  }
}
```

and then add `"drip-email/drip-php": "1.0"` to requirements.

Sample usage adding a user and firing an event:

```
use DelfiNet\LifecycleEvents\Adapter\DripAdapter;
use DelfiNet\LifecycleEvents\LifecycleEvents;

$accountId = 123; // your drip account id
$dripApi = new Drip_Api('your drip api token');
$adapter = new DripAdapter($accountId, $dripApi);

$lifecycle = new LifecycleEvents($adapter);
$lifecycle->identifyNewUser(array('Random' => 'Property'), array('id' => 123, 'email' => 'drip@example.com'));
$lifecycle->fire('Registered', array('LifecyleEvents' => 'Success'));
```


Magic Method Events
-------------------

As a shortcut for firing events, non-existing methods are treated as calls fire(),
with the case of the name is preserved.

For example, the following would be the equivalant of calling `fire('registered')`.
```
$lifecycle->Registered();
```

To call with extra parameters:
```
$lifecycle->Registered(array('extra' => 'params'));
```

Testing
-------

Run `phpunit` from the project root. If you don't have phpunit install globally,
it may be run from the vendor directory: `vendor/bin/phpunit`


Coding Style
------------

We follow PSR-2 with tabs instead of spaces.

There is a PHP Codesniffer ruleset included (phpcs.xml) for automatic checking that can be run: `vendor/bin/phpcs --standard=phpcs.xml`
