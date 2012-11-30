<?php

namespace Sly\ParseComManager\Manager;

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
    public function __construct($appID, $apiKey)
    {
        $this->client = new Client($appID, $apiKey);
    }

    /**
     * Execute query.
     * 
     * @param \Sly\ParseComManager\Query\Query $query        Query
     * @param boolan                           $objectOutput Object output formatted
     * 
     * @return object|string
     */
    public function execute(Query $query, $objectOutput = true)
    {
        $response = $this->client->getResponse(
            $query->getMethod(),
            $query->getUrl(),
            $query->getProperties()
        );

        return $objectOutput ? json_decode($response) : $response;
    }
}
