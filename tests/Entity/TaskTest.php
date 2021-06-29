<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskTest extends WebTestCase
{
    public function testEntityTask()
    {
        $task = new Task();
        $task->setTitle('A title');
        $task->setContent('A great content!');
        $task->setCreatedAt(new \Datetime('2021-10-20'));
        $task->setIsDone(true);
        $user = new User();
        $task->setUser($user);

        $this->assertEquals('A title', $task->getTitle());
        $this->assertEquals('A great content!', $task->getContent());
        $this->assertEquals(new DateTime('2021-10-20'), $task->getCreatedAt());
        $this->assertTrue($task->getIsDone());
        $this->assertEquals($user, $task->getUser());
    }
}