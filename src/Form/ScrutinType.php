<?php

namespace App\Form;

use App\Entity\College;
use App\Entity\Scrutin;
use App\Entity\SecteurDisciplinaire;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ScrutinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('secteurs', EntityType::class, ['class' => SecteurDisciplinaire::class, 'label' => 'Secteur(s) disciplinaire(s)', 'multiple' => true, 'attr' => ['class' => 'select2'],
                'query_builder' => function(EntityRepository $er) { return $er->createQueryBuilder('s')->where('s.actif = 1')->addOrderBy('s.nom', 'ASC'); }])
            ->add('colleges', EntityType::class, ['class' => College::class, 'label' => 'Collège(s) électoral(aux)', 'multiple' => true, 'attr' => ['class' => 'select2'],
                'query_builder' => function(EntityRepository $er) { return $er->createQueryBuilder('c')->where('c.actif = 1')->addOrderBy('c.nom', 'ASC'); }])
            ->add('explications', TextareaType::class, ['label' => 'Explications/Informations supplémentaires', 'required' => false, 'attr' => ['rows' => 3, 'placeholder' => 'Texte à afficher sur la procuration...']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Scrutin::class,
        ]);
    }
}
