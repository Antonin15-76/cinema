<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="categorie", methods={"GET"})
     * @return Response
     */
    public function index(CategorieRepository $categorieRepository): Response
    {

        $listCategories = $categorieRepository->findAll();
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
            'categories' => $listCategories,
        ]);
    }

    /**
     * @Route("/categorie/categorieNew", name="Categorie_new")
     * @param Request $request
     * CreateCategorie
     * @return Response
     */

    public function newCategorie(Request $request)
    {
        $addCategorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $addCategorie);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($addCategorie);
            $em->flush();
            //   return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
        }
        //  return $this->handleView($this->view($form->getErrors()));

        return $this->render('categorie/newCategorie.html.twig',[
            'form' => $form->createView()
        ]);
    }

    public function deleteCategorie(CategorieRepository $categorieRepository, $id = 0): Response
    {
        $categorie = $categorieRepository->find($id);


        if ($categorie) {

            $this->em->remove($categorie);
            $this->em->flush();

        }
    }
}
