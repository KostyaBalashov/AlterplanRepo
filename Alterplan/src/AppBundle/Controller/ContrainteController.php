<?php
/**
 * Created by PhpStorm.
 * User: penno
 * Date: 16/08/2017
 * Time: 18:03
 *//*
This file is part of Alterplan. 
 
Alterplan is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. 
 
Alterplan is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details. 
 
You should have received a copy of the GNU Affero General Public License along with Alterplan. If not, see <http://www.gnu.org/licenses/>.
*/


namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Calendrier;
use AppBundle\Entity\Contrainte;
use AppBundle\Form\Filtre\FormationFiltreType;

class ContrainteController extends Controller
{
    /**
     * @param Request $request
     *
     * @Route("/{calendrier}/contraintes", name="contraintes_edit")
     * @Method({"GET", "POST"})
     */
    public function editContraintes(Request $request, Calendrier $calendrier, array $contraintes){

        $form = $this->createForm('AppBundle\Form\contrainteType', $calendrier, $contraintes,
            array('attr' => array('id' => 'contraintes'),
                'action' =>$this->generateUrl('contraintes_edit',
                    array('id'=>$calendrier->getId())),
                'method'=>'POST'));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return new Response('Les contraintes ont bien été modifiées.');
        }

        $titre = 'Modification des contraintes ';


        return $this->render(':contraintes:contrainteForm.html.twig', array(
            'calendrier' => $calendrier,
            'contraintes' => $contraintes,
            'form' => $form->createView(),
            'titre' => $titre
        ));
    }
}