<?php


namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    public function testGet()
    {
        $task = new Task();
        $this->assertInstanceOf(Task::class, new Task());
        $task->setTitle('test');
        $title = $task->getTitle();
        $this->assertInstanceOf(\DateTime::class, $task->getCreatedAt());
        $task->setCreatedAt(new \DateTime('2011-01-01T15:03:01.012345Z'));
        $date=new \DateTime('2011-01-01T15:03:01.012345Z');
        $this->assertEquals($date, $task->getCreatedAt());
        $this->assertSame('test', $title);
        $task->setContent('test');
        $content = $task->getContent();
        $this->assertSame('test', $content);
        $this->assertSame(false, $task->getIsDone());
        $this->assertInstanceOf(Task::class, $task->setIsDone(false));
        $this->assertInstanceOf(Task::class, $task->setUser(new User()));
        $this->assertInstanceOf(User::class, $task->getUser());
    }
}