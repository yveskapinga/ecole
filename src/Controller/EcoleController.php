<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Cour;

class EcoleController extends AbstractController
{
    
    /**
    * @Route("/", name="home")
    */
    public function home(Request $request)
    {
        
        return $this->render('pages/home.html.twig',['nom'=>  'kamel']);
    }
    
    /**
    * @Route("/login", name="login")
    */
    public function login() 
    { 
        return $this->render('pages/login.html.twig',[]);
    }

     /**
    * @Route("/about", name="about")
    */
    public function about() 
    { 
        return $this->render('pages/about.html.twig');
    }

    /**
    * @Route("/matiers", name="matiers")
    */
    public function matiers() 
    {
       $repo = $this->getDoctrine()->getRepository(Cour::class);
       $cour = $repo->find(12);
        return $this->render('pages/matiers.html.twig');
    }
     /**
    * @Route("/equipe", name="equipe")
    */
    public function equipe() 
    {
       $repo = $this->getDoctrine()->getRepository(Cour::class);
       $cour = $repo->find(12);
        return $this->render('pages/equipe.html.twig');
    }
}
