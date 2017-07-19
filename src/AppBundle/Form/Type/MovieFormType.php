<?php

namespace AppBundle\Form\Type;


use AppBundle\Entity\Movie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovieFormType extends AbstractType
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
            ->add('title')
            ->add('releaseYear', ChoiceType::class, [
                'choices' => $this->getMovieReleaseYears()
            ])
            ->add('description', TextareaType::class, [
                'required'   => false,
            ])
            ->addEventListener(
                FormEvents::PRE_SUBMIT,
                array($this, 'checkIfMovieAlreadyExists')
            )
        ;
    }

    /**
     * @inheritdoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Movie::class,
        ));
    }

    /**
     * @param FormEvent $event
     */
    public function checkIfMovieAlreadyExists(FormEvent $event)
    {
        $submittedData = $event->getData();
        $title = $submittedData['title'] ?? null;
        $releaseYear = $submittedData['releaseYear'] ?? null;

        $movie = $this->em->getRepository('AppBundle:Movie')
            ->findBy([
                'title' => $title,
                'releaseYear' => $releaseYear
            ]);

        if (empty($movie)) {
            return;
        }

        $currentMovieId = $event->getForm()->getData() ? $event->getForm()->getData()->getId() : null;
        $movie = array_pop($movie);
        if ($movie->getId() != $currentMovieId) {
            $event->getForm()->addError(
                new FormError('Movie with the title' . $title . ' and release year ' . $releaseYear . ' already exists.')
            );
        }
    }

    /**
     * @return array
     */
    private function getMovieReleaseYears()
    {
        $range = range(1896, date('Y') + 1);
        $range = array_reverse($range);

        return array_combine($range, $range);
    }
}