<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{

    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    /**
     * method for connection User
     *
     * @return void
     */
    public function loginUser(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('login')->form(['_username' => 'User1','_password' => 'test']);
        $this->client->submit($form);
    }


    /**
     * method for connection Admin
     *
     * @return void
     */
    public function loginAdmin(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('login')->form(['_username' => 'Admin','_password' => 'root']);
        $this->client->submit($form);
    }


    /**
     * test index with no log
     *
     * @return void
     */
    public function testIndexActionWithoutLogin(): void
    {
        $this->client->request('GET', '/');
        static::assertSame(302, $this->client->getResponse()->getStatusCode());
        $crawler = $this->client->followRedirect();
        static::assertSame(1, $crawler->filter('input[name="_username"]')->count());
        static::assertSame(1, $crawler->filter('input[name="_password"]')->count());
    }
}
