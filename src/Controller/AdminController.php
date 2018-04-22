<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

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
        return $this->render('admin/index.html.twig', array(

        ));
    }

}