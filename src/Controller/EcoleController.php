<?php
namespace App\Controller;

use App\Entity\Matiere;
use App\Entity\Etudiant;
use App\Form\Type\EtudiantType;
use App\Repository\CourRepository;
use App\Repository\MatiereRepository;
use App\Repository\EtudiantRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EcoleController extends AbstractController
{

    /**
    * @Route("/", name="home")
    */
    public function home(Request $req)
    {    
        return $this->render('pages/home.html.twig',['user'=>$this->get('session')->get('user')]);
    }
    
    /**
    * @Route("/login", name="login")
    */
    public function login(Request $req,EtudiantRepository $repo) 
    { 
       
        $etudiants = $repo->findAll();
        $email=$req->request->get('email');
        $password=$req->request->get('password');
        if(count($etudiants)>0)foreach($etudiants as $etu)
        {
            if($etu->getEmail()==$email && password_verify($password,$etu->getPassword()))
            {
                $this->get('session')->set('user', $etu);
                return $this->redirectToRoute('home');
            }
         }
        return $this->render('pages/login.html.twig',['user'=>$this->get('session')->get('user')]);
    }

     /**
    * @Route("/deconexion", name="deconexion")
    */
    public function deconexion(Request $req) 
    { 
        $this->get('session')->set('user', null);
        return $this->redirectToRoute('home');
    }

     /**
    * @Route("/about", name="about")
    */
    public function about() 
    { 
        return $this->render('pages/about.html.twig',['user'=>$this->get('session')->get('user')]);
    }
    
    /**
    * @Route("/matiers", name="matiers")
    */
    public function matiers(MatiereRepository $repo) 
    {
        $matieres = $repo->findAllOrderById();
        return $this->render('pages/matiers.html.twig',[
            'matieres'=>$matieres,
            'user'=>$this->get('session')->get('user')
        ]);
    }

    /**
    * @Route("/matiers/{id}", name="cour")
    */
    public function cour($id,CourRepository $repoCour,MatiereRepository $repoMatiere) 
    {
        // a revoir
        try{
            $cours = $repoCour->findByMatiere($id);
            $matier = $repoMatiere->findOneById($id);
            return $this->render('pages/cours.html.twig',[
                'cours'=>$cours,
                'matiere'=>$matier,
                'user'=>$this->get('session')->get('user')
                ]);
        }catch (DriverException $e){
            return $this->redirectToRoute('matiers');
        }
    }

     /**
    * @Route("/equipe", name="equipe")
    */
    public function equipe() 
    {
        return $this->render('pages/equipe.html.twig',['user'=>$this->get('session')->get('user')]);
    }

     /**
    * @Route("/creerCompte", name="creerCompte")
    */
    public function creerCompte(Request $req,EtudiantRepository $repo) 
    {
        $etudiants = $repo->findAll();
        $etudiant = new Etudiant();
        $form = $this->createForm(EtudiantType::class,$etudiant);
        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid() &&
         $req->request->get('confirmPassword')==$etudiant->getPassword())
         {
            if(count($etudiants)>0)foreach($etudiants as $etu)
            {
                if($etu->getEmail()==$etudiant->getEmail())
                    return $this->redirectToRoute('creerCompte');
             }
            $entityManager = $this->getDoctrine()->getManager();
            //hashage de mot de passe 
            $etudiant->setPassword(password_hash($etudiant->getPassword(), PASSWORD_DEFAULT));
            //si tout va bien je enrigitre dans la table etudiant 
            $entityManager->persist($etudiant);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('pages/creerCompte.html.twig',[
           'form'=>$form->createView(),
           'user'=>$this->get('session')->get('user')
        ]);
    }
}
