<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\DBAL\Driver\Connection;

use App\Entity\Assignment;
use App\Entity\Task;

class AdminController extends Controller
{

    /**
     * @Route("/admin", name="admin")
     * @return Response
     */
    public function index()
    {
        return $this->redirectToRoute('admin/tasks');
    }


    /**
     * @Route("/admin/tasks", name="admin/tasks")
     * @param Connection $connection
     * @return Response
     */
    public function tasks(Connection $connection)
    {

        $icones = [
            'text-info',
            'text-warning',
            'text-success'
        ];

        $data = $connection->fetchAll('SELECT assignment.id, COUNT(1) AS nb_answers FROM assignment INNER JOIN answer ON assignment.id = answer.assignment_id GROUP BY assignment.id');
        $nbAnswers = [];
        foreach ($data as $row){
            $nbAnswers[$row['id']] = $row['nb_answers'];
        }
        unset($data);

        // Tasks repository
        $repTask = $this->getDoctrine()->getRepository(Task::class);
        $dashboardList = $repTask->getDashboard(10);

        return $this->render('admin/index.html.twig', array(
            'icones' => $icones,
            'dashboardList' => $dashboardList,
            'nbAsnwer' => $nbAnswers
        ));
    }

}