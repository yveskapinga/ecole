<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Matiere;
use App\Entity\Enseigne;
use App\Entity\Enseignant;
use App\Form\EnseignantType;
use App\Repository\AdminRepository;
use App\Repository\MatiereRepository;
use App\Repository\EtudiantRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface ;

class AdminController extends AbstractController
{
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
        $enseignant->setRoles(array('ROLE_USER'));
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
    public function ajoutMatiere(Request $req)
    {   
        $enseigne = new Enseigne();
        $matiere = new Matiere();
        $entityManager = $this->getDoctrine()->getManager();
        if($req->request->count() > 0){
            $repo1 = $entityManager->getRepository(Enseigne::class);
            $repo2 = $entityManager->getRepository(Matiere::class);
            $enseignes=$repo1->findall();
            foreach($enseignes as $el)
                if($req->request->get('enseigne') == $el->getId())
                {
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
}
