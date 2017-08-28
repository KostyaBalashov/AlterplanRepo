<?php
/**
 * Created by PhpStorm.
 * User: penno
 * Date: 01/08/2017
 * Time: 16:18
 *//*
This file is part of Alterplan. 
 
Alterplan is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. 
 
Alterplan is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details. 
 
You should have received a copy of the GNU Affero General Public License along with Alterplan. If not, see <http://www.gnu.org/licenses/>.
*/


namespace AppBundle\Controller;

use AppBundle\Entity\Formation;
use AppBundle\Entity\GroupeModule;
use AppBundle\Entity\OrdreModule;
use AppBundle\Entity\SousGroupeModule;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Filtre\FormationFiltre;
use AppBundle\Form\Filtre\FormationFiltreType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Utilisateur controller.
 *
 * @Route("Formations")
 */
class FormationController extends Controller
{
    /**
     * Liste les formations correspondants aux critères de recherche.
     *
     * @Route("/", name="formations_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        //Récupération du repository
        $repo = $this->getDoctrine()->getRepository(Formation::class);

        //Création de l'objet filtre
        $filtre = new  FormationFiltre();

        //Création du formulaire de recherche
        $form = $this->createForm(FormationFiltreType::class, $filtre, array(
            'attr' => array('id' => 'formation_search'),
            'action' => $this->generateUrl('formations_index'),
            'method' => 'POST'
        ));

        $formations = null;

        //Le formulaire écoute les requêtes (pour le submit)
        $form->handleRequest($request);

        //Si le formulaire est sousmis
        if ($form->isSubmitted()){
            //On recherche les formations avec les critères de filtre
            $formations = $repo->search($filtre);

            //Réponse à la recherche
            return $this->render(':formations:table.html.twig', array(
                'formations' => $formations,
            ));
        }

        //Dans tous les autres cas
        //On charge toutes les formations
        $formations = $repo->search();


        return $this->render('formations/index.html.twig', array(
            'formations' => $formations,
            'formSearch' => $form->createView()
        ));
    }

    /**
     * @param Request $request
     * @param Formation $formation
     *
     * @Route("/{codeFormation}", name="formations_edit")
     * @Method("GET")
     */
    public function editAction(Request $request, Formation $formation){

        if ($request->isXmlHttpRequest()){
            return $this->render('ordreLogique/ordreModule.html.twig');
        }

        return $this->render(':ordreLogique:gestionOrdre.html.twig', array(
            'formation' => $formation,
            'modules' => $formation->getAllModules()
        ));
    }

    /**
     * @param Request $request
     * @param Formation $formation
     *
     * @Route("/{codeFormation}", name="formations_save")
     * @Method("POST")
     */
    public function saveAction(Request $request, Formation $formation){
        if ($request->isXmlHttpRequest()) {
            $formationRepo = $this->getDoctrine()->getRepository(Formation::class);
            $ordreModuleRepo = $this->getDoctrine()->getRepository(OrdreModule::class);

            $receivedModulesJson = $request->get('ordreLogique')['modules'];
            $referenceModulesJson = $formation->jsonSerialize()['modules'];

            foreach ($receivedModulesJson as $idModule => $ordreModule){

                if (isset($ordreModule['ordreModule']['groupes'])){
                    $receivedGroupes = $ordreModule['ordreModule']['groupes'];
                    $referenceGroups = $referenceModulesJson[$idModule]['ordreModule']['groupes'];

                    if(sizeof($referenceGroups) > 0){
                        $addedGroupes = array_diff_key($receivedGroupes, $referenceGroups);
                        if (sizeof($addedGroupes) > 0){
                            $idOrdreModule = $ordreModule['ordreModule']['codeOrdreModule'];
                            $this->insertGroupes($addedGroupes, $idOrdreModule);
                        }

                        $removedGroupes = array_diff_key($referenceGroups, $receivedGroupes);
                        if (sizeof($removedGroupes)){
                            $this->removeGroupes($removedGroupes);
                        }

                        $unchagedGroupes = array_intersect_key($receivedGroupes, $referenceGroups);
                        if (sizeof($unchagedGroupes) > 0){
                            $test = 0;
                        }
                    }else{
                        $idOrdreModule = $ordreModuleRepo->insert($formation->getCodeFormation(), $ordreModule['ordreModule']['idModule']);
                        $this->insertGroupes($receivedGroupes, $idOrdreModule);
                    }
                }else{
                    if (sizeof($referenceModulesJson[$idModule]['ordreModule']['groupes']) > 0){
                        $ordreModuleRepo->remove($referenceModulesJson[$idModule]['ordreModule']['codeOrdreModule']);
                    }
                }
            }

            $fershFormation = $formationRepo->findOneBy(array('codeFormation' => $formation->getCodeFormation()));
            return new Response(json_encode($fershFormation));
        }else{
            return new Response('Action non autorisée', Response::HTTP_FORBIDDEN);
        }
    }

    private function insertGroupes($groupes, $idOrdreModule){
        $groupesRepo = $this->getDoctrine()->getRepository(GroupeModule::class);
        foreach ($groupes as $groupeKey => $groupeValue){
            $sousGroupesId = $this->insertSousGroupes($groupeValue['sousGroupes']);
            $groupesRepo->insert($idOrdreModule, $sousGroupesId);
        }
    }

    private function removeGroupes($groupes){
        $groupesRepo = $this->getDoctrine()->getRepository(GroupeModule::class);
        $groupesRepo->remove(array_keys($groupes));
    }

    private function insertSousGroupes($sousGroupes){
        $sousGroupeRepo = $this->getDoctrine()->getRepository(SousGroupeModule::class);
        $sousGroupesId = array();

        foreach ($sousGroupes as $sousGroupeKey => $sousGroupeValue){
            $moduesId = array();
            $modules = array_filter($sousGroupeValue['modules']);
            foreach ($modules as $k => $v){
                $moduesId[] = $v['idModule'];
            }

            $sousGroupesId[] = $sousGroupeRepo->insert($moduesId);
        }

        return $sousGroupesId;
    }
}