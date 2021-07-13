<?php

namespace App\Tests\Unit\Controller;

use App\Tests\LogTrait;
use App\DataFixtures\UserFixtures;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;

class UserControllerTest extends WebTestCase
{
    use LogTrait;

    private $client;

   /** @var AbstractDatabaseTool */
    protected $databaseTool;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = $this->createClient();
        $this->databaseTool = self::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->databaseTool->loadFixtures([UserFixtures::class]);
    }

    public function testListAction()
    {
        $this->loginAdmin();
        $this->client->request('GET', '/users');
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    public function testListActionWithUser()
    {
        $this->loginUser();
        $this->client->request('GET', '/users');
        $this->assertSame(302, $this->client->getResponse()->getStatusCode());
        $this->client->followRedirect();
    }

    public function testListActionWithoutLogin()
    {
        $this->client->request('GET', '/users');
        $this->assertSame(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();
        $this->assertSame(1, $crawler->filter('input[name="_username"]')->count());
        $this->assertSame(1, $crawler->filter('input[name="_password"]')->count());
    }

    public function testCreateAction()
    {
        $crawler = $this->client->request('GET', '/users/create');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Add')->form();
        $form['user[username]'] = 'autre';
        $form['user[password][first]'] = 'Test123..';
        $form['user[password][second]'] = 'Test123..';
        $form['user[email]'] = 'autre@autre.org';
        $form['user[roles][0]']->tick();
        $this->client->submit($form);
        $crawler->filter('strong:contains("Superb !")');
    }

    public function testEditAction()
    {
        $this->loginUser();

        $crawler = $this->client->request('GET', '/users/1/edit');
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());

        $this->assertSame(1, $crawler->filter('input[name="user[username]"]')->count());
        $this->assertSame(1, $crawler->filter('input[name="user[password][first]"]')->count());
        $this->assertSame(1, $crawler->filter('input[name="user[password][second]"]')->count());
        $this->assertSame(1, $crawler->filter('input[name="user[email]"]')->count());
        $this->assertSame(2, $crawler->filter('input[name="user[roles][]"]')->count());

        $form = $crawler->selectButton('Update')->form();
        $form['user[username]'] = 'user';
        $form['user[password][first]'] = 'Test123..';
        $form['user[password][second]'] = 'Test123..';
        $form['user[email]'] = 'editedUser@example.org';
        $form['user[roles][0]']->tick();

        $this->client->submit($form);
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    public function testEditActionNotLog()
    {
        $this->loginAnonymous();
        $this->client->request('GET', '/users/1/edit');
        $this->assertSame(403, $this->client->getResponse()->getStatusCode());
    }

    public function testDeleteAction()
    {
        $this->loginAdmin();
        $this->client->request('GET', '/users/1/delete');
        $this->assertSame(302, $this->client->getResponse()->getStatusCode());
        if ($this->client->getResponse()->isRedirection()) {
            $this->client->followRedirect();
        }
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    public function testDeleteActionNotLog()
    {
        $this->loginAnonymous();
        $this->client->request('GET', '/users/1/delete');
        $this->assertSame(403, $this->client->getResponse()->getStatusCode());
    }
}
