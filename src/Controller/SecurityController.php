<?php
namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class SecurityController extends Controller
{

    /**
     * @Route("/")
     * @return Response
     */
    public function index (AuthorizationCheckerInterface $authChecker)
    {

        if ($authChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin/tasks');
        }elseif ($authChecker->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('tasks');
        }else{
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @Method("get")
     * @Route("/login", name="login")
     */
    public function loginAction(AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    /**
     * @Method("post")
     * @Route("/login", name="login_check")
     */
    public function loginCheckAction()
    {
        // tout se passe dans l'interface
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        // tout se passe dans l'interface
    }

}
