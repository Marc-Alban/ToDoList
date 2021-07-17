<?php

namespace App\Tests\Repository;

use App\DataFixtures\UserFixtures;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;

class UserRepositoryTest extends KernelTestCase
{


    /** @var AbstractDatabaseTool */
    protected $databaseTool;

    public function setUp(): void
    {
        parent::setUp();
        $this->databaseTool = self::getContainer()->get(DatabaseToolCollection::class)->get();
    }

    /**
     * test count database entry
     *
     * @return void
     */
    public function testCount(): void
    {
        self::bootKernel();

        $this->databaseTool->loadFixtures([UserFixtures::class]);

        $users = self::getContainer()->get(UserRepository::class)->count([]);

        $this->assertEquals(10, $users);
    }
}
