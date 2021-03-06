<?php

namespace Sly\ParseComManager\Query;

use Sly\ParseComManager\Exception\ConfigurationException;
use Sly\ParseComManager\Config\YamlConfigLoader;
use Symfony\Component\Yaml\Yaml;

/**
 * Parse.com queries.
 *
 * @author Cédric Dugat <cedric@dugat.me>
 */
class Query
{
    const API_BASE_URL = 'https://api.parse.com/1';

    private $config;
    private $key;
    private $method;
    private $url;
    private $properties = array();

    /**
     * Constructor.
     * 
     * @param string $key             Query key
     * @param string $specificAPIFile Specific API file path
     *
     * @throws Sly\ParseComManager\Exception\ConfigurationException
     */
    public function __construct($key, $specificAPIFile = null)
    {
        if ($specificAPIFile && true === file_exists($specificAPIFile)) {
            $this->config = Yaml::parse($specificAPIFile);
        } else {
            $this->config = Yaml::parse(__DIR__.'/../Resources/config/api.yml');
        }

        if (false === array_key_exists($key, $this->config)) {
            throw new ConfigurationException(sprintf('API config file has no "%s" key', $key));
        }

        $this->key    = $key;
        $this->method = $this->config[$key]['method'];
        $this->url    = $this->config[$key]['url'];
    }

    /**
     * Query method.
     * 
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Query url.
     * 
     * @return string
     */
    public function getUrl()
    {
        $url = $this->url;

        foreach ($this->properties as $key => $value) {
            $r = "/%$key%/i";

            if (preg_match($r, $url)) {
                $url = str_replace("%$key%", $value, $url);
                unset($this->properties[$key]);
            }
        }

        return $url;
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
        $this->properties = array_merge($this->properties, $properties);
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
