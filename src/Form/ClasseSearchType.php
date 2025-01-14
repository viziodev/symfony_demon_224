<?php

namespace App\Form;

use App\Entity\Niveau;
use App\Entity\Filiere;
use App\Dto\ClasseSearchDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ClasseSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('filiere', EntityType::class, [
            'class' => Filiere::class,
            'choice_label' => 'nom',
            "placeholder" =>"All",
            "required" => false
        ])
        ->add('niveau', EntityType::class, [
            'class' => Niveau::class,
            'choice_label' => 'nom',
            "placeholder" =>"All",
            "required" => false
        ])
        ->add('add',SubmitType::class,[
            "label" => "Search",
            "attr"=>[
                "class" => "btn btn-outline-dark float-right",
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ClasseSearchDto::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }
}
