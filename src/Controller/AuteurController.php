<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Form\AuteurType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuteurController extends AbstractController
{
    /**
     * @Route("/auteur", name="auteur")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $auteurs = $doctrine
        ->getRepository(Auteur::class)
        ->findAll();

        return $this->render('auteur/index.html.twig', [
            'auteurs' => $auteurs
        ]);
    }


    /**
     * @Route("/auteur/new", name="auteur_new")
     * @Route("/auteur/edit/{id}", name="auteur_edit")
     */
    public function new(Request $request, Auteur $auteur = null): Response {

        if(!$auteur){
            $auteur = new Auteur();
        }
        

        $form = $this->createForm(AuteurType::class, $auteur);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $auteur = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($auteur);
            $em->flush();

            return $this->redirectToRoute('auteur');
        }

        return $this->render('auteur/new.html.twig', [
            'formAjoutAuteur' => $form->createView(),
            'editMode' => $auteur->getId() != null
        ]);
    }

        /**
     * @Route("/auteur/{id}", name="auteur_show")
     */
    public function show(Auteur $auteur): Response {

        return $this->render('auteur/show.html.twig', [
            'auteur' => $auteur
        ]);
    }

        /**
     * @Route("/auteur/delete/{id}", name="delete_auteur")
     */
    public function delete(ManagerRegistry $em, Auteur $auteur) : Response {

        $em = $em->getManager();

        $em->remove($auteur);
        $em->flush();

        return $this->redirectToRoute('auteur');
    }
}
