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
var Calendrier = function (jCalendrier) {
    var parsedPeriode = JSON.parse(jCalendrier.periode);
    var me = this;

    this.codeCalendrier = jCalendrier.codeCalendrier;
    this.periode = {'debut': JSON.parse(parsedPeriode.debut), 'fin': JSON.parse(parsedPeriode.fin)};
    this.formation = JSON.parse(jCalendrier.formation);
    this.contraintes = JSON.parse(jCalendrier.contraintes);


    this.modulesCalendrierPlaces = JSON.parse(jCalendrier.modulesCalendrierPlaces).reduce(function (p1, p2) {
        p1[p2.module.idModule + '-' + p2.codeModuleCalendrier] = p2;
        return p1;
    }, []);

    this.modulesCalendrierAPlacer = JSON.parse(jCalendrier.modulesCalendrierAPlacer).reduce(function (p1, p2) {
        p1[p2.module.idModule + '-' + p2.codeModuleCalendrier] = p2;
        return p1;
    }, []);

    this.modules = Object.keys(this.modulesCalendrierAPlacer).reduce(function (p1, p2) {
        p1[me.modulesCalendrierAPlacer[p2].module.idModule] = me.modulesCalendrierAPlacer[p2].module;
        return p1;
    }, []);

    this.displayPlaceableElements = function () {
        var $container = $('#modules-planifiables-container');
        $container.empty();
        for (cle in this.modulesCalendrierAPlacer) {
            if (this.modulesCalendrierAPlacer.hasOwnProperty(cle)) {
                $container.append(getPlaceableRendering(this.modulesCalendrierAPlacer[cle]));
            }
        }
    };

    this.updateModules = function () {
        this.modules = this.modulesCalendrierAPlacer.reduce(function (p1, p2) {
            p1[p2.module.idModule] = p2.module;
            return p1;
        }, [])
    };

    this.addModuleCalendrierAPlacer = function (jModuleCalendrier) {
        if (!jModuleCalendrier.hasOwnProperty('codeModuleCalendrier')) {
            var code = 0;
            for (cle in this.modulesCalendrierAPlacer) {
                if (this.modulesCalendrierAPlacer.hasOwnProperty(cle)) {
                    code = code < this.modulesCalendrierAPlacer[cle].codeModuleCalendrier ? this.modulesCalendrierAPlacer[cle].codeModuleCalendrier : code;
                }
            }
            jModuleCalendrier.codeModuleCalendrier = ++code;
        }
        this.modulesCalendrierAPlacer[jModuleCalendrier.module.idModule + '-' + jModuleCalendrier.codeModuleCalendrier] = jModuleCalendrier;
        return jModuleCalendrier;
    };

    this.addModuleCalendrierPlace = function (jModuleCalendrier) {
        if (!jModuleCalendrier.hasOwnProperty('codeModuleCalendrier')) {
            var code = 0;
            for (cle in this.modulesCalendrierPlaces) {
                if (this.modulesCalendrierPlaces.hasOwnProperty(cle)) {
                    code = code < this.modulesCalendrierPlaces[cle].codeModuleCalendrier ? this.modulesCalendrierPlaces[cle].codeModuleCalendrier : code;
                }
            }
            jModuleCalendrier.codeModuleCalendrier = ++code;
        }

        this.modulesCalendrierPlaces[jModuleCalendrier.module.idModule + '-' + jModuleCalendrier.codeModuleCalendrier] = jModuleCalendrier;
        if (this.modulesCalendrierAPlacer.hasOwnProperty(jModuleCalendrier.module.idModule + '-' + jModuleCalendrier.codeModuleCalendrier)) {
            delete this.modulesCalendrierAPlacer[jModuleCalendrier.module.idModule + '-' + jModuleCalendrier.codeModuleCalendrier];
        }

        return jModuleCalendrier;
    };

    this.removeModulePlace = function (identifiant) {
        if (this.modulesCalendrierPlaces.hasOwnProperty(identifiant)) {
            this.modulesCalendrierPlaces[identifiant].dateDebut = null;
            this.modulesCalendrierPlaces[identifiant].dateFin = null;
            this.addModuleCalendrierAPlacer(this.modulesCalendrierPlaces[identifiant]);
            delete this.modulesCalendrierPlaces[identifiant];
        }
    };
};

