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

function handleRemove(container) {
    if(container instanceof GroupeModule){
        var dataContainer = container.getDraggableContainer();
        container.nbElements = dataContainer.getElementsByTagName('sous-groupe').length;
        var last = dataContainer.getElementsByClassName('last')[0];
        if (last){
            last.classList.remove('last');
        }

        if (container.nbElements > 0){
            var sousGroupe = dataContainer.getElementsByTagName('sous-groupe')[0];
            if (sousGroupe){
                sousGroupe.classList.remove('s6');
                sousGroupe.classList.add('s12');
            }
        }else{
            container.remove();
        }
    }else if (container instanceof SousGroupe){
        var dataContainer = container.getDraggableContainer();
        var parent = container.groupeParent;
        container.nbElements = dataContainer.getElementsByTagName('module-disponible').length;
        if (container.nbElements === 0){
            container.remove();
            handleRemove(parent);
        }

    }
}

function appendModule(target, module) {
    if (target.classList.contains('centre')){
        var idGroupe = target.getElementsByTagName('groupe-module').length;
        var groupe = new GroupeModule();
        groupe.identifiant = idGroupe;
        groupe.addModule(module);
        target.appendChild(groupe);
    }else {
        target.addModule(module);
    }
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
