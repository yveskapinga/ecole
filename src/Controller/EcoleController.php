<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Matiere;
use App\Entity\Cour;
use App\Repository\MatiereRepository;

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
    /*dans cette fonction je vais recupere le repository de Matiere via le service Container de symfony*/
    public function matiers(MatiereRepository $repo) 
    {
       /*
        plus besoin de cette ligne
        $repo = $this->getDoctrine()->getRepository(Matiere::class);
       */
       $matieres = $repo->findAll();
        return $this->render('pages/matiers.html.twig',['controller_name'=>'EcoleController','matieres'=>$matieres
        ]);
    }

    /**
    * @Route("/matiers/{id}", name="cour")
    */
    public function cour($id) 
    {
       $repo1 = $this->getDoctrine()->getRepository(Cour::class);
       $repo2 = $this->getDoctrine()->getRepository(Matiere::class);
       $cours = $repo1->findByMatiere($id);
       $matiers = $repo2->findOneById($id);
        return $this->render('pages/cours.html.twig',['cours'=>$cours,'matiere'=>$matiers]);
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
