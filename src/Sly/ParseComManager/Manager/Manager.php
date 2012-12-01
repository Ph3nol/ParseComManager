<?php

namespace Sly\ParseComManager\Manager;

use Sly\ParseComManager\Exception\NotFoundHttpException;
use Sly\ParseComManager\Exception\ApiException;
use Sly\ParseComManager\Client\Client;
use Sly\ParseComManager\Query\Query;

/**
 * Manager.
 *
 * @author Cédric Dugat <cedric@dugat.me>
 */
class Manager
{
    private $client;

    /**
     * Constructor.
     * 
     * @param string $appID  Parse.com application ID
     * @param string $apiKey Parse.com REST API key
     */
    public function __construct($appID, $masterKey, $apiKey)
    {
        $this->client = new Client(array(
            'appID'     => $appID,
            'masterKey' => $masterKey,
            'apiKey'    => $apiKey,
        ));
    }

    /**
     * Execute query.
     *
     * Output formats:
     * - 'api' (default): native API output format
     * - 'client': library client output format
     * 
     * @param \Sly\ParseComManager\Query\Query $query  Query
     * @param boolan                           $output Output format
     *
     * @throws Sly\ParseComManager\Exception\ApiException
     * @throws Sly\ParseComManager\Exception\NotFoundHttpException
     * 
     * @return object|string
     */
    public function execute(Query $query, $output = 'api')
    {
        $response = $this->client->getResponse(
            $query->getMethod(),
            $query->getUrl(),
            $query->getProperties()
        );

        return ('api' == $output) ? $response->json() : $response;
    }
}
