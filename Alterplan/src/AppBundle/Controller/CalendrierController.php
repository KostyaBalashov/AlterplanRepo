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
use AppBundle\Entity\StagiaireParEntreprise;
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
     * Deletes a calendar entity.
     *
     * @Route("/{codeCalendrier}", name="calendar_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Calendrier $calendar)
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($calendar);
        $em->flush();
        // Retourner le tableau

        // Affichage de la fiche du stagiaire avec la liste de ses calendrier
        $repo = $this->getDoctrine()->getRepository(Calendrier::class);
        $calendriers = $repo->findBy(array('stagiaire' => $calendar->getStagiaire()));

        return $this->render('stagiaire/show.html.twig', array(
            'calendars' => $calendriers,
        ));

        //return $this->redirectToRoute('stagiaires_show',array('numLien' => 7));
        //return new Response('Utlisateur ' . $calendar->getTitre() . ' a bien été supprimé.');
    }
}