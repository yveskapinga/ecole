<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminFixtures extends Fixture
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
     {
         $this->passwordEncoder = $passwordEncoder;
     }
    public function load(ObjectManager $manager)
    {
        $admin = new Admin();
        $admin-> setEmail('sitayebsofiane51@gmail.com');
        $admin-> setRoles(array('ROLE_SUPER_ADMIN'));
        $admin->setPassword($this->passwordEncoder->encodePassword(
             $admin,
            'superadmin'
         ));
        $manager->persist($admin);
        $manager->flush();

        $admin = new Admin();
        $admin-> setEmail('melody@gamil.com');
        $admin-> setRoles(array('ROLE_ADMIN'));
        $admin->setPassword($this->passwordEncoder->encodePassword(
             $admin,
            'admin'
         ));
        $manager->persist($admin);
        $manager->flush();

        $admin = new Admin();
        $admin-> setEmail('marc@gmail.com');
        $admin-> setRoles(array('ROLE_USER'));
        $admin->setPassword($this->passwordEncoder->encodePassword(
             $admin,
            'user'
         ));
        $manager->persist($admin);
        $manager->flush();
    }
}
