# ParseComManager

Manage API queries to Parse.com cloud service.

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
    url: https://api.parse.com/1/login

login:
    method: get
    url: https://api.parse.com/1/login

retrieveUser:
    method: get
    url: https://api.parse.com/1/users/%userKey%

# ...
```

You can use keys into a URL, like retrieveUser '%userKey%' case.
Just set a 'userKey' property to your query, as usual, it will be replaced
in your URL.
