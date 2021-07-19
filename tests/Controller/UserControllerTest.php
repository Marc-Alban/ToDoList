<?php

namespace App\Tests\Unit\Controller;

use App\DataFixtures\UserFixtures;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class UserControllerTest extends WebTestCase
{

    private KernelBrowser $client;

   /** @var AbstractDatabaseTool */
    protected $databaseTool;

    public function setUp(): void
    {
        $this->client = $this->createClient();
        $this->databaseTool = self::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->databaseTool->loadFixtures([UserFixtures::class]);
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
     * test path /users with log Admin
     *
     * @return void
     */
    public function testListActionWithAdmin(): void
    {
        $this->loginAdmin();
        $this->client->request('GET', '/users');
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }


    /**
     * test path /users with log user
     *
     * @return void
     */
    public function testListActionWithUser(): void
    {
        $this->loginUser();
        $this->client->request('GET', '/users');
        $this->assertSame(403, $this->client->getResponse()->getStatusCode());
    }

    /**
     * test path /users not log
     *
     * @return void
     */
    public function testListActionWithoutLogin(): void
    {
        $this->client->request('GET', '/users');
        $this->assertSame(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();
        $this->assertSame(1, $crawler->filter('input[name="_username"]')->count());
        $this->assertSame(1, $crawler->filter('input[name="_password"]')->count());
    }

    /**
     * test path /create with notlog
     *
     * @return void
     */
    public function testCreateAction(): void
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

       /**
     * test path /edit with log Admin
     *
     * @return void
     */
    public function testEditActionWithAdmin(): void
    {
        $this->loginAdmin();
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


    /**
     * test path /edit with log user
     *
     * @return void
     */
    public function testEditActionWithUser(): void
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

    /**
     * test path /edit with not log
     *
     * @return void
     */
    public function testEditActionNotLog(): void
    {
        $this->client->request('GET', '/users/1/edit');
                $this->assertSame(302, $this->client->getResponse()->getStatusCode());
        if ($this->client->getResponse()->isRedirection()) {
            $this->client->followRedirect();
        }
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    /**
     * test path /delete with log Admin
     *
     * @return void
     */
    public function testDeleteAction(): void
    {
        $this->loginAdmin();
        $this->client->request('GET', '/users/1/delete');
        $this->assertSame(302, $this->client->getResponse()->getStatusCode());
        if ($this->client->getResponse()->isRedirection()) {
            $this->client->followRedirect();
        }
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    /**
     * test path /delete with notlog
     *
     * @return void
     */
    public function testDeleteActionNotLog(): void
    {
        $this->client->request('GET', '/users/1/delete');
        $this->assertSame(302, $this->client->getResponse()->getStatusCode());
    }
}
