<?php
// src/BVDS/ComptaBundle/Controller/AccountController.php

namespace BVDS\ComptaBundle\Controller;

use BVDS\ComptaBundle\Entity\TCategorie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TCategorieController extends Controller
{
  public function listAction() {
    $repository = $this->getDoctrine()->getManager()->getRepository("BVDSComptaBundle:TCategorie");
    $liste = $repository->findAll();
    return $this->render("BVDSComptaBundle:TCategorie:list.html.twig", array('liste' => $liste));
  }

  public function addAction(Request $request) {
    // Création de l'entité
    $cat = new TCategorie();

    // Creation du formulaire
    $form = $this->createFormBuilder($cat)
      ->add('libelle', TextType::class)
      ->add('save', SubmitType::class, array('label' => 'Valider'))
      ->getForm();

    $form->handleRequest($request);

    if ($form->isValid()) {
      // On l'enregistre notre objet $advert dans la base de données, par exemple
      $em = $this->getDoctrine()->getManager();
      $em->persist($cat);
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'La catégorie à bien ajouté');

      // On redirige vers la page de visualisation de l'annonce nouvellement créée
      return $this->redirect($this->generateUrl('bvds_compta_transcategories_list'));
    }

    return $this->render('BVDSComptaBundle:TCategorie:add.html.twig', array('form' => $form->createView()));
  }
}