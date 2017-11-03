/**
 * Created by void on 27/10/2017.
 * This file is part of Alterplan.
 *
 * Alterplan is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 *
 * Alterplan is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License along with Alterplan. If not, see <http://www.gnu.org/licenses/>.
 */

var oneH = 3600000;
var oneD = 24 * oneH;

var PlacementManager = function (calendrier) {

    var oldModuleClasses = 'flow-text card-panel module';
    var newModuleClasses = 'module-place center valign-wrapper hoverable bordered';
    var spanClasses = 'center-align col s12';
    var containerClasse = 'valign-wrapper';

    var me = this;
    this.calendar = calendrier;

    this.isContainer = function (el) {
        return ($(el).attr('id') === 'modules-planifiables-container') || $(el).hasClass('module-container');
    };

    this.moves = function (el, source, handle, sibling) {
        return $(el).hasClass('selected');
    };

    this.accepts = function (el, target, source, sibling) {
        return $(el).hasClass('selected');
    };

    this.onOver = function (el, container, source) {
        if ($(container).hasClass('module-container')) {
            var nbHeuresModule = $(el).data('placeable').nbHeures;
            var nbHeuresCours = $(container).parents('.tr').data('cours').nbHeures;
            if (nbHeuresModule < nbHeuresCours && Math.round(nbHeuresCours / nbHeuresModule) > 1) {
                splitCours($(container).parents('.tr'), Math.round(nbHeuresCours / nbHeuresModule));
            }
            $(el).removeClass(oldModuleClasses);
            $(el).addClass(newModuleClasses);
            $(el).find('span').addClass(spanClasses);
            $(container).removeClass(containerClasse).children().hide();
        } else {
            $(el).removeClass(newModuleClasses);
            $(el).addClass(oldModuleClasses);
            $(el).find('span').removeClass(spanClasses);
        }
        $('.module-container').each(function (index, obj) {
            if (container !== obj) {
                $(obj).addClass(containerClasse).children().show();
            }
        });
    };

    this.onDrop = function (el, target, source, sibling) {
        if (target !== source) {
            if ($(target).hasClass('module-container')) {
                elementDroped(el, target);
            } else {
                me.calendar.removeModulePlace(el.id);
            }

            if ($(source).hasClass('module-container')) {
                transformerContainer(source);
            }

            $('.tr-cours').not('.no-remove').remove();
            $(el).removeClass('selected').addClass('clickable');
            insertEntreprise();
        }
    };

    var splitCours = function (trCours, semaines) {
        var dateDebut = new Date(new Date(trCours.data('cours').dateDebut.date).toDateString());
        var dateFin = new Date(new Date(trCours.data('cours').dateFin.date).toDateString());

        var nwDateFin = new Date(dateDebut.getTime() + (Math.round((dateFin - dateDebut) / semaines) - oneD));
        var nbH = Math.round((nwDateFin - dateDebut) / oneD) * 7;

        trCours.data('cours').dateFin = {date: nwDateFin.toDateString()};
        trCours.data('cours').nbHeures = nbH;
        trCours.find('span.date').text(getDateStr(dateDebut) + '-' + getDateStr(nwDateFin));
        trCours.find('span.heures').text(nbH + 'H');

        var nwDateDebut = new Date(nwDateFin.getTime() + (3 * oneD));
        nbH = Math.round((dateFin - nwDateDebut + oneD) / oneD) * 7;
        var cloneTr = trCours.clone();

        cloneTr.data('cours', JSON.parse(JSON.stringify(trCours.data('cours'))));
        cloneTr.data('cours').dateDebut = {date: nwDateDebut.toDateString()};
        cloneTr.data('cours').dateFin = {date: dateFin.toDateString()};
        cloneTr.data('cours').nbHeures = nbH;
        cloneTr.find('span.date').text(getDateStr(nwDateDebut) + '-' + getDateStr(dateFin));
        cloneTr.find('span.heures').text(nbH + 'H');
        cloneTr.insertAfter(trCours);
    };

    var elementDroped = function (element, container) {
        transformerContainer(container);
        var nbHeuresModule = $(element).data('placeable').nbHeures;
        var nbHeuresCours = $(container).parents('.tr').data('cours').nbHeures;
        if (nbHeuresModule === nbHeuresCours) {

            $(element).data('placeable').dateDebut = $(container).parents('.tr').data('cours').dateDebut;
            $(element).data('placeable').dateFin = $(container).parents('.tr').data('cours').dateFin;
            me.calendar.addModuleCalendrierPlace($(element).data('placeable'));

        } else if (nbHeuresModule > nbHeuresCours) {

            var nbTotaleSemaines = $(element).data('placeable').module.nbSemaines;
            var nbSemainesRestante = Math.round((nbHeuresModule - nbHeuresCours) / 35);
            var nbSemainesPlaces = nbTotaleSemaines - nbSemainesRestante;

            $(element).data('placeable').dateDebut = $(container).parents('.tr').data('cours').dateDebut;
            $(element).data('placeable').dateFin = $(container).parents('.tr').data('cours').dateFin;
            $(element).data('placeable').nbHeures = nbHeuresCours;
            $(element).data('placeable').nbSemaines = nbSemainesPlaces;
            if (nbSemainesRestante > 0) {
                var s = [];
                for (var i = 1; i <= nbSemainesPlaces; i++) {
                    s.push('S' + i);
                }
                $(element).data('placeable').libelle = $(element).data('placeable').module.libelle + ' (' + s.join(',') + ')';
                $(element).find('span').text($(element).data('placeable').libelle);

                var sr = [];
                for (var j = 1; j <= nbSemainesRestante; j++) {
                    sr.push('S' + (j + nbSemainesPlaces));
                }
                var mc = {
                    codeCalendrier: me.calendar.codeCalendrier,
                    dateDebut: null,
                    dateFin: null,
                    libelle: $(element).data('placeable').module.libelle + ' (' + sr.join(',') + ')',
                    module: $(element).data('placeable').module,
                    nbHeures: nbHeuresModule - nbHeuresCours,
                    nbSemaines: nbSemainesRestante

                };
                var $container = $('#modules-planifiables-container');
                $container.append(getPlaceableRendering(me.calendar.addModuleCalendrierAPlacer(mc)));
            }
            me.calendar.addModuleCalendrierPlace($(element).data('placeable'));
        }
        $(element).data('placeable').cours = $(container).parents('.tr').data('cours');
        $(element).parent().removeClass('module-container');
        verifContraintes();
    };

    var transformerContainer = function (container) {
        $(container).parents('.tr').toggleClass('no-remove');
        $(container).parents('.tr').toggleClass('tr-cours');
        $(container).parents('.tr').toggleClass('tr-module');
        $(container).parents('.tr').toggleClass('cyan lighten-5');

        $(container).parent().toggleClass('cours');
        $(container).parent().toggleClass('module-planifie');
    };
};

