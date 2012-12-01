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
    private $appID;
    private $apiKey;

    /**
     * Constructor.
     * 
     * @param string $appID  Parse.com application ID
     * @param string $apiKey Parse.com REST API key
     */
    public function __construct($appID, $apiKey)
    {
        $this->client = new BaseClient();
        $this->appID  = $appID;
        $this->apiKey = $apiKey;
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
                'X-Parse-Application-Id' => $this->appID,
                'X-Parse-REST-API-Key'   => $this->apiKey,
            ),
            $properties
        );

        $request->setHeader('Content-Type', 'application/json');

        $response = $request->send();

        return $response;
    }
}
