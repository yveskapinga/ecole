<?php

namespace App\Controller;

use App\Entity\Matiere;
use App\Entity\Enseigne;
use App\Entity\Promotion;
use App\Form\EnseigneType;
use App\Form\PromotionType;
use App\Form\EnseignantType;
use App\Repository\CourRepository;
use App\Repository\AdminRepository;
use App\Repository\MatiereRepository;
use App\Repository\EnseigneRepository;
use App\Repository\EtudiantRepository;
use App\Repository\PromotionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/**
* @Route("/superAdmin", name="")
*/
class SuperAdminController extends AbstractController
{
   /*********administaration etudiant************/
   /**
    * @Route("/inscriptionEtudiant/{id}", name="inscriptionEtudiant")
    */
    public function inscriptionEtudiant(int $id, EtudiantRepository $repo)
    {
        // je selection l'etudiant par son id et je change sont statut inscription a true ou false et je le save dans la base
        $etudiant = $repo->find($id);
        $etudiant->setInscrit(!$etudiant->getInscrit());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($etudiant);
        $entityManager->flush();
        return $this->redirectToRoute('FicheEtudiant', ['id' => $etudiant->getId()]);
    }

    /**
    * @Route("/supressionEtudiant/{id}", name="supressionEtudiant")
    */
    public function supressionEtudiant(int $id, EtudiantRepository $repo)
    {
        // je selection l'etudiant par son id et je le suprime definitivement de la base
        $etudiant = $repo->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($etudiant);
        $entityManager->flush();
        return $this->redirectToRoute('adminEtudiant');
    }
    /*********fin administaration etudiant************/

    /*********administaration enseignant************/
    /**
    * @Route("/adminEnseignant", name="adminEnseignant")
    */
    public function adminEnseignant(AdminRepository $repo)
    {
        $enseignants = $repo->findAll();
        return $this->render('admin/superAdmin/adminEnseignant.html.twig', [
            'enseignants' => $enseignants
        ]);
    }
    /**
    * @Route("/modifierEnseignant{id}", name="modifierEnseignant")
    */
    public function modifierEnseignant($id,Request $req, AdminRepository $repoAdmin)
    {
        //on instancie l'entitie Enseignant
        $enseignant = $repoAdmin->find($id);
        // je cree l'objet formulaire
        $form = $this->createForm(EnseignantType::class, $enseignant);
        //je recupere les donnée saisie
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            //ici le formulaire a été envoyer et les donnée sont valide
            $enseignant->setRoles(array($req->request->get('role')));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($enseignant);
            $entityManager->flush();
            return $this->redirectToRoute('adminEnseignant');
        }
        return $this->render('admin/superAdmin/modifierEnseignant.html.twig', [
            'role_actuel'=>$enseignant->getRoles()[0],
            'form' => $form->createView()
        ]);
    }

     /**
    * @Route("/suprimerEnseignant{id}", name="suprimerEnseignant")
    */
    public function suprimerEnseignant($id, AdminRepository $repoAdmin)
    {
        //on instancie l'entitie Enseignant
        $enseignant = $repoAdmin->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($enseignant);
        $entityManager->flush();
      
        return $this->redirectToRoute('adminEnseignant');
    }
    /*************fin administartion enseignant*************/

    /*************administartion matiere*************/
    /**
    * @Route("/ajoutMatiere/{id}",name="modifierMatiere")
    * @Route("/ajoutMatiere", name="ajoutMatiere")
    */
    public function ajoutMatiere($id=0,Request $req, EnseigneRepository $repoEnseigne,MatiereRepository $repoMatiere)
    {
        $matiere = $id==0?new Matiere:$repoMatiere->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $enseignes = $repoEnseigne->findAll();
        if ($req->isMethod('post')) {
                    $matiere->setNom($req->request->get('nom'));
                    $matiere->setEnseigne($repoEnseigne->find($req->request->get('enseigne')));
                    $entityManager->persist($matiere);
                    $entityManager->flush();
                return $this->redirectToRoute("adminMatiere");
                }
        return $this->render('admin/superAdmin/ajoutMatiere.html.twig', [
            'enseignes'=>$enseignes,
            'matiere' => $matiere,
        ]);
    }
    /**
    * @Route("/suprimerMatiere/{id}", name="suprimerMatiere")
    */
    public function suprimerMatiere($id, MatiereRepository $repo)
    {
        $matiere = $repo->findOneById($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($matiere);
        $entityManager->flush();

        return $this->redirectToRoute('adminMatiere');

    }
    /*************fin administartion matiere*****************/

    /******************administration enseigne***************/
    /**
    * @Route("/adminEnseigne", name="adminEnseigne")
    */
    public function adminEnseigne(EnseigneRepository $repoEnseigne)
    {
        $enseignes = $repoEnseigne->findAll();
        return $this->render('admin/superAdmin/adminEnseigne.html.twig',[
            'enseignes'=> $enseignes
        ]);
    }

    /**
    * @Route("/modifierEnseigne/{id}", name="modifierEnseigne")
    * @Route("/enseigne", name="enseigne")
    */
    public function enseigne($id=0,Request $req,EnseigneRepository $repoEnseigne)
    {
        $enseigne = $id==0? new Enseigne():$repoEnseigne->find($id);
        $form = $this->createForm(EnseigneType::class, $enseigne);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($enseigne);
            $entityManager->flush();
            return $this->redirectToRoute('adminEnseigne');
        }
        return $this->render('admin/superAdmin/enseigne.html.twig',[
            'form' => $form->createView()
        ]);
    }
    /**
    * @Route("/suprimerEnseigne/{id}", name="suprimerEnseigne")
    */
    public function suprimerEnseigne($id, EnseigneRepository $repo)
    {
        $enseigne = $repo->findOneById($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($enseigne);
        $entityManager->flush();

        return $this->redirectToRoute('adminEnseigne');
    }
    /******************fin administration enseigne***************/

    /******************administration promotion******************/
    /**
    * @Route("/adminPromotion", name="adminPromotion")
    */
    public function adminPromotion(PromotionRepository $repoPromotion)
    {
        $promotions = $repoPromotion->findAll();
        return $this->render('admin/superAdmin/adminPromotion.html.twig',[
            'promotions'=> $promotions
        ]);
    }

    /**
    * @Route("/modifierPromotion/{id}", name="modifierPromotion")
    * @Route("/promotion", name="promotion")
    */
    public function promotion($id=0,Request $req ,EnseigneRepository $repoEnseigne,PromotionRepository $repoPromotion)
    {
        $promotion = $id==0?new Promotion():$repoPromotion->find($id);
        $enseignes= $repoEnseigne->findAll();
        $form = $this->createForm(PromotionType::class, $promotion);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid())
        {
            $enseigne=$repoEnseigne->find($req->request->get('enseigne'));
            $promotion->setEnseigne($enseigne);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($promotion);
            $entityManager->flush();
            return $this->redirectToRoute('adminPromotion');
        }
        return $this->render('admin/superAdmin/promotion.html.twig',[
            'form' => $form->createView(),
            'enseignes'=>$enseignes,
            'promotion'=>$promotion
        ]);
    }
    /**
    * @Route("/suprimerPromotion/{id}", name="suprimerPromotion")
    */
    public function suprimerPromotion($id, PromotionRepository $repo)
    {
        $promotion = $repo->findOneById($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($promotion);
        $entityManager->flush();

        return $this->redirectToRoute('adminPromotion');
    }
    /******************fin administration promotion***************/
}