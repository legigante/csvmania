<?php

namespace App\Repository;

use App\Entity\Task;
use App\Entity\Assignment;
use App\Form\Type\TaskType;
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
     * trouve le nombre de tâche qu'il reste à piocher pour le user
     * @return int
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getNbTodoTasks($user_id){
        $qb = $this->createQueryBuilder('t')
            ->select('count(t.id)')
            ->andWhere('t.status = 0')
            ->andWhere('t.id NOT IN (SELECT a FROM App\Entity\Assignment a WHERE a.assigned_to = :user_id)')
            ->setParameter('user_id', $user_id)
            ->getQuery();

        return $qb->getSingleScalarResult();
    }

    /**
     * trouve la prochaine tâche à piocher pour le user
     * @param $user_id
     * @return Task|null
     */

    /**
     * @param $user_id
     * @param $nb nb tasks to return
     * @return array => [ [Task,nb_contents, nb_fields] , [...] ]
     */
    public function getNextTodoTasks($user_id, $nb){

        $r = $this->createQueryBuilder('t')
            ->select('t')
            ->innerJoin('t.contents', 'c')
            ->addSelect('COUNT(DISTINCT c.id) AS nb_contents')
            ->innerJoin('t.fields', 'f')
            ->addSelect('COUNT(DISTINCT f.id) AS nb_fields')
            ->andWhere('t.status = 0')
            ->andWhere('t.id NOT IN (SELECT a FROM App\Entity\Assignment a WHERE a.assigned_to = :user_id)')
            ->setParameter('user_id', $user_id)
            ->groupBy('t.id')
            ->setMaxResults($nb)
            ->getQuery()
            ->getResult();

        if($r[0][0] == null){
            return [];
        }else{
            return $r;
        }

    }











    /**
     *
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

        dump($qb);
        exit();

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
