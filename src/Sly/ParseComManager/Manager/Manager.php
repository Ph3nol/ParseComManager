<?php

namespace Sly\ParseComManager\Manager;

use Sly\ParseComManager\Exception\NotFoundHttpException;
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
     * Output formats:
     * - 'api' (default): native API output format
     * - 'client': library client output format
     * 
     * @param \Sly\ParseComManager\Query\Query $query  Query
     * @param boolan                           $output Output format
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

        $headers = $response->getHeaders();

        if ('HTTP/1.1 404 Not Found' === $headers[0]) {
            throw new NotFoundHttpException('API request failed (404 error returned)');
        }

        return ('api' == $output) ? $response->getContent() : $response;
    }
}
