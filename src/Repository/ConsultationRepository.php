<?php

namespace App\Repository;

use App\Entity\Consultation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Consultation>
 */
class ConsultationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Consultation::class);
    }

//    /**
//     * @return Consultation[] Returns an array of Consultation objects
//     */
    public function findConsultationsToday(): array
    {
        $today = new \DateTime('today');
        $tomorrow = new \DateTime('tomorrow');
        return $this->createQueryBuilder('c')
            ->andWhere('c.date >= :today')
            ->andWhere('c.date < :tomorrow')
            ->setParameter('today', $today->format('Y-m-d 00:00:00'))
            ->setParameter('tomorrow', $tomorrow->format('Y-m-d 00:00:00'))
            ->orderBy('c.date', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

//    public function findOneBySomeField($value): ?Consultation
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
