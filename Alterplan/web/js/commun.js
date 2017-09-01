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

/*
* Affiche un formulaire dans une fenêtre modale
* */
function renderModal(idModalForm,controllerUrl, useCustomSubmit, postSubmitCallback, onModalOpen) {
    var modalSelector ="[data-target='"+idModalForm+"']";
    var formSelector = '#'+idModalForm;

    showLoader();

    //get en ajax pour récupérer le form à afficher
    $.get(controllerUrl, function( data ) {

        //insertion du form dans la div modale
        $( modalSelector +  " > .modal-content" ).html( data );

        //ouverture de la modale
        $(modalSelector).modal('open',{

            //à l'ouverture de la modale
            ready: function () {

                if (onModalOpen !== undefined){
                    onModalOpen();
                }

                if (useCustomSubmit){
                    var frm = $(formSelector);

                    //abonnement au submit du form
                    frm.submit(function (event) {

                        event.preventDefault();

                        postForm(frm, postSubmitCallback, modalSelector);

                    });
                }
            }
        });
    }).always(function(){
        dismissLoader();
    });
}

//affiche un message sous forme de toast
function showToast(content, msgType) {
    var toastColor;
    if ('error' === msgType){
        toastColor = 'red';
    }else {
        toastColor = 'light-blue';
    }
    Materialize.toast(content, 5000, toastColor);
}

//affcihe le loader
function showLoader() {
    $(".preloader-background").fadeIn('slow');
    $(".preloader-wrapper").fadeIn('slow');
}

//cache le loader
function dismissLoader() {
    var loader = $('.preloader-background');
    if (loader.is(':visible')){
        loader.fadeOut('slow');
        $(".preloader-wrapper").fadeOut('slow');
    }
}

function postForm(form, postSubmitCallback, modalSelector) {

    showLoader();

    //Récupération de l'url pour post
    var action = form.attr('action');

    //post en ajax des données
    $.post(action, form.serialize()).done(function (data) {
        //si le post réussit
        //fermeture de la modale
        $(modalSelector).modal('close');

        //appelle de la méthode postSubmit
        if (postSubmitCallback !== undefined){
            postSubmitCallback();
        }

        //affichage du message retourné par le controller
        //TODO mettre le message dans postSublmit
        showToast(data);

    }).fail(function () {
        //en cas d'échec affichage du msg d'erreur
        //TODO changer le message ou le passer un paramètres...?
        showToast('Erreur d\'enregistrement', 'error');
    }).always(function () {
        dismissLoader();
    });
}

function initDatePicker(selector, onSetCallBack) {
    if (!selector){
        selector = '.datepicker';
    }

    $(selector).pickadate({
        labelMonthNext: 'mois suivant',
        labelMonthPrev: 'mois précédent',
        labelMonthSelect: 'Sélectionnez un mois',
        labelYearSelect: 'Sélectionnez une année',
        monthsFull: [ 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre' ],
        monthsShort: [ 'janv', 'févr', 'mars', 'avr', 'mai', 'juin', 'juil', 'août', 'sept', 'oct', 'nov', 'déc' ],
        weekdaysFull: [ 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'vendredi', 'Samedi', 'Dimanche' ],
        weekdaysShort: [ 'lun', 'mar', 'mer', 'jeu', 'ven', 'sam', 'dim' ],
        weekdaysLetter: [ 'L', 'M', 'M', 'J', 'V', 'S', 'D' ],
        today: 'Aujourd\'hui',
        clear: 'Annuler',
        close: 'Fermer',
        formatSubmit: 'yyyy/mm/dd',
        hiddenName: true,
        selectYears: true,
        selectMonths: true,
        onSet: onSetCallBack
    });
}


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

function setPickerMinOrMaxVlueFromPickerValue(event, pickerToSet, pickerContainingValue, minOrMax){
    if ( event.select ) {
        pickerToSet.set(minOrMax, pickerContainingValue.get('select'))
    }
    else if ( 'clear' in event ) {
        pickerToSet.set(minOrMax, false)
    }
}

function getDateDebutPicker(){
    var from_$input = $("input[id*='dateDebut']").pickadate();
    return from_$input.pickadate('picker');
}

function getDateFinPicker(){
    var to_$input = $("input[id*='dateFin']").pickadate();
    return to_$input.pickadate('picker');
}

function onSetDateFin(event) {
    setPickerMinOrMaxVlueFromPickerValue(event, getDateDebutPicker(),
        getDateFinPicker(), 'max');
}

function onSetDateDebut(event) {
    setPickerMinOrMaxVlueFromPickerValue(event, getDateFinPicker(),
        getDateDebutPicker(), 'min');
}
