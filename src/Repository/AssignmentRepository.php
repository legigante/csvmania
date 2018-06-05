<?php

namespace App\Repository;

use App\Entity\Assignment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Assignment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Assignment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Assignment[]    findAll()
 * @method Assignment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssignmentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Assignment::class);
    }





    /**
     * trouve les tâches/assignment en cours de saisie par le user + comptes pour progression
     * @param $user_id
     * @return array => [ [Task with Assignments, nb_answers, nb_contents, nb_fields], [...] ]
     */
    public function getOngoingAssignments($user_id){

        $qb = $this->createQueryBuilder('a')
            ->innerJoin('a.task', 't')
            ->addSelect('t')
            ->leftJoin('a.answers', 'w')
            ->addSelect('COUNT(DISTINCT w.id) AS nb_answers')
            ->innerJoin('t.contents', 'c')
            ->addSelect('COUNT(DISTINCT c.id) AS nb_contents')
            ->innerJoin('t.fields', 'f')
            ->addSelect('COUNT(DISTINCT f.id) AS nb_fields')
            ->where('a.status = 0')
            ->andWhere('a.assigned_to = :user_id')
            ->setParameter(':user_id', $user_id)
            ->groupBy('a.id')
            ->orderBy('t.priority', 'ASC')
            ->addOrderBy('t.deadline', 'ASC')
            ->addOrderBy('t.created_at', 'ASC')
            ->getQuery();
        return $qb->getResult();

    }











    /**
     * check if the task $task_id is already assigned to user $user_id
     * @param $task_id
     * @param $user_id
     * @return bool
     */
    public function isAlreadyAssigned($task_id, $user_id){

        $qb = $this->createQueryBuilder('a')
            ->select('count(a.id) AS cpt')
            ->andWhere('a.task = :task_id')
            ->andWhere('a.assigned_to = :user_id')
            ->setParameter('task_id', $task_id)
            ->setParameter('user_id', $user_id)
            ->getQuery();

        return $qb->getScalarResult()[0]['cpt'] != 0;
    }


    /**
     * get next field to entry
     * @param $assignment_id
     * @return mixed
     */
    public function getNextEntry($assignment_id){
        $qb = $this->createQueryBuilder('a')
            ->select('a.id AS assignment_id, c.id AS content_id, f.id AS field_id, fe.id AS feeling_id, c.message, fe.label, fe.format')
            ->innerJoin('a.task', 't')
            ->innerJoin('t.fields', 'f')
            ->innerJoin('f.feeling', 'fe')
            ->innerJoin('t.contents', 'c')
            ->leftJoin('f.answers', 'an')
            ->andWhere('an.id IS NULL')
            ->andWhere('a.id = :assingment_id')
            ->addOrderBy('f.id','ASC')
            ->addOrderBy('c.id','ASC')
            ->setParameter('assingment_id', $assignment_id)
            ->setMaxResults(1)
            ->getQuery();

        return $qb->getResult();
    }



}
