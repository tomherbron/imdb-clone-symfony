<?php

namespace App\Form;

use App\Entity\Season;
use App\Entity\Serie;
use App\Repository\SerieRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeasonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number')
            ->add('firstAirDate', DateType::class, [
                'widget' => 'single_text',
                'html5' => true
            ])
            ->add('overview')
            ->add('poster', FileType::class, [
                'mapped' => false
            ])
            ->add('tmdbId')
            ->add('serie', EntityType::class, [
                'class' => Serie::class,
                'choice_label' => 'name',
                'query_builder' => function(SerieRepository $repository){
                    $qb = $repository->createQueryBuilder('s');
                    $qb->addOrderBy('s.name', 'ASC');
                    return $qb;
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Season::class,
        ]);
    }
}
