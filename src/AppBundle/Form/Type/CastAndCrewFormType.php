<?php

namespace AppBundle\Form\Type;


use AppBundle\Entity\CastAndCrew;
use AppBundle\Entity\Movie;
use AppBundle\Entity\Person;
use AppBundle\Enum\RoleType;
use AppBundle\Repository\CastAndCrewRepository;
use AppBundle\Repository\PersonRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CastAndCrewFormType extends AbstractType
{
    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('person', EntityType::class, [
                'placeholder' => 'Choose a person for movie cast and crew',
                'class' => Person::class,
                'query_builder' => function(PersonRepository $repo) use ($options) {
                    return $repo->createAlphabeticalQueryBuilder($options['movie']);
                },
                'choice_label' => function ($person) {
                    return $person->getFirstName() . ' ' . $person->getLastName();
                }
            ])
            ->add('role', ChoiceType::class, [
                'choices' => array_flip(RoleType::getAll())
            ]);
    }

    /**
     * @inheritdoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => CastAndCrew::class,
            'movie' => null
        ));
    }
}