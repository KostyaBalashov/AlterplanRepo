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
/**
 * Création d'un prototype héritant de div
 * @type {HTMLDivElement} div
 */
var GroupeModuleProto = Object.create(HTMLDivElement.prototype);


GroupeModuleProto.createdCallback = function () {
    this.eventRemoved = document.createEvent('Event');
    this.sousGroupeAdded = document.createEvent('Event');
    this.sousGroupeRemoved = document.createEvent('Event');

    this.eventRemoved.initEvent('groupeRemoved', true, true);
    this.sousGroupeAdded.initEvent('sousGroupeAdded', true, true);
    this.sousGroupeRemoved.initEvent('sousGroupeRemoved', true, true);

    this.eventRemoved.data = [];
    this.sousGroupeAdded.data = [];
    this.sousGroupeRemoved.data = [];

    //teal lighten-5
    //blue lighten-5
    //indigo lighten-5
    this.className = 'card groupe valign-wrapper col s12 blue lighten-5';
    var container = new DraggableContainer();
    container.classList.add('valign-wrapper');
    this.appendChild(container);
};

GroupeModuleProto.addSousGroupe = function (sousGroupe) {
    var sousGroupes = this.getSousGroupes();
    var idSousGroupe = -1;
    for (var i = 0, len = sousGroupes.length; i < len; i++){
        var id = parseInt(sousGroupes[i].identifiant);
        if (id > idSousGroupe){
            idSousGroupe = id;
        }
    }

    sousGroupe.identifiant = ++idSousGroupe;
    sousGroupe.groupeParent = this.identifiant;

    this.sousGroupeAdded.data['groupe'] = this.identifiant;
    this.sousGroupeAdded.data['sousGroupe'] = sousGroupe;

    this.getDraggableContainer().appendChild(sousGroupe);
    this.nbElements = this.getSousGroupes().length;

    this.dispatchEvent(this.sousGroupeAdded);
};

GroupeModuleProto.removeSousGroupe = function (sousGroupe) {
    this.sousGroupeRemoved.data['groupe'] = this.identifiant;
    this.sousGroupeRemoved.data['sousGroupe'] = sousGroupe;

    this.eventRemoved.data['groupe'] = this.identifiant;
    this.nbElements = this.getSousGroupes().length;
    this.dispatchEvent(this.sousGroupeRemoved);

    if (this.nbElements === 0){
        this.dispatchEvent(this.parentNode.removeChild(this).eventRemoved);
    }
};

GroupeModuleProto.getSousGroupes = function () {
    return this.getDraggableContainer().getElementsByTagName('sous-groupe');
};

GroupeModuleProto.getDraggableContainer = function () {
    return this.querySelector('#draggable-container');
};

GroupeModuleProto.toJson = function () {
    var result = {codeGroupe: this.identifiant, sousGroupes: []};

    var sousGroupes = this.getSousGroupes();
    for (var i = 0, len = sousGroupes.length; i < len; i++){
        result.sousGroupes.push(sousGroupes[i].toJson());
    }
    return result;
};

var GroupeModule = document.registerElement('groupe-module', {prototype: GroupeModuleProto});

GroupeModule.identifiant = -1;
GroupeModule.nbElements = 0;