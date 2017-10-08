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
var Calendrier = function (codeCalendrier, jFormation, jModules) {
    this.codeCalendrier = codeCalendrier;
    this.formation = jFormation;
    this.modules = jModules.reduce(function (p1, p2) {
        p1[p2.idModule] = p2;
        return p1;
    }, []);
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
            span.addClass('card-title');
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
    if (!$module.hasClass('selected')) {
        showLoader();
        $module.addClass('selected').siblings().removeClass('selected');
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
    $(bodySelector).empty();
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