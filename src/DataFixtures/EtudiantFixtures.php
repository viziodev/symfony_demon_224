<?php

namespace App\DataFixtures;

use App\Entity\Classe;
use App\Entity\Etudiant;
use App\Repository\ClasseRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class EtudiantFixtures extends Fixture   implements DependentFixtureInterface
{
    //Injection de  Dependance  ClasseRepository
   public function __construct(private ClasseRepository $classeRepository){
      
   }
    public function load(ObjectManager $manager): void
    {
         $classes= $this->classeRepository->findAll();
            foreach ($classes as $key => $classe) {
            $nbreEtudiant=rand(10,20);
            for ($i=1; $i <= $nbreEtudiant ; $i++) { 
                $etudiant=new Etudiant();
                $etudiant
                    ->setNomComplet("Nom Complet ".$i)
                    ->setMatricule(uniqid())
                    ->setAdresse("Adresse ".$i)
                    ->setLogin(uniqid()."@gmail.com ")
                    ->setPassword("passer".$i)
                    ->setClasse($classe);
                $manager->persist($etudiant);
            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
           ClasseFixtures::class
        ];
    }
}
