<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

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
     * @return Response
     */
    public function tasks()
    {

        // Tasks repository
        $rep = $this->getDoctrine()->getRepository(Task::class);

        // tâche en cours prog bar (x/x piochée) (x/x saisie)
        // possibilité changer priorité

        // get assigned tasks done (if admin)
        $toValidateTasks = [];
        if ($authChecker->isGranted('ROLE_ADMIN')) {
            //$toValidateTasks = $rep->getToValidateTasks($user->getId());
        }

        return $this->render('admin/index.html.twig', array(

        ));
    }

}