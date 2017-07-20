<?php


namespace AppBundle\Controller;


use AppBundle\Entity\CastAndCrew;
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

            return $this->redirectToRoute('movie_cast_and_crew_list', [
                'id' => $movie->getId()
            ]);
        }

        return $this->render('cast_and_crew/new.html.twig', [
            'castAndCrewForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/movies/{movie}/cast-and-crew/{id}/edit", name="edit_movie_cast_and_crew_item")
     */
    public function editMovieCastAndCrew(Request $request, Movie $movie, CastAndCrew $castAndCrew)
    {
        $form = $this->createForm(CastAndCrewFormType::class, $castAndCrew, ['movie' => $movie, 'is_edit' => true]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $castAndCrew = $form->getData();
            $castAndCrew->setMovie($movie);

            $em = $this->getDoctrine()->getManager();
            $em->persist($castAndCrew);
            $em->flush();

            $this->addFlash('success', 'Movie cast and crew successfully edited!');

            return $this->redirectToRoute('movie_cast_and_crew_list', [
                'id' => $movie->getId()
            ]);
        }

        return $this->render('cast_and_crew/edit.html.twig', [
            'castAndCrewForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/movies/{movie}/cast-and-crew/{id}/delete", name="movie_cast_and_crew_delete")
     */
    public function deleteAction(Movie $movie, CastAndCrew $castAndCrew)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($castAndCrew);
        $em->flush();

        $this->addFlash('success', 'Cast and crew for the movie "' . $movie->getTitle() . '"" successfully deleted!');

        return $this->redirectToRoute('movie_cast_and_crew_list', [
            'id' => $movie->getId()
        ]);
    }

    /**
     * @Route("/movies/{id}/cast-and-crew", name="movie_cast_and_crew_list")
     */
    public function listMovieCastAndCrew(Movie $movie)
    {
        return $this->render('cast_and_crew/index.html.twig', [
            'movieCastAndCrew' => $this->getDoctrine()->getRepository('AppBundle:CastAndCrew')
                ->findBy(['movie' => $movie->getId()], ['id' => 'DESC']),
            'movie' => $movie
        ]);
    }
}