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
use AppBundle\Entity\Contrainte;
use AppBundle\Entity\Module;
use AppBundle\Entity\ModuleCalendrier;
use AppBundle\Entity\Stagiaire;
use AppBundle\Entity\StagiaireParEntreprise;
use AppBundle\Filtre\CalendrierFiltre;
use AppBundle\Filtre\ModuleFiltre;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Dompdf\Dompdf;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Collection;
use AppBundle\Entity\Cours;
use AppBundle\Entity\TypeContrainte;

/**
 * Class CalendrierController
 * @Route("calendriers")
 */
class CalendrierController extends Controller
{
    /**
     * Affiche le calendrier créé ou a éditer
     * @Route("/edit/{codeCalendrier}", options={"expose"=true}, name="calendrier_edit")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Calendrier $calendrier, Request $request)
    {
        if ($request->getMethod() == 'POST' && $request->isXmlHttpRequest()) {
            $removedModulesAPlacer = $request->get('removedModules');
            $addedModulesAPlacer = $request->get('addedModules');

            $moduleRepo = $this->getDoctrine()->getRepository(Module::class);
            $em = $this->getDoctrine()->getManager();

            $repo = $this->getDoctrine()->getRepository(ModuleCalendrier::class);
            $repo->delete($removedModulesAPlacer);

            foreach ($addedModulesAPlacer as $moduleCalendrier) {
                $module = $moduleRepo->find($moduleCalendrier['module']['idModule']);
                $mc = new ModuleCalendrier();
                $mc->setNbSemaines($module->getDureeEnSemaines());
                $mc->setLibelle($module->getLibelle());
                $mc->setCalendrier($calendrier);
                $mc->setModule($module);
                $em->persist($mc);
            }

            $em->flush();
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
     * @Route("/new", name="model_new")
     * @Route("/new/{codeStagiaire}", name="calendrier_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Stagiaire $stagiaire = null)
    {
        $calendrier = new Calendrier();
        $titre = '';
        if ($stagiaire != null) {
            $calendrier->setStagiaire($stagiaire);
            $calendrier->setIsModele(false);
            $titre = 'Création d\'un calendrier';
        } else {
            $calendrier->setIsModele(true);
            $titre = 'Création d\'un modèle';
        }
        $dt = new DateTime();
        $calendrier->setDateCreation($dt);
        $calendrier->setIsInscrit(false);

        //Création du formulaire de création du calendrier


        if ($stagiaire != null) {
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
            $moduleRepo = $this->getDoctrine()->getRepository(Module::class);
            $filtreModule = new ModuleFiltre();
            $filtreModule->setFormation($calendrier->getFormation());
            $modules = $moduleRepo->search($filtreModule);

            foreach ($modules as $module) {

                $moduleCalendrier = new ModuleCalendrier();
                $moduleCalendrier->setModule($module);
                $moduleCalendrier->setCalendrier($calendrier);
                $moduleCalendrier->setLibelle($module->getLibelle());
                $moduleCalendrier->setNbSemaines($module->getDureeEnSemaines());
                $calendrier->getModulesCalendrier()->add($moduleCalendrier);

            }
            
            if ($stagiaire != null) {
                $today = date("d/m/Y");
                if ($calendrier->getTitre() == null || empty($calendrier->getTitre())) {
                    $newTitre = $today . "-"
                        . $calendrier->getFormation()->getLibelleCourt() . "-"
                        . $calendrier->getStagiaire()->getNom() . " "
                        . $calendrier->getStagiaire()->getPrenom();
                    $calendrier->setTitre($newTitre);
                }
            } else {
                $today = date("d/m/Y");
                if ($calendrier->getTitre() == null || empty($calendrier->getTitre())) {
                    $newTitre = $today . "-"
                        . $calendrier->getFormation()->getLibelleCourt();
                    $calendrier->setTitre($newTitre);
                }
            }

            //region gestion de la contrainte periode contractuelle
            $contrainte = new Contrainte();
            $contrainte->setCalendrier($calendrier);
            $dateContrainte = new \DateTime("now");
            $contrainte->setDateCreation($dateContrainte);
            $contrainte->setP1($calendrier->getDateDebut()->format('d-m-Y'));
            $contrainte->setTypeP1('date');
            $contrainte->setP2($calendrier->getDateFin()->format('d-m-Y'));
            $contrainte->setTypeP2('date');
            $tcRepository = $this->getDoctrine()->getRepository(TypeContrainte::class);
            $typecontrainte = $tcRepository->findOneBy(array('codeTypeContrainte' => 1));
            $contrainte->setTypeContrainte($typecontrainte);
            $contraintes = [$contrainte];
            $calendrier->setContraintes($contraintes);
            //endregion


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
    public function searchCalendrier(Request $request, $nameModal, Stagiaire $stagiaire = null)
    {
        $em = $this->getDoctrine()->getManager();

        $repo = $this->getDoctrine()->getRepository(Calendrier::class);

        //Création de l'objet filtre
        $filtre = new  CalendrierFiltre();


        $calendriers = null;
        $nameAction = null;

        // On récupère la modal qu'on a ouvert.
        // Si celle-ci est la modal pour la duplication d'un calendrier ou pour appliquer un modèle
        if ($nameModal == "duplicate") {
            $filtre->setIsModele(0);
            $nameAction = "calendrier_duplicate";
            $titreModal = "Recherche d'un calendrier à dupliquer";
            $titreTableau = "Liste des Calendriers";
        } elseif ($nameModal == "applyModel") {
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
        if ($nameModal == "duplicate" || $nameModal == "applyModel") {
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


            if ($nameModal == "duplicate" || $nameModal == "applyModel") {
                return $this->render(':calendrier:searchTableCalendrierForm.html.twig', array(
                    'nameAction' => $nameAction,
                    'stagiaire' => $stagiaire,
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

            if ($nameModal == "duplicate" || $nameModal == "applyModel") {
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
     * @Route("/{codeCalendrier}", name="model_delete")
     * @Method("DELETE")
     * @return Response
     */
    public function deleteAction(Request $request, Calendrier $calendar, StagiaireParEntreprise $stagiaireParEntreprise = null)
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
            // Si le stagiaireParEntreprise est null c'est que le calendrier est un modele
            if ($stagiaireParEntreprise != null) {

                $calendrierNonInscrit = $repo->findBy(array('stagiaire' => $calendar->getStagiaire(), 'isInscrit' => 0));
                $calendrierInscrit = $repo->findOneBy(array('stagiaire' => $calendar->getStagiaire(), 'isInscrit' => 1));

                return $this->render('stagiaire/tableCalendrier.html.twig', array(
                    'stagiaireParEntreprise' => $stagiaireParEntreprise,
                    'calendars' => $calendrierNonInscrit,
                    'calendarRegistered' => $calendrierInscrit,
                ));
            } else {
                $modeles = $repo->findBy(array('isModele' => 1));
                $titreTableau = "Liste des modèles";
                $nameAction = "calendrier_edit";
                return $this->render('calendrier/searchTableCalendrierForm.html.twig', array(
                    'calendars' => $modeles,
                    'titreTableau' => $titreTableau,
                    'nameAction' => $nameAction,
                ));
            }
        }
    }

    /**
     * Export pdd
     *
     * @param $calendrier calendrier
     * @Route("/exportPDF/{codeCalendrier}", name="calendar_export")
     * @Method({"GET", "POST"})
     */
    public function exportPDF(Calendrier $calendrier)
    {

        $repoCalendrier = $this->getDoctrine()->getRepository(Calendrier::class);
        // Récupération du calendrier concerné.
        $calendrier = $repoCalendrier->find($calendrier);

        // On trie la liste des modulesCalendrier par la date de début du cours
        $collection = $this->sortModulesCalendrier($calendrier);
        $calendrier->setModulesCalendrier($collection);

        $tableauCalendrier = $this->getPlanning($calendrier);

        $options = new Options();
        $options->set('defaultFont', 'Calibri');
        $options->set('isRemoteEnabled', TRUE);
        $dompdf = new Dompdf($options);


        $html = $this->renderView('calendrier/calendrierPDF.html.twig', array('calendrier' => $calendrier, 'tableauDonnee' => $tableauCalendrier));
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream($calendrier->getTitre() . ".pdf");
    }

    /**
     * génère le calendrier
     * @param $calendrier calendrier
     * @return array calendrier avec entreprise et cours
     */
    public function getPlanning($calendrier)
    {

        $tableauCalendrier = array();

        // Pour gérer le temps en entreprise on va devoir fair des comparaisons de date.
        // On prend dans un premier temps le début de la formation
        $previousModuleDate = $calendrier->getDateDebut();

        // On parcourt la liste des modulesCalendrier;
        foreach ($calendrier->getModuleCalendrierPlaces() as $moduleCalendrier) {
            // On prend la date de début du cours
            $currentModuleDate = $moduleCalendrier->getDateDebut();

            // On calcule le nombre de jour d'intervale qui sépare
            // la fin d'un module (ou dans un premier cas, la date de début de formation) et la date de début d'un
            // nouveau module
            $nbJourDiff = $this->getDiffDate($currentModuleDate, $previousModuleDate);

            // Si le nombre de jour est supérieur à trois c'est que le stagiaire est en entreprise entre ces deux
            // cours. Sinon c'est qui a 2 semaines de cours à la suite
            if ($nbJourDiff > 3) {
                //
                $debutEntreprise = $this->getDateDebutEntreprise($previousModuleDate);
                $FinEntreprise = $this->getDateFinEntreprise($currentModuleDate);
                array_push($tableauCalendrier, array(
                    "entreprise" => array(
                        "debut" => $debutEntreprise->format('d/m/Y'),
                        "fin" => $FinEntreprise->format('d/m/Y'),
                        "libelle" => "ENTREPRISE")));
                array_push($tableauCalendrier, array("cours" => $moduleCalendrier));
            } else {
                array_push($tableauCalendrier, array("cours" => $moduleCalendrier));
            }
            $previousModuleDate = $moduleCalendrier->getDateFin();
        }

        // On regarde s'il y a une periode d'entreprise avant la fin de la formation
        // $previousModuleDate contient la date de fin du dernier module
        $nbJourDiff = $this->getDiffDate($calendrier->getDateFin(), $previousModuleDate);
        if ($nbJourDiff > 3) {
            $debutEntreprise = $this->getDateDebutEntreprise($previousModuleDate);
            array_push($tableauCalendrier, array(
                "entreprise" => array(
                    "debut" => $debutEntreprise->format('d/m/Y'),
                    "fin" => $calendrier->getDateFin()->format('d/m/Y'),
                    "libelle" => "ENTREPRISE")));
        }

        return $tableauCalendrier;
    }

    /**
     * Fonction permettant de rechercher la date de début en entreprise
     * @param $date date précédente concerné par la fin d'un module ou le début de la formation
     * @return DateTime date de début d'entreprise
     */
    public function getDateDebutEntreprise($date)
    {
        // Récupère le jour de la semaine 1..7
        $jourSemaine = date('N', strtotime($date->format('d-m-Y')));
        $dateDebutEntreprise = $date;

        // Tant que la date de début d'entreprise n'est pas un lundi, on incrémente la date d'une journée
        while ($jourSemaine != 1) {
            $dateString = $dateDebutEntreprise->format('d-m-Y');
            $dateDebutEntreprise = new DateTime($dateString);
            $dateDebutEntreprise->modify('+1 day');
            $jourSemaine = date('N', strtotime($dateDebutEntreprise->format('d-m-Y')));
        }

        return $dateDebutEntreprise;
    }

    /**
     * Fonction permettant de rechercher la date de début en entreprise
     * @param $date date du prochain module concerné ou date de fin de contrat
     * @return DateTime date de début d'entreprise
     */
    public function getDateFinEntreprise($date)
    {
        // Récupère le jour de la semaine 1..7
        $jourSemaine = date('N', strtotime($date->format('d-m-Y')));
        $dateFinEntreprise = $date;

        // Tant que la date de fin d'entreprise n'est pas un vendredi, on décrémente la date d'une journée
        while ($jourSemaine != 5) {
            $dateString = $dateFinEntreprise->format('d-m-Y');
            $dateFinEntreprise = new DateTime($dateString);
            $dateFinEntreprise->modify('-1 day');
            $jourSemaine = date('N', strtotime($dateFinEntreprise->format('d-m-Y')));
        }

        return $dateFinEntreprise;
    }

    /**
     * Permet de définir le nombre de jour d'intervale entre deux dates
     * @param $date1 date de fin d'un module
     * @param $date2 date de début d'un module
     * @return int nb jours d'intervale
     */
    public function getDiffDate($date1, $date2)
    {
        if ($date1 > $date2) {
            $nbJoursTimestamp = $date1->diff($date2);
        } else {
            return 0;
        }

        return $nbJoursTimestamp->format('%a');
    }

    /**
     * Permet de trier la liste des modules calendrier par la date de début d'un cours
     * @param $calendrier calendrier concerné
     * @return ArrayCollection tableau trié
     */
    public function sortModulesCalendrier($calendrier)
    {
        $arrayModulesCalendrier = $calendrier->getModuleCalendrierPlaces();

        $iterator = $arrayModulesCalendrier->getIterator();
        $iterator->uasort(function ($a, $b) {
            return ($a->getDateDebut() < $b->getDateDebut()) ? -1 : 1;
        });
        $collection = new ArrayCollection(iterator_to_array($iterator));
        return $collection;
    }


    /**
     * Permet de modifier les dates de contrat d'un calendrier
     * @param $calendrier calendrier concerné
     * @Route("/saveCalendrierDate/{codeCalendrier}", name="saveCalendrierDate", options = { "expose" = true })
     * @return JsonResponse vide
     * @Method({"POST"})
     */

    public function saveCalendrier(Request $request, Calendrier $calendrier)
    {
        $dateDebut = $request->get('dateDebut');
        $dateFin = $request->get('dateFin');
        $codeCalendrier = $request->get('codeCalendrier');
        dump($codeCalendrier);
        $repo = $this->getDoctrine()->getRepository(Calendrier::class);
        $calendrier = $repo->findOneBy(array('codeCalendrier' => $codeCalendrier));
        if ($calendrier != null) {
            $calendrier->setDateDebut($dateDebut);
            $calendrier->setDateFin($dateFin);
            $em = $this->getDoctrine()->getManager();
            $em->merge($calendrier);
            $em->flush();
        }
        return new JsonResponse($calendrier);
    }


    /**
     * @param Calendrier $calendrier
     * @Route("/inscrire/{codeCalendrier}", options={"expose"=true}, name="calendrier_inscrire")
     * @Method({"GET", "POST"})
     * @return  Response
     */
    public function inscrireCalendrier(Request $request, Calendrier $calendrier)
    {
        $repoCalendrier = $this->getDoctrine()->getRepository(Calendrier::class);
        $em = $this->getDoctrine()->getManager();
        // recherche d'un calendrier inscrit pour le stagiaire concerné.
        $calendrierIsInscrit = $repoCalendrier->findBy(array('isInscrit' => 1, 'stagiaire' => $calendrier->getStagiaire()));


        if ($request->getMethod() == 'POST' && $request->isXmlHttpRequest()) {
            if ($calendrierIsInscrit != null) {
                $calendrierIsInscrit[0]->setIsInscrit(0);
                $em->persist($calendrierIsInscrit[0]);
            }
            $calendrier->setIsInscrit(1);
            $em->persist($calendrier);
            $em->flush();
            return new JsonResponse("success");
        } else {
            return $this->render(':calendrier:modaleInscrireCalendrier.html.twig', array(
                'calendrier' => $calendrier,
                'calendrierInscrit' => $calendrierIsInscrit
            ));
        }
    }

    /**
     * @param $calendrier Calendrier
     * @Route("/nonrecouvrement/{codeCalendrier}", options={"expose"=true}, name="non_recouvrement")
     * @Method({"GET", "POST"})
     * @return  Response
     */
    public function CalendrierNonRecouvrement(Request $request)
    {
        $codeStagiaire = $request->get('codeStagiaire');
        $repo = $this->getDoctrine()->getRepository(Calendrier::class);
        $calendrieCompare = $repo->findOneBy(array('codeStagiaire' => $codeStagiaire, 'isInscrit' => 1));
        return new JsonResponse($calendrieCompare);
    }


    /**
     * Enregistre les modifications du planning du calendrier
     * @param Request $request
     * @param Calendrier $calendrierReference
     * @Route("/save/{codeCalendrier}", name="calendrier_save", options={"expose"=true})
     * @Method({"POST"})
     */
    public function saveCalendrierAction(Request $request, Calendrier $calendrierReference)
    {
        $em = $this->getDoctrine()->getManager();
        $modulesRepo = $this->getDoctrine()->getRepository(Module::class);
        $coursRepo = $this->getDoctrine()->getRepository(Cours::class);

        $received = $request->get('calendrier');
        $receivedModulesAPlacer = array_filter(json_decode($received['modulesAPlacer']));
        $receivedModulesPlaces = array_filter(json_decode($received['modulesPlaces']));

        $calendrierReference->setTitre($received['titre']);
        $calendrierReference->setDureeEnHeures($received['nbHeures']);

        $criteria = Criteria::create();
        $criteria->where(Criteria::expr()->in('codeModuleCalendrier', array_keys($receivedModulesAPlacer)));

        $modulesAPlacer = $calendrierReference->getMatchingModuleCalendrier($criteria);
        foreach ($modulesAPlacer as $mcap) {
            $mcap->setCours(null);
            $mcap->setNbSemaines($mcap->getModule()->getDureeEnSemaines());
            $mcap->setLibelle($receivedModulesAPlacer[$mcap->getCodeModuleCalendrier()]->libelle);
            $mcap->setDateDebut(null)->setDateFin(null);
        }

        $criteria->where(Criteria::expr()->in('codeModuleCalendrier', array_keys($receivedModulesPlaces)));
        $modulesPlaces = $calendrierReference->getMatchingModuleCalendrier($criteria);
        foreach ($modulesPlaces as $mcp) {
            $cours = $coursRepo->find($receivedModulesPlaces[$mcp->getCodeModuleCalendrier()]->cours->idCours);
            $mcp->setCours($cours);
            $mcp->setNbSemaines($receivedModulesPlaces[$mcp->getCodeModuleCalendrier()]->nbSemaines);
            $mcp->setLibelle($receivedModulesPlaces[$mcp->getCodeModuleCalendrier()]->libelle);
            $mcp->setDateDebut(new DateTime($receivedModulesPlaces[$mcp->getCodeModuleCalendrier()]->dateDebut->date));
            $mcp->setDateFin(new DateTime($receivedModulesPlaces[$mcp->getCodeModuleCalendrier()]->dateFin->date));
        }

        $refMC = array_reduce($calendrierReference->getModulesCalendrier()->toArray(), function ($p1, $p2) {
            $p1[] = $p2->getCodeModuleCalendrier();
            return $p1;
        }, []);

        $recMcp = array_keys($receivedModulesPlaces);
        $recMcap = array_keys($receivedModulesAPlacer);
        $nouveauxMcp = array_diff($recMcp, $refMC, $recMcap);
        $nouveauxMcap = array_diff($recMcap, $refMC, $recMcp);

        foreach ($nouveauxMcp as $keyModulePlace) {
            $stdModuleCalendrierPlace = $receivedModulesPlaces[$keyModulePlace];
            $module = $modulesRepo->find($stdModuleCalendrierPlace->module->idModule);
            $cours = $coursRepo->find($stdModuleCalendrierPlace->cours->idCours);

            $newModuleCalendrierPlace = new ModuleCalendrier();
            $newModuleCalendrierPlace->setModule($module);
            $newModuleCalendrierPlace->setLibelle($stdModuleCalendrierPlace->libelle);
            $newModuleCalendrierPlace->setNbSemaines($stdModuleCalendrierPlace->nbSemaines);
            $newModuleCalendrierPlace->setDateDebut(new DateTime($stdModuleCalendrierPlace->dateDebut->date));
            $newModuleCalendrierPlace->setDateFin(new DateTime($stdModuleCalendrierPlace->dateFin->date));
            $newModuleCalendrierPlace->setCours($cours);

            $calendrierReference->addModuleCalendrier($newModuleCalendrierPlace);
        }

        foreach ($nouveauxMcap as $keyModuleAPlace) {
            $stdModuleCalendrierAPlace = $receivedModulesAPlacer[$keyModuleAPlace];
            $module = $modulesRepo->find($stdModuleCalendrierAPlace->module->idModule);

            $newModuleCalendrierAPlace = new ModuleCalendrier();
            $newModuleCalendrierAPlace->setModule($module);
            $newModuleCalendrierAPlace->setLibelle($stdModuleCalendrierAPlace->libelle);
            $newModuleCalendrierAPlace->setCours(null);

            $calendrierReference->addModuleCalendrier($newModuleCalendrierAPlace);
        }

        $em->persist($calendrierReference);
        $em->flush();

        return new Response();
    }
}