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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Filtre\FormationFiltre;
use AppBundle\Form\FormationFiltreType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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



}