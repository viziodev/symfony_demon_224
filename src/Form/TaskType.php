<?php

namespace App\Form;


use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfonycasts\DynamicForms\DependentField;
use Symfony\Component\Form\FormBuilderInterface;
use Symfonycasts\DynamicForms\DynamicFormBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder = new DynamicFormBuilder($builder);
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
            ->addDependent('category', 'addCategory', function (DependentField $field, ?string $choice) {
                if (empty($choice)) {
                    return;
                }

                $field
                    ->add(CategoryType::class, [
                        'label' => false,
                        'attr' => [],
                    ]);
            })
              
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
