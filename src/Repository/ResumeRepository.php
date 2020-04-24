<?php

namespace App\Repository;

use App\Entity\Resume;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ResumeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Resume::class);
    }

     /**
      * @return User[] Returns an array of User objects
    */
    public function findById($id)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.user = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
        ;
    }


}
