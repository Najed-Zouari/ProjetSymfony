<?php
namespace App\Controller;

use App\Entity\Magasin;
use App\Entity\Vendeur;
use App\Form\MagasinType;
use App\Form\VendeurType;
use App\Entity\SalarySearch;
use App\Entity\MagasinSearch;
use App\Entity\PropertySearch;
use App\Form\SalarySearchType;
use App\Form\MagasinSearchType;
use App\Form\PropertySearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
Use Symfony\Component\Routing\Annotation\Route;


class IndexController extends AbstractController
{/**
 *@Route("/",name="vendeur_list")
 */

public function home(Request $request)
{
$propertySearch = new PropertySearch();
$form = $this->createForm(PropertySearchType::class,$propertySearch);
$form->handleRequest($request);
//initialement le tableau des vendeurs est vide,
//c.a.d on affiche les vendeurs que lorsque l'utilisateur
//clique sur le bouton rechercher
$vendeurs= [];

if($form->isSubmitted() && $form->isValid()) {
//on récupère le nom du vendeur tapé dans le formulaire
$nom = $propertySearch->getNom(); 
 if ($nom!="")
 //si on a fourni un nom du vendeur on affiche tous les vendeurs ayant ce nom
 $vendeurs= $this->getDoctrine()->getRepository(Vendeur::class)->findBy(['Nom' => $nom] );
 else 
 //si si aucun nom n'est fourni on affiche tous les vendeurs
 $vendeurs= $this->getDoctrine()->getRepository(Vendeur::class)->findAll();
 }
 return $this->render('vendeurs/index.html.twig',[ 'form' =>$form->createView(), 'vendeurs' => $vendeurs]); 
 }


 /**
 * @Route("/vendeur/save")
 */
public function save() {
    $entityManager = $this->getDoctrine()->getManager();
    $vendeur = new Vendeur();
    $vendeur->setNom('vendeur 3');
    $vendeur->setSalaire(1050);
    
    $entityManager->persist($vendeur);
    $entityManager->flush();
    return new Response('Vendeur enregisté avec id '.$vendeur->getId());
    }
/**
 * @Route("/vendeur/new", name="new_vendeur")
 * Method({"GET", "POST"})
 */
public function new(Request $request) {
    $vendeur = new vendeur();
    $form = $this->createForm(VendeurType::class,$vendeur);
    $form->handleRequest($request);
   
    
    if($form->isSubmitted() && $form->isValid()) {
    $vendeur = $form->getData();
    
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->persist($vendeur);
    $entityManager->flush();
    
    return $this->redirectToRoute('vendeur_list');
    }
    return $this->render('vendeurs/new.html.twig',['form' => $form->createView()]);
    }

/**
 * @Route("/vendeur/{id}", name="vendeur_show")
 */
public function show($id) {
    $vendeur = $this->getDoctrine()->getRepository(Vendeur::class)
    ->find($id);
    return $this->render('vendeurs/show.html.twig',
    array('vendeur' => $vendeur));
     }

/**
 * @Route("/vendeur/edit/{id}", name="edit_vendeur")
 * Method({"GET", "POST"})
 */
public function edit(Request $request, $id) {
    $vendeur = new vendeur();
    $vendeur = $this->getDoctrine()->getRepository(vendeur::class)->find($id);
 
    $form = $this->createForm(VendeurType::class,$vendeur);
    
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()) {
    
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->flush();
    
    return $this->redirectToRoute('vendeur_list');
    }
    
    return $this->render('vendeurs/edit.html.twig', ['form' => $form->createView()]);
    }

/**
 * @Route("/vendeur/delete/{id}",name="delete_vendeur")
 * Method({"DELETE"})
 */
public function delete(Request $request, $id) {
    $vendeur = $this->getDoctrine()->getRepository(vendeur::class)->find($id);
    
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->remove($vendeur);
    $entityManager->flush();
    
    $response = new Response();
    $response->send();
    return $this->redirectToRoute('vendeur_list');
    }

    /**
 * @Route("/magasin/newmag", name="new_magasin")
 * Method({"GET", "POST"})
 */
 public function newMagasin(Request $request) {
    $magasin = new Magasin();
    $form = $this->createForm(MagasinType::class,$magasin);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()) {
    $vendeur = $form->getData();
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->persist($magasin);
    $entityManager->flush();
    }
   return $this->render('vendeurs/newMagasin.html.twig',['form'=>
   $form->createView()]);
    }
 
  /**
 * @Route("/vend_mag/", name="vendeur_par_mag")
 * Method({"GET", "POST"})
 */ 
 public function vendeurParMagasin(Request $request) {
    $magasinSearch = new MagasinSearch();
    $form = $this->createForm(MagasinSearchType::class,$magasinSearch);
    $form->handleRequest($request);
    $vendeurs= [];  
    if($form->isSubmitted() && $form->isValid()) {
        $magasin = $magasinSearch->getMagasin();
        
        if ($magasin!="")
       $vendeurs= $magasin->getVendeurs();
        else 
        $vendeurs= $this->getDoctrine()->getRepository(Vendeur::class)->findAll();
        }
        
        return $this->render('vendeurs/vendeurParMagasin.html.twig',['form' => $form->createView(),'vendeurs' => $vendeurs]);
        }


    /**
 * @Route("/vend_salaire/", name="vendeur_par_salaire")
 * Method({"GET"})
 */
 public function vendeursParSalaire(Request $request)
 {
    
 $SalarySearch = new SalarySearch();
 $form = $this->createForm(SalarySearchType::class,$SalarySearch);
 $form->handleRequest($request);
 $vendeurs= [];
 if($form->isSubmitted() && $form->isValid()) {
 $minSalary = $SalarySearch->getMinSalary();
 $maxSalary = $SalarySearch->getMaxSalary();
 $vendeurs= $this->getDoctrine()-> getRepository(vendeur::class)->findBySalaryRange($minSalary,$maxSalary);
 }
 return $this->render('vendeurs/vendeursParSalaire.html.twig',[ 'form' =>$form->createView(), 'vendeurs' => $vendeurs]);
 }

}