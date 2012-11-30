# ParseComManager

Manage API queries to Parse.com cloud service.

**WORK IN PROGRESS.**

## Example

``` php
<?php

require_once '/path/to/vendor/autoload.php';

use Sly\ParseComManager\Manager\Manager;
use Sly\ParseComManager\Query\Query;

$manager = new Manager(
    'YourAppID',
    'YourRESTAPIKey'
);

$query = new Query('login'); // 'login' is API service key
$query->addProperties(array(
    'username' => 'Chuck',
    'password' => 'n0rr1s',
));

$user = $manager->execute($query); // Get your 'user' entity from cloud!
```
