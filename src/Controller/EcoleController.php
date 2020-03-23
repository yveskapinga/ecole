<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Cour;
class EcoleController extends AbstractController
{
    
    /**
    * @Route("/", name="home")
    */
    public function home()
    {
        $nom = 'kamel';
        return $this->render('pages/home.html.twig');
    }
    
    /**
    * @Route("/login", name="login")
    */
    public function login() 
    { 
        return $this->render('pages/login.html.twig');
    }

    /**
    * @Route("/cours", name="cours")
    */
    public function cours() 
    {
       $repo = $this->getDoctrine()->getRepository(Cour::class);
       $cour = $repo->find(12);
        return $this->render('pages/cours.html.twig');
    }
}
