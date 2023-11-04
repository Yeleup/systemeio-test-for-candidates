<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PurchaseControllerTest extends WebTestCase
{
    public function test_calculate_price(): void
    {
        $client = static::createClient();

        $payload = [
            'product' => 1,
            'couponCode' => 'COUPON123',
            'taxNumber' => 'DE123456789',
        ];

        $client->request(
            'POST',
            '/calculate-price',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($payload)
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function test_purchase(): void
    {
        $client = static::createClient();

        $payload = [
            'product' => 1,
            'couponCode' => 'COUPON123',
            'taxNumber' => 'DE123456789',
            'paymentProcessor'=> 'paypal',
        ];

        $client->request(
            'POST',
            '/purchase',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($payload)
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
