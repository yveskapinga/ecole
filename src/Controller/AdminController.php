<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function loginAdmin()
    {
        return $this->render('admin/login.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

     /**
     * @Route("/adminMatiere", name="adminMatiere")
     */
    public function dminMatiere()
    {
        return $this->render('admin/adminMatiere.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}

