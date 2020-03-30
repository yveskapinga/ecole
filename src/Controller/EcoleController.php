<?php

namespace App\Controller;

use App\Form\Type\EtudiantType;
use App\Entity\Cour;
use App\Entity\Matiere;
use App\Entity\Etudiant;
use App\Repository\MatiereRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EcoleController extends AbstractController
{
    
    /**
    * @Route("/", name="home")
    */
    public function home(Request $request)
    {
        return $this->render('pages/home.html.twig',['nom'=>  '']);
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
        $matieres = $repo->findAllOrderById();
        return $this->render('pages/matiers.html.twig',['controller_name'=>'EcoleController','matieres'=>$matieres
        ]);
    }

    /**
    * @Route("/matiers/{id}", name="cour")
    */
    public function cour($id) 
    {
        // a revoir
        try{
            $repo1 = $this->getDoctrine()->getRepository(Cour::class);
            $repo2 = $this->getDoctrine()->getRepository(Matiere::class);
            $cours = $repo1->findByMatiere($id);
            $matiers = $repo2->findOneById($id);
            return $this->render('pages/cours.html.twig',['cours'=>$cours,'matiere'=>$matiers]);
        }catch (DriverException $e){
            return $this->redirectToRoute('matiere');
        }
    }

     /**
    * @Route("/equipe", name="equipe")
    */
    public function equipe() 
    {
       
        return $this->render('pages/equipe.html.twig');
    }

     /**
    * @Route("/creerCompte", name="creerCompte")
    */
    public function creerCompte(Request $req) 
    {
        $etudiant = new Etudiant();
        $etudiant->setDateDeNaissance(new \DateTime('NOW'));
        $form = $this->createForm(EtudiantType::class,$etudiant);

        $entityManager = $this->getDoctrine()->getManager();
        // $entityManager->persist($etudiant);
        // $entityManager->flush();
        return $this->render('pages/creerCompte.html.twig',[
           'kamel'=>$form->createView()
        ]);
    }
}
