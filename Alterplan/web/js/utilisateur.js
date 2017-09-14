/**
 * Created by void on 08/09/2017.
 * This file is part of Alterplan.
 *
 * Alterplan is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 *
 * Alterplan is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License along with Alterplan. If not, see <http://www.gnu.org/licenses/>.
 */

function passwordCheck() {
    var firstPwd = $('#appbundle_utilisateur_plainPassword');
    var secondPwd = $('#appbundle_utilisateur_checkPassword');

    secondPwd.change(function () {
        if (firstPwd.val() !== secondPwd.val()){
            secondPwd.get(0).setCustomValidity('Les deux mots de passes ne correspondent pas');
        }else {
            secondPwd.get(0).setCustomValidity('');
        }
    });
}

function postSubmitUserForm(data) {
    var modalSelector ="[data-target='user']";
    //fermeture de la modale
    $(modalSelector).modal('close');
    //affichage du message retourné par le controller
    showToast(data);
}
 
