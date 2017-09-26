/**
 * Created by void on 07/09/2017.
 * This file is part of Alterplan.
 *
 * Alterplan is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 *
 * Alterplan is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License along with Alterplan. If not, see <http://www.gnu.org/licenses/>.
 */

var boutonSelectors = [];
boutonSelectors['add'] = 'div[data-module-action=\'add\']';
boutonSelectors['remove'] = 'div[data-module-action=\'remove\']';

var ModulesManager = function (caledrier) {
    this.addedModules = [];
    this.removedModules = [];

    this.calendrier = caledrier;
    var me = this;

    var add = function (module) {
        if (!(module.idModule in me.addedModules) &&
            !(module.idModule in me.calendrier.modules)) {
            me.addedModules[module.idModule] = module;
        }
        if (module.idModule in me.removedModules) {
            delete me.removedModules[module.idModule];
        }
    };

    var remove = function (module) {
        if (!(module.idModule in me.removedModules)) {
            me.removedModules[module.idModule] = module;
        }
        if (module.idModule in me.addedModules) {
            delete me.addedModules[module.idModule];
        }
    };

    this.onModaleOpen = function () {
        var modules = me.calendrier.modules;
        var tBody = $('#modules-a-planifier');
        for (var key in modules) {
            if (modules.hasOwnProperty(key)) {
                var tr = $(document.createElement('tr'));
                tr.addClass('clickable');
                tr.attr('id', key);
                tr.data('activate-selector', "div[data-module-action='remove']");
                tr.data('module', modules[key]);
                tr.click(function () {
                    me.selectRow($(this));
                });

                var tdModule = createTd(modules[key].libelle);
                var tdFormation = createTd(modules[key].formation.Libelle);
                var tdLieu = createTd(modules[key].formation.Lieu);

                tr.append(tdModule, [tdFormation, tdLieu]);
                tBody.append(tr);
            }
        }
    };

    this.selectRow = function (row) {
        var $row = $(row);

        var boutonSelector = $row.data('activate-selector');
        if ($(boutonSelector).hasClass('disabled')) {
            me.toggleButton(boutonSelector);
        }

        var destinactionSelector = $(boutonSelector).data('module-table-destination');
        me.deselectRowOnTable(destinactionSelector);

        if (!$row.hasClass('selected')) {
            $row.addClass('selected').siblings().removeClass('selected');
        }
    };

    this.deselectRowOnTable = function (tableSelector) {
        var $tBody = $(tableSelector);
        var selectedRow = $tBody.find('tr.selected');
        if (selectedRow.length > 0) {
            selectedRow.removeClass('selected');
            me.toggleButton(selectedRow.data('activate-selector'));
        }
    };

    this.toggleButton = function (buttonSelector) {
        if ($(buttonSelector).hasClass('disabled')) {
            $(buttonSelector).removeClass('disabled');
        } else {
            $(buttonSelector).addClass('disabled');
        }
    };

    this.transferRow = function (clickedBouton) {
        var action = $(clickedBouton).data('module-action');
        var destinationSelector = $(clickedBouton).data('module-table-destination');

        var $selectedRow = $('tr.selected');
        var module = $selectedRow.data('module');
        var $clone = $selectedRow.clone(true);

        if ('add' === action) {
            $clone.data('activate-selector', boutonSelectors['remove']);
            add(module);
        } else {
            $clone.data('activate-selector', boutonSelectors['add']);
            remove(module);
        }
        var destinationTrSelector = destinationSelector + ' > tr[id="' + $clone.attr('id') + '"]';
        if ($(destinationTrSelector).length > 0) {
            $(destinationTrSelector).replaceWith($clone);
        } else {
            $(destinationSelector).append($clone);
        }
        $selectedRow.remove();

        me.toggleButton(boutonSelectors['add']);
        me.toggleButton(boutonSelectors['remove']);
    };
};

function createTd(content) {
    var td = $(document.createElement('td'));
    td.addClass('col s4 truncate');
    td.attr('title', content);
    td.text(content);
    return td;
}

function postFormSearchSubmit(data) {
    $('div.hoverable.btn').each(function (index) {
        if (!$(this).hasClass('disabled')) {
            $(this).addClass('disabled');
        }
    });

    var searchTabDiv = $('#modules-search-result-container');
    searchTabDiv.empty();
    searchTabDiv.html(data);
}

