<?php

namespace App\Controller;

use App\Entity\Film;
use App\Form\FilmType;
use App\Repository\FilmRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FilmController extends AbstractController
{
    /**
     * @Route("/film", name="film", methods={"GET"})
     * @return Response
     */
    public function index(FilmRepository $filmRepository): Response
    {

        $listFilms = $filmRepository->findAll();
        return $this->render('film/index.html.twig', [
            'controller_name' => 'FilmController',
            'films' => $listFilms,
        ]);
    }

     /**
      * @Route("/film/filmNew", name="Film_new")
      * @param Request $request
      * CreateFilm
      * @return Response
      */

    public function newFilm(Request $request)
    {
        $addFilm = new Film();
        $form = $this->createForm(FilmType::class, $addFilm);
        $data = json_decode($request->getContent(), true);
            $form->submit($data);
            if ($form->isSubmitted() && $form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $em->persist($addFilm);
                $em->flush();
             //   return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
            }
      //  return $this->handleView($this->view($form->getErrors()));

        return $this->render('film/newFilm.html.twig',[
            'form' => $form->createView()
       ]);
    }

    public function deleteFilm(FilmRepository $filmRepository, $id = 0): Response
    {
        $film = $filmRepository->find($id);


        if ($film) {

            $this->em->remove($film);
            $this->em->flush();

        }
    }
}
