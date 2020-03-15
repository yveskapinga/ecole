<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Cour;
use DateTime;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i=1; $i<10; $i++){
            $cour = new Cour();
            $cour->setDate(new \DateTime());
            $cour->setDurreEnMinte(60+$i);
            $cour->setDescription("<p>description$i</p>");
            $manager->persist($cour);
        }

        $manager->flush();
    }
}
