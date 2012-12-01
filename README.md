# ParseComManager

Manage API queries to Parse.com cloud service.

[![Continuous Integration status](https://secure.travis-ci.org/Ph3nol/ParseComManager.png)](http://travis-ci.org/Ph3nol/ParseComManager)

## Requirements

* PHP 5.3+
* PHP Curl extension

## Installation

### Add to your project Composer packages

Just add `sly/parsecom-manager` package to the requirements of your Composer JSON configuration file,
and run `php composer.phar install` to install it.

### Install from GitHub

Clone this library from Git with `git clone https://github.com/Ph3nol/ParseComManager.git`.

Goto to the library directory, get Composer phar package and install vendors:

```
curl -s https://getcomposer.org/installer | php
php composer.phar install
```

You're ready to go.

## Usage

``` php
<?php

require_once '/path/to/vendor/autoload.php';

use Sly\ParseComManager\Manager\Manager;
use Sly\ParseComManager\Query\Query;

/**
 * Initialize the manager with your application ID and REST API key.
 */
$manager = new Manager(
    'YourAppID',
    'YourRESTAPIKey'
);

/**
 * Initialize the query with 'login' API part parameters.
 *
 * Some API parameters are defined into the library:
 * Resources/config/api.yml
 *
 * You can add yours or overload base ones with declaring
 * your YAML file path as second argument:
 * $query = new Query('login', '/path/to/your/api.yml');
 */
$query = new Query('login');

/**
 * Add some properties, required by Parse.com REST API.
 */
$query->addProperties(array(
    'username' => 'Chuck',
    'password' => 'n0rr1s',
));

// or/and $query->addProperty('specificProperty', 'propertyValue');

/**
 * Get API JSON response.
 * 
 * You can use 'client' second argument to get the client response.
 * Example: $clientResponse = $manager->execute($query, 'client');
 */
$apiResponse = $manager->execute($query);

/**
 * Construct user from JSON response.
 */
$user = json_decode($apiResponse);
```

## YAML API config file

You can use your own YAML API config file. Here is an example:

``` yaml
signup:
    method: post
    url: /login

login:
    method: get
    url: /login

retrieveUser:
    method: get
    url: /users/%userKey%

# ...
```

Be careful: URLs are relative ones.
Base one is declared as `Sly\ParseComManager\Query\Query::API_BASE_URL` constant.

You can use keys into a URL, like retrieveUser '%userKey%' case.
Just set a 'userKey' property to your query, as usual, it will be replaced
in your URL.

## Test with Atoum

This library is using [Atoum](https://github.com/atoum/atoum) for unit testing,
whose Composer package can be installed with `dev` mode:

```
php composer install --dev
./atoum -d tests/units
```
