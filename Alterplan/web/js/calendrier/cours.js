/**
 * Created by void on 19/09/2017.
 * This file is part of Alterplan.
 *
 * Alterplan is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 *
 * Alterplan is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License along with Alterplan. If not, see <http://www.gnu.org/licenses/>.
 */

var CoursManager = function (jCours) {
    var sorted = jCours.sort(function (c1, c2) {
        if (parseInt(c1.fromToday) > parseInt(c2.fromToday)) {
            return 1;
        }
        if (parseInt(c1.fromToday) < parseInt(c2.fromToday)) {
            return -1;
        }
        return 0;
    });

    this.all = sorted.reduce(function (p1, p2) {
        p1[p2.idCours] = p2;
        return p1;
    }, []);

    this.renderCour = function (jCour, containerSelector) {
        var $body = $(containerSelector);
        $body.append(getTr(jCour));
    };

    var getIndicateurRendering = function () {
        var div = $(document.createElement('div'));
        div.addClass('indicateur amber lighten-4');
        return div;
    };

    var getTr = function (jCour) {
        var div = $(document.createElement('div'));
        div.addClass('tr valign-wrapper bordered');
        div.append(getIndicateurRendering());
        div.append(getTrBody(jCour));

        return div;
    };

    var getTrBody = function (jCour) {
        var div = $(document.createElement('div'));
        div.addClass('tr-body');
        div.append(getCour(jCour));
        return div;
    };

    var getCour = function (jCour) {
        var cour = $(document.createElement('div'));
        cour.addClass('cours center valign-wrapper');
        var columns = getColumns(jCour);
        cour.append(columns[0], columns[1]);
        return cour;
    };

    var getColumns = function (jCour) {
        function pad(s) {
            return (s < 10) ? '0' + s : s;
        }

        var dateDebut = new Date(jCour.dateDebut.date);
        var strDateDebut = [pad(dateDebut.getDate()), pad(dateDebut.getMonth() + 1), dateDebut.getFullYear()].join('/');
        var dateFin = new Date(jCour.dateFin.date);
        var strDateFin = [pad(dateFin.getDate()), pad(dateFin.getMonth() + 1), dateFin.getFullYear()].join('/');

        var columns = [];
        var date = strDateDebut + ' - ' + strDateFin;
        columns[0] = getColumn(date, 's3 date valign-wrapper');

        var lieu = ' - ';
        if (jCour.hasOwnProperty('lieu')) {
            lieu = jCour.lieu.libelle;
        }

        var lieuDisplay = getColumn(lieu, 's12');
        var nbHeure = getColumn(jCour.nbHeures + ' H', 's12');
        var wrapper = $(document.createElement('div'));
        wrapper.addClass('col s12');
        wrapper.append(lieuDisplay, nbHeure);

        var lieuColumn = $(document.createElement('div'));
        lieuColumn.addClass('col s2 valign-wrapper');
        lieuColumn.append(wrapper);

        var programmeColumn = $(document.createElement('div'));
        programmeColumn.addClass('col s6 programme valign-wrapper');

        var titreSize = 12;

        var salleSize = null;
        if (jCour.hasOwnProperty('salle')) {
            titreSize -= 2;
            salleSize = getCour(jCour.salle.capacite, 's2 valign-wrapper');
        }

        var promotionColumn = null;
        if (jCour.hasOwnProperty('promotion')) {
            titreSize -= 2;
            promotionColumn = getColumn(jCour.promotion, 's2 valign-wrapper');
        }

        var titreColumn = getColumn(jCour.libelle, 's' + titreSize + ' center');

        programmeColumn.append(promotionColumn, [titreColumn, salleSize]);
        columns[1] = [lieuColumn, programmeColumn];

        return columns;
    };

    var getColumn = function (spanContent, columnClasses) {
        var div = $(document.createElement('div'));
        var span = $(document.createElement('span'));
        span.addClass('center-align');
        span.addClass('columnContent');
        span.text(spanContent);

        div.addClass('col ' + columnClasses);
        div.append(span);

        return div;
    }
};
 
