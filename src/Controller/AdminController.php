<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Matiere;
use App\Entity\Enseigne;
use App\Entity\Enseignant;
use App\Form\EnseignantType;
use App\Repository\AdminRepository;
use App\Repository\MatiereRepository;
use App\Repository\EnseigneRepository;
use App\Repository\EtudiantRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface ;

class AdminController extends AbstractController
{
    
    /**
    * @Route("/adminEtudiant", name="adminEtudiant")
    */
    public function adminEtudiant(EtudiantRepository $repo)
    {
        $etudiants = $repo->findAll();
        return $this->render('admin/adminEtudiant.html.twig', [
            'etudiants'=>$etudiants
        ]);
    }
    /**
    * @Route("/superAdmin/inscriptionEtudiant/{id}", name="inscriptionEtudiant")
    */
    public function inscriptionEtudiant(int $id,EtudiantRepository $repo)
    {     
        // je selection l'etudiant par son id et je change sont statut inscription a true ou false et je le save dans la base
            $etudiant = $repo->find($id);
            $etudiant->setInscrit(!$etudiant->getInscrit());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($etudiant);
            $entityManager->flush();
            return $this->redirectToRoute('FicheEtudiant' ,['id' =>$etudiant->getId()]);


    }

     /**
    * @Route("/superAdmin/supressionEtudiant/{id}", name="supressionEtudiant")
    */
    public function supressionEtudiant(int $id,EtudiantRepository $repo)
    {     
        // je selection l'etudiant par son id et je le suprime definitivement de la base
            $etudiant = $repo->find($id); 
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($etudiant);
            $entityManager->flush();
            return $this->redirectToRoute('adminEtudiant');


    }
    /**
    * @Route("/adminEtudiant{id}", name="FicheEtudiant")
    */
    public function ficheEtudiant(int $id,Request $req,EtudiantRepository $repo)
    {
        // je selection l'etudiant par son id
        $etudiant = $repo->find($id);
        /*
          ici je vais traiter les donner envoyer sur l'etudiant par l'admin
         */
        return $this->render('admin/ficheEtudiant.html.twig', [
            'etudiant'=>$etudiant
        ]);
    }

     /**
     * @Route("superAdmin/adminEnseignant", name="adminEnseignant")
     */
    public function adminEnseignant(AdminRepository $repo)
    {
        $enseignants = $repo->findAll();
        return $this->render('admin/superAdmin/adminEnseignant.html.twig', [
            'enseignants'=>$enseignants
        ]);
    }
     /**
     * @Route("ajoutEnseignant", name="ajoutEnseignant")
     */
    public function ajoutEnseignant(UserPasswordEncoderInterface $passwordEncoder,Request $req,AdminRepository $repo)
    {
        //on instancie l'entitie Enseignant
        $enseignant = new Admin();
        // je cree l'objet formulaire
        $form = $this->createForm(EnseignantType::class,$enseignant);
        //je recupere les donnée saisie
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid())
        {
            //ici le formulaire a été envoyer et les donnée sont valide
            $enseignant->setPassword($passwordEncoder->encodePassword(
                $enseignant,
                $enseignant->getPassword()
            ));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($enseignant);
            $entityManager->flush();

        }
        return $this->render('admin/ajoutEnseignant.html.twig', [
            'form'=>$form->createView()
        ]);
    }
     /**
     * @Route("superAdmin/ajoutMatiere", name="ajoutMatiere")
     */
    public function ajoutMatiere(Request $req,MatiereRepository $repoMatiere,EnseigneRepository $repoEnseigne)
    {   
        $enseigne = new Enseigne();
        $matiere = null;
        $entityManager = $this->getDoctrine()->getManager();
        if($req->request->count() > 0){
            $enseignes=$repoEnseigne->findAll();
            foreach($enseignes as $el)
                if($req->request->get('enseigne') == $el->getId())
                {
                    $matiere = new Matiere;
                    $matiere->setNom($req->request->get('nom'));
                    $matiere->setEnseigne($el);
                    $entityManager->persist($matiere);
                    $entityManager->flush();
                break;
                }
            
            }
        return $this->render('admin/superAdmin/ajoutMatiere.html.twig', [
        'matiere'=>$matiere,
        ]);
    }
    /**
    * @Route("/adminMatiere", name="adminMatiere")
    */
    public function adminMatiere(MatiereRepository $repo)
    {
        $matieres = $repo->findAll();
        return $this->render('admin/adminMatiere.html.twig', [
            'matieres'=>$matieres
        ]);
    }
}
