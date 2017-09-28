<?php
/**
 * Created by PhpStorm.
 * User: a590697
 * Date: 17/08/2017
 * Time: 01:40
 *//*
This file is part of Alterplan. 
 
Alterplan is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. 
 
Alterplan is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details. 
 
You should have received a copy of the GNU Affero General Public License along with Alterplan. If not, see <http://www.gnu.org/licenses/>.
*/


namespace AppBundle\Controller;


use AppBundle\Entity\Calendrier;
use AppBundle\Entity\Stagiaire;
use AppBundle\Entity\StagiaireParEntreprise;
use AppBundle\Filtre\CalendrierFiltre;
use AppBundle\Form\Filtre\CalendrierFiltreType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CalendrierController
 * @Route("calendriers")
 */
class CalendrierController extends Controller
{
    private $moduleAPlanifierService;

    public function __construct(ModuleAPlanifierService $moduleAPlanifierService)
    {
        $this->moduleAPlanifierService = $moduleAPlanifierService;
    }

    /**
     * Affiche le calendrier créé ou a éditer
     * @Route("/edit/{codeCalendrier}", name="calendrier_edit")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Calendrier $calendrier, Request $request)
    {
        if ($request->getMethod() == 'POST' && $request->isXmlHttpRequest()) {
            $removedModulesAPlacer = $request->get('removedModules');
            $addedModulesAPlacer = $request->get('addedModules');

            if ($removedModulesAPlacer) {
                $this->moduleAPlanifierService->delete($calendrier->getCodeCalendrier(), $removedModulesAPlacer);
            }

            if ($addedModulesAPlacer) {
                $this->moduleAPlanifierService->insert($calendrier->getCodeCalendrier(), $addedModulesAPlacer);
            }

            return new Response('Ok');
        } else {
            return $this->render(':calendrier:edit.html.twig', array(
                'calendrier' => $calendrier
            ));
        }
    }

    /**
     * Créé un nouveau calendrier.
     *
     * @Route("/new/{codeStagiaire}", name="calendrier_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Stagiaire  $stagiaire = null)
        {
            $calendrier = new Calendrier();
            $titre ='';
            if($stagiaire != null) {
                $calendrier->setStagiaire($stagiaire);
                $calendrier->setIsModele(false);
                $titre= 'Création d\'un calendrier';
            } else {
                $calendrier->setIsModele(true);
                $titre= 'Création d\'un modèle';
            }
            $dt = new DateTime();
            $calendrier->setDateCreation($dt);
            $calendrier->setIsInscrit(false);

        //Création du formulaire de création du calendrier


            if($stagiaire != null) {
                $form = $this->createForm('AppBundle\Form\CalendrierType', $calendrier,
                    array('attr' => array('id' => 'calendrier'),
                        'action' => $this->generateUrl('calendrier_new', array('codeStagiaire' => $stagiaire->getCodeStagiaire())),
                        'method' => 'POST'));
            } else {
                $form = $this->createForm('AppBundle\Form\CalendrierType', $calendrier,
                    array('attr' => array('id' => 'calendrier'),
                        'action' => $this->generateUrl('model_new'),
                        'method' => 'POST'));
            }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            foreach ($calendrier->getFormation()->getAllModules() as $module) {
                if (!$module->isArchiver()) {
                    $calendrier->addModuleAPlacer($module);
                }
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($calendrier);
            $em->flush();

            return $this->redirect($this->generateUrl('calendrier_edit', array('codeCalendrier' => $calendrier->getCodeCalendrier())));
        }

        return $this->render(':calendrier:newCalendrierForm.html.twig', array(
            'calendrier' => $calendrier,
            'form' => $form->createView(),
            'titre' => $titre,
        ));
    }

    /**
     * Rechercher un calendrier à dupliquer ou à appliquer un modèle
     *
     * @param $request request
     * @param $nameModal string
     * @param $stagiaire Stagiaire
     * @Route("/searchCalendar/{nameModal}", name="model_search")
     * @Route("/searchCalendar/{nameModal}/{codeStagiaire}", name="calendrier_search")
     * @Method({"GET", "POST"})
     * @return Response
     */
    public function searchCalendrier(Request $request, $nameModal, Stagiaire $stagiaire = null){
        $em = $this->getDoctrine()->getManager();

        $repo = $this->getDoctrine()->getRepository(Calendrier::class);

        //Création de l'objet filtre
        $filtre = new  CalendrierFiltre();


        $calendriers = null;
        $nameAction = null;

        // On récupère la modal qu'on a ouvert.
        // Si celle-ci est la modal pour la duplication d'un calendrier ou pour appliquer un modèle
        if($nameModal == "duplicate") {
            $filtre->setIsModele(0);
            $nameAction = "calendrier_duplicate";
            $titreModal = "Recherche d'un calendrier à dupliquer";
            $titreTableau = "Liste des Calendriers";
        } elseif($nameModal == "applyModel") {
            $filtre->setIsModele(1);
            $nameAction = "apply_model";
            $titreModal = "Recherche d'un modèle à appliquer au nouveau calendrier";
            $titreTableau = "Liste des modèles";
        } else {
            $filtre->setIsModele(1);
            $nameAction = "calendrier_edit";
            $titreModal = "Gestion des modèles";
            $titreTableau = "Liste des Modèles";
        }

        //Création du formulaire de recherche
        if($nameModal == "duplicate" || $nameModal == "applyModel") {
            $form = $this->createForm('AppBundle\Form\Filtre\CalendrierFiltreType', $filtre, array(
                'attr' => array('id' => 'calendrier_search'),
                'action' => $this->generateUrl('calendrier_search', array('nameModal' => $nameModal, 'codeStagiaire' => $stagiaire->getCodeStagiaire())),
                'method' => 'POST'
            ));
        } else {
            $form = $this->createForm('AppBundle\Form\Filtre\CalendrierFiltreType', $filtre, array(
                'attr' => array('id' => 'calendrier_search'),
                'action' => $this->generateUrl('model_search', array('nameModal' => $nameModal)),
                'method' => 'POST'
            ));
        }
        $form->handleRequest($request);


        //Si le formulaire est sousmis
        if ($form->isSubmitted()) {

            $calendriers = $repo->search($filtre);


            if($nameModal == "duplicate" || $nameModal == "applyModel") {
                return $this->render(':calendrier:searchTableCalendrierForm.html.twig', array(
                    'nameAction' => $nameAction,
                    'stagiaire' =>$stagiaire,
                    'calendars' => $calendriers,
                    'titreTableau' => $titreTableau,
                    'nameModal' => $nameModal
                ));

            } else {
                return $this->render(':calendrier:searchTableCalendrierForm.html.twig', array(
                    'nameAction' => $nameAction,
                    'calendars' => $calendriers,
                    'titreTableau' => $titreTableau,
                    'nameModal' => $nameModal
                ));
            }
        } else {

            $newFiltre = new  CalendrierFiltre();
            $newFiltre->setIsModele($filtre->isModele());
            $calendriers = $repo->search($newFiltre);

            if($nameModal == "duplicate" || $nameModal == "applyModel") {
                return $this->render(':calendrier:modaleSearchCalendrier.html.twig', array(
                    'calendars' => $calendriers,
                    'nameAction' => $nameAction,
                    'stagiaire' => $stagiaire,
                    'formSearch' => $form->createView(),
                    'titreModal' => $titreModal,
                    'titreTableau' => $titreTableau,
                    'nameModal' => $nameModal
                ));
            } else {
                return $this->render(':calendrier:gestionModele.html.twig', array(
                    'calendars' => $calendriers,
                    'nameAction' => $nameAction,
                    'formSearch' => $form->createView(),
                    'titreModal' => $titreModal,
                    'titreTableau' => $titreTableau,
                    'nameModal' => $nameModal
                ));
            }
        }
    }

