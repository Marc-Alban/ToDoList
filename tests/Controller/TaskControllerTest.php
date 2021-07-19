<?php

namespace App\Tests\Unit\Controller;

use App\DataFixtures\TaskFixtures;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class TaskControllerTest extends WebTestCase
{

    private KernelBrowser $client;

   /** @var AbstractDatabaseTool */
    protected $databaseTool;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->databaseTool = self::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->databaseTool->loadFixtures([TaskFixtures::class]);
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
     * test with role user
     *
     * @return void
     */
    public function testListAction(): void
    {
        $this->loginUser();
        $this->client->request('GET', '/tasks');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    /**
     * test with role user
     *
     * @return void
     */
    public function testListDoneAction(): void
    {
        $this->loginUser();
        $this->client->request('GET', '/tasks/done');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    /**
     * test with role user
     *
     * @return void
     */
    public function testCreateAction(): void
    {
        $this->loginUser();
        $crawler = $this->client->request('GET', '/tasks/create');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Add')->form();
        $form['task[title]'] = 'letitre';
        $form['task[content]'] = 'lecontenue';
        $this->client->submit($form);

        if ($this->client->getResponse()->isRedirection()) {
            $crawler = $this->client->followRedirect();
        }

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }

    /**
     * test with role user
     *
     * @return void
     */
    public function testEditAction(): void
    {
        $this->loginUser();

        $crawler = $this->client->request('GET', '/tasks/1/edit');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Update')->form();
        $form['task[title]'] = 'letitredematache';
        $form['task[content]'] = 'lecontenuedematache';
        $this->client->submit($form);

        if ($this->client->getResponse()->isRedirection()) {
            $crawler = $this->client->followRedirect();
        }

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }

    /**
     * test with role user
     *
     * @return void
     */
    public function testToogleTaskAction(): void
    {
        $this->loginUser();

        $this->client->request('GET', '/tasks/1/toggle');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        if ($this->client->getResponse()->isRedirection()) {
            $crawler = $this->client->followRedirect();
        }

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }

    /**
     * test with role user
     *
     * @return void
     */
    public function testDeleteAction(): void
    {
        $this->loginUser();

        $this->client->request('GET', '/tasks/1/delete');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        if ($this->client->getResponse()->isRedirection()) {
            $crawler = $this->client->followRedirect();
        }

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }
}
