LifecycleEvents - A consistent interface to drip email services
==========================================================

Installation
------------

1. Add `delfinet/lifecycle-events` to your composer.json file.
2. Run `composer update`


Usage with Drip (https://www.getdrip.com/)
-----

use DelfiNet\LifecycleEvents\Adapter\DripAdapter;
use DelfiNet\LifecycleEvents\LifecycleEvents;

$accountId = 123; // your drip account id
$dripApi = new Drip_Api('your drip api token');
$adapter = new DripAdapter($accountId, $dripApi);

$lifecycle = new LifecycleEvents($adapter);
$lifecycle->identifyNewUser(array('Random' => 'Property'), array('id' => 123, 'email' => 'drip@example.com'));
$lifecycle->fire('Registered', array('LifecyleEvents' => 'Success'));


Testing
-------

Run `phpunit` from the project root. If you don't have phpunit install globally,
it may be run from the vendor directory: `vendor/bin/phpunit`


Coding Style
------------

We follow PSR-2 with tabs instead of spaces.

There is a PHP Codesniffer ruleset included (phpcs.xml) for automatic checking that can be run: `vendor/bin/phpcs --standard=phpcs.xml`
