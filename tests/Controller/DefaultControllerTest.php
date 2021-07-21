<?php

namespace App\Tests\Controller;

use App\DataFixtures\UserFixtures;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;

class DefaultControllerTest extends WebTestCase
{

    private KernelBrowser $client;

    /** @var AbstractDatabaseTool */
    protected $databaseTool;

    public function setUp(): void
    {
        $this->client = static::createClient();
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
     * test index with no log
     *
     * @return void
     */
    public function testIndexActionWithoutLogin(): void
    {
        $this->client->request('GET', '/');
        $this->assertSame(302, $this->client->getResponse()->getStatusCode());
        $crawler = $this->client->followRedirect();
        $this->assertSame(1, $crawler->filter('input[name="_username"]')->count());
        $this->assertSame(1, $crawler->filter('input[name="_password"]')->count());
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    /**
     * test index with user
     *
     * @return void
     */
    public function testIndexActionWithUser(): void
    {
        $this->loginUser();
        $this->client->request('GET', '/');
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }
}
