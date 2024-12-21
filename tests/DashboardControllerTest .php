<?php

namespace App\Tests\Controller\Back\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DashboardControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        // Create client for HTTP simulation
        $client = static::createClient();
        $client->request('GET', '/admin');

        // Check if response 200
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // Check response with correct content
        $this->assertStringContainsString('User Count:', $client->getResponse()->getContent());
        $this->assertStringContainsString('Article Count:', $client->getResponse()->getContent());
        $this->assertStringContainsString('Category Count:', $client->getResponse()->getContent());

        echo "Dashboard controller test OK\n";
    }
}
