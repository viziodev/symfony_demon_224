<?php

namespace App\DataFixtures;

use App\Entity\Niveau;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class NiveauFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $datas=["L1","L2","L3"];
        foreach ($datas as $key=>$value) {
           $niveau=new Niveau();
           $niveau->setNom($value);
           $manager->persist($niveau);
           $this->addReference("Niveau".$key, $niveau);

        }
         $manager->flush();
    }
}
