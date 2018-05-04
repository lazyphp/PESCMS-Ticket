# sessions
A non-blocking session handler for PHP

Full documentation is available at http://duncan3dc.github.io/sessions/  
PHPDoc API documentation is also available at [http://duncan3dc.github.io/sessions/api/](http://duncan3dc.github.io/sessions/api/namespaces/duncan3dc.Sessions.html)  

[![Latest Version](https://poser.pugx.org/duncan3dc/sessions/version.svg)](https://packagist.org/packages/duncan3dc/sessions)
[![Build Status](https://travis-ci.org/duncan3dc/sessions.svg?branch=master)](https://travis-ci.org/duncan3dc/sessions)
[![Coverage Status](https://coveralls.io/repos/github/duncan3dc/sessions/badge.svg)](https://coveralls.io/github/duncan3dc/sessions)


Quick Examples
--------------

```php
$session = new \duncan3dc\Sessions\SessionInstance("my-app");
$session->set("current-status", 4);
$currentStatus = $session->get("current-status");
```

Avoid common key clashes:
```php
$session->set("user", "Mark");

$backend = $session->createNamespace("backend");
$backend->set("user", "Caroline");

$session->get("user"); # "Mark"
$backend->get("user"); # "Caroline"
```

Store one-time flash messages:
```php
$session->setFlash("message", "Your profile has been updated");

$session->getFlash("message"); # "Your profile has been updated";

$session->getFlash("message"); # null;
```

There is also a static class you can use with all the features above:
```php
use \duncan3dc\Sessions\Session;
Session::name("my-app");

Session::set("current-status", 4);
$currentStatus = Session::get("current-status");
```

_Read more at http://duncan3dc.github.io/sessions/_  


Changelog
---------
A [Changelog](CHANGELOG.md) has been available since the beginning of time


Where to get help
-----------------
Found a bug? Got a question? Just not sure how something works?  
Please [create an issue](//github.com/duncan3dc/sessions/issues) and I'll do my best to help out.  
Alternatively you can catch me on [Twitter](https://twitter.com/duncan3dc)
