<?php

namespace App\Tests\Repository;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskRepositoryTest extends KernelTestCase
{
   /**
     * @var \Doctrine\ORM\EntityManager
     */
    private EntityManager $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testTaskrepo(): void
    {
        $repo = $this->entityManager->getRepository(Task::class);
        $this->assertInstanceOf(TaskRepository::class, $repo);
    }
}