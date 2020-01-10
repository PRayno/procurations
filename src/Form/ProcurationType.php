<?php

namespace App\Form;

use App\Entity\College;
use App\Entity\Procuration;
use App\Entity\SecteurDisciplinaire;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProcurationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $scrutin_id = $options['data']->getScrutin()->getId();
        $builder
            //->add('username', HiddenType::class)
            ->add('mandataire')
            ->add('lieu')
            //->add('date')
            //->add('scrutin')
            ->add('college', EntityType::class, ['label'=>'Collège électoral', 'required'=>true, 'class'=>College::class, 'placeholder' => (count($options['data']->getScrutin()->getColleges()) > 1) ? 'Choix du collège...' : null,
                    'query_builder'=>function(EntityRepository $er) use ($scrutin_id) { return $er->createQueryBuilder('c')->join('c.scrutins', 'sc')->where('c.actif = 1')->andWhere('sc.id = :scrutin')->setParameter('scrutin', $scrutin_id); }])
            ->add('secteurDisciplinaire', EntityType::class, ['label'=>'Secteur disciplinaire', 'required'=>true, 'class'=>SecteurDisciplinaire::class, 'placeholder' => (count($options['data']->getScrutin()->getSecteurs()) > 1) ? 'Choix du secteur disciplinaire...' : null,
                    'query_builder'=>function(EntityRepository $er) use ($scrutin_id) { return $er->createQueryBuilder('s')->join('s.scrutins', 'sc')->where('s.actif = 1')->andWhere('sc.id = :scrutin')->setParameter('scrutin', $scrutin_id); }])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Procuration::class,
        ]);
    }
}
