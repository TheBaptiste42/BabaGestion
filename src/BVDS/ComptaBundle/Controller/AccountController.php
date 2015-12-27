<?php
// src/BVDS/ComptaBundle/Controller/AccountController.php

namespace BVDS\ComptaBundle\Controller;

use BVDS\ComptaBundle\Entity\Account;
use BVDS\ComptaBundle\Entity\Transaction;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\PersistentCollection;

class AccountController extends Controller
{

  public function getMontantCompte(PersistentCollection $transactions)
  {
    $total = 0; ### PENSER A METTRE LES TRANSACTIONS EN ORDRE DE DATE
    foreach (array_reverse($transactions->toArray(),true) as $key => $tra) {
      $type = $tra->getType();
      if($type == "deb") {
        $total -= $tra->getMontant();
      } elseif($type ==  "cre") {
        $total += $tra->getMontant();
      } else {  // $type == "aju" && $type == "ini"
        $total = $tra->getMontant();
      }
    }
    return $total;
  }

  public function viewAction($id)
  {
  	$repository = $this->getDoctrine()->getManager()->getRepository('BVDSComptaBundle:Account');
    // On récupère l'entité correspondante à l'id $id
    $account = $repository->find($id);

    $repCat = $this->getDoctrine()->getManager()->getRepository('BVDSComptaBundle:TCategorie');
    $tcat = $repCat->find(1);

    // $newtr = new Transaction();
    // $newtr->setLibelle("Hello123");
    // $newtr->setMontant(40.00);
    // $newtr->setDate(new \DateTime);
    // $newtr->setType("deb");
    // $newtr->setAccount($account);
    // $newtr->addCategory($tcat);
    // $enr = $this->getDoctrine()->getManager();
    // $enr->persist($newtr);
    // $enr->flush();

    $transactions = $account->getTransactions();

    $mtotal = $this->getMontantCompte($transactions);

    // $advert est donc une instance de OC\PlatformBundle\Entity\Advert
    // ou null si l'id $id  n'existe pas, d'où ce if :
    if (null === $account) {
      throw new NotFoundHttpException("Le compte d'id ".$id." n'existe pas.");
    }

    // Le render ne change pas, on passait avant un tableau, maintenant un objet
    return $this->render('BVDSComptaBundle:Account:view.html.twig', array(
      'account' => $account,
      'transactions' => $transactions,
      'mtotal' => $mtotal
    ));
  }

  public function delAction($id, Request $request)
  {
  	$em = $this->getDoctrine()->getManager();
    // On récupère l'entité correspondante à l'id $id
    $account = $em->getRepository('BVDSComptaBundle:Account')->find($id);

    if (null === $account) {
      throw new NotFoundHttpException("Le compte d'id ".$id." n'existe pas.");
    }

    $form = $this->createFormBuilder()->getForm();

    if ($form->handleRequest($request)->isValid()) {
      $em->remove($account);
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', "Le compte a bien été supprimé.");

      return $this->redirect($this->generateUrl('bvds_compta_account_list'));
    }

    // Si la requête est en GET, on affiche une page de confirmation avant de supprimer
    return $this->render('BVDSComptaBundle:Account:del.html.twig', array(
      'account' => $account,
      'form'   => $form->createView()
    ));
  }

  public function listAction()
  {
  	$repository = $this->getDoctrine()->getManager()->getRepository('BVDSComptaBundle:Account');
  	$liste = $repository->findBy(
  		array('proprio' => $this->getUser())
  	);
    return $this->render('BVDSComptaBundle:Account:list.html.twig', 
    	array(
      		'listAccounts' => $liste
      	)
    );
  }

  public function addAction(Request $request)
  {
    // Création de l'entité
    $account = new Account($this->getUser());

    // Creation du formulaire
    $form = $this->createFormBuilder($account)
    	->add('nom', TextType::class)
      ->add('save', SubmitType::class, array('label' => 'Valider'))
      ->getForm();

    $form->handleRequest($request);

    if ($form->isValid()) {
    	// On l'enregistre notre objet $advert dans la base de données, par exemple
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($account);
     	$em->flush();

      	$request->getSession()->getFlashBag()->add('notice', 'Compte bien ajouté');

      	// On redirige vers la page de visualisation de l'annonce nouvellement créée
      	return $this->redirect($this->generateUrl('bvds_compta_account_list'));
    }


    return $this->render('BVDSComptaBundle:Account:add.html.twig', array(
      'form' => $form->createView(),
    ));
  }
}