<?php

namespace App\Tests\Unit\Controller;

use App\Tests\LogTrait;
use App\DataFixtures\UserFixtures;
use App\Repository\UserRepository;
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
        $this->client = static::createClient();
        $this->databaseTool = self::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->databaseTool->loadFixtures([UserFixtures::class]);
    }

    public function testListAction()
    {
        $this->loginAdmin();
        $this->client->request('GET', '/users');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
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

        if ($this->client->getResponse()->isRedirection()) {
            $crawler = $this->client->followRedirect();
        }
        $this->assertSame(302, $this->client->getResponse()->getStatusCode());
        $crawler->filter('strong:contains("Superb !")');
    }

    public function testUpdateAction()
    {
        $this->loginUser();

        $crawler = $this->client->request('GET', '/users/1/edit');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Update')->form();
        $form['user[username]'] = 'User123';
        $form['user[password][first]'] = 'Test123..';
        $form['user[password][second]'] = 'Test123..';
        $form['user[email]'] = 'user123@autre.org';
        $form['user[roles][0]']->tick();
        $this->client->submit($form);
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }
}
