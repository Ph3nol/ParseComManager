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
     * @param string $config Parse.com configuration
     */
    public function __construct(array $config)
    {
        $this->client = new Client($config);
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