function getPlaceableRendering(jPlaceable) {
    var div = $(document.createElement('div'));
    div.attr('id', jPlaceable.module.idModule + '-' + jPlaceable.codeModuleCalendrier);
    div.data('placeable', jPlaceable);
    div.addClass('flow-text card-panel module clickable');
    div.click(function () {
        selectPlaceable($(this));
    });

    var span = $(document.createElement('span'));
    span.text(jPlaceable.libelle);
    div.append(span);

    return div;
}

function selectPlaceable(clickedElement) {
    var $element = $(clickedElement);
    if (!$element.hasClass('selected')) {
        showLoader();
        if ($element.hasClass('module-place')) {
            $element.parent().toggleClass('module-container');
        }

        $('.module.selected').removeClass('selected').addClass('clickable');
        $('.module-place.selected').removeClass('selected').addClass('clickable').parent().toggleClass('module-container');

        $element.removeClass('clickable').addClass('selected');
        var url = Routing.generate('cours_search', {
            idModule: $element.data('placeable').module.idModule,
            codeCalendrier: calendrier.codeCalendrier
        });

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

function saveModulesAPlanifier() {
    showLoader();
    closeModaleGestionModules();

    var added = [];
    var removed = [];

    var moduleCalendrierRemoved = Object.keys(calendrier.modulesCalendrierAPlacer).filter(function (t, number, ts) {
        return Object.keys(modulesManager.removedModules).indexOf(String(calendrier.modulesCalendrierAPlacer[t].module.idModule)) > -1;
    });

    for (cleMC in moduleCalendrierRemoved) {
        if (moduleCalendrierRemoved.hasOwnProperty(cleMC) &&
            calendrier.modulesCalendrierAPlacer.hasOwnProperty(moduleCalendrierRemoved[cleMC])) {
            removed.push(calendrier.modulesCalendrierAPlacer[moduleCalendrierRemoved[cleMC]].codeModuleCalendrier);
            delete calendrier.modulesCalendrierAPlacer[moduleCalendrierRemoved[cleMC]];
        }
    }

    for (addedKey in modulesManager.addedModules) {
        if (!calendrier.modules.hasOwnProperty(addedKey)) {

            var addedMC = calendrier.addModuleCalendrierAPlacer({
                codeCalendrier: calendrier.codeCalendrier,
                dateDebut: null,
                dateFin: null,
                libelle: modulesManager.addedModules[addedKey].libelle,
                module: modulesManager.addedModules[addedKey]
            });

            added.push(addedMC);
        }
    }

    calendrier.updateModules();

    //TODO : enregistrer avec les calendrier peut être?
    var data = {'addedModules': added, 'removedModules': removed};
    var url = Routing.generate('calendrier_edit', {codeCalendrier: calendrier.codeCalendrier});
    $.post(url, data);

    calendrier.displayPlaceableElements();
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
                    rowP2 = stagiaire.codeStagiaire;
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
    var contraintesToSave = JSON.parse(JSON.stringify(contraintesManager.contraintes));
    contraintesManager.addedContraintes.forEach(function (newC) {
        //pour toutes les nouvelles contraintes on cherche l'équivalent dans la liste complète
        contraintesToSave.forEach(function (c) {
            if (c != null) {
                if (newC === c.codeContrainte) {
                    c.codeContrainte = null;
                    return;
                }
            }
        });
    });
    //modification de la date et enregistrement du calendrier.
    contraintesToSave.forEach(function (contrainte) {
        if (contrainte.typeContrainte.codeTypeContrainte === 1) {
            calendrier.periode.debut = contrainte.P1;
            calendrier.periode.fin = contrainte.P2;
            var saveUrl = Routing.generate('saveCalendrierDate', {codeCalendrier: calendrier.codeCalendrier});
            var saveData = {
                'dateDebut': calendrier.periode.debut,
                'dateFin': calendrier.periode.fin,
                'codeCalendrier': calendrier.codeCalendrier
            };
            $.post(saveUrl, saveData);
            return;
        }
    });


    var data = {
        'updatedContraintes': contraintesToSave,
        'removedContraintes': contraintesManager.removedContraintes
    };
    var url = Routing.generate('contraintes_edit', {codeCalendrier: calendrier.codeCalendrier});
    $.post(url, data);
    calendrier.contraintes = contraintesManager.contraintes;
    closeModaleGestionContraintes();
    verifContraintes();
    dismissLoader();
}

function closeModaleGestionContraintes() {
    $("div[data-target='contrainte']").modal('close');
}

function closeModaleInscrireCalendrier() {
    $("div[data-target='inscrire_calendrier']").modal('close');
}

function inscrireCalendrier() {
    showLoader();
    var url = Routing.generate('calendrier_inscrire', {codeCalendrier: calendrier.codeCalendrier});
    $.post(url).done(function () {
        showToast("Le calendrier a bien été inscrit", "success");
        $('#inscrireCalendrier').addClass('disabled');
    });
    closeModaleInscrireCalendrier();
    dismissLoader();
}
function verifContraintes() {

    //on commence par supprimer toutes les divs warning
    $(".warning").remove();

    var firstModule = null;
    var lastModule = null;
    var nbHeuresFormation = 0;
    var nbSemainesFormationMax = null;
    var codeStagiaireNR = null;
    var modulesPlaces = calendrier.modulesCalendrierPlaces
    for (cle in calendrier.modulesCalendrierPlaces) {
        if (calendrier.modulesCalendrierPlaces.hasOwnProperty(cle)) {
            nbHeuresFormation += calendrier.modulesCalendrierPlaces[cle].nbHeures;
            if (firstModule != null && lastModule != null) {
                if (calendrier.modulesCalendrierPlaces[cle].dateDebut < firstModule.dateDebut) {
                    firstModule = calendrier.modulesCalendrierPlaces[cle];
                }
                if (calendrier.modulesCalendrierPlaces[cle].dateFin > lastModule.dateFin) {
                    lastModule = calendrier.modulesCalendrierPlaces[cle];
                }

            } else {
                firstModule = calendrier.modulesCalendrierPlaces[cle];
                lastModule = calendrier.modulesCalendrierPlaces[cle];
            }
        }
    }

    //1ère vérification: periode contractuelle
    if (calendrier.periode.debut > firstModule.dateDebut) {
        div_header = $('#calandar-hearder')[0];

        var divContrainte = createDivContraite(div_header, '- Le calendrier démarre avant  la période contractuelle qui débute le ' + calendrier.periode.debut);
    }
    if (calendrier.periode.fin < lastModule.dateFin) {
        div_header = $('#calandar-hearder')[0];
        var divContrainte = createDivContraite(div_header, ' - Le calendrier dépasse la période contractuelle qui finit le ' + calendrier.periode.fin);
    }
    //verif volume horaire
    for (cle in calendrier.contraintes) {
        if (calendrier.contraintes.hasOwnProperty(cle)) {
            var contrainte = calendrier.contraintes[cle];
            if (contrainte.typeContrainte.codeTypeContrainte === 2) {
                if (nbHeuresFormationnbHeuresFormation < contrainte.P1 || nbHeuresFormation > contrainte.p2) {
                    div_header = $('#calandar-hearder')[0];
                    var div_contrainte = createDivContraite(div_header, '- Le volume horaire actuel (' + nbHeuresFormation + 'h) ne convient pas (min: ' + contrainte.P1 + 'h, max: ' + contrainte.P2 + 'h)');
                    //div_header.append(div_contrainte);
                }
            }
            //Ecart debut de formation
            if (contrainte.typeContrainte.codeTypeContrainte === 3) {
                var date1 = new Date(firstModule.dateDebut.date);
                var date2 = new Date(calendrier.periode.debut.date);
                var diff = date1 - date2;
                var semaines = Math.round(diff / 604800000);
                if (semaines < contrainte.P1 || semaines > contrainte.P2) {
                    div_header = $('#calandar-hearder')[0]
                    var div_contrainte = createDivContraite(div_header, '- Ecart début de formation non valide: Actuel:' + semaines + ', min:' + contrainte.P1 + ', max:' + contrainte.P2);
                }
            }
            //Ecart fin de formation
            if (contrainte.typeContrainte.codeTypeContrainte === 4) {
                var date1 = new Date(calendrier.periode.fin.date);
                var date2 = new Date(firstModule.dateFin.date);
                var diff = date1 - date2;
                var semaines = Math.round(diff / 604800000);
                if (semaines < contrainte.P1 || semaines > contrainte.P2) {
                    div_header = $('#calandar-hearder')[0]
                    var div_contrainte = createDivContraite(div_header, '- Ecart fin de formation non valide: Actuel:' + semaines + ', min:' + contrainte.P1 + ', max:' + contrainte.P2);
                }
            }
            if (contrainte.typeContrainte.codeTypeContrainte === 5) {
                nbSemainesFormationMax = contrainte.P1;
            }
            if (contrainte.typeContrainte.codeTypeContrainte === 6) {
                codeStagiaireNR = contrainte.P2;
            }
        }
    }

    //Semaines en formation Max
    //on classe les modules dans l'ordre dans lequel ils arrivent.
    // Si il y a moins de 7 jours entre les début des deux modules alors ils se suivent

    if (nbSemainesFormationMax != null) {
        var orderedModulesPlaces = calendrier.modulesCalendrierPlaces.sort(sortModulesByDate(a, b));
        var nbSemaines = 0;
        var previousModuleCalendrier = null;
        for (cle in orderedModulesPlaces) {
            if (orderedModulesPlaces.hasOwnProperty(cle)) {
                var moduleCalendrier = orderedModulesPlaces[cle];
                if (previousModuleCalendrier != null) {
                    var semaines = Math.round((dateFin - dateDebut) / 604800000);
                    if (!(semaines < 2)) {
                        nbSemaines = 0;
                    }
                    nbSemaines++;
                    if (nbSemaines > nbSemainesFormationMax) {
                        var div_header = $('#' + cle)[0]
                        var div_contrainte = createDivContraite(div_header, '- Nombre de semaines en formation dépassé (actuel:' + nbSemaines + ', max:' + nbSemainesFormationMax);

                    }
                }
                previousModuleCalendrier = moduleCalendrier;
            }
        }
    }

    //Non recouvrement
    if (codeStagiaireNR != null) {
        var calendrierNR = null;
        var url = Routing.generate('non_recouvrement');
        var data = {
            'codeStagiaire': codeStagiaireNR
        };
        $.get(url, data, function (data) {
            calendrierNR = data;
        })
        if (calendrierNR != null) {
            // on trie les deux listes (on ne prends que les modulesPlaces pour la deuxieme),
            //foreach sur la première
            // foreach sur la deuxième
            // Si dd1<dd2<df1 || dd1<df1<dd2 || dd2<dd1<df2 || dd2<df1<df2
            // alors on déclanche la contrainte pour le module de la liste 1
            var modulesPlaces = calendrier.modulesCalendrierPlaces.sort(sortModulesByDate(a, b));
            var modulesNR = calendrierNR.modulesCalendrier.filter(filtreByDate).sort(sortModulesByDate(a, b));
            for (cle in modulesPlaces) {
                if (modulesPlaces.hasOwnProperty(cle)) {
                    var module = modulesPlaces[cle];
                    for (cle2 in modulesNR) {
                        if (modulesNR.hasOwnProperty(cle2)) {
                            var moduleNR = modulesNR[cle2];
                            if (module.dateDebut < moduleNR.dateDebut < module.dateFin ||
                                module.dateDebut < moduleNR.dateFin < module.dateFin ||
                                moduleNR.dateDebut < module.dateDebut < moduleNR.dateFin ||
                                moduleNR.dateDebut < module.dateFin < moduleNR.dateFin) {
                                div_header = $('#' + cle)[0]
                                var div_contrainte = createDivContraite(div_header, '- Le stagiaire ' + contrainte.P1 + ' est lui aussi en formation pendant cette periode');
                            }
                        }
                    }
                }
            }
        }
    }
    //gestion de l'ordre logique des modules

    {
        var txtCOL = null;
        //pour chaque ordremodule
        for (cle in calendrier.formation.ordresModule) {
            if (calendrier.formation.ordresModule.hasOwnProperty(cle)) {
                var ordreModule = calendrier.formation.ordresModule[cle];

                //pour chaque moduleCalendrier placé
                for (cleMCPlace in calendrier.modulesCalendrierPlaces) {
                    if (calendrier.modulesCalendrierPlaces.hasOwnProperty(cleMCPlace)) {
                        var mcPlace = calendrier.modulesCalendrierPlaces[cleMCPlace];

                        //si le calendrier placé correspond à l'ordre module
                        if (mcPlace.module.idModule === ordreModule.idModule) {
                            var tableModuleFail = [];
                            for (cleGroupe in ordreModule.groupes) {
                                if (ordreModule.groupes.hasOwnProperty(cleGroupe)) {
                                    var groupe = ordreModule.groupes[cleGroupe];
                                    //maintenant qu'on a un groupe, on va faire une condition graces aux modules de ses 1 ou 2 sousgroupes
                                    var sousgroupe1 = null;
                                    var sousgroupe2 = null;
                                    var moduleFailGroupe = []
                                    var module1 = [];
                                    var module2 = [];
                                    var moduleCompare = null;
                                    for (i = 0; i < 10; i++) {
                                        moduleFailGroupe[i] = null;
                                        module1[i] = true;
                                        module2[i] = true;
                                    }
                                    //region sg1
                                    var i = 0;
                                    if (groupe.sousGroupes != null) {
                                        for (var j in groupe.sousGroupes) {
                                            sousgroupe1 = groupe.sousGroupes[j];
                                            break;
                                        }
                                        if (sousgroupe1) {
                                            for (CleSG1 in sousgroupe1.modules) {
                                                if (sousgroupe1.modules.hasOwnProperty(CleSG1)) {
                                                    var module = sousgroupe1.modules[CleSG1];
                                                    if (module !== null) {
                                                        moduleCompare = calendrier.modulesCalendrierPlaces.filter(function (obj) {
                                                            return obj.module.idModule == module.idModule;
                                                        });
                                                        if (moduleCompare.length > 0) {
                                                            moduleFailGroupe[i] = (moduleCompare[0].libelle);
                                                            if (moduleCompare[0].dateDebut > mcPlace.dateDebut) {
                                                                module1[i] = false;
                                                            } else {
                                                                module1[i] = true;
                                                            }
                                                        } else {
                                                            moduleFailGroupe[i] = null;
                                                            module1[i] = true;
                                                        }
                                                    } else {
                                                        moduleFailGroupe[i] = null;
                                                        module1[i] = true;
                                                    }
                                                    i++;
                                                }
                                            }
                                        }
                                    }
                                    //endregion
                                    i = 5;
                                    //region sg2
                                    if (groupe.sousGroupes != null) {
                                        var sousgroupe2 = groupe.sousGroupes[Object.keys(groupe.sousGroupes)[Object.keys(groupe.sousGroupes).length - 1]];
                                        if (sousgroupe2 && sousgroupe2 != sousgroupe1) {
                                            for (CleSG2 in sousgroupe2.modules) {
                                                if (sousgroupe2.modules.hasOwnProperty(CleSG2)) {
                                                    var module = sousgroupe2.modules[CleSG2];
                                                    if (module !== null) {
                                                        moduleCompare = calendrier.modulesCalendrierPlaces.filter(function (obj) {
                                                            return obj.module.idModule == module.idModule;
                                                        });
                                                        if (moduleCompare.length > 0) {
                                                            moduleFailGroupe[i] = (moduleCompare[0].libelle);
                                                            if (moduleCompare[0].dateDebut > mcPlace.dateDebut) {
                                                                module2[i] = false;
                                                            } else {
                                                                module2[i] = true;
                                                            }
                                                        } else {
                                                            moduleFailGroupe[i] = null;
                                                            module2[i] = true;
                                                        }
                                                    } else {
                                                        moduleFailGroupe[i] = null;
                                                        module2[i] = true;
                                                    }
                                                    i++;
                                                }
                                            }
                                        }
                                    }
                                    //endregion
                                    //on fait le if
                                    if (((module1[0] && module1[1] && module1[2] && module1[3] && module1[4]) ||
                                        (module2[5] && module2[6] && module2[7] && module2[3] && module2[4])) === false) {
                                        // le groupe ne suit pas l'ordre logique --> on ajoutes les modules posant pb à la liste.
                                        tableModuleFail.push(moduleFailGroupe)
                                    }
                                }
                            }
                            for (i = 0; i < tableModuleFail.length; i++) {
                                for (j = 0; j < 10; j++) {
                                    if (tableModuleFail[i][j] != null) {
                                        if (j != 0 && j != 5)
                                            txtCOL += "et " + tableModuleFail[i][j] + " ";
                                    } else if (j === 0) {
                                        txtCOL += "- " + tableModuleFail[i][j] + " ";
                                    } else if (j === 5) {
                                        txtCOL += "ou bien " + tableModuleFail[i][j] + " ";
                                    }
                                }
                                txtCOL += "<br/>";
                            }
                            if (tableModuleFail.length > 1) {
                                var div_header = $('#' + cleMCPlace)[0];
                                var div_contrainte = createDivContraite(div_header, "L\'ordre logique des modules n\'est pas suivi: les modules suivant doivent PRÉCEDER ce module:" + '<br/>' + txtCOL);
                            }
                        }
                    }
                }
            }
        }
    }

    $('.tooltipped').tooltip({delay: 50, html: true}).each(function () {
        var background = $(this).data('background-color');
        if (background) {
            $("#" + $(this).data('tooltip-id')).find(".backdrop").addClass(background);
        }
    });
}

function sortModulesByDate(moduleA, moduleB) {
    if (moduleA.dateDebut < moduleB.dateDebut) {
        return -1;
    }
    if (moduleA.dateDebut > moduleB.dateDebut) {
        return 1;
    }
    return 0;
}

function filtreByDate(module) {
    if (module.dateDebut != null && module.dateFin != null) {
        return true;
    }
    return false;
}

function createDivContraite(parentDiv, tooltip) {
    if ($(parentDiv).find('.contrainte').length > 0) {
        warning = $(parentDiv).find('.warning');
        var textWarning = $(warning).attr('data-tooltip');
        $(warning).attr('data-tooltip', textWarning += '<br/>' + tooltip);
    } else {
        var div = document.createElement('div');
        $(div).addClass('contrainte');
        var warning = document.createElement('i');
        $(warning).addClass('material-icons');
        $(warning).addClass('tooltipped');
        $(warning).addClass('warning');
        $(warning).attr('data-position', 'bottom');
        $(warning).attr('data-tooltip', tooltip);
        $(warning).attr('data-background-color', 'red');
        $(warning).html('warning');
        div.append(warning);
        parentDiv.append(div);
        return div
    }

}

function findModuleById(modules, id) {

}