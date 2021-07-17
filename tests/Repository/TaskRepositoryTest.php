<?php

namespace App\Tests\Repository;

use App\DataFixtures\TaskFixtures;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;

class TaskRepositoryTest extends KernelTestCase
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

        $this->databaseTool->loadFixtures([TaskFixtures::class]);

        $users = self::getContainer()->get(TaskRepository::class)->count([]);

        $this->assertEquals(10, $users);
    }
}
