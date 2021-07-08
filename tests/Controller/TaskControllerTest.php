<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use App\DataFixtures\TaskAttachedFixtures;
use App\DataFixtures\TaskFixtures;
use App\DataFixtures\UserFixtures;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;

/**
 *
 */
class TaskControllerTest extends WebTestCase
{

    private $client;

    /** @var AbstractDatabaseTool */
    protected $databaseTool;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->databaseTool = self::getContainer()->get(DatabaseToolCollection::class)->get();
    }

    // Mettre en place un syteme de droit pour acceder a cette page.
    public function testlistActionNotLog()
    {
        $this->client = static::createClient();
        $crawler = $this->client->request('GET', '/tasks');
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }

    public function testlistActionNotLogRedirect()
    {
        $this->client = static::createClient();
        $crawler = $this->client->request('GET', '/tasks');
        $this->assertResponseRedirects('/login');
    }

    public function testlistActionLog()
    {
        $this->client = static::createClient();

        $users = $this->databaseTool->loadFixtureFiles([ UserFixtures::class]);


        $crawler = $this->client->request('GET', '/tasks');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testlistActionFinishedLog()
    {
        $this->client = static::createClient();

        $users = $this->databaseTool->loadFixtureFiles([ UserFixtures::class]);


        $crawler = $this->client->request('GET', '/tasks/finished');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testEditActionWithGoodCredentialsUser()
    {
        $this->client = static::createClient();

        $this->databaseTool->loadFixtureFiles([TaskAttachedFixtures::class]);

        $user = self::getContainer()->get(UserRepository::class)->findOneBy(['username' => 'User1']);
        $task = self::getContainer()->get(TaskRepository::class)->findOneBy(['user' => $user->getId()]);

        $crawler = $this->client->request('GET', '/tasks/' . $task->getId() . '/edit');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->selectButton('Modifier')->form([
            'task[title]' => 'test task',
            'task[content]' => 'content of test task'
        ]);
        $this->client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $this->assertResponseRedirects('/tasks');
        $this->client->followRedirect();
        $this->assertSelectorTextContains('div.alert.alert-success', 'Superbe ! La tâche a bien été modifiée.');
    }

    public function testEditActionWithGoodCredentialsAdmin()
    {
        $this->client = static::createClient();

        $this->databaseTool->loadFixtureFiles([TaskAttachedFixtures::class]);

        $task = self::getContainer()->get(TaskRepository::class)->find(1);
        $user = self::getContainer()->get(UserRepository::class)->findOneBy(['username' => 'Admin']);


        $crawler = $this->client->request('GET', '/tasks/' . $task->getId() . '/edit');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->selectButton('Modifier')->form([
            'task[title]' => 'test task',
            'task[content]' => 'content of test task'
        ]);
        $this->client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $this->assertResponseRedirects('/tasks');
        $this->client->followRedirect();
        $this->assertSelectorTextContains('div.alert.alert-success', 'Superbe ! La tâche a bien été modifiée.');
    }

    public function testEditActionWithBadCredentials()
    {
        $this->client = static::createClient();

        $this->databaseTool->loadFixtureFiles([TaskAttachedFixtures::class]);
        $task = self::getContainer()->get(TaskRepository::class)->find(1);
        $user = self::getContainer()->get(UserRepository::class)->find(1);

        $crawler = $this->client->request('GET', '/tasks/' . $task->getId() . '/edit');
        $form = $crawler->selectButton('Modifier')->form([
            'task[title]' => '',
            'task[content]' => ''
        ]);

        $this->client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('ul.list-unstyled', 'Vous devez saisir un titre.');
    }

    public function testEditActionOtherUser()
    {
        $this->client = static::createClient();

        $this->databaseTool->loadFixtureFiles([TaskAttachedFixtures::class]);
        $task = self::getContainer()->get(TaskRepository::class)->find(2);
        $user = self::getContainer()->get(UserRepository::class)->find(1);

        $crawler = $this->client->request('GET', '/tasks/' . $task->getId() . '/edit');

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testEditActionUserAnonymous()
    {
        $this->client = static::createClient();

        $this->databaseTool->loadFixtureFiles([TaskAttachedFixtures::class]);
        $task = self::getContainer()->get(TaskRepository::class)->find(3);
        $user = self::getContainer()->get(UserRepository::class)->find(1);

        $crawler = $this->client->request('GET', '/tasks/' . $task->getId() . '/edit');

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testcreateActionWithBadCredentials()
    {
        $this->client = static::createClient();

        $users = $this->databaseTool->loadFixtureFiles([
            UserFixtures::class,
            TaskFixtures::class
        ]);



        $crawler = $this->client->request('GET', '/tasks/create');
        $form = $crawler->selectButton('Ajouter')->form([
            'task[title]' => '',
            'task[content]' => ''
        ]);

        $this->client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('ul.list-unstyled', 'Vous devez saisir un titre.');
    }

    public function testcreateActionWithGoodCredentials()
    {
        $this->client = static::createClient();

        $users = $this->databaseTool->loadFixtureFiles([
            UserFixtures::class,
            TaskFixtures::class
        ]);



        $crawler = $this->client->request('GET', '/tasks/create');
        $form = $crawler->selectButton('Ajouter')->form([
            'task[title]' => 'test',
            'task[content]' => 'test'
        ]);

        $this->client->submit($form);

        $this->assertResponseRedirects('/tasks');
        $this->client->followRedirect();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('div.alert.alert-success', 'Superbe ! La tâche a été bien été ajoutée.');
    }

    public function testToggleTaskActionWithGoodCredentials()
    {
        $this->client = static::createClient();

        $this->databaseTool->loadFixtureFiles([TaskAttachedFixtures::class]);
        $task = self::getContainer()->get(TaskRepository::class)->find(1);
        $user = self::getContainer()->get(UserRepository::class)->find(1);


        $crawler = $this->client->request('GET', '/tasks/' . $task->getId() . '/toggle');

        $this->assertResponseRedirects('/tasks');
        $this->client->followRedirect();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('div.alert.alert-success', 'La tâche ' . $task->getTitle() . ' a bien été marquée comme faite.');
    }

    public function testToggleTaskActionOtherUser()
    {
        $this->client = static::createClient();

        $this->databaseTool->loadFixtureFiles([TaskAttachedFixtures::class]);
        $task = self::getContainer()->get(TaskRepository::class)->find(2);
        $user = self::getContainer()->get(UserRepository::class)->find(1);


        $crawler = $this->client->request('GET', '/tasks/' . $task->getId() . '/toggle');

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }


    public function testToggleTaskActionUserAnonymous()
    {
        $this->client = static::createClient();

        $this->databaseTool->loadFixtureFiles([TaskAttachedFixtures::class]);
        $task = self::getContainer()->get(TaskRepository::class)->find(3);
        $user = self::getContainer()->get(UserRepository::class)->find(1);


        $crawler = $this->client->request('GET', '/tasks/' . $task->getId() . '/toggle');

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testDeleteTaskActionWithGoodCredentials()
    {
        $this->client = static::createClient();

        $this->databaseTool->loadFixtureFiles([TaskAttachedFixtures::class]);
        $task = self::getContainer()->get(TaskRepository::class)->find(1);
        $user = self::getContainer()->get(UserRepository::class)->find(1);


        $crawler = $this->client->request('GET', '/tasks/' . $task->getId() . '/delete');

        $this->assertResponseRedirects('/tasks');
        $this->client->followRedirect();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('div.alert.alert-success', ' La tâche a bien été supprimée.');
    }

    public function testDeleteTaskActionOtherUser()
    {
        $this->client = static::createClient();

        $this->databaseTool->loadFixtureFiles([TaskAttachedFixtures::class]);
        $task = self::getContainer()->get(TaskRepository::class)->find(2);
        $user = self::getContainer()->get(UserRepository::class)->find(1);


        $crawler = $this->client->request('GET', '/tasks/' . $task->getId() . '/delete');

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testDeleteTaskActionUserAnonymous()
    {
        $this->client = static::createClient();

        $this->databaseTool->loadFixtureFiles([TaskAttachedFixtures::class]);
        $task = self::getContainer()->get(TaskRepository::class)->find(3);
        $user = self::getContainer()->get(UserRepository::class)->find(1);


        $crawler = $this->client->request('GET', '/tasks/' . $task->getId() . '/delete');

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }
}