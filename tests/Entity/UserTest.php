<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTest extends WebTestCase
{
    use FixturesTrait;

    public function testEntityUser()
    {

        // $user = new User();
        // $user->setUserName('Jean-Paul');
        // $user->setPassword('password');
        // $this->assertNull($user->getSalt());
        // $this->assertNull($user->eraseCredentials());
        // $user->setEmail('name@name.fr');
        // $user->setRoles(['ROLE_USER']);

        // // $tasks = new Task();
        // // $tasks->setTitle('A title');
        // // $tasks->setContent('A great content!');
        // // $tasks->setCreatedAt(new \Datetime('2021-10-20'));
        // // $tasks->setIsDone(true);

        // $user->addTask($tasks);
        //  $this->assertCount(1, $user->getTasks());
        // // $user->removeTask($task);
        //  $this->assertCount(0, $user->getTasks());
    }
}
