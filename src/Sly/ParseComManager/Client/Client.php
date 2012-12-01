<?php

namespace Sly\ParseComManager\Client;

use Buzz\Browser;
use Buzz\Message\RequestInterface;
use Buzz\Message\Response;
use Buzz\Client\Curl;

/**
 * Client.
 *
 * @author Cédric Dugat <cedric@dugat.me>
 */
class Client
{
    private $browser;
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
        $this->browser = new Browser(new Curl());
        $this->appID   = $appID;
        $this->apiKey  = $apiKey;
    }

    /**
     * Get browser response.
     * 
     * @return string
     */
    public function getResponse($method, $url, $properties)
    {
        switch ($method) {
            default:
            case 'get':
                $browserMethod = RequestInterface::METHOD_GET;
                break;

            case 'post':
                $browserMethod = RequestInterface::METHOD_POST;
                break;
        }

        return $this->browser->submit(
            $url,
            $properties,
            $browserMethod,
            array(
                'X-Parse-Application-Id' => $this->appID,
                'X-Parse-REST-API-Key'   => $this->apiKey,
                'Content-Type'           => 'application/json',
            )
        );
    }
}
