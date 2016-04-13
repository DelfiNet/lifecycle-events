LifecycleEvents - A consistent interface to email services
==========================================================

Installation / Usage
--------------------

1. Add `delfinet/lifecycle-events` and service library (see below) to your composer.json file requirements.
3. Run `composer update`


### Usage with Customer.io (http://customer.io/) ###

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



### Usage with Drip (https://www.getdrip.com/) ###

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


Laravel 4
---------

### Installation ###

Include LifecycleEvents as a dependency in composer.json:

```
"delfinet/lifecycle-events": "dev-master",
```

Include the relevant service API class (Drip, Customerio, etc.) in composer.json

Run `composer install`

Add the relevant service provider to your provider array in `config/app.php`

```
'providers' => array(
	'DelfiNet\LifecycleEvents\Laravel\CustomerioServiceProvider',
)
```


### Configuration ###

Add configuration to your `config/services.php` file for the service that you will be using
and the environment variables in `.env.php`.


#### Drip ####

In `config/services.php`:

```
<?php
return array(
	'drip' => array(
    		'account_id' => $_ENV['DRIP_ACCOUNT_ID'],
    		'api_token' => $_ENV['DRIP_API_TOKEN'],
    	),
);
```

In `.env.php`:

```
<?php

return array(
	'DRIP_ACCOUNT_ID' => "account id",
	'DRIP_API_TOKEN' => "api token",
);


```

#### Customer.io ####

In `config/services.php`:

```
return array(
	'customerio' => array(
		'site_id' => $_ENV['CUSTOMERIO_SITE_ID'],
		'api_secret' => $_ENV['CUSTOMERIO_API_SECRET'],
	),
);
```

In `.env.php`:

```
<?php

return array(
	'CUSTOMERIO_SITE_ID' => "side id",
	'CUSTOMERIO_API_SECRET' => "api secret",
);
```


Usage
-----

Because the service provider does not set a user when creating LifecycleEvents,
user info will need to be specified the first time one of its methods is called.

```
$lifecycle = App::make('LifecycleEvents');
$lifecycle->identifyUser(array(), array('id' => 123, 'email' => 'laravel@example.com'));
$lifecycle->fire('Registered');
```


Magic Method Events
-------------------

As a shortcut for firing events, non-existing methods are treated as calls fire(),
with the case of the name is preserved.

For example, the following would be the equivalent of calling `fire('registered')`.
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
