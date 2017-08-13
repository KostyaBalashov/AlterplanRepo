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
    var dataContainer = container.getElementsByClassName('draggable-container')[0];
    if(container.classList.contains('groupe')){
        container.dataset.nbElements = dataContainer.getElementsByClassName('sous-groupe').length;
        var last = dataContainer.getElementsByClassName('last')[0];
        if (last){
            last.classList.remove('last')
        }

        if (container.dataset.nbElements > 0){
            var sousGroupe = dataContainer.getElementsByClassName('sous-groupe')[0];
            if (sousGroupe){
                sousGroupe.classList.remove('s6');
                sousGroupe.classList.add('s12');
                sousGroupe.getElementsByClassName('remove')[0].remove();
                container.appendChild(materialIcon('add'));
            }
        }else{
            container.remove();
        }
    }else if (container.classList.contains('sous-groupe')){
        var parent = container.parentNode.parentNode;
        container.dataset.nbElements = dataContainer.getElementsByClassName('module').length;
        if (container.dataset.nbElements === '0'){
            container.remove();
            handleRemove(parent);
        }

    }
}

function appendModule(target, module) {
    if (target.classList.contains('centre')){
        var groupe = creatGroupe(module);
        target.appendChild(groupe);
    }else if (target.classList.contains('groupe')){
        appendSousGroupe(target, createSousGroupe(module));
    }else if (target.classList.contains('sous-groupe')){
        target.dataset.nbElements++;
        var groupeContainer = target.getElementsByClassName('draggable-container')[0];
        groupeContainer.appendChild(module);
    }
}

function appendSousGroupe(target, sousGroupe) {

    if (target.dataset.nbElements < 2){

        if(target.dataset.nbElements === '1'){
            var firstSousGroupe = target.getElementsByClassName('sous-groupe')[0];
            firstSousGroupe.classList.remove('s12');
            firstSousGroupe.classList.add('s6');
            firstSousGroupe.appendChild(materialIcon('remove'));

            sousGroupe.classList.add('col');
            sousGroupe.classList.remove('s12');
            sousGroupe.classList.add('s6');
            sousGroupe.classList.add('last');
            if (!(sousGroupe.getElementsByClassName('remove')[0])){
                sousGroupe.appendChild(materialIcon('remove'));
            }
        }

        var groupeContainer = target.getElementsByClassName('draggable-container')[0];
        groupeContainer.appendChild(sousGroupe);


        target.dataset.nbElements++;
        if(target.dataset.nbElements > 1){
            var icon = target.getElementsByClassName('add')[0];
            icon.remove();
            //var plus = target.getElementsByClassName('material-icons')[0];
            //plus.innerHTML = 'remove_circle_outline';
        }
    }
}

function creatGroupe(content) {

    var draggableContainer = document.createElement('div');
    draggableContainer.classList.add('draggable-container');
    draggableContainer.classList.add('col');
    draggableContainer.classList.add('s12');
    draggableContainer.classList.add('valign-wrapper');

    var groupe = document.createElement('div');
    groupe.classList.add('col');
    groupe.classList.add('s12');
    groupe.classList.add('card');
    groupe.classList.add('groupe');
    groupe.classList.add('blue');
    groupe.classList.add('lighten-5');
    groupe.classList.add('valign-wrapper');
    groupe.dataset.nbElements = 0;
    groupe.appendChild(draggableContainer);

    var sousGroupe = content;

    if (sousGroupe.classList.contains('module')){
        sousGroupe = createSousGroupe(content);
    }

    sousGroupe.classList.add('col');
    sousGroupe.classList.add('s12');
    appendSousGroupe(groupe, sousGroupe);

    groupe.appendChild(materialIcon('add'));

    return groupe;
}

function createSousGroupe(module) {
    var draggableContainer = document.createElement('div');
    draggableContainer.classList.add('draggable-container');
    draggableContainer.classList.add('col');
    draggableContainer.classList.add('s12');

    var sousGroupe = document.createElement('div');
    sousGroupe.classList.add('card');
    sousGroupe.classList.add('sous-groupe');
    sousGroupe.classList.add('orange');
    sousGroupe.classList.add('lighten-5');
    sousGroupe.classList.add('valign-wrapper');
    sousGroupe.dataset.nbElements = 0;
    sousGroupe.appendChild(draggableContainer);

    if(module){
        appendModule(sousGroupe, module);
    }

    return sousGroupe;
}

function materialIcon(addOrRemove) {
    var plus = document.createElement('i');
    plus.classList.add('material-icons');
    plus.classList.add('clickable');

    if (addOrRemove === 'add'){
        plus.classList.add('add');
        plus.innerHTML = 'add_circle_outline';
    }else {
        plus.classList.add('remove');
        plus.innerHTML = 'remove_circle_outline';
    }

    if (plus.addEventListener){
        plus.addEventListener('click', materialIconClick, false);
    } else if (plus.attachEvent) {
        plus.attachEvent('onclick', materialIconClick);
    }

    return plus;
}

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
        appendSousGroupe(groupe, sousGroupe);
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
