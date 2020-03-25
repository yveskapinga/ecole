<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Matiere;
use App\Entity\Enseigne;
use DateTime;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $enseigne = new Enseigne();
        $enseigne->setNom('enseigne');
        $enseigne->setLibelle('libelle_enseinge');
        $manager->persist($enseigne);
         for($i=1; $i<50; $i++){
            $matiere = new Matiere();
            $matiere->setNom('matiere'.$i);
            $matiere->setEnseigne($enseigne);
            $manager->persist($matiere);
         }
        $manager->flush();
    }
}
