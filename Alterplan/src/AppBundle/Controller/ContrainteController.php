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

use AppBundle\AppBundle;
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
use Symfony\Component\HttpFoundation\Response;

class ContrainteController extends Controller
{
    /**
     * @param Request $request
     * @param Calendrier $calendrier
     *
     * @Route("/contraintes/{codeCalendrier}", name="contraintes_edit", options = { "expose" = true })
     * @Method({"GET", "POST"})
     */
    public function editContraintes(Request $request, Calendrier $calendrier)
    {
        if ($request->getMethod() == 'POST') {
            $updatedContraintes = $request->get('updatedContraintes');
            $removedContraintes = $request->get('removedContraintes');
            dump($updatedContraintes);
            dump($removedContraintes);
            $em = $this->getDoctrine()->getManager();
            if ($updatedContraintes != null || !empty($updatedContraintes)) {
                foreach ($updatedContraintes as $arrayContrainte) {
                    if ($arrayContrainte != null && $arrayContrainte != "") {
                        $typecontrainte = new TypeContrainte();
                        $repositoryContrainte = $this
                            ->getDoctrine()
                            ->getManager()
                            ->getRepository('AppBundle:TypeContrainte');
                        $typecontrainte = $repositoryContrainte->find($arrayContrainte['typeContrainte']['codeTypeContrainte']);

                        $typecontrainte->setCodeTypeContrainte($arrayContrainte['typeContrainte']['codeTypeContrainte']);
                        $typecontrainte->setLibelle($arrayContrainte['typeContrainte']['libelle']);
                        $typecontrainte->setNbParametres($arrayContrainte['typeContrainte']['nbParametres']);
                        $contrainte = new Contrainte();
                        $contrainte->setCodeContrainte($arrayContrainte['codeContrainte']);
                        $dateContrainte = new \DateTime("now");
                        $contrainte->setDateCreation($dateContrainte);
                        $contrainte->setP1($arrayContrainte['P1']);
                        $contrainte->setP2($arrayContrainte['P2']);
                        $contrainte->setCalendrier($calendrier);
                        $contrainte->setTypeContrainte($typecontrainte);


                        if ($contrainte->getCodeContrainte() != null) {
                            $em->merge($contrainte);
                            $em->flush();
                        } else {
                            $em->persist($contrainte);
                            $em->flush();
                        }

                    }
                }
            }
            if ($removedContraintes != null || !empty($removedContraintes)) {
                foreach ($removedContraintes as $idContrainte) {
                    if ($idContrainte != null && $idContrainte != "") {
                        $contrainte = $em->getReference("AppBundle:Contrainte", $idContrainte);
                        $em->remove($contrainte);
                        $em->flush();
                    }
                }
            }
            return new Response();

        } else {

            $titre = 'Modification des contraintes ';
            $tcRepository = $this->getDoctrine()->getRepository(TypeContrainte::class);
            $typecontrainteList = $tcRepository->findAll();


            return $this->render(':contraintes:contraintesForm.html.twig', array(
                'calendrier' => $calendrier,
                'typeContraintes' => $typecontrainteList,
                'titre' => $titre
            ));

        }
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