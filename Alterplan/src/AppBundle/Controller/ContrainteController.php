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

use AppBundle\Entity\Stagiaire;
use AppBundle\Entity\TypeContrainte;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Calendrier;
use AppBundle\Entity\Contrainte;
use AppBundle\Form\Filtre\FormationFiltreType;

class ContrainteController extends Controller
{
    /**
     * @param Request $request
     * @param Calendrier $calendrier
     *
     * @Route("/contraintes/{codeCalendrier}", name="contraintes_edit")
     * @Method({"GET", "POST"})
     */
    public function editContraintes(Request $request, Calendrier $calendrier)
    {

        $titre = 'Modification des contraintes ';
        $tcRepository = $this->getDoctrine()->getRepository(TypeContrainte::class);
        $typecontrainteList = $tcRepository->findAll();


        return $this->render(':contraintes:contraintesForm.html.twig', array(
            'calendrier' => $calendrier,
            'typeContraintes' => $typecontrainteList,
            'titre' => $titre
        ));
    }

    /**
     * @param Request $request
     * @Route("/contraintes/typeContrainte/{codeCalendrier}", name="all_typeContraintes")
     * @Method({"GET", "POST"})
     */
    public function allTypeContraintes(Request $request)
    {
        $tcRepository = $this->getDoctrine()->getRepository(TypeContrainte::class);
        $typecontrainteList = $tcRepository->findAll();
        return new JsonResponse($typecontrainteList);
    }
}