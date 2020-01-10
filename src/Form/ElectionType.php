<?php

namespace App\Form;

use App\Entity\Election;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class ElectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('debut', DateType::class, ['attr'=>['class'=>"form-control js-datepicker"],'widget'=> 'single_text','html5'=>false,'format' => 'dd/MM/yyyy HH:mm','required'=>true])
            ->add('fin', DateType::class, ['attr'=>['class'=>"form-control js-datepicker"],'widget'=> 'single_text','html5'=>false,'format' => 'dd/MM/yyyy HH:mm','required'=>true])
            ->add('scrutins', CollectionType::class, ['entry_type' => ScrutinType::class, 'label' => false, 'allow_add' => true, 'allow_delete' => true])
            ->add('submit', SubmitType::class, ['label'=>'Enregistrer', 'attr'=>['class'=>"button button-uca-blue"]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Election::class,
            'constraints' => [new Callback([$this, 'customValidation'])]
        ]);
    }

    public function customValidation($data, ExecutionContextInterface $context)
    {
        if ($data->getDebut() && $data->getFin() && $data->getFin() < $data->getDebut()) {
            $context->buildViolation('La date de fin doit être postérieure à la date de début.')
                    ->atPath('fin')
                    ->addViolation();
        }
    }
}
