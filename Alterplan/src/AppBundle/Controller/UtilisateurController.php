<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Utilisateur;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

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
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $utilisateurs = $em->getRepository('AppBundle:Utilisateur')->findAll();

        return $this->render('utilisateurs/index.html.twig', array(
            'utilisateurs' => $utilisateurs,
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
        $form = $this->createForm('AppBundle\Form\UtilisateurType', $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userManager->updateUser($utilisateur);

            $em = $this->getDoctrine()->getManager();
            $em->persist($utilisateur);
            $em->flush();

            return $this->redirectToRoute('utilisateurs_show', array('codeUtilisateur' => $utilisateur->getCodeutilisateur()));
        }

        return $this->render('utilisateurs/new.html.twig', array(
            'utilisateurs' => $utilisateur,
            'form' => $form->createView(),
            'titre' => 'Création d\'un utilisateur',
        ));
    }

    /**
     * Finds and displays a utilisateurs entity.
     *
     * @Route("/{codeUtilisateur}", name="utilisateurs_show")
     * @Method("GET")
     */
    public function showAction(Utilisateur $utilisateur)
    {
        $deleteForm = $this->createDeleteForm($utilisateur);

        return $this->render('utilisateurs/show.html.twig', array(
            'utilisateurs' => $utilisateur,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing utilisateurs entity.
     *
     * @Route("/{codeUtilisateur}/edit", name="utilisateurs_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Utilisateur $utilisateur)
    {
        $deleteForm = $this->createDeleteForm($utilisateur);
        $editForm = $this->createForm('AppBundle\Form\UtilisateurType', $utilisateur);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('utilisateurs_edit', array('codeUtilisateur' => $utilisateur->getCodeutilisateur()));
        }

        return $this->render('utilisateur/edit.html.twig', array(
            'utilisateurs' => $utilisateur,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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
        $form = $this->createDeleteForm($utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($utilisateur);
            $em->flush();
        }

        return $this->redirectToRoute('utilisateurs_index');
    }

    /**
     * Creates a form to delete a utilisateurs entity.
     *
     * @param Utilisateur $utilisateur The utilisateurs entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Utilisateur $utilisateur)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('utilisateurs_delete', array('codeUtilisateur' => $utilisateur->getCodeutilisateur())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
