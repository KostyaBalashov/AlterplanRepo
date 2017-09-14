<?php
/**
 * Created by PhpStorm.
 * User: void
 * Date: 13/09/2017
 * Time: 14:01
 *//*
This file is part of Alterplan. 
 
Alterplan is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. 
 
Alterplan is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details. 
 
You should have received a copy of the GNU Affero General Public License along with Alterplan. If not, see <http://www.gnu.org/licenses/>.
*/


namespace AppBundle\Controller;


use AppBundle\Entity\Cours;
use AppBundle\Entity\Module;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class CoursController
 * @package AppBundle\Controller
 *
 * @Route("cours")
 */
class CoursController extends Controller
{
    /**
     * @param Module $module
     * @Route("/{idModule}")
     * @Method("GET")
     */
    function searchAction(Module $module){
        $repo = $this->getDoctrine()->getRepository(Cours::class);
        $cours = $repo->findBy(array('module' => $module));
        return new JsonResponse($cours);
    }
}