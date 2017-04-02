<?php

namespace CE;

/**
 * Simple storage class for API keys.
 */
class ApiKey
{
    /**
     * @var array The store of API keys
     */
    private $keyStore = array();

    /**
     * Constructor for an API key store
     *
     * @param string $filename Name of a JSON file containing API keys
     */
    public function __construct($filename)
    {
        if (!file_exists($filename)) {
            throw new \Exception("Cannot find the file specified: " . $filename);
        }

        $this->keyStore = json_decode(file_get_contents($filename), true);
    }

    /**
     * Gets a key for a specific service from 'api_keys.json'.
     *
     * @param string $service Name of a service listed in the key store
     * @return string|null The key returned
     */
    public function getKey($service)
    {
        if (!isset($this->keyStore[$service])) {
            return null;
        }

        return $this->keyStore[$service];
    }
}
