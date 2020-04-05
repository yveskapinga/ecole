<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminFixture extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $admin = new Admin();
        $admin-> setNom('bruno');
        $admin-> setPrenom('bruno');
        $admin-> setNom('bruno');
        $admin-> setPhoto('bruno');
        $admin->setPassword($this->passwordEncoder->encodePassword(
                         $admin,
                         'the_new_password'
                     ));
        $manager->persist($admin);
        $manager->flush();
    }
}
