<?php

namespace Sly\ParseComManager\Client;

use Sly\ParseComManager\Exception\ConfigurationException;
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

    /**
     * Constructor.
     * 
     * @param array $config API configuration
     */
    public function __construct(array $config)
    {
        $this->client = new BaseClient();
        $this->config = array_merge($this->getDefaultConfig(), $config);

        if (
            null === $this->config['appID'] ||
            null === $this->config['masterKey'] ||
            null === $this->config['apiKey']
        ) {
            throw new ConfigurationException('Bad configuration, see documentation');
        }
    }

    /**
     * Get default configuration.
     * 
     * @return array
     */
    private function getDefaultConfig()
    {
        return array(
            'appID'        => null,
            'masterKey'    => null,
            'apiKey'       => null,
            'sessionToken' => null,
        );
    }

    /**
     * Get client response.
     * 
     * @return string
     */
    public function getResponse($method, $url, $properties)
    {
        $headers = array(
            'X-Parse-Application-Id' => $this->config['appID'],
            'X-Parse-Master-Key'     => $this->config['masterKey'],
            'X-Parse-REST-API-Key'   => $this->config['apiKey'],
        );

        if ($this->config['sessionToken']) {
            $headers['X-Parse-Session-Token'] = $this->config['sessionToken'];
        }

        $request = $this->client->$method(
            Query::API_BASE_URL.$url,
            $headers,
            in_array($method, array('put', 'post'))
                ? json_encode($properties)
                : $properties
        );

        $request->setHeader('Content-Type', 'application/json');

        $response = $request->send();

        return $response;
    }
}
