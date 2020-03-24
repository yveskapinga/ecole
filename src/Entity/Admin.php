<?php

namespace App\Entity;
use App\Entity\Personne;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonneRepository")
 */
class Admin extends Personne{

   
}