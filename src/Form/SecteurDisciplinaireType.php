<?php

namespace App\Form;

use App\Entity\SecteurDisciplinaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SecteurDisciplinaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('actif')
            ->add('submit', SubmitType::class, ['label'=>'Enregistrer', 'attr'=>['class'=>'button button-uca-blue']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SecteurDisciplinaire::class,
        ]);
    }
}