function insertEntreprise() {
    function getEntreprise(periode, semaines) {
        var entrepriseTemplate = $('#entreprise-template').children();
        entrepriseTemplate.find("span.date").text(periode);
        entrepriseTemplate.find("span.semaines").text(semaines);
        return entrepriseTemplate.clone().removeClass('no-remove');
    }

    $('.tr-module').not('.template').each(function (index, item) {
        var dateDebut = null;
        var dateFin = null;
        var strDateDebut;
        var strDateFin;
        var semaines;

        var prev = $(item).prev();
        if (prev.length > 0) {
            dateDebut = new Date(new Date($(prev).data('cours').dateFin.date).getTime() + 3 * oneD);
            dateFin = new Date(new Date($(item).data('cours').dateDebut.date).getTime() - 3 * oneD);
        } else {
            dateDebut = new Date(calendrier.periode.debut.date);
            dateFin = new Date(new Date($(item).data('cours').dateDebut.date).getTime() - 3 * oneD);
        }

        strDateDebut = getDateStr(dateDebut);
        strDateFin = getDateStr(dateFin);
        semaines = Math.round((dateFin - dateDebut) / 604800000);
        if (semaines > 0) {
            $(getEntreprise(strDateDebut + ' - ' + strDateFin, (semaines > 1 ? semaines + ' semaines' : semaines + ' semaines'))).insertBefore(item);
        }

        var next = $(item).next();
        if (next.length === 0) {
            dateDebut = new Date(new Date($(item).data('cours').dateFin.date).getTime() + 3 * oneD);
            dateFin = new Date(calendrier.periode.fin.date);
            strDateDebut = getDateStr(dateDebut);
            strDateFin = getDateStr(dateFin);
            semaines = Math.round((dateFin - dateDebut) / 604800000);
            if (semaines > 0) {
                $(getEntreprise(strDateDebut + ' - ' + strDateFin, (semaines > 1 ? semaines + ' semaines' : semaines + ' semaines'))).insertAfter(item);
            }
        }
    });
}

