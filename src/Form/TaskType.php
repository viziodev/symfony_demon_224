<?php

namespace App\Form;


use App\Entity\Task;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                "required" => false,
            ])
            ->add('addCategory', CheckboxType::class, [
                'label' => 'Ajouter une Categorie ?',
                'required' => false,
                'data' => false,
                'mapped' => false,
                'attr' => [
                    'class' => 'form-check-input',
                ],
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, function (PreSubmitEvent $event): void {
                $formData = $event->getData(); // Récupère les données du formulaire
                $form = $event->getForm();

                if (isset($formData['addCategory']) && $formData['addCategory'] == "1") {
                    $form
                        ->add('category', CategoryType::class, [
                            'label' => false,
                            'attr' => [],
                        ]);
                }
            })
            ->add("save", SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
            'validation_groups' => function (FormInterface $form) {
                if ($form->has("addCategory") && $form->get("addCategory")->getData()) {
                    return ['Default', "Category"];
                }
                return ['Default'];
            }
        ]);
    }
}
