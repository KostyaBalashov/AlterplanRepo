<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Calendrier;
use AppBundle\Entity\Stagiaire;
use AppBundle\Entity\StagiaireParEntreprise;
use AppBundle\Filtre\StagiaireParEntrepriseFiltre;
use AppBundle\Form\Filtre\StagiaireParEntrepriseFiltreType;
use AppBundle\Repository\CalendrierRepository;
use AppBundle\Repository\StagiaireParEntrepriseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * StagiaireParEntreprisecontroller.
 *
 * @Route("stagiaires")
 */
class StagiaireParEntrepriseController extends Controller
{
    /**
     * Lists all stagiaireParEntreprise entities.
     *
     * @Route("/", name="stagiaires_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $repo = $this->getDoctrine()->getRepository(StagiaireParEntreprise::class);

        //Création de l'objet filtre
        $filtre = new  StagiaireParEntrepriseFiltre();

        //Création du formulaire de recherche
        $form = $this->createForm(StagiaireParEntrepriseFiltreType::class, $filtre, array(
            'attr' => array('id' => 'stagiaire_search'),
            'action' => $this->generateUrl('stagiaires_index'),
            'method' => 'POST'
        ));

        $stagiairesEntreprise = null;

        // Le formulaire écoute les requêtes (pour le submit)
        $form->handleRequest($request);

        //Si le formulaire est sousmis
        if ($form->isSubmitted()) {
            //On recherche les formations avec les critères de filtre
            $stagiairesEntreprise = $repo->search($filtre);

            //Réponse à la recherche
            return $this->render(':stagiaire:tableStagiaire.html.twig', array(
                'stagiairesEntreprise' => $stagiairesEntreprise,
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
     * @Route("/{numLien}", name="stagiaires_show")
     * @Method("GET")
     */
    public function showAction(StagiaireParEntreprise $stagiaireParEntreprise)
    {

        // Affichage de la fiche du stagiaire avec la liste de ses calendrier
        $repo = $this->getDoctrine()->getRepository(Calendrier::class);
        $calendriers = $repo->findBy(array('stagiaire' => $stagiaireParEntreprise->getStagiaire()));

        $calendrierInscrit = null;
        foreach ($calendriers as $calendrier) {
            if ($calendrier->isInscrit() == 1) {
                $calendrierInscrit = $calendrier;
            }
        }
        return $this->render('stagiaire/show.html.twig', array(
            'stagiaireParEntreprise' => $stagiaireParEntreprise,
            'calendars' => $calendriers,
            'calendarRegistered' => $calendrierInscrit,
        ));
    }
}