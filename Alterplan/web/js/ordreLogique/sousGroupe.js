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

var SousGroupeProto = Object.create(HTMLDivElement.prototype);
SousGroupeProto.createdCallback = function () {
    this.className = 'card sous-groupe orange lighten-5 valign-wrapper col';
    this.appendChild(new DraggableContainer());
    this.appendChild(new ButtonRemoveSousGroupe());
};

SousGroupeProto.detachedCallback = function () {
    //TODO mettre à jour l'objet JSON formation
    this.groupeParent.removeSousGroupe(this);
};

SousGroupeProto.nbModules = 0;
SousGroupeProto.groupeParent = null;

Object.defineProperty(SousGroupeProto, 'identifiant', {
    configurable: true,
    enumerable: true,
    get: function () {
        return this.id;
    },
    set: function (val) {
        this.id = val;
    }
});


Object.defineProperty(SousGroupeProto, 'nbElements', {
    configurable: true,
    enumerable: true,
    get: function () {
        return this.nbModules;
    },
    set: function (val) {
        this.nbModules = val;
    }
});

Object.defineProperty(SousGroupeProto, 'groupeParent',{
    configurable: true,
    enumerable: true,
    get: function () {
        return SousGroupe.groupeParent;
    },
    set: function (groupe) {
        SousGroupe.groupeParent = groupe;
    }
});

SousGroupeProto.addModule = function (module) {
    var container = this.getDraggableContainer();
    container.appendChild(module);
    this.nbElements = container.getElementsByTagName('module-disponible').length;
    //TODO mettre à jour l'objet JSON formation
};

SousGroupeProto.removeModule = function (module) {
    var modulesContainer = document.getElementById('modules-disponibles-container');
    var container = this.getDraggableContainer();
    modulesContainer.appendChild(container.removeChild(module));
    this.nbElements = container.getElementsByTagName('module-disponible').length;
    if (this.nbElements === 0)
        this.parentNode.removeChild(this);
};

SousGroupeProto.getModules = function () {
    return this.querySelector('#draggable-container').getElementsByTagName('module-disponible');
};

SousGroupeProto.getDraggableContainer = function () {
    return this.querySelector('#draggable-container');
};

var SousGroupe = document.registerElement('sous-groupe', {prototype: SousGroupeProto});
