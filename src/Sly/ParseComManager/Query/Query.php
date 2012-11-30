<?php

namespace Sly\ParseComManager\Query;

use Sly\ParseComManager\Config\YamlConfigLoader;
use Symfony\Component\Yaml\Yaml;

/**
 * Query.
 *
 * @author Cédric Dugat <cedric@dugat.me>
 */
class Query
{
    const BASE_API_URL = 'https://api.parse.com/1';

    private $config;
    private $key;
    private $method;
    private $url;
    private $properties;

    /**
     * Constructor.
     * 
     * @param string $key Query key
     */
    public function __construct($key)
    {
        $this->key    = $key;
        $this->config = Yaml::parse(__DIR__.'/../Resources/config/api.yml');

        if (false === array_key_exists($key, $this->config)) {
            throw new \Exception(sprintf('API config has no "%s" key', $key));
        }

        $this->method = $this->config[$key]['method'];
        $this->url    = $this->config[$key]['url'];
    }

    /**
     * Query query method.
     * 
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Query query url.
     * 
     * @return string
     */
    public function getUrl()
    {
        return self::BASE_API_URL.$this->url;
    }

    /**
     * Add property.
     * 
     * @param string $key   Key
     * @param mixed  $value Value
     */
    public function addProperty($key, $value)
    {
        $this->properties[$key] = $value;
    }

    /**
     * Add properties.
     * 
     * @param array $properties Properties
     */
    public function addProperties(array $properties)
    {
        $this->properties = array_merge($properties, $this->properties);
    }

    /**
     * Get properties.
     * 
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }
}
