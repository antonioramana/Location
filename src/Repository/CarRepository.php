<?php

namespace App\Repository;

use App\classes\Search;
use App\Entity\Car;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Car>
 *
 * @method Car|null find($id, $lockMode = null, $lockVersion = null)
 * @method Car|null findOneBy(array $criteria, array $orderBy = null)
 * @method Car[]    findAll()
 * @method Car[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }
    /**
     * Fonction  de recherche par type de voiture
     * @return Car[] 
     */
    public function findWidthSearch(Search $search){
        $query=$this
        ->createQueryBuilder("c")
        ->select("t","c")
        ->join("c.type","t");
        if(!empty($search->type)){
            $query=$query
            ->andWhere("t.id IN (:type)")
            ->setParameter("type",$search->type);
        }
        if(!empty($search->string)){
            $query=$query
            ->andWhere("c.mark LIKE :string")
            ->setParameter("string","%{$search->string}%");
        }
        return $query->getQuery()->getResult();
    }
    /**
     * Fonction  de recherche par type de voiture
     * @return Car[] 
     */
    public function findAdvanced($mark,$type,$vintage,$climatisation,$toi_ouvrant,$decapotable){
        $query=$this
        ->createQueryBuilder("c")
        ->select("t","c")
        ->join("c.type","t");
        if(!empty($type)){
            $query=$query
            ->andWhere("t.id IN (:type)")
            ->setParameter("type",$type);
        }
        if(!empty($mark)){
            $query=$query
            ->andWhere("c.mark LIKE :mark")
            ->setParameter("mark","%{$mark}%");
        }
        if(!empty($search->vintage)){
            $query=$query
            ->andWhere("c.vintage = :vintage")
            ->setParameter("vintage",$vintage);
        }
        if(!empty($climatisation)){
            $query=$query
            ->andWhere("c.climatisation = :climatisation")
            ->setParameter("climatisation",$climatisation);
        }
        if(!empty($decapotable)){
            $query=$query
            ->andWhere("c.decapotable = :decapotable")
            ->setParameter("decapotable",$decapotable);
        }
        if(!empty($toit_ouvrant)){
            $query=$query
            ->andWhere("c.toit_ouvrant = :toit_ouvrant")
            ->setParameter("toit_ouvrant",$toit_ouvrant);
        }
        
        return $query->getQuery()->getResult();
    }


    public function save(Car $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Car $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Car[] Returns an array of Car objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Car
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
