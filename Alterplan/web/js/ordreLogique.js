/**
 * Created by void on 10/08/2017.
 * This file is part of Alterplan.
 *
 * Alterplan is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 *
 * Alterplan is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License along with Alterplan. If not, see <http://www.gnu.org/licenses/>.
 */

function OrdreLogique(formationJson) {
    this.formation = new Formation(formationJson);

    this.handleRemove = function (container, element) {
        if(container instanceof GroupeModule){
            container.removeSousGroupe(element);
        }else if (container instanceof SousGroupe){
            container.removeModule(element);
        }
    };

    this.createModulesDisponibles = function () {
        var modulesJson = this.formation.getModulesDisponibles();
        var container = document.getElementsByClassName('droite')[0];
        $('.droite > module-disponible').each(function () {
            $(this).remove();
        });
        for (var i = 0, len = modulesJson.length; i < len; i++){
            var module = new Module();
            module.identifiant = modulesJson[i]['idModule'];
            module.libelle = modulesJson[i]['libelle'];
            container.appendChild(module);
        }
    };

    this.createGroupesModules = function () {
        var groupesJson = this.formation.getGroupesModules();
        var container = document.getElementsByClassName('centre')[0];
        $('.centre > groupe-module').each(function () {
            $(this).remove();
        });

        for (var i = 0, len = groupesJson.length; i < len; i++){
            var groupe = this.createGroupe();
            groupe.identifiant = groupesJson[i].codeGroupeModule;

            var sousGroupes = this.createSousGroupes(groupesJson[i].sousGroupes);
            for (var j = 0, jLen = sousGroupes.length; j < jLen; j++){
                groupe.getDraggableContainer().appendChild(sousGroupes[j]);
            }
            groupe.nbElements = groupe.getSousGroupes().length;
            container.appendChild(groupe);
        }
    };

    this.createSousGroupes = function (sousGroupesJson) {
        var sousGroupes = [];
        for (var i = 0 , len = sousGroupesJson.length; i < len; i++){
            var sousGroupe = this.createSousGroupe();
            sousGroupe.identifiant = sousGroupesJson[i].codeSousGroupe;

            var modulesJson = sousGroupesJson[i].modules;
            for (var j = 0, mLen = modulesJson.length; j < mLen; j++){
                var module = new Module();
                module.identifiant = modulesJson[j].idModule;
                module.libelle = modulesJson[j].libelle;
                sousGroupe.getDraggableContainer().appendChild(module);
            }
            sousGroupe.nbElements = sousGroupe.getModules().length;
            sousGroupes.push(sousGroupe);
        }
        return sousGroupes;
    };

    this.createSousGroupe = function () {
        var ordre = this;
        var sousGroupe = new SousGroupe();

        sousGroupe.addEventListener('sousGroupeRemoved', function (e) {
            ordre.formation.removeSousGroupe(e.data['sousGroupe']);
        }, false);
        sousGroupe.addEventListener('moduleAdded', function (e) {
            ordre.formation.addModuleToSousGroupe(e.data['sousGroupe'], e.data['module']);
        }, false);
        sousGroupe.addEventListener('moduleRemoved', function (e) {
            ordre.formation.removeModuleFromSousGroupe(e.data['sousGroupe'], e.data['module']);
        }, false);

        return sousGroupe;
    };

    this.createGroupe = function () {
        var ordre = this;
        var groupe = new GroupeModule();

        groupe.addEventListener('groupeRemoved', function (e) {
            ordre.formation.removeGroupe(e.data['groupe']);
        }, false);

        groupe.addEventListener('sousGroupeAdded', function (e) {
            ordre.formation.addSousGroupeToGroupe(e.data['groupe'], e.data['sousGroupe']);
        }, false);

        groupe.addEventListener('sousGroupeRemoved', function (e) {
            ordre.formation.removeSousGroupe(e.data['sousGroupe'], e.data['groupe']);
        }, false);

        return groupe;
    };
}

//TODO gérer le click sur le bouton
function materialIconClick(){
    var groupe = this.parentElement;
    if('add_circle_outline' === this.innerHTML){
        var firstSousGroupe = groupe.getElementsByClassName('sous-groupe')[0];
        firstSousGroupe.classList.remove('s12');
        firstSousGroupe.classList.add('s6');
        var sousGroupe = createSousGroupe(null);
        sousGroupe.classList.add('col');
        sousGroupe.classList.add('s6');
        sousGroupe.classList.add('last');
        //appendSousGroupe(groupe, sousGroupe);
    }else{
        var data = groupe.getElementsByClassName('draggable-container')[0];
        var modules = data.getElementsByClassName('module');
        var origine = document.getElementsByClassName('droite')[0];
        var origineContainer = origine.getElementsByClassName('draggable-container')[0];
        if (modules.length > 0){
            for (var i = 0, len = -modules.length; len < i; len++) {
                var module = modules[i];
                origineContainer.appendChild(module);
                handleRemove(groupe);
            }
        }else {
            handleRemove(groupe);
            groupe.remove();
        }
    }
}
