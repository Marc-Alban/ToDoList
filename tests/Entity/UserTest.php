<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;
use Doctrine\Common\Collections\Collection;

class UserTest extends TestCase
{
    public function testGet(): void
    {
        $user = new User();

        $user->setUsername('test');
        $this->assertSame('test', $user->getUsername());
        $user->setEmail('test@gmail.com');
        $this->assertSame('test@gmail.com', $user->getEmail());
        $user->setPassword('test');
        $this->assertSame('test', $user->getPassword());

        $task = $this->createMock(Task::class);
        $task->method('getId')->willReturn(1);

        $user->eraseCredentials();
        $this->assertNull($user->getSalt());
        $this->assertInstanceOf(User::class, $user->addTask($task));
        $this->assertInstanceOf(Collection::class, $user->getTasks());
        $this->assertInstanceOf(User::class, $user->removeTask($task));

        $user->setRoles(['ROLE_ADMIN']);
        $this->assertSame(['ROLE_ADMIN'], $user->getRoles());
    }
}
