<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class MenuController extends Controller
{

    /**
     * @Route("/", name="home")
     * @param AuthorizationCheckerInterface $authChecker
     * @return Response
     */
    public function index (AuthorizationCheckerInterface $authChecker)
    {
        // home admin, home user ou formulaire de connexion
        if ($authChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin/tasks');
        }elseif ($authChecker->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('tasks');
        }else{
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @Route("/about", name="about")
     * @return Response
     */
    public function about ()
    {
        return $this->render('app/about.html.twig');
    }

}
