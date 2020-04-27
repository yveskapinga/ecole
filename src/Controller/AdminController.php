<?php

namespace App\Controller;

use DateTime;
use App\Entity\Cour;
use App\Entity\Admin;
use App\Form\CourType;
use App\Entity\Matiere;
use App\Entity\Enseigne;
use App\Entity\Promotion;
use App\Entity\Enseignant;
use App\Form\EnseignantType;
use App\Repository\AdminRepository;
use App\Repository\MatiereRepository;
use App\Repository\EnseigneRepository;
use App\Repository\EtudiantRepository;
use App\Repository\PromotionRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/***controller administaration****/
class AdminController extends AbstractController
{
    /***************************************************administartion etudiant************************************************/
    /**
     * @Route("/adminEtudiant", name="adminEtudiant")
     */
    public function adminEtudiant(EtudiantRepository $repo)
    {
        $etudiants = $repo->findAll();
        return $this->render('admin/adminEtudiant.html.twig', [
            'etudiants' => $etudiants
        ]);
    }

    /**
     * @Route("/adminEtudiant{id}", name="FicheEtudiant")
     */
    public function ficheEtudiant(int $id, EtudiantRepository $repo, Request $req,PromotionRepository $repoPromotion)
    {
        // je selection l'etudiant par son id
        $etudiant = $repo->find($id);
        if ($req->isMethod('post')) {
            $etudiant->setNom($req->request->get('nom'));
            $etudiant->setPrenom($req->request->get('prenom'));
            $etudiant->setEmail($req->request->get('email'));
            $etudiant->setAdresses($req->request->get('adresses'));
            $etudiant->setDateDeNaissance(new \DateTime($req->request->get('dateNaissance')));
            $etudiant->setPromotion($repoPromotion->find($req->request->get('promotion')));
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($etudiant);
        $entityManager->flush();
        return $this->render('admin/ficheEtudiant.html.twig', [
            'etudiant' => $etudiant
        ]);
    }
    /**
    * @Route("/adminAjoutAbscence",name="ajoutAbscence")
    */
    public function ajoutAbscence()
    {
        //todo
    }
   
    /*********************************************************fin administartion etudiant*****************************************/

    /**********************************************************administartion enseignant***************************************************/
    /**
     * @Route("ajoutEnseignant", name="ajoutEnseignant")
     */
    public function ajoutEnseignant(UserPasswordEncoderInterface $passwordEncoder, Request $req)
    {
        //on instancie l'entitie Enseignant
        $enseignant = new Admin();
        // je cree l'objet formulaire
        $form = $this->createForm(EnseignantType::class, $enseignant);
        //je recupere les donnée saisie
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            //ici le formulaire a été envoyer et les donnée sont valide
            $enseignant->setPassword($req->request->get('password'));
            $enseignant->setPassword($passwordEncoder->encodePassword(
                $enseignant,
                $enseignant->getPassword()
            ));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($enseignant);
            $entityManager->flush();
            return $this->render('admin/confirmation.html.twig');
        }
        return $this->render('admin/ajoutEnseignant.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /*************fin administartion enseignant*************/

    /********************************************administartion matiere*******************************************/
    /**
     * @Route("/adminMatiere", name="adminMatiere")
     */
    public function adminMatiere(Request $req, PaginatorInterface $paginator, MatiereRepository $repo)
    {
        $donnees = $repo->findAll();
        $matieres = $paginator->paginate(
            $donnees, //on passe les donner
            $req->query->getInt('page', 1), // numero de la page en cours ,par default 1
            6 // le nombre d'element par page
        );
        return $this->render('admin/adminMatiere.html.twig', [
            'matieres' => $matieres
        ]);
    }
    /**
    * @Route("/adminAjoutCours/{id}",name="ajoutCours")
    */
    public function ajoutCours($id,Request $req)
    {
        $cour = new Cour();
        // je cree l'objet formulaire
        $form = $this->createForm(CourType::class, $cour);
        //je recupere les donnée saisie
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            //ici le formulaire a été envoyer et les donnée sont valide
          
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cour);
            $entityManager->flush();
            return $this->render('admin/confirmation.html.twig');
        }
        return $this->render('admin/superAdmin/ajoutCour.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /*************fin administartion matiere*************/
}
