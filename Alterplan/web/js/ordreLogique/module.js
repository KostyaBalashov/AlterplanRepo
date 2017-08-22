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

var ModuleProto = Object.create(HTMLDivElement.prototype);

ModuleProto.createdCallback = function () {
    this.className = 'flow-text valign-wrapper card-panel module';
};

ModuleProto.toJson = function () {
    return {idModule: this.identifiant, libelle: this.libelle};
};

Object.defineProperty(ModuleProto, 'identifiant', {
    configurable: true,
    enumerable: true,
    get: function () {
        return this.id;
    },
    set: function (val) {
        this.id = val;
    }
});

Object.defineProperty(ModuleProto, 'libelle', {
    configurable: true,
    enumerable: true,
    get: function () {
        return this.innerHTML;
    },
    set: function (val) {
        this.innerHTML = val;
    }
});

var Module = document.registerElement('module-disponible',{prototype: ModuleProto});
