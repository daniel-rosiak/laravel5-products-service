<?php

use PHPUnit\Framework\TestCase;

abstract class ApiTest extends TestCase
{
    protected $http;

    public function setUp(): void
    {
        $this->http = new GuzzleHttp\Client(['base_uri' => 'http://chalhoub.api.lo/api/']);
    }

    public function tearDown(): void
    {
        $this->http = null;
    }
}