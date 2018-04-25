<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class SecurityController extends Controller
{

    /**
     * @Method("get")
     * @Route("/login", name="login")
     * @param AuthenticationUtils $authenticationUtils
     * @param AuthorizationCheckerInterface $authChecker
     * @return Response
     */
    public function loginAction(AuthorizationCheckerInterface $authChecker, AuthenticationUtils $authenticationUtils)
    {
        // si déjà authentifié => home
        if ($authChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('home');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        // formulaire de connexion
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
