<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends WebTestCase
{
    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    /**
     * test login
     *
     * @return void
     */
    public function testloginAction(): void
    {
        $this->client->request('GET', '/login');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    /**
     * test with bad credentials
     *
     * @return void
     */
    public function testloginActionWithBadCredentials(): void
    {
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('login')->form([
            '_username' => 'notgoodusername',
            '_password' => 'notgoodpassword'
        ]);

        $this->client->submit($form);

        $this->assertResponseRedirects();

        $this->client->followRedirect();

        $this->assertSelectorExists('.alert.alert-danger');
    }

    /**
     * test with no token
     *
     * @return void
     */
    public function testloginActionWithNoToken(): void
    {

        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('login')->form([
            '_username' => 'notgoodusername',
            '_password' => 'notgoodpassword',
            '_csrf_token' => ''
        ]);

        $this->client->submit($form);

        $this->assertResponseRedirects();

        $this->client->followRedirect();

        $this->assertSelectorExists('.alert.alert-danger');
    }

    /**
     * test loginwith good credantial
     *
     * @return void
     */
    public function testloginActionWithGoodCredentials(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('login')->form([
            '_username' => 'User',
            '_password' => 'test'
        ]);
        $this->client->submit($form);
        $this->assertResponseRedirects();
    }

    /**
     * test logout
     *
     * @return void
     */
    public function testlogoutCheck(): void
    {
        $this->client->request('GET', '/logout');
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }
}
