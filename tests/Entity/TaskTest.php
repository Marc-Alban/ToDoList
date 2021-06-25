<?php


namespace App\Tests\Entity;


use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskTest extends WebTestCase
{
    private $task;
    private $user;

    public function setUp(): void
    {
        $this->task = new Task();
        $this->user = new User();
    }

    public function testId(): void
    {
        $this->assertNotNull($this->task->getId());
    }

    public function testTitle()
    {
        $this->task->setTitle('title');
        $this->assertSame('title', $this->task->getTitle());
    }

    public function testContent()
    {
        $this->task->setContent('content');
        $this->assertSame('content', $this->task->getContent());
    }

    public function testIsDone()
    {
        $this->task->setIsDone(true);
        $this->assertSame(true, $this->task->getIsDone());
    }

    public function testCreatedAt()
    {
        $date = new \DateTime();
        $this->task->setCreatedAt($date);
        $this->assertSame($date, $this->task->getCreatedAt());
    }

    public function testUser()
    {
        $this->assertInstanceOf($this->user, $this->task->getUser());
    }

}