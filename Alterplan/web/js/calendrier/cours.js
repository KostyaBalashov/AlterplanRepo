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

        var courTemplate = $('#cours-template').children();
        setDate(courTemplate, jCour);
        setHeures(courTemplate, jCour);
        setLieu(courTemplate, jCour);
        setProgramme(courTemplate, jCour);
        setPromotion(courTemplate, jCour);

        var clone = courTemplate.clone();
        clone.removeClass('no-remove');
        clone.data('cours', jCour);

        var added = false;
        $('.tr-module').each(function (index, item) {
            if ($(item).data('cours').idCours !== jCour.idCours) {
                var dateDebutCours = new Date(jCour.dateDebut.date);
                var dateFinCours = new Date(jCour.dateFin.date);
                var dateDebutModule = new Date($(item).data('cours').dateDebut.date);
                var dateFinModulePrecedent = $(item).prev().lenght > 0 ? new Date($(item).prev().data('cours').dateFin.date) : new Date(1970, 0, 1);
                if (dateFinCours < dateDebutModule && dateDebutCours > dateFinModulePrecedent) {
                    clone.insertBefore(item);
                    added = true;
                    return false;
                }
            } else {
                added = true;
                return false;
            }
        });

        if (!added) {
            $body.append(clone);
        }
    };

    var setDate = function ($template, jCour) {
        function pad(s) {
            return (s < 10) ? '0' + s : s;
        }

        var dateDebut = new Date(jCour.dateDebut.date);
        var strDateDebut = [pad(dateDebut.getDate()), pad(dateDebut.getMonth() + 1), dateDebut.getFullYear()].join('/');
        var dateFin = new Date(jCour.dateFin.date);
        var strDateFin = [pad(dateFin.getDate()), pad(dateFin.getMonth() + 1), dateFin.getFullYear()].join('/');
        var date = strDateDebut + ' - ' + strDateFin;

        $template.find("span.date").text(date);
    };

    var setLieu = function ($template, jCour) {
        var lieu = ' - ';
        if (jCour.hasOwnProperty('lieu')) {
            lieu = jCour.lieu.libelle;
        }
        $template.find("span.lieu").text(lieu);
    };

    var setHeures = function ($template, jCour) {
        $template.find("span.heures").text(jCour.nbHeures + ' H');
    };

    var setPromotion = function ($template, jCour) {
        var promotion = ' - ';
        if (jCour.hasOwnProperty('promotion')) {
            promotion = jCour.promotion;
        }
        $template.find("span.promotion").text(promotion);
    };

    var setProgramme = function ($template, jCour) {
        $template.find("span.programme").text(jCour.libelle);
    };
};
 
