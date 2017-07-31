<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Utilisateur;
use AppBundle\Filtre\UtilisateurFiltre;
use AppBundle\Form\UtilisateurFiltreType;
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
     * Liste les utilisateurs correspondants aux critères de recherche.
     *
     * @Route("/", name="utilisateurs_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(Utilisateur::class);

        $filtre = new  UtilisateurFiltre();
        $form = $this->createForm(UtilisateurFiltreType::class, $filtre, array(
            'attr' => array('id' => 'user_search'),
            'action' => $this->generateUrl('utilisateurs_index'),
            'method' => 'POST'
        ));

        $utilisateurs = null;

        $form->handleRequest($request);

        if ($form->isSubmitted()){
            $utilisateurs = $repo->search($filtre);

            //On retourne que le tableau des utilisateurs.
            return $this->render(':utilisateurs:table.html.twig', array(
                'utilisateurs' => $utilisateurs,
            ));
        }

        //On charge tous les utilisateurs
        $utilisateurs = $repo->search();

        //Si c'est un get
        if ($request->getMethod() == 'GET'){

            //Si c'est de l'ajax
            if ($request->isXmlHttpRequest()){

                //On retourne que le tableau des utilisateurs.
                return $this->render(':utilisateurs:table.html.twig', array(
                    'utilisateurs' => $utilisateurs,
                ));
            }
        }

        return $this->render('utilisateurs/index.html.twig', array(
            'utilisateurs' => $utilisateurs,
            'formSearch' => $form->createView()
        ));
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

        return $this->render(':utilisateurs:userForm.html.twig', array(
            'utilisateurs' => $utilisateur,
            'form' => $form->createView(),
            'titre' => 'Création d\'un utilisateur',
        ));
    }

    /**
     * Displays a form to edit an existing utilisateurs entity.
     *
     * @Route("/{id}", name="utilisateurs_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Utilisateur $utilisateur)
    {
        $form = $this->createForm('AppBundle\Form\UtilisateurType', $utilisateur,
            array('attr' => array('id' => 'user'),
                'action' =>$this->generateUrl('utilisateurs_edit',
                    array('id'=>$utilisateur->getId())),
                'method'=>'POST'));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userManager->updateUser($utilisateur);
            $this->getDoctrine()->getManager()->flush();

            return new Response('Utlisateur '.$utilisateur->getNom().' '.$utilisateur->getPrenom().' a bien été modifié.');
        }

        return $this->render(':utilisateurs:userForm.html.twig', array(
            'utilisateurs' => $utilisateur,
            'form' => $form->createView(),
            'titre' => 'Modification d\'un utilisateur'
        ));
    }

    /**
     * Deletes a utilisateurs entity.
     *
     * @Route("/{id}", name="utilisateurs_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Utilisateur $utilisateur)
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($utilisateur);
            $em->flush();
            return new Response('Utlisateur ' . $utilisateur->getNom() . ' ' . $utilisateur->getPrenom() . ' a bien été supprimé.');
        } else {
            return new Response('Ajax s\'il vous plait.');
        }
    }
}
