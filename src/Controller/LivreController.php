<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Form\LivreType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LivreController extends AbstractController
{
    /**
     * @Route("/livre", name="livre")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $livres = $doctrine
        ->getRepository(Livre::class)
        ->findAll();

        return $this->render('livre/index.html.twig', [
            'livres' => $livres,
        ]);
    }


    /**
     * @Route("/livre/new", name="livre_new")
     * @Route("livre/edit/{id}", name="livre_edit")
     */
    public function new_edit(Request $request, Livre $livre = null): Response {
        if(!$livre){
            $livre = new Livre();
        }
        
       

        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $livre = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($livre);
            $em->flush();

            return $this->redirectToRoute('livre');
        }

        return $this->render('livre/new.html.twig', [
            'formAjoutLivre' => $form->createView(),
            'editMode' => $livre->getId() != null
        ]);
    }

    /**
     * @Route("/livre/{id}", name="livre_show")
     */
    public function show(Livre $livre): Response {

        return $this->render('livre/show.html.twig', [
            'livre' => $livre
        ]);
    }

    /**
     * @Route("/livre/delete/{id}", name="delete_livre")
     */
    public function delete(ManagerRegistry $em, Livre $livre) : Response {

        $em = $em->getManager();

        $em->remove($livre);
        $em->flush();

        return $this->redirectToRoute('livre');
    }

}
