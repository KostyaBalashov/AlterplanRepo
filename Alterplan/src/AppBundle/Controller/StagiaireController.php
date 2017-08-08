<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Stagiaire;
use AppBundle\Filtre\StagiaireFiltre;
use AppBundle\Form\Filtre\StagiaireFiltreType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\BrowserKit\Request;

/**
 * Stagiaire controller.
 *
 * @Route("stagiaires")
 */
class StagiaireController extends Controller
{
    /**
     * Lists all stagiaireParEntreprise entities.
     *
     * @Route("/", name="stagiaires_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $repo = $em->getRepository('AppBundle:Stagiaire');

        //Création de l'objet filtre
        $filtre = new  StagiaireFiltre();

        //Création du formulaire de recherche
        $form = $this->createForm(StagiaireFiltreType::class, $filtre, array(
            'attr' => array('id' => 'stagiaire_search'),
            'action' => $this->generateUrl('stagiaires_index'),
            'method' => 'POST'
        ));

        $stagiairesEntreprise = null;

        // Le formulaire écoute les requêtes (pour le submit)
        $form->handleRequest($request);

        //Si le formulaire est sousmis
        if ($form->isSubmitted()){
            //On recherche les formations avec les critères de filtre
            $stagiairesEntreprise = $repo->search($filtre);

            //Réponse à la recherche
            return $this->render(':stagiaire:table.html.twig', array(
                '$stagiairesEntreprise' => $stagiairesEntreprise,
            ));
        }

        //Dans tous les autres cas
        //On charge toutes les formations
        $stagiairesEntreprise = $repo->search();

        return $this->render('stagiaire/index.html.twig', array(
            'stagiairesEntreprise' => $stagiairesEntreprise,
            'formSearch' => $form->createView()
        ));
    }

    /**
     * Finds and displays a stagiaire entity.
     *
     * @Route("/{codeStagiaire}", name="stagiaires_show")
     * @Method("GET")
     */
    public function showAction(Stagiaire $stagiaire)
    {

        return $this->render('stagiaire/show.html.twig', array(
            'stagiaire' => $stagiaire,
        ));
    }
}
