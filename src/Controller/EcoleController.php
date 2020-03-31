<?php

namespace App\Controller;

use App\Entity\Cour;
use App\Entity\Matiere;
use App\Entity\Etudiant;
use App\Form\Type\EtudiantType;
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
    public function login(Request $req) 
    { 
        $kamel=$req->request->get('email');
        return $this->render('pages/login.html.twig',['kamel'=>$kamel]);
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
        $repo = $this->getDoctrine()->getRepository(Etudiant::class);
        $etudiants = $repo->findAll();
        dump($etudiants);
        $etudiant = new Etudiant();
        $form = $this->createForm(EtudiantType::class,$etudiant);
        $form->handleRequest($req);
        // si l'email existe deja je le renvoi au form sans l'enrigisterer
        // foreach($etudiants as $etudiant)
        // {
        //     if($etudiant.getEmail()==$req->request->get('email'))
        //     {
        //     return $this->render('pages/creerCompte.html.twig',[
        //         'form'=>$form->createView()
        //      ]);
        //     }
        // }
        if($form->isSubmitted() && $form->isValid() &&
         $req->request->get('confirmPassword')==$req->request->get('confirmPassword')){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($etudiant);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('pages/creerCompte.html.twig',[
           'form'=>$form->createView()
        ]);
    }
}
