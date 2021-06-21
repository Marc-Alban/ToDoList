<?php

namespace App\Repository;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function findByIdUserAndIsDoneFalse(User $user): array
    {

        return $this->createQueryBuilder('t')
        ->andWhere('t.user = :val')
        ->setParameter('val', $user)
        ->andWhere('t.isDone = false')
        ->orderBy('t.id', 'ASC')
        ->getQuery()
        ->getResult()
        ;
    }



    public function findByIdUserAndIsDoneTrue(User $user): array
    {
        return $this->createQueryBuilder('t')
        ->andWhere('t.user = :val')
        ->setParameter('val', $user)
        ->andWhere('t.isDone = true')
        ->orderBy('t.id', 'ASC')
        ->getQuery()
        ->getResult()
        ;
    }
}
