<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findByCategories(array $categories): array
    {
        return $this->createQueryBuilder('u')
            ->innerJoin('u.categories', 'c')
            ->where('c IN (:categories)')
            ->setParameter('categories', $categories)
            ->getQuery()
            ->getResult();
    }
}
