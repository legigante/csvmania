<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends Controller
{

    /**
     * @Route("/tasks", name="tasks")
     * @return Response
     */
    public function index()
    {
        return $this->render('task/index.html.twig', array(

        ));
    }

}