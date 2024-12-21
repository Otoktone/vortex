<?php

use App\Controller\ErrorController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ErrorControllerTest extends WebTestCase
{
    public function testError404(): void
    {
        // Create client for HTTP simulation
        $client = static::createClient();

        $client->request('GET', '/error/404');

        // Check if response 200
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // Check 404 page content
        $this->assertStringContainsString('Page Not Found', $client->getResponse()->getContent());

        echo "Test Error 404 passed\n";
    }
}
