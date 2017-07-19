<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Movie;
use AppBundle\Form\Type\CastAndCrewFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CastAndCrewController extends Controller
{
    /**
     * @Route("/movies/{id}/cast-and-crew/new", name="new_movie_cast_and_crew")
     */
    public function newMovieCastAndCrew(Request $request, Movie $movie)
    {
        $form = $this->createForm(CastAndCrewFormType::class, null, ['movie' => $movie]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $castAndCrew = $form->getData();
            $castAndCrew->setMovie($movie);

            $em = $this->getDoctrine()->getManager();
            $em->persist($castAndCrew);
            $em->flush();

            $this->addFlash('success', 'Movie cast and crew saved!');

            return $this->redirectToRoute('movie_list');
        }

        return $this->render('cast_and_crew/new.html.twig', [
            'castAndCrewForm' => $form->createView()
        ]);
    }
}