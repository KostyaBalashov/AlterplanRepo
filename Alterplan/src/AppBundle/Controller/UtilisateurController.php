<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Utilisateur;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Utilisateur controller.
 *
 * @Route("utilisateurs")
 */
class UtilisateurController extends Controller
{
    private $userManager;

    function __construct(UserManagerInterface $userManager) {
        $this->userManager = $userManager;
    }


    /**
     * Lists all utilisateurs entities.
     *
     * @Route("/", name="utilisateurs_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        //Si c'est un get
        if ($request->getMethod() == 'GET'){

            //On charge tous les utilisateurs
            $utilisateurs = $em->getRepository('AppBundle:Utilisateur')->findAll();

            //Si c'est de l'ajax
            if ($request->isXmlHttpRequest()){
                //On retourne que le tableau des utilisateurs.
                return $this->render(':utilisateurs:table.html.twig', array(
                    'utilisateurs' => $utilisateurs,
                ));

            }else {
                //Si non on render le twig normal.
                return $this->render('utilisateurs/index.html.twig', array(
                    'utilisateurs' => $utilisateurs,
                ));
            }
        }else{
            //Gestion des recherches
            return new Response();
        }
    }

    /**
     * Creates a new utilisateurs entity.
     *
     * @Route("/new", name="utilisateurs_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $utilisateur = new Utilisateur();

        //Création du formulaire de création d'utilisateur
        $form = $this->createForm('AppBundle\Form\UtilisateurType', $utilisateur,
            array('attr' => array('id' => 'user'),
                'action' => $this->generateUrl('utilisateurs_new'),
                'method' => 'POST'));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->userManager->updateUser($utilisateur);

            $em = $this->getDoctrine()->getManager();
            $em->persist($utilisateur);
            $em->flush();


            return new Response('Utlisateur ' . $utilisateur->getNom() . ' ' . $utilisateur->getPrenom() . ' a bien été enregistré.');
        }

        return $this->render('utilisateurs/new.html.twig', array(
            'utilisateurs' => $utilisateur,
            'form' => $form->createView(),
            'titre' => 'Création d\'un utilisateur',
        ));
    }

    /**
     * Displays a form to edit an existing utilisateurs entity.
     *
     * @Route("/{codeUtilisateur}", name="utilisateurs_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Utilisateur $utilisateur)
    {
        $form = $this->createForm('AppBundle\Form\UtilisateurType', $utilisateur,
            array('attr' => array('id' => 'user'),
                'action' =>$this->generateUrl('utilisateurs_edit',
                    array('codeUtilisateur'=>$utilisateur->getCodeUtilisateur())),
                'method'=>'POST'));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userManager->updateUser($utilisateur);
            $this->getDoctrine()->getManager()->flush();

            return new Response('Utlisateur '.$utilisateur->getNom().' '.$utilisateur->getPrenom().' a bien été modifié.');
        }

        return $this->render(':utilisateurs:new.html.twig', array(
            'utilisateurs' => $utilisateur,
            'form' => $form->createView(),
            'titre' => 'Modification d\'un utilisateur'
        ));
    }

    /**
     * Deletes a utilisateurs entity.
     *
     * @Route("/{codeUtilisateur}", name="utilisateurs_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Utilisateur $utilisateur)
    {
        if ($request->isXmlHttpRequest()){
            $em = $this->getDoctrine()->getManager();
            $em->remove($utilisateur);
            $em->flush();
            return new Response('Utlisateur '.$utilisateur->getNom().' '.$utilisateur->getPrenom().' a bien été supprimé.');
        }else{
            return new Response('Ajax s\'il vous plait.');
        }
    }
}
