<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Common\Collections\Collection;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTest extends WebTestCase
{
    const USERNAME = 'fatellim';
    const EMAIL = 'fatellim@prmaster.fr';
    const PASSWORD = 'password';
    const ROLES = ['ROLE_USER'];

    public function testGetterSetter(): void
    {
        $user = new User();

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals(null, $user->getId());
        $this->assertEquals(null, $user->getUsername());
        $this->assertEquals(null, $user->getEmail());
        $this->assertEquals(null, $user->getPassword());
        $this->assertInstanceOf(Collection::class, $user->getTasks());
        $this->assertEquals([], $user->getRoles());

        $user->setUsername(self::USERNAME);
        $this->assertEquals(self::USERNAME, $user->getUsername());
        $user->setEmail(self::EMAIL);
        $this->assertEquals(self::EMAIL, $user->getEmail());
        $user->setPassword(self::PASSWORD);
        $this->assertEquals(self::PASSWORD, $user->getPassword());
        $user->setRoles(self::ROLES);
        $this->assertEquals(self::ROLES, $user->getRoles());

        $task = new Task();
        $user->addTask($task);
        $this->assertCount(1, $user->getTasks());

        $user->removeTask($task);
        $this->assertCount(0, $user->getTasks());
    }
}