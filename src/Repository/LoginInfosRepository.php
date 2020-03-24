<?php

namespace App\Repository;

use App\Entity\LoginInfos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method LoginInfos|null find($id, $lockMode = null, $lockVersion = null)
 * @method LoginInfos|null findOneBy(array $criteria, array $orderBy = null)
 * @method LoginInfos[]    findAll()
 * @method LoginInfos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LoginInfosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LoginInfos::class);
    }

    // /**
    //  * @return LoginInfos[] Returns an array of LoginInfos objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LoginInfos
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
