<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testGet()
    {
        $user = new User();

        $user->setUsername('test');
        $this->assertSame('test', $user->getUsername());
        $user->setEmail('test@gmail.com');
        $this->assertSame('test@gmail.com', $user->getEmail());
        $user->setPassword('test');
        $this->assertSame('test', $user->getPassword());

        $task = new Task();
        $user->eraseCredentials();
        $this->assertNull($user->getSalt());
        $this->assertInstanceOf(User::class, $user->addTask($task));
        $this->assertInstanceOf(Collection::class, $user->getTasks());
        $this->assertInstanceOf(User::class, $user->removeTask($task));

        $this->assertSame(['ROLE_USER'], $user->getRoles());
        $this->assertNull($user->setRoles(array('ROLE_ADMIN')));

    }

}