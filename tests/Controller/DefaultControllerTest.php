<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class DefaultControllerTest extends WebTestCase
{

    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testIndexActionNotLog()
    {
        $this->client->request('GET', '/');
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }

    public function testIndexActionNotLogRedirect()
    {
        $this->client->request('GET', '/');
        $this->assertResponseRedirects('/login');
    }

}