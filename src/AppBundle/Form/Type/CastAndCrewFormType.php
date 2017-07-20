<?php

namespace AppBundle\Form\Type;


use AppBundle\Entity\CastAndCrew;
use AppBundle\Entity\Person;
use AppBundle\Enum\RoleType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CastAndCrewFormType extends AbstractType
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('person', EntityType::class, [
                'disabled' => $options['is_edit'],
                'placeholder' => 'Choose a person for movie cast and crew',
                'class' => Person::class,
                'query_builder' => function(EntityRepository $repo) use ($options) {
                    if (false === $options['is_edit']) {
                        return $repo->createQueryBuilder('p')
                            ->orderBy('p.lastName', 'ASC');
                    }
                },
                'choice_label' => function ($person) {
                    return $person->getFirstName() . ' ' . $person->getLastName();
                }
            ])
            ->add('role', ChoiceType::class, [
                'choices' => array_flip(RoleType::getAll())
            ]);

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) use ($options) {
                $submittedData = $event->getData();
                $personId = $submittedData['person'] ?? null;
                $role = $submittedData['role'] ?? null;
                $personWithRole = $this->em->getRepository('AppBundle:CastAndCrew')
                    ->findBy([
                        'person' => $personId,
                        'role' => $role,
                        'movie' => $options['movie']
                    ]);

                if (!empty($personWithRole)) {
                    $event->getForm()->addError(
                        new FormError('This person with this role is already part of movie cast and crew')
                    );
                }
            });
    }

    /**
     * @inheritdoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => CastAndCrew::class,
            'movie' => null,
            'is_edit' => false
        ));
    }
}