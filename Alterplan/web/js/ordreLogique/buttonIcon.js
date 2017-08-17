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

var ButtonAddSousGroupeProto = Object.create(HTMLElement.prototype);
ButtonAddSousGroupeProto.createdCallback = function () {
    this.className = 'material-icons clickable';
    this.innerHTML = 'add_circle_outline';
    this.addEventListener('click', function (e) {
        //TODO corriger la création de sous groupe avec le bouton
        materialIconClick();
    });
};

var ButtonRemoveSousGroupeProto = Object.create(HTMLElement.prototype);
ButtonRemoveSousGroupeProto.createdCallback = function () {
    this.className = 'material-icons clickable';
    this.innerHTML = 'remove_circle_outline';
    this.addEventListener('click', function (e) {
        //TODO corriger la suppression de sous groupe avec le bouton
        materialIconClick();
    });
};

var ButtonAddSousGroupe = document.registerElement('add-sous-groupe',
    {prototype: ButtonAddSousGroupeProto, extends: 'i'});

var ButtonRemoveSousGroupe = document.registerElement('remove-sous-groupe',
    {prototype: ButtonRemoveSousGroupeProto, extends: 'i'});
