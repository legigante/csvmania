<?php

namespace App\Repository;

use App\Entity\Content;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Content|null find($id, $lockMode = null, $lockVersion = null)
 * @method Content|null findOneBy(array $criteria, array $orderBy = null)
 * @method Content[]    findAll()
 * @method Content[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Content::class);
    }



    /**
     * get next field to entry
     * @param $assignment_id
     * @return mixed
     */
    public function getNextEntry($assignment_id){
        $r = $this->createQueryBuilder('c')
            ->select('c')
            ->addSelect('COALESCE(c.id,0) AS cNull')
            ->innerJoin('c.task', 't')
            ->addSelect('t')
            ->innerJoin('t.assignments', 'a')
            ->addSelect('a')
            ->innerJoin('t.fields', 'f')
            ->addSelect('f')
            ->addSelect('COALESCE(f.id,0) AS fNull')
            ->innerJoin('f.feeling', 'fe')
            ->addSelect('fe')
            ->leftJoin('f.answers', 'an', 'WITH', 'an.content = c AND an.assignment = a')
            ->andWhere('an.id IS NULL')
            ->andWhere('a.id = :assingment_id')
            ->orderBy('cNull','ASC')
            ->addOrderBy('fNull','ASC')
            ->setParameter('assingment_id', $assignment_id)
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();


        if(!empty($r)){
            return $r[0];
        }else{
            return null;
        }

    }


}
