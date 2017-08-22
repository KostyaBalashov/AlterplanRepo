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

function Formation(formationJson) {
    var innerFormation = formationJson;
    var idSelectedModule = -1;

    this.selectModule = function (idModule) {
        idSelectedModule = idModule
    };

    this.getModulesDisponibles = function () {
        return innerFormation['modules'][idSelectedModule]['modulesDisponibles'];
    };

    this.getGroupesModules = function () {
        return innerFormation['modules'][idSelectedModule]['ordreModule']['groupes']
    };
    
    this.addGroupe = function (groupe) {
        this.getGroupesModules(idSelectedModule)[groupe.identifiant] = groupe.toJson();
    };
    
    this.addSousGroupeToGroupe = function (groupe, sousGroupe) {
        this.getGroupesModules(idSelectedModule)[groupe.identifiant].sousGroupes[sousGroupe.identifiant] = sousGroupe.toJson();
    };

    this.addModuleToSousGroupe = function (sousGroupe, module) {
        this.getGroupesModules(idSelectedModule)[sousGroupe.groupeParent.identifiant].sousGroupes[sousGroupe.identifiant].modules.push(module.toJson());
    };

    this.addModuleDisponible = function (module) {
        this.getModulesDisponibles(idSelectedModule).push(module);
    };

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

    this.removeModuleFromSousGroupe = function (sousGroupe, module) {
        var index = -1;
        var modules = this.getGroupesModules(idSelectedModule)[sousGroupe.groupeParent.identifiant].sousGroupes[sousGroupe.identifiant].modules;
        for (var i = 0, len = modules.length; i < len; i++){
            if (modules[i].idModule === module.identifiant){
                index = i;
                break;
            }
        }

        if (index > -1){
            this.getGroupesModules(idSelectedModule)[sousGroupe.groupeParent.identifiant].sousGroupes[sousGroupe.identifiant].modules.splice(index, 1);
        }
    };

    this.removeSousGroupe = function (sousGroupe, groupe) {
        var indexGroupe = -1;
        var groupes = this.getGroupesModules(idSelectedModule);
        for(var j = 0, jLen = groupes.length; j < jLen; j++){
            if (groupes[j].codeGroupeModule === groupe.identifiant){
                indexGroupe = j;
                break;
            }
        }

        if(indexGroupe > -1){
            var index = -1;
            var sousGroupes = this.getGroupesModules(idSelectedModule)[indexGroupe].sousGroupes;
            for (var i = 0, len = sousGroupes.length; i < len; i++){
                if (sousGroupes[i].codeSousGroupe === sousGroupe.identifiant){
                    index = i;
                    break;
                }
            }

            if (index > -1){
                this.getGroupesModules(idSelectedModule)[indexGroupe].sousGroupes.splice(index, 1);
            }
        }

    };

    this.removeGroupe = function (groupe) {
        var index = -1;
        var groupes = this.getGroupesModules(idSelectedModule);
        for (var i = 0, len = groupes.length; i < len; i++){
            if (groupes[i].codeGroupeModule === groupe.identifiant){
                index = i;
                break;
            }
        }

        if (index > -1){
            this.getGroupesModules(idSelectedModule).splice(index, 1);
        }
    }
}
