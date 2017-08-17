/**
 * Created by void on 15/08/2017.
 * This file is part of Alterplan.
 *
 * Alterplan is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 *
 * Alterplan is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License along with Alterplan. If not, see <http://www.gnu.org/licenses/>.
 */
var GroupeModuleProto = Object.create(HTMLDivElement.prototype);

GroupeModuleProto.createdCallback = function () {
    this.className = 'card groupe blue lighten-5 valign-wrapper col s12';
    var container = new DraggableContainer();
    container.classList.add('valign-wrapper');
    this.appendChild(container);
    this.appendChild(new ButtonRemoveSousGroupe());
};

GroupeModuleProto.detachedCallback = function () {
    //TODO mettre à jour l'objet JSON formation
};

GroupeModuleProto.nbSousGroupes = 0;

Object.defineProperty(GroupeModuleProto, 'identifiant', {
    configurable: true,
    enumerable: true,
    get: function () {
        return this.id;
    },
    set: function (val) {
        this.id = val;
    }
});

Object.defineProperty(GroupeModuleProto, 'nbElements',{
    configurable: true,
    enumerable: true,
    get: function () {
        return this.nbSousGroupes;
    },
    set: function (val) {
        this.nbSousGroupes = val;
    }
});

GroupeModuleProto.addSousGroupe = function (sousGroupe) {
    var container = this.getDraggableContainer();
    if (this.nbElements === 0)
        sousGroupe.classList.add('s12');
    else {
        var first = container.getElementsByTagName('sous-groupe')[0];
        first.classList.remove('s12');
        first.classList.add('s6');

        sousGroupe.classList.add('s6');
        sousGroupe.classList.add('last');
    }
    container.appendChild(sousGroupe);
    this.nbElements = container.getElementsByTagName('sous-groupe').length;
    //TODO mettre à jour JSON
};

GroupeModuleProto.removeSousGroupe = function (sousGroupe) {
    var modulesContainer = document.getElementById('modules-disponibles-container');
    var container = this.getDraggableContainer();
    var modules = sousGroupe.getModules();
    for (var i = 0, len = modules.length; i < len; i++){
        modulesContainer.appendChild(sousGroupe.removeModule(modules[i]));
    }
    this.nbElements = container.getElementsByTagName('sous-groupe').length;

    if (this.nbElements === 0)
        this.parentNode.removeChild(this);

    //TODO peut être mettre à jour JSON
};

GroupeModuleProto.addModule = function (module) {
    var sousGroupe = new SousGroupe();
    //TODO  trouver un meilleur id
    sousGroupe.identifiant = this.nbElements;
    sousGroupe.groupeParent = this;
    sousGroupe.addModule(module);
    this.addSousGroupe(sousGroupe);
};

GroupeModuleProto.getDraggableContainer = function () {
    return this.querySelector('#draggable-container');
};

var GroupeModule = document.registerElement('groupe-module', {prototype: GroupeModuleProto});