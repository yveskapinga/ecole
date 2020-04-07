<?php

namespace App\Controller;

use App\Entity\Matiere;
use App\Entity\Enseigne;
use App\Repository\MatiereRepository;
use App\Repository\EtudiantRepository;
use App\Repository\EnseignantRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    public function adminEnseignant(EnseignantRepository $repo)
    {
        $enseignants = $repo->findAll();
        return $this->render('admin/superAdmin/adminEnseignant.html.twig', [
            'enseignants'=>$enseignants
        ]);
    }
     /**
     * @Route("superAdmin/ajoutEnseignant", name="ajoutEnseignant")
     */
    public function ajoutEnseignant(EnseignantRepository $repo)
    {
        $enseignants = $repo->findAll();
        return $this->render('admin/superAdmin/ajoutEnseignant.html.twig', [
            'enseignants'=>$enseignants
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
