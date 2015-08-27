<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Alexa\Request\Request;

class NestGetTempIntentTest extends TestCase
{
    public function testSimpleRequest()
    {
        $requestBody = [
            'request' => [
                'requestId' => 1,
                'timestamp' => (new DateTime())->format(DateTime::ISO8601),
                'type' => 'IntentRequest',
                'intent' => [
                    'name' => 'NestGetTempIntent'
                ]
            ]
        ];

        $this->call('POST', '/', [], [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($requestBody));
        $this->seeJson(['type' => 'PlainText']);
    }
}
