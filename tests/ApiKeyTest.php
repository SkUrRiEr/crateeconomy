<?php

namespace Test;

use CE\ApiKey;
use PHPUnit\Framework\TestCase;

class ApiKeyTest extends TestCase
{
    /**
     * Name of the provided key store
     */
    const PROVIDED = __DIR__ . "/provided/apikeytest.json";

    /**
     * Given the ApiKey class
     * When instantiated with the provided key store and the "Test" key is requested
     * Then the expected string will be returned
     */
    public function testGetSuccess()
    {
        $keystore = new ApiKey(self::PROVIDED);

        $key = $keystore->getKey("Test");

        self::assertEquals("TEST KEY", $key);
    }

    /**
     * Given the ApiKey class
     * When instantiated with the provided key store and the "Test2" key is requested
     * Then the expected string will be returned
     */
    public function testGetSuccess2()
    {
        $keystore = new ApiKey(self::PROVIDED);

        $key = $keystore->getKey("Test2");

        self::assertEquals("TEST KEY 2", $key);
    }

    /**
     * Given the ApiKey class
     * When instatiated with the provided key store and an unknown key is requested
     * Then null will be returned
     */
    public function testGetUnknown()
    {
        $keystore = new ApiKey(self::PROVIDED);

        $key = $keystore->getKey("Unknown");

        self::assertNull($key);
    }

    /**
     * Given the ApiKey class
     * When instantiated with a non-existent key store
     * Then an exception will be thrown
     */
    public function testMissingStore()
    {
        self::expectException("Exception");

        new ApiKey("NONEXISTENT");
    }
}
