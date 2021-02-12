<?php

namespace App\Controller;

use App\Entity\Acteur;
use App\Form\ActeurType;
use App\Repository\ActeurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ActeurController extends AbstractController
{
    /**
     * @Route("/acteur", name="acteur")
     */
    public function index(ActeurRepository $acteurRepository): Response
    {
        $listActeur = $acteurRepository->findAll();
       // var_dump($listActeur);
        return $this->render('acteur/index.html.twig', [
            'controller_name' => 'ActeurController',
            'acteurs' => $listActeur
        ]);
    }

    /**
     * @Route("/acteur/acteurNew", name="Acteur_new")
     * @param Request $request
     * CreateActeur
     * @return Response
     */

    public function newActeur(Request $request)
    {
        $addActeur = new Acteur();
        $form = $this->createForm(ActeurType::class, $addActeur);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($addActeur);
            $em->flush();
            //   return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
        }
        //  return $this->handleView($this->view($form->getErrors()));

        return $this->render('acteur/newActeur.html.twig',[
            'form' => $form->createView()
        ]);
    }

    public function deleteActeur(ActeurRepository $acteurRepository, $id = 0): Response
    {
        $acteur= $acteurRepository->find($id);


        if ($acteur) {

            $this->em->remove($acteur);
            $this->em->flush();

        }
    }
}
