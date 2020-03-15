<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EcoleController extends AbstractController
{
    
    /**
     * @Route("/", name="ecole")
     */
    public function home()
    {
        return $this->render('pages/home.html.twig');
    }
    /**
     * @Route("/login", name="login")
     */
    public function login() 
    {
       
        return $this->render('pages/login.html.twig');
    }
}
