<?php

namespace App\Tests\Controller;

use App\Tests\logTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    use logTrait;

    public function testLogin()
    {
        $this->loginUser();
        $this->client->request('GET', '/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testLogOut()
    {
        $this->loginUser();
        $crawler = $this->client->request('GET', '/');
        $crawler->selectLink('log out')->link();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
