<?php

namespace App\DataFixtures;

use App\Entity\Classe;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ClasseFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
       for ($i=0; $i <3; $i++) { 
          $niveau= $this->getReference("Niveau".$i);
          for ($j=0; $j <3 ; $j++) { 
               $filiere= $this->getReference("Filiere".$j);
               $classe=new Classe();
               $classe->setNom($niveau->getNom()." ".$filiere->getNom());
               $classe->setNiveau($niveau);
               $classe->setFiliere($filiere);
               $manager->persist($classe);
          }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
           NiveauFixtures::class,
           FiliereFixtures::class,
        ];
    }
}
