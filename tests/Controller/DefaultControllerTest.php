<?php

namespace App\Tests\Controller;

use App\Tests\LogTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    use LogTrait;

    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testIndexActionLogin()
    {
        $this->loginUser();
        $this->client->request('GET', '/');
        static::assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    public function testIndexActionWithoutLogin()
    {
        $this->client->request('GET', '/');
        static::assertSame(302, $this->client->getResponse()->getStatusCode());
        $crawler = $this->client->followRedirect();
        static::assertSame(1, $crawler->filter('input[name="_username"]')->count());
        static::assertSame(1, $crawler->filter('input[name="_password"]')->count());
    }
}
