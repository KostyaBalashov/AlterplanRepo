/**
 * Created by void on 18/07/2017.
 * This file is part of Alterplan.
 *
 * Alterplan is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 *
 * Alterplan is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License along with Alterplan. If not, see <http://www.gnu.org/licenses/>.
 */

function renderModal(idModalTarget,controllerUrl) {
    var selector ="[data-target='"+idModalTarget+"']";
    $(".preloader-wrapper").addClass("active");
    $.get(controllerUrl, function( data ) {
        $( ".modal-content" ).html( data );
        $(selector).modal('open',{
            ready: function () {
                $('#user_create').submit(function (event) {
                    event.preventDefault();
                    $.post( "/utilisateurs/new", $('#user_create').serialize())
                        .done(function (data) {
                            $('[data-target=create_user]').modal('close');
                            showToast(data)
                        }).fail(function () {
                        showToast('Erreur d\'enregistrement');
                    });
                });
            }
        });
    }).always(function(){
        $(".preloader-wrapper").removeClass("active");
    });
}

function showToast(content, msgType) {
    var toastColor;
    if ('error' === msgType){
        toastColor = 'red';
    }else {
        toastColor = 'blue';
    }
    Materialize.toast(content, 5000, toastColor);
}