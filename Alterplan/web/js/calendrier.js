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

var Cours = function (jCours) {
    this.all = jCours.reduce(function (p1, p2) {
        p1[p2.idCours] = p2;
        return p1;
    }, []);

};

var Calendrier = function (jFormation, jModules) {
    this.formation = jFormation;
    this.modules = jModules.reduce(function (p1, p2) {
        p1[p2.idModule] = p2;
        return p1;
    }, []);
};

function refreshModules(modules) {
    var $container = $('#modules-planifiables-container');
    $container.empty();
    for (cle in modules){
        if (modules.hasOwnProperty(cle)){
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
    var calendarBody = $('#calendar-body');
    var $module = $(clickedModule);
    if (!$module.hasClass('selected')){
        showLoader();
        $module.addClass('selected').siblings().removeClass('selected');
        var url = "/cours/" + $module.attr('id');
        $.get(url, function (data) {
            calendarBody.text(data);
        }).always(function () {
            dismissLoader();
        });
    }
}