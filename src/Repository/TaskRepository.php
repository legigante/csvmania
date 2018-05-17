<?php

namespace App\Repository;

use Doctrine\ORM\Query\ResultSetMapping;

use App\Entity\Task;
use App\Entity\Token;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Task::class);
    }


    /**
     * @param $user_id
     * @return array
     */
    public function getToDoTasks($user_id): array{

        $qb = $this->createQueryBuilder('t')
            ->andWhere('t.assigned_to = :user_id')
            ->setParameter('user_id', $user_id)
            ->getQuery();

        return $qb->execute();
    }

    /**
     * @param $user_id
     * @return array
     */
    public function getToValidateTasks($user_id): array{

        $qb = $this->createQueryBuilder('t')
            ->andWhere('t.validated_by = :user_id')
            ->setParameter('user_id', $user_id)
            ->getQuery();

        return $qb->execute();
    }





    /**
     * @param $id
     * @return array
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getTaskProgressionDone($id): array
    {
        $qb = $this->createQueryBuilder('ta')
            ->select('count(to.id)')
            ->innerJoin('ta.tokens','to')
            ->andWhere('ta.id = :id')
            ->andWhere('to.done_at IS NOT NULL')
            ->setParameter('id', $id)
            ->setMaxResults(1)
            ->getQuery();

        return $qb->getSingleResult();
    }


    /**
     * @param $id
     * @return array
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getTaskProgressionValidated($id): array{
        $qb = $this->createQueryBuilder('ta')
            ->select('count(to.id)')
            ->innerJoin('ta.tokens','to')
            ->andWhere('ta.id = :id')
            ->andWhere('to.validated_at IS NOT NULL')
            ->setParameter('id', $id)
            ->getQuery();

        return $qb->getSingleResult();
    }

}
