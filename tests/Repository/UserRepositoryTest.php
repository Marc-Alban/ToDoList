<?php


namespace App\Tests\Repository;


use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
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

    public function testUserRepo(): void
    {
        $repo = $this->entityManager->getRepository(User::class);
        $this->assertInstanceOf(UserRepository::class, $repo);
    }
}