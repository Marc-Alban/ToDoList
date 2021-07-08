<?php

namespace App\Tests\Controller;

use App\DataFixtures\UserFixtures;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;


class UserControllerTest extends WebTestCase
{
    private $client;
    private $user;

    /** @var AbstractDatabaseTool */
    protected $databaseTool;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->databaseTool = self::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->user = $this->databaseTool->loadFixtures([UserFixtures::class]); 
    }


    public function testEditActionWithGoodCredentialsUser()
    {
        $crawler = $this->client->request('GET', '/user/' . $this->users->getId() . '/edit');
        $form = $crawler->selectButton('Update')->form([
            'user[_password][first]' => 'test',
            'user[_password][second]' => 'test'
        ]);

        $this->client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $this->assertResponseRedirects();
    }

    
    public function testlistActionNotLog()
    {
        $this->client->request('GET', '/users');
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }

    public function testlistActionNotLogRedirect()
    {
        $this->client->request('GET', '/users');
        $this->assertResponseRedirects();
    }
}
 
    // public function testEditActionWithGoodCredentialsAdmin()
    // {
    //     $user = self::getContainer()->get(UserRepository::class)->findOneBy(['username' => 'Admin']);
    //     $crawler = $this->client->request('GET', '/user/' . $user->getId() . '/edit');
    //     $form = $crawler->selectButton('Modifier')->form([
    //         'user[password][first]' => 'test',
    //         'user[password][second]' => 'test'
    //     ]);

    //     $this->client->submit($form);
    //     $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    //     $this->assertResponseRedirects();
    // }

    // public function testEditActionWithBadCredentials()
    // {
    //     $crawler = $this->client->request('GET', '/user/' . $this->users->getId() . '/edit');
    //     $form = $crawler->selectButton('Modifier')->form([
    //         'user[password][first]' => '',
    //         'user[password][second]' => ''
    //     ]);

    //     $this->client->submit($form);

    //     $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    //     $this->assertSelectorTextContains('ul.list-unstyled', 'Le mot de passe ne peu pas être vide.');
    // }

    // public function testcreateActionWithBadCredentials()
    // {
    //     $crawler = $this->client->request('GET', '/user/create');
    //     $form = $crawler->selectButton('Ajouter')->form([
    //         'user[username]' => 'test1',
    //         'user[email]' => 'test',
    //         'user[password][first]' => 'test',
    //         'user[password][second]' => 'test'
    //     ]);
    //     $this->client->submit($form);
    //     $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    //     $this->assertSelectorTextContains('ul.list-unstyled', 'Le format de l\'adresse n\'est pas correcte.');
    // }

    // public function testcreateActionWithGoodCredentialsUser()
    // {
    //     $crawler = $this->client->request('GET', '/user/create');
    //     $form = $crawler->selectButton('Ajouter')->form([
    //         'user[username]' => 'test1',
    //         'user[email]' => 'test1@test.fr',
    //         'user[password][first]' => 'test',
    //         'user[password][second]' => 'test'
    //     ]);

    //     $this->client->submit($form);
    //     $this->assertResponseRedirects();
    //     $this->client->followRedirect();
    //     $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    //     $this->assertSelectorTextContains('div.alert.alert-success', 'Superbe ! L\'utilisateur a bien été ajouté.');
    // }

    // public function testcreateActionWithGoodCredentialsAdmin()
    // {
    //     $crawler = $this->client->request('GET', '/user/create');
    //     $form = $crawler->selectButton('Ajouter')->form([
    //         'user[username]' => 'test1',
    //         'user[email]' => 'test1@test.fr',
    //         'user[password][first]' => 'test',
    //         'user[password][second]' => 'test'
    //     ]);

    //     $this->client->submit($form);
    //     $this->assertResponseRedirects('/users');
    //     $this->client->followRedirect();
    //     $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    //     $this->assertSelectorTextContains('div.alert.alert-success', 'Superbe ! L\'utilisateur a bien été ajouté.');
    // }

    // public function testcreateActionWithExistingCredentials()
    // {
    //     $crawler = $this->client->request('GET', '/user/create');
    //     $form = $crawler->selectButton('Ajouter')->form([
    //         'user[username]' => 'test',
    //         'user[email]' => 'test@test.fr',
    //         'user[password][first]' => 'test',
    //         'user[password][second]' => 'test'
    //     ]);
    //     $this->client->submit($form);
    //     $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    //     $this->assertSelectorTextContains('ul.list-unstyled', 'This value is already used.');
    // }
// }