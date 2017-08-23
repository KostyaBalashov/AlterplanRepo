/**
 * Created by void on 18/08/2017.
 * This file is part of Alterplan.
 *
 * Alterplan is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 *
 * Alterplan is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License along with Alterplan. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Regroupe les méthodes pour intervenir dans le Json
 * @param formationJson Formation au format Json
 * @constructor
 */
function Formation(formationJson) {
    var innerFormation = formationJson;
    var idSelectedModule = -1;

    /**
     * Enregistre le module sélectionné. Utilisé dans les autres méthodes comme module de référence.
     * @param idModule l'identifiant du module
     */
    this.selectModule = function (idModule) {
        idSelectedModule = idModule
    };

    /**
     * Récupére les modules disponibles pour le module sélectionné.
     * @returns {*}
     */
    this.getModulesDisponibles = function () {
        return innerFormation['modules'][idSelectedModule]['modulesDisponibles'];
    };

    /**
     * Récupère les Groupes pour le modules sélectionné.
     * @returns {*}
     */
    this.getGroupesModules = function () {
        return innerFormation['modules'][idSelectedModule]['ordreModule']['groupes']
    };

    /**
     * Ajoute un groupe à la liste des groupes du module sélectionné.
     * @param groupe une instance de GroupeModule
     */
    this.addGroupe = function (groupe) {
        this.getGroupesModules(idSelectedModule)[groupe.identifiant] = groupe.toJson();
    };

    /**
     * Ajoute un Sous Groupe au Groupe du module sélectionné.
     * @param groupe Identifiant du groupe
     * @param sousGroupe instance de SousGroupe
     */
    this.addSousGroupeToGroupe = function (groupe, sousGroupe) {
        this.getGroupesModules(idSelectedModule)[groupe].sousGroupes[sousGroupe.identifiant] = sousGroupe.toJson();
    };

    /**
     * Ajoute un Module au sous groupe du module sélectionné
     * @param sousGroupe Instance de SousGroupe
     * @param module Instance de Module
     */
    this.addModuleToSousGroupe = function (sousGroupe, module) {
        this.getGroupesModules(idSelectedModule)[sousGroupe.groupeParent].sousGroupes[sousGroupe.identifiant].modules.push(module.toJson());
    };

    /**
     * Ajoute le module à la liste des modules disponibles du module sélectionné.
     * @param module instance de Module
     */
    this.addModuleDisponible = function (module) {
        this.getModulesDisponibles(idSelectedModule).push(module);
    };

    /**
     * Supprime un module de la liste des modules diponibles du module sélectionné.
     * @param module instance de Module
     */
    this.removeModuleDisponible = function (module) {
        var index = -1;
        var modules = innerFormation['modules'][idSelectedModule]['modulesDisponibles'];
        for (var i = 0, len = modules.length; i < len; i++){
            if(modules[i].idModule ===  parseInt(module.identifiant, 10)){
                index = i;
                break;
            }
        }

        if (index > -1){
            innerFormation['modules'][idSelectedModule]['modulesDisponibles'].splice(index, 1);
        }
    };

    /**
     * Supprime un module du Sous groupe
     * @param sousGroupe instance de SousGroupe
     * @param module instance de Module
     */
    this.removeModuleFromSousGroupe = function (sousGroupe, module) {
        var index = -1;
        var modules = this.getGroupesModules(idSelectedModule)[sousGroupe.groupeParent].sousGroupes[sousGroupe.identifiant].modules;
        for (var i = 0, len = modules.length; i < len; i++){
            if (modules[i].idModule === module.identifiant){
                index = i;
                break;
            }
        }

        if (index > -1){
            this.getGroupesModules(idSelectedModule)[sousGroupe.groupeParent].sousGroupes[sousGroupe.identifiant].modules.splice(index, 1);
        }
    };

    /**
     * Supprime un sous groupe d'un groupe.
     * @param sousGroupe instance de Sous groupe
     * @param groupe identifaint du Groupe
     */
    this.removeSousGroupe = function (sousGroupe, groupe) {
        var index = -1;
        var sousGroupes = this.getGroupesModules(idSelectedModule)[groupe].sousGroupes;
        for (var i = 0, len = sousGroupes.length; i < len; i++){
            if (sousGroupes[i].codeSousGroupe === sousGroupe.identifiant){
                index = i;
                break;
            }
        }

        if (index > -1){
            this.getGroupesModules(idSelectedModule)[groupe].sousGroupes.splice(index, 1);
        }
    };

    /**
     * Supprime un groupe
     * @param groupe identifiant du groupe
     */
    this.removeGroupe = function (groupe) {
        if (groupe){
            this.getGroupesModules(idSelectedModule).splice(groupe, 1);
        }
    }
}
