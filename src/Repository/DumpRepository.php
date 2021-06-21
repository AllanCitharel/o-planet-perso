<?php

namespace App\Repository;

use App\Entity\Dump;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Dump|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dump|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dump[]    findAll()
 * @method Dump[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DumpRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dump::class);
    }

    // /**
    //  * @return Dump[] Returns an array of Dump objects
    //  */
    
    public function findAllByCreationDateDesc($order = 'DESC')
    {
        return $this->createQueryBuilder('d')
            ->orderBy('d.createdAt', $order)
            // ->setParameters(['1' => $order])
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOpenedDumps()
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.isClosed = 0')
            ->orderBy('d.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
    
    
    public function findCleanedDumps()
    {

        /*
        SELECT COUNT(*) FROM `dump`
        LEFT JOIN `removal` ON `dump`.`id` = `removal`.`dump_id`
        WHERE `dump`.`is_closed` = 1 AND  `removal`.`is_finished` = 1;
        */

        return $this->createQueryBuilder('d')
            ->add('select', 'd')
            ->andWhere('d.isClosed = 1')
            ->orderBy('d.title', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function findDumpsWithGetParameters($LongitudeCoordinates, $latitudeCoordinates, $emergency, $wasteIds)
    {

        // $LongitudeCoordinateMin = -179.9, $LongitudeCoordinateMax = 179.9, $latitudeCoordinateMin = -85.99, $latitudeCoordinateMax = 85.99
        /*
    SELECT * FROM  `dump`
WHERE `longitude_coordinate` > 12.3 
AND  `longitude_coordinate` <  123.6 
AND `latitude_Coordinate` > 12.3
AND  `latitude_Coordinate` <  123.6 ;


SELECT COUNT(*) FROM  `dump_waste`
WHERE `dump_waste`.`waste_id` = 1 OR `dump_waste`.`waste_id` =  3;
        */

        $qb = $this->createQueryBuilder('d');

        $qb->add('select', 'd');
        
        if($wasteIds){

            $qb->leftJoin('d.wastes', 'w')
                ->addSelect('w');

            foreach($wasteIds as $wasteId){

                $qb->orWhere($qb->expr()->eq('w.id', $wasteId));

            }
        }

        $setParameters = [];

        if($emergency){
            $qb->andWhere('d.emergency = :emergencyId');
            $setParameters['emergencyId'] = $emergency;
         }


        if($LongitudeCoordinates && $latitudeCoordinates){

                $qb->andWhere('d.longitudeCoordinate >= :LongitudeCoordinateMin')
                ->andWhere('d.longitudeCoordinate <= :LongitudeCoordinateMax')
                ->andWhere('d.latitudeCoordinate >= :latitudeCoordinateMin')
                ->andWhere('d.latitudeCoordinate <= :latitudeCoordinateMax');

                $setParameters['LongitudeCoordinateMin'] = $LongitudeCoordinates[0];
                $setParameters['LongitudeCoordinateMax'] = $LongitudeCoordinates[1];
                $setParameters['latitudeCoordinateMin'] = $latitudeCoordinates[0];
                $setParameters['latitudeCoordinateMax'] = $latitudeCoordinates[1];
        }

        return $qb->setParameters($setParameters)
            ->orderBy('d.title', 'ASC')
            ->getQuery()
            ->getResult()
        ;

    }
    
    public function findDumpsByWaste($wasteIds)
    {
        $qb = $this->createQueryBuilder('d');

        $qb->leftJoin('d.wastes', 'w')
            ->addSelect('w');

        foreach($wasteIds as $wasteId){

            $qb->orWhere($qb->expr()->eq('w.id', $wasteId));

        }

        return $qb->orderBy('d.createdAt', 'DESC')
                ->getQuery()
                ->getResult()
                ;
    }

    /*
    public function findOneBySomeField($value): ?Dump
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
