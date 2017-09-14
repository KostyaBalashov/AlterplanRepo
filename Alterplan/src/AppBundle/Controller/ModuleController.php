<?php
/**
 * Created by PhpStorm.
 * User: void
 * Date: 06/09/2017
 * Time: 08:46
 *//*
This file is part of Alterplan. 
 
Alterplan is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. 
 
Alterplan is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details. 
 
You should have received a copy of the GNU Affero General Public License along with Alterplan. If not, see <http://www.gnu.org/licenses/>.
*/


namespace AppBundle\Controller;


use AppBundle\Entity\Calendrier;
use AppBundle\Entity\Module;
use AppBundle\Filtre\ModuleFiltre;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ModuleController
 * @package AppBundle\Controller
 *
 * @Route("modules")
 */
class ModuleController extends Controller
{
    /**
     * @Route("/{codeCalendrier}", name="modules_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request, Calendrier $calendrier){
        $filtre = new ModuleFiltre();
        $filtre->setFormation($calendrier->getFormation());

        $modulesRepository = $this->getDoctrine()->getRepository(Module::class);

        $modulesRecherche = null;
        $modulesFormation = $calendrier->getFormation()->getAllModules();

        $form = $this->createForm('AppBundle\Form\Filtre\ModuleFiltreType', $filtre, array(
            'action' => $this->generateUrl('modules_show',
                array('codeCalendrier' => $calendrier->getCodeCalendrier()))
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $modulesRecherche = $modulesRepository->search($filtre);
            return $this->render('modules/searchResultRenderer.html.twig',array(
                'searchModules' => $modulesRecherche
            ));
        }

        $modulesRecherche = $modulesRepository->search($filtre);

        return $this->render(':modules:gestionModules.html.twig',array(
            'formSearch' => $form->createView(),
            'searchModules' => $modulesRecherche
        ));
    }
}