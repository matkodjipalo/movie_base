<?php


namespace AppBundle\Controller;


use AppBundle\Entity\MovieCastMember;
use AppBundle\Entity\Movie;
use AppBundle\Form\Type\MovieCastMemberFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MovieCastMemberController extends Controller
{
    /**
     * @Route("/movies/{id}/cast-member/new", name="new_movie_cast_member")
     */
    public function newMovieCastAndCrew(Request $request, Movie $movie)
    {
        $form = $this->createForm(MovieCastMemberFormType::class, null, ['movie' => $movie]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $castAndCrew = $form->getData();
            $castAndCrew->setMovie($movie);

            $em = $this->getDoctrine()->getManager();
            $em->persist($castAndCrew);
            $em->flush();

            $this->addFlash('success', 'Movie cast member saved!');

            return $this->redirectToRoute('movie_cast_member_list', [
                'id' => $movie->getId()
            ]);
        }

        return $this->render('movie_cast_member/new.html.twig', [
            'castMemberForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/movies/{movie}/cast-member/{id}/edit", name="edit_movie_cast_member")
     */
    public function editMovieCastAndCrew(Request $request, Movie $movie, MovieCastMember $movieCastMember)
    {
        $form = $this->createForm(MovieCastMemberFormType::class, $movieCastMember, ['movie' => $movie, 'is_edit' => true]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $movieCastMember = $form->getData();
            $movieCastMember->setMovie($movie);

            $em = $this->getDoctrine()->getManager();
            $em->persist($movieCastMember);
            $em->flush();

            $this->addFlash('success', 'Movie cast member successfully edited!');

            return $this->redirectToRoute('movie_cast_member_list', [
                'id' => $movie->getId()
            ]);
        }

        return $this->render('movie_cast_member/edit.html.twig', [
            'castMemberForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/movies/{movie}/cast-member/{id}/delete", name="movie_cast_member_delete")
     */
    public function deleteAction(Movie $movie, MovieCastMember $movieCastMember)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($movieCastMember);
        $em->flush();

        $this->addFlash('success', 'Cast member for the movie "' . $movie->getTitle() . '"" successfully deleted!');

        return $this->redirectToRoute('movie_cast_member_list', [
            'id' => $movie->getId()
        ]);
    }

    /**
     * @Route("/movies/{id}/cast-member", name="movie_cast_member_list")
     */
    public function listMovieCastAndCrew(Movie $movie)
    {
        return $this->render('movie_cast_member/index.html.twig', [
            'movieCastAndCrew' => $this->getDoctrine()->getRepository('AppBundle:MovieCastMember')
                ->findBy(['movie' => $movie->getId()], ['id' => 'DESC']),
            'movie' => $movie
        ]);
    }
}