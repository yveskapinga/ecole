<?php

namespace App\Controller;

use App\Entity\Matiere;
use App\Entity\Enseigne;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function loginAdmin()
    {
        return $this->render('admin/login.html.twig', [
           
        ]);
    }

     /**
     * @Route("/adminMatiere", name="adminMatiere")
     */
    public function adminMatiere()
    {
        return $this->render('admin/adminMatiere.html.twig', [
            
        ]);
    }
     /**
     * @Route("/ajoutMatiere", name="ajoutMatiere")
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
                if($req->request->get('enseigne') == $el->getId()){
                    $matiere->setNom($req->request->get('nom'));
                    $matiere->setEnseigne($el);
                    $entityManager->persist($matiere);
                    $entityManager->flush();
                break;
                }
            
        }
        return $this->render('admin/ajoutMatiere.html.twig', [
        'matiere'=>$matiere
        ]);
    }
}

