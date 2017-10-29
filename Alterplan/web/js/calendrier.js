/**
 * Created by void on 12/09/2017.
 * This file is part of Alterplan.
 *
 * Alterplan is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 *
 * Alterplan is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License along with Alterplan. If not, see <http://www.gnu.org/licenses/>.
 */
var Calendrier = function (codeCalendrier, jFormation, jModules, jContraintes) {
    this.codeCalendrier = codeCalendrier;
    this.formation = jFormation;
    this.modules = jModules.reduce(function (p1, p2) {
        p1[p2.idModule] = p2;
        return p1;
    }, []);
    this.contraintes = jContraintes;
};

function refreshModules(modules) {
    var $container = $('#modules-planifiables-container');
    $container.empty();
    for (cle in modules) {
        if (modules.hasOwnProperty(cle)) {
            var div = $(document.createElement('div'));
            div.attr('id', cle);
            div.addClass('flow-text card-panel module clickable');
            div.click(function () {
                selectModule($(this));
            });

            var span = $(document.createElement('span'));
            span.text(modules[cle].libelle);
            div.append(span);
            $container.append(div);
        }
    }
}

function endEdit(e, defaultText) {
    var input = $(e.target),
        div = input && input.prev();

    div.find('span').text(input.val() === '' ? defaultText : input.val());
    input.hide();
    div.show();
}

function initTitleInput(defaultText) {
    $('.clickedit').hide()
        .focusout(defaultText, endEdit)
        .keyup(function (e) {
            if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
                endEdit(e, defaultText);
                return false;
            } else {
                return true;
            }
        })
        .prev().click(function () {
        $(this).hide();
        $(this).next().show(function () {
            $(this).val(($(this).val() !== '' ? $(this).val() : defaultText));
            return $(this);
        }).focus();
    });
}

function selectModule(clickedModule) {
    var $module = $(clickedModule);
    if ($module.hasClass('module-place')) {
        $module.parent().toggleClass('module-container');
    }
    if (!$module.hasClass('selected')) {
        showLoader();
        $('.module.selected').removeClass('selected').addClass('clickable');
        $('.module-place.selected').removeClass('selected').addClass('clickable').parent().toggleClass('module-container');

        $module.removeClass('clickable').addClass('selected');
        var url = "/cours/" + $module.attr('id');
        $.get(url, function (data) {
            renderCours(data);
        }).always(function () {
            dismissLoader();
        });
    }
}

function renderCours(data) {
    var bodySelector = '#calnendar-body';
    $(bodySelector).find('.tr').not('.no-remove').remove();
    var coursManager = new CoursManager(data);
    for (idCour in coursManager.all) {
        if (coursManager.all.hasOwnProperty(idCour)) {
            coursManager.renderCour(coursManager.all[idCour], bodySelector);
        }
    }
}

function saveModulesAPlanifier() {
    showLoader();
    closeModaleGestionModules();

    var added = [];
    var removed = [];

    for (removedKey in modulesManager.removedModules) {
        if (calendrier.modules.hasOwnProperty(removedKey)
            && (removedKey in calendrier.modules)) {
            delete calendrier.modules[removedKey];
            removed.push(removedKey);
        }
    }

    for (addedKey in modulesManager.addedModules) {
        if (!calendrier.modules.hasOwnProperty(addedKey)) {
            calendrier.modules[addedKey] = modulesManager.addedModules[addedKey];
            added.push(addedKey);
        }
    }

    var data = {'addedModules': added, 'removedModules': removed};
    var url = "/calendriers/edit/" + calendrier.codeCalendrier;
    $.post(url, data);

    refreshModules(calendrier.modules);
    dismissLoader();
}

function closeModaleGestionModules() {
    $("div[data-target='gestion-modules']").modal('close');
}


function saveContraintes() {
    showLoader();

    //plusieurs étapes:
    //1 : Pour chaque TR, on cherche la contrainte avec la même id et on lui passe les valeurs P1 et P2
    //2: pour chaque contrainte qui est nouvelle (présente dans addedContrainte) on passe l'id à null

    var invalidInputs = [];
    $('#tbl tr.trTable').each(function (i, row) {
        var $row = $(row);
        var codeContrainte = parseInt(this.id);
        var inputP1 = $row.find('input[name=val0]')[0];
        var rowP1 = inputP1.value;
        var inputP2 = $row.find('input[name=val1]')[0];
        var rowP2 = null;
        if (inputP2 != undefined) {
            rowP2 = inputP2.value;
        }
        if (rowP1 === "") {
            invalidInputs.push(inputP1);
        }
        if (rowP2 != null) {
            if (rowP2 === "") {
                invalidInputs.push(inputP2);
            }
        }
        if (rowP2 != null && inputP1.classList.contains('int')) {
            if (rowP1 > rowP2) {
                invalidInputs.push(inputP1);
                invalidInputs.push(inputP2);
            }
        }

        if (inputP1.id === 'rechercheStagiaire') {
            var nomPrenom = rowP1.split(" ");
            contraintesManager.stagiaires.forEach(function (stagiaire) {
                if (stagiaire.nom === nomPrenom[0] && stagiaire.prenom === nomPrenom[1]) {
                    rowP1 = stagiaire.codeStagiaire;
                }
            });

        }
        contraintesManager.contraintes.forEach(function (c) {
                if (c.codeContrainte === codeContrainte) {
                    c.P1 = rowP1;
                    if (rowP2 != null) {
                        c.P2 = rowP2;
                    }
                }
            }
        );
        i++;
    });
    if (invalidInputs.length != 0) {
        invalidInputs.forEach(function (input) {
            if (input.type.includes('hidden')) {
                var inputPicker = $(this).parent().find('input');
                inputPicker.className += 'invalid'
            }
            input.setCustomValidity("champ invalide (champ vide ou valeur erronée)")
            input.className += ' invalid';
        });
        dismissLoader();
        return;
    }

    contraintesManager.addedContraintes.forEach(function (newC) {
        //pour toutes les nouvelles contraintes on cherche l'équivalent dans la liste complète
        contraintesManager.contraintes.forEach(function (c) {
            if (newC === c.codeContrainte) {
                c.codeContrainte = null;
                return;
            }
        });
    });

    var data = {
        'updatedContraintes': contraintesManager.contraintes,
        'removedContraintes': contraintesManager.removedContraintes
    };
    var url = Routing.generate('contraintes_edit', {codeCalendrier: calendrier.codeCalendrier});
    $.post(url, data);
    calendrier.contraintes = contraintesManager.contraintes;
    closeModaleGestionContraintes();
    dismissLoader();
}

function closeModaleGestionContraintes() {
    $("div[data-target='contrainte']").modal('close');
}

