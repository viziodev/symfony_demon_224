<?php

namespace App\DataFixtures;

use App\Entity\Filiere;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FiliereFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $datas=["Dev Web Mobile","Assistanat Digital","Marketing Digital"];
        foreach ($datas as $key=>$value) {
           $filiere=new Filiere();
           $filiere->setNom($value);
           $manager->persist($filiere);
           $this->addReference("Filiere".$key, $filiere);
        }
         $manager->flush();
    }
}
