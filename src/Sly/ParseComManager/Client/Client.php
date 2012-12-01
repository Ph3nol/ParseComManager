<?php

namespace Sly\ParseComManager\Client;

use Guzzle\Http\Client as BaseClient;
use Sly\ParseComManager\Query\Query;

/**
 * Client.
 *
 * @author Cédric Dugat <cedric@dugat.me>
 */
class Client
{
    private $client;
    private $config;
    private $appID;
    private $masterKey;
    private $apiKey;

    /**
     * Constructor.
     * 
     * @param array $config API configuration
     */
    public function __construct(array $config)
    {
        $this->client = new BaseClient();
        $this->config = $config;
    }

    /**
     * Get client response.
     * 
     * @return string
     */
    public function getResponse($method, $url, $properties)
    {
        $request = $this->client->$method(
            Query::API_BASE_URL.$url,
            array(
                'X-Parse-Application-Id' => $this->config['appID'],
                'X-Parse-REST-API-Key'   => $this->config['apiKey'],
                'X-Parse-Master-Key'     => $this->config['masterKey'],
            ),
            $properties
        );

        $request->setHeader('Content-Type', 'application/json');

        $response = $request->send();

        return $response;
    }
}