    /**
     * Duplicate a calendar entity
     *
     * @param $calendrier Calendrier
     * @param $stagiaire Stagiaire
     * @Route("/duplicate/{codeCalendrier}/{codeStagiaire}", name="calendrier_duplicate")
     * @Method({"GET", "POST"})
     * @return Response
     */
    public function duplicate(Calendrier $calendrier, Stagiaire $stagiaire)
    {
        // On crée un nouveau calendrier en reprenant les données du calendrier sélectionné
        $newCalendrier = clone $calendrier;

        $newCalendrier->setStagiaire($stagiaire);
        $newCalendrier->setDateCreation(new DateTime());
        $em = $this->getDoctrine()->getManager();
        $em->persist($newCalendrier);
        $em->flush();

        return $this->redirectToRoute('calendrier_edit', array(
            'codeCalendrier' => $newCalendrier->getCodeCalendrier(),
        ));
    }

    /**
     * Apply modele
     *
     * @param $calendrier Calendrier
     * @param $stagiaire Stagiaire
     * @Route("/applyModel/{codeCalendrier}/{codeStagiaire}", name="apply_model")
     * @Method({"GET", "POST"})
     * @return Response
     */
    public function applyModel(Calendrier $calendrier, Stagiaire $stagiaire)
    {
        // On crée un nouveau calendrier en reprenant les données du calendrier sélectionné
        $newCalendrier = clone $calendrier;

        $newCalendrier->setStagiaire($stagiaire);
        $newCalendrier->setDateCreation(new DateTime());
        $newCalendrier->setIsModele(0);

        $em = $this->getDoctrine()->getManager();
        $em->persist($newCalendrier);
        $em->flush();

        return $this->redirectToRoute('calendrier_edit', array(
            'codeCalendrier' => $newCalendrier->getCodeCalendrier(),
        ));
    }

    /**
     * Deletes a calendar entity.
     *
     * @param $request Request
     * @param $calendar Calendrier
     * @param $stagiaireParEntreprise StagiaireParEntreprise
     * @Route("/{codeCalendrier}/{numLien}", name="calendar_delete")
     * @Method("DELETE")
     * @return Response
     */
    public function deleteAction(Request $request, Calendrier $calendar, StagiaireParEntreprise $stagiaireParEntreprise)
    {

        if ($calendar->isInscrit()) {
            return new Response('Le calendrier ' . $calendar->getTitre() . ' ne peut pas être supprimé car il est inscrit.', Response::HTTP_FORBIDDEN);
        } else {
            $em = $this->getDoctrine()->getManager();
            $em->remove($calendar);
            $em->flush();
            // Retourner le tableau

            // Affichage de la fiche du stagiaire avec la liste de ses calendrier
            $repo = $this->getDoctrine()->getRepository(Calendrier::class);
            $calendrierNonInscrit = $repo->findBy(array('stagiaire' => $calendar->getStagiaire(), 'isInscrit' => 0));
            $calendrierInscrit = $repo->findOneBy(array('stagiaire' => $calendar->getStagiaire(), 'isInscrit' => 1));

            return $this->render('stagiaire/tableCalendrier.html.twig', array(
                'stagiaireParEntreprise' => $stagiaireParEntreprise,
                'calendars' => $calendrierNonInscrit,
                'calendarRegistered' => $calendrierInscrit,
            ));
        }
    }
}