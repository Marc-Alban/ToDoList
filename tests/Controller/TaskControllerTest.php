<?php

namespace App\Tests\Unit\Controller;

use App\Tests\LogTrait;
use App\DataFixtures\TaskFixtures;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;

class TaskControllerTest extends WebTestCase
{
    use LogTrait;

    private $client;

   /** @var AbstractDatabaseTool */
    protected $databaseTool;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->databaseTool = self::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->databaseTool->loadFixtures([TaskFixtures::class]);
    }

    public function testListAction()
    {
        $this->loginUser();
        $this->client->request('GET', '/tasks');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testListDoneAction()
    {
        $this->loginUser();
        $this->client->request('GET', '/tasks/done');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testCreateAction()
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

    public function testEditAction()
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

    public function testDeleteAction()
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
