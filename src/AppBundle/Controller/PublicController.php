<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class PublicController extends Controller
{
    /**
     * @Route("/home")
     */
    public function homeAction()
    {
        return $this->render('public/home.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request, AuthenticationUtils $authUtils)
    {
      // get the login error if there is one
      $error = $authUtils->getLastAuthenticationError();

      // last username entered by the user
      $lastUsername = $authUtils->getLastUsername();

      return $this->render('public/login.html.twig', array(
          'last_username' => $lastUsername,
          'error'         => $error,
      ));

    }

}
