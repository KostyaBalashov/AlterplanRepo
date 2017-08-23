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
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CalendrierController
 * @Route("calendrier")
 */
class CalendrierController extends Controller
{

    /**
     * Affiche le calendrier créé ou a éditer
     * @Route("/edit/{codeCalendrier}", name="calendrier_edit")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Calendrier $calendrier) {

        return $this->render(':calendrier:index.html.twig', array(
            'calendrier' => $calendrier,
        ));
    }

    /**
     * Créé un nouveau calendrier.
     *
     * @Route("/new/{codeStagiaire}", name="calendrier_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Stagiaire  $stagiaire)
        {
            $calendrier = new Calendrier();
            $calendrier->setStagiaire($stagiaire);
            $dt = new DateTime();
            $calendrier->setDateCreation($dt);
            $calendrier->setIsInscrit(false);
            $calendrier->setIsModele(false);

        //Création du formulaire de création du calendrier
        $form = $this->createForm('AppBundle\Form\CalendrierType', $calendrier,
            array('attr' => array('id' => 'calendrier'),
                'action' => $this->generateUrl('calendrier_new',array('codeStagiaire'=>$stagiaire->getCodeStagiaire())),
                'method' => 'POST'));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($calendrier);

            $em = $this->getDoctrine()->getManager();
            $em->persist($calendrier);
            $em->flush();


            return new Response('Le calendrier ' . $calendrier->getTitre() . ' a bien été enregistré.');
        }

        return $this->render(':calendrier:newCalendrierForm.html.twig', array(
            'calendrier' => $calendrier,
            'form' => $form->createView(),
            'titre' => 'Création d\'un calendrier',
        ));
    }



    /**
     * Deletes a calendar entity.
     *
     * @Route("/{codeCalendrier}/{numLien}", name="calendar_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Calendrier $calendar, StagiaireParEntreprise $stagiaireParEntreprise)
    {

        if($calendar->isInscrit()) {
            return Response('Le calendrier ' . $calendar->getTitre() . ' ne peut pas être supprimé car il est inscrit');
        } else {
            $em = $this->getDoctrine()->getManager();
            $em->remove($calendar);
            $em->flush();
            // Retourner le tableau

            // Affichage de la fiche du stagiaire avec la liste de ses calendrier
            $repo = $this->getDoctrine()->getRepository(Calendrier::class);
            $calendrierNonInscrit = $repo->findBy(array('stagiaire' =>  $calendar->getStagiaire(), 'isInscrit' => 0));
            $calendrierInscrit = $repo->findOneBy(array('stagiaire' =>  $calendar->getStagiaire(), 'isInscrit' => 1));

            return $this->render('stagiaire/tableCalendrier.html.twig', array(
                'stagiaireParEntreprise' => $stagiaireParEntreprise,
                'calendars' => $calendrierNonInscrit,
                'calendarRegistered' => $calendrierInscrit,
            ));
        }
    }
}