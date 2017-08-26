<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Utilisateur;
use AppBundle\Filtre\UtilisateurFiltre;
use AppBundle\Form\UtilisateurFiltreType;
use FOS\UserBundle\Model\UserInterface;
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
        //Récupération du repository
        $repo = $this->getDoctrine()->getRepository(Utilisateur::class);

        //Création de l'objet filtre
        $filtre = new  UtilisateurFiltre();

        //Création du formulaire de recherche
        $form = $this->createForm(UtilisateurFiltreType::class, $filtre, array(
            'action' => $this->generateUrl('utilisateurs_index')
        ));

        $utilisateurs = null;

        //Le formulaire écoute les requêtes (pour le submit)
        $form->handleRequest($request);

        //Si le formulaire est sousmis
        if ($form->isSubmitted()){
            //On recherche les utilisateurs avec les critères de filtre
            $utilisateurs = $repo->search($filtre);

            //Réponse à la recherche
            return $this->render(':utilisateurs:table.html.twig', array(
                'utilisateurs' => $utilisateurs,
            ));
        }

        //Dans tous les autres cas
        //On charge tous les utilisateurs
        $utilisateurs = $repo->search();

        if ($request->getMethod() == 'GET'){
            if ($request->isXmlHttpRequest()){
                //La réponse au GET en ajax
                //survient après la création ou la modification de l'utilisateur
                return $this->render(':utilisateurs:table.html.twig', array(
                    'utilisateurs' => $utilisateurs,
                ));
            }
        }

        //La réponse au GET normal
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
            $utilisateur->setIsAdministrateur($form->getData()->getIsAdministrateur());
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

        $titre = 'Modification de l\'utilisateur ';

        if ($this->getUser()->getId() !== $utilisateur->getId()){
            $titre = $titre.$utilisateur->getUsername();
        }else{
            $titre = 'Mon compte';
        }

        return $this->render(':utilisateurs:userForm.html.twig', array(
            'utilisateurs' => $utilisateur,
            'form' => $form->createView(),
            'titre' => $titre
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
            return new Response('Action non autoriséee.', Response::HTTP_FORBIDDEN);
        }
    }
}
