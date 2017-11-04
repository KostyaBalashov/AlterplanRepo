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
function renderModal(idModalForm, controllerUrl, useCustomSubmit, postSubmitCallback, onModalOpen) {
    var modalSelector = "[data-target='" + idModalForm + "']";
    var formSelector = '#' + idModalForm;

    showLoader();

    //get en ajax pour récupérer le form à afficher
    $.get(controllerUrl, function (data) {

        //insertion du form dans la div modale
        $(modalSelector + " > .modal-content").html(data);

        //ouverture de la modale
        $(modalSelector).modal('open', {

            //à l'ouverture de la modale
            ready: function () {

                if (onModalOpen !== undefined) {
                    onModalOpen();
                }

                if (useCustomSubmit) {
                    var frm = $(formSelector);

                    //abonnement au submit du form
                    frm.submit(function (event) {

                        event.preventDefault();

                        postForm(frm, postSubmitCallback);

                    });
                }
            },
            complete: function () {
                $(modalSelector + " > .modal-content").empty();
            }
        });
    }).always(function () {
        dismissLoader();
    });
}

//affiche un message sous forme de toast
function showToast(content, msgType) {
    var toastColor;
    if ('error' === msgType) {
        toastColor = 'red';
    } else {
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
    if (loader.is(':visible')) {
        loader.fadeOut('slow');
        $(".preloader-wrapper").fadeOut('slow');
    }
}

function postForm(form, postSubmitCallback) {

    showLoader();

    //Récupération de l'url pour post
    var action = form.attr('action');

    //post en ajax des données
    $.post(action, form.serialize()).done(function (data) {
        //si le post réussit
        //appelle de la méthode postSubmit
        if (postSubmitCallback !== undefined) {
            postSubmitCallback(data);
        }
    }).fail(function () {
        //en cas d'échec affichage du msg d'erreur
        showToast('Erreur interne', 'error');
    }).always(function () {
        dismissLoader();
    });
}

function initDatePicker(selector, onSetCallBack) {
    if (!selector) {
        selector = '.datepicker';
    }
    console.log('selector!');
    var $input = $(selector).pickadate({
        labelMonthNext: 'mois suivant',
        labelMonthPrev: 'mois précédent',
        labelMonthSelect: 'Sélectionnez un mois',
        labelYearSelect: 'Sélectionnez une année',
        monthsFull: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
        monthsShort: ['janv', 'févr', 'mars', 'avr', 'mai', 'juin', 'juil', 'août', 'sept', 'oct', 'nov', 'déc'],
        weekdaysFull: ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'vendredi', 'Samedi', 'Dimanche'],
        weekdaysShort: ['lun', 'mar', 'mer', 'jeu', 'ven', 'sam', 'dim'],
        weekdaysLetter: ['L', 'M', 'M', 'J', 'V', 'S', 'D'],
        today: 'Aujourd\'hui',
        clear: 'Effacer',
        close: 'Fermer',
        formatSubmit: 'yyyy/mm/dd',
        format: 'dd/mm/yyyy',
        hiddenName: true,
        selectYears: true,
        selectMonths: true,
        onSet: onSetCallBack
    });
    return $input.pickadate('picker');
}

function setPickerMinOrMaxVlueFromPickerValue(event, pickerToSet, pickerContainingValue, minOrMax) {
    if (event.select) {
        pickerToSet.set(minOrMax, pickerContainingValue.get('select'))
    }
    else if ('clear' in event) {
        pickerToSet.set(minOrMax, false)
    }
}

function getDateDebutPicker(selector) {
    if (!selector) {
        selector = "input[id*='dateDebut']";
    }
    var from_$input = $(selector).pickadate();
    return from_$input.pickadate('picker');
}

function getDateFinPicker(selector) {
    if (!selector) {
        selector = "input[id*='dateFin']";
    }
    var to_$input = $(selector).pickadate();
    return to_$input.pickadate('picker');
}

function onSetDateFin(event) {
    var idPicker = $('.picker.picker--opened.picker--focused').attr('id');
    if (idPicker) {
        var idInputFin = replaceString('_root', '', idPicker);
        var idInputDebut = replaceString('dateFin', 'dateDebut', idInputFin);
        setPickerMinOrMaxVlueFromPickerValue(event, getDateDebutPicker('#' + idInputDebut),
            getDateFinPicker('#' + idInputFin), 'max');
    }
}

function onSetDateDebut(event) {
    var idPicker = $('.picker.picker--opened.picker--focused').attr('id');
    if (idPicker) {
        var idInputDebut = replaceString('_root', '', idPicker);
        var idInputFin = replaceString('dateDebut', 'dateFin', idInputDebut);
        setPickerMinOrMaxVlueFromPickerValue(event, getDateFinPicker('#' + idInputFin),
            getDateDebutPicker('#' + idInputDebut), 'min');
    }
}

function replaceString(oldS, newS, fullS) {
// On remplace oldS avec newS dans fullS
    for (var i = 0; i < fullS.length; i++) {
        if (fullS.substring(i, i + oldS.length) == oldS) {
            fullS = fullS.substring(0, i) + newS + fullS.substring(i + oldS.length, fullS.length);
        }
    }
    return fullS;
}

function getDateStr(date) {
    function pad(s) {
        return (s < 10) ? '0' + s : s;
    }

    return [pad(date.getDate()), pad(date.getMonth() + 1), date.getFullYear()].join('/');
}


function addFormFeature() {
    (function ($) {
        /**
         * polyfill for html5 form attr
         */

            // detect if browser supports this
        var sampleElement = $('[form]').get(0);
        var isIE11 = !(window.ActiveXObject) && "ActiveXObject" in window;
        if (sampleElement && window.HTMLFormElement && sampleElement.form instanceof HTMLFormElement && !isIE11) {
            // browser supports it, no need to fix
            return;
        }

        /**
         * Append a field to a form
         *
         */
        $.fn.appendField = function (data) {
            // for form only
            if (!this.is('form')) return;

            // wrap data
            if (!$.isArray(data) && data.name && data.value) {
                data = [data];
            }

            var $form = this;

            // attach new params
            $.each(data, function (i, item) {
                $('<input/>')
                    .attr('type', 'hidden')
                    .attr('name', item.name)
                    .val(item.value).appendTo($form);
            });

            return $form;
        };

        /**
         * Find all input fields with form attribute point to jQuery object
         *
         */
        $('form[id]').submit(function (e) {
            var $form = $(this);
            // serialize data
            var data = $('[form=' + $form.attr('id') + ']').serializeArray();
            // append data to form
            $form.appendField(data);
        }).each(function () {
            var form = this,
                $form = $(form),
                $fields = $('[form=' + $form.attr('id') + ']');

            $fields.filter('button, input').filter('[type=reset],[type=submit]').click(function () {
                var type = this.type.toLowerCase();
                if (type === 'reset') {
                    // reset form
                    form.reset();
                    // for elements outside form
                    $fields.each(function () {
                        this.value = this.defaultValue;
                        this.checked = this.defaultChecked;
                    }).filter('select').each(function () {
                        $(this).find('option').each(function () {
                            this.selected = this.defaultSelected;
                        });
                    });
                } else if (type.match(/^submit|image$/i)) {
                    $(form).appendField({name: this.name, value: this.value}).submit();
                }
            });
        });


    })(jQuery);
}