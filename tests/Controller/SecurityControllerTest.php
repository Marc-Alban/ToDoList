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

    public function testloginAction()
    {
        $this->client->request('GET', '/login');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testloginActionWithBadCredentials()
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

    public function testloginActionWithNoToken()
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

    public function testloginActionWithGoodCredentials()
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('login')->form([
            '_username' => 'User',
            '_password' => 'test'
        ]);
        $this->client->submit($form);
        $this->assertResponseRedirects();
    }

    public function testlogoutCheck()
    {
        $this->client->request('GET', '/logout');
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }
}
