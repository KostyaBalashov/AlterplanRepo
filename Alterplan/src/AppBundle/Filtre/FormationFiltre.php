<?php
/**
 * Created by PhpStorm.
 * User: penno
 * Date: 01/08/2017
 * Time: 17:01
 *//*
This file is part of Alterplan.

Alterplan is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

Alterplan is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along with Alterplan. If not, see <http://www.gnu.org/licenses/>.
*/


namespace AppBundle\Filtre;

use AppBundle\Entity\Lieu;

/**
 * Class UtilisateurFiltre représente les critères de filtre sur les utilisateurs.
 * @package AppBundle\Filtre
 */
class FormationFiltre
{
    /**
     * @var string
     * Filtre sur le titre (libelleCourt)
     */
    private $libelleCourt;

    /**
     * @var string
     * Filtre sur le codeFormation
     */
    private $codeFormation;

    /**
     * @var Lieu
     * Filtre sur le lieu
     */
    private $lieu;

    /**
     * @return string
     */
    public function getLibelleCourt()
    {
        return $this->libelleCourt;
    }

    /**
     * @param string $libelleCourt
     */
    public function setLibelleCourt($libelleCourt)
    {
        $this->libelleCourt = $libelleCourt;
    }

    /**
     * @return string
     */
    public function getCodeFormation()
    {
        return $this->codeFormation;
    }

    /**
     * @param string $codeFormation
     */
    public function setCodeFormation($codeFormation)
    {
        $this->codeFormation = $codeFormation;
    }

    /**
     * @return lieu
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * @param lieu $lieu
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;
    }


}