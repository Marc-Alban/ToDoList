<?php

namespace App\Tests\Controller;

use App\Tests\logTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    use logTrait;

    public function testListAction(): void
    {
        $this->loginUser();
        $this->client->request('GET', '/users');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testCreateAction(): void
    {
        $this->loginUser();

        $crawler = $this->client->request('GET', '/users/create');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Add')->form();
        $form['user[username]'] = 'new1';
        $form['user[password][first]'] = '123Mm..';
        $form['user[password][second]'] = '123Mm..';
        $form['user[email]'] = 'new1@user.com';
        $form['user[roles][0]']->tick();
        $this->client->submit($form);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }

    public function testUpdateAction(): void
    {
        $this->loginUser();

        $crawler = $this->client->request('GET', '/users/4/edit');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Update')->form();
        $form['user[username]'] = 'user1';
        $form['user[password][first]'] = '123Mm..';
        $form['user[password][second]'] = '123Mm..';
        $form['user[email]'] = 'user1@user.com';
        $form['user[roles][1]']->tick();
        $this->client->submit($form);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }
}
