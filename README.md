[![Build Status](https://travis-ci.org/madwings/longurl.svg?branch=develop)](https://travis-ci.org/madwings/longurl)
    
# longurl

This library can be used to expand short URLs such as https://t.co/XdXRudPXH5 and get the URL that is behind the short URL

## Install

Install via [composer](https://getcomposer.org):

```javascript
{
    "require": {
        "madwings/longurl": "@stable"
    }
}
```

Run `composer install` or `composer update`.

## Attention

This library currently only supports methods for getting services, checking if an URL is a short URL and expanding URLs.

For caching, by default this library uses the /tmp/ directory. If you want to change it, use the Config class.

## Getting Started

Note: You can also see the examples.php for more examples.

### Basic parsing

```php
<?php
require __DIR__ . '/vendor/autoload.php';

$expand = new \tzfrs\LongURL\Endpoints\Expand();
try {
    print $expand->expandURL('https://t.co/XdXRudPXH5'); //https://blog.twitter.com/2013/rich-photo-experience-now-in-embedded-tweets-3
    print $expand->expandURL('https://blog.twitter.com/2013/rich-photo-experience-now-in-embedded-tweets-3'); //https://blog.twitter.com/2013/rich-photo-experience-now-in-embedded-tweets-3
} catch (\tzfrs\LongURL\Exceptions\ExpandException $e) {
    print $e->getMessage();
}
```

### List all services

```php
<?php
require __DIR__ . '/vendor/autoload.php';

$services = new \tzfrs\LongURL\Endpoints\Services();
try {
    $services = $services->getServices(); // Object array with all services
} catch (\tzfrs\LongURL\Exceptions\ServicesException $e) {
    print $e->getMessage();
}
```

### Check if is a short URL

```php
<?php
require __DIR__ . '/vendor/autoload.php';

$services = new \tzfrs\LongURL\Endpoints\Services();
try {
    $services->isShortURL('https://t.co/XdXRudPXH5'); // True
    $services->isShortURL('https://blog.twitter.com/2013/rich-photo-experience-now-in-embedded-tweets-3'); // False
} catch (\tzfrs\LongURL\Exceptions\ServicesException $e) {
    print $e->getMessage();
}
```
