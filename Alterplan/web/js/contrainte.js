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

var ContraintesManager = function (calendrier, urlAllTC) {

    //region Déclaration des variables
    this.addedContraintes = [];
    this.removedContraintes = [];
    this.calendrier = calendrier;
    this.contraintes = [];
    this.typeContraintes = getAllTypeContraintes(urlAllTC);
    var me = this;
    this.stagiaires = [];
    //endregion


    this.onModaleOpen = function () {
        showLoader();
        //bug index null, on supprime
        //me.contraintes.splice(null, 1);


        //Pour chaque contrainte on créé un TR
        //Dans ce TR on place un td avec un select qui a pour option par defait le tc de la contrainte
        //Dans un deuxième td on place le/les champs correspondant au tc et on les remplis si on a les infos
        // A chaque fois qu'on supprime une contrainte on l'ajoute dans la liste des contraintes à supprimer
        //A chaque fois qu'on ajoute une contrainte on l'ajoute dans la liste des contraintes en plus
        $.when(getContraintesCalendrier(me.calendrier.codeCalendrier)).then(function (result) {
            dismissLoader();
            if (result != undefined) {
                me.calendrier.contraintes = result;

            }
            me.contraintes = [];
            for (var cle in me.calendrier.contraintes) {
                var contrainte = calendrier.contraintes[cle]
                me.contraintes[cle] = contrainte;
            }
            var typeContraintes = me.typeContraintes;
            var tBody = $('#tableauContraintes');
            var x = 1;
            for (var key in me.contraintes) {
                contrainte = me.contraintes[key];
                var tr = document.createElement("tr");
                tr.id = contrainte.codeContrainte;
                tr.className = "trTable";
                var tdTypeContrainte = document.createElement("td");
                var div_input = document.createElement('div');
                div_input.id = 'div_input';


                //region tdTypeContrainte
                var selectList = document.createElement("select");
                selectList.id = "typeContrainte";
                selectList.className = "select typeContrainte";
                //selectList.style.display = "block";
                //Récuperation de tous les typeContraintes
                if (typeContraintes != null) {
                    for (var k in typeContraintes) {
                        var typeContrainte = typeContraintes[k];
                        var option = document.createElement("option");
                        option.value = typeContraintes.indexOf(typeContrainte);
                        option.setAttribute('data-nb-input', typeContrainte.nbParametres);
                        option.setAttribute('data-nb-contraintes', me.contraintes.indexOf(contrainte));
                        option.innerHTML = typeContrainte.libelle;
                        $(selectList).append(option);
                        if (contrainte) {
                            if (typeContrainte.codeTypeContrainte === contrainte.typeContrainte.codeTypeContrainte) {
                                option.setAttribute('selected', 'true');
                            }
                        }
                    }
                }
                refreshAllSelect();
                // endregion

                //gestion du td contenant les champs: au lancement, on lance la fonction
                tdData = document.createElement('td');
                var typeContrainte = $('option:selected', this).val();
                ChargementContraintes(contrainte, div_input);


                //gestion td avec bouton delete
                var tdDelete = document.createElement('td')
                var deleteButton = document.createElement('a');
                deleteButton.className = "deleteRow btn-floating waves-effect waves-light red right-align";
                deleteButton.innerHTML = '<i class="material-icons">remove</i>';
                if (selectList.selectedIndex === 0) {
                    $(deleteButton).addClass('disabled');
                }
                $(tdDelete).append(deleteButton);

                // on place tous les éléments dans le tbody
                $(tdTypeContrainte).append(selectList);
                $(tdData).append(div_input);
                $(tr).append(tdTypeContrainte);
                $(tr).append(tdData);
                $(tr).append(tdDelete)
                $(tBody).append(tr);
                x++;
                initDP();


                $('select').change(function () {

                    var value = $(this).val();

                    $(this).siblings('select').children('option').each(function () {
                        if ($(this).val() === value) {
                            $(this).attr('disabled', true).siblings().removeAttr('disabled');
                        }
                    });
                    refreshAllSelect();
                });
            }
            if ($('select.typeContrainte').length >= 6) {
                $('.add_another').attr('disabled', 'disabled');
            }

            // à chaque changement d'option, on rafraichi la td et on remet les valeurs à vide
            $(document).on('change', '#typeContrainte', function () {
                var $this = $(this);
                //ce qu'on veut récupérer, c'est la div input du même tr et la contrainte
                var optionSelected = $("option:selected", this);
                var i = optionSelected.attr('data-nb-contraintes');
                var selectedContrainte = me.contraintes[i];

                //on doit changer le typeContrainte à celui de maintenant
                selectedContrainte.typeContrainte = typeContraintes[this.value];
                //on vide les données de la contrainte
                selectedContrainte.P1 = null;
                selectedContrainte.P2 = null;
                //on veut maintenant récupérer la div
                div_input = $this.closest('tr').find('div.div_input')[0];
                ChargementContraintes(selectedContrainte, div_input);
            });

            $('.deleteRow').click(function () {
                var codeContrainteToRemove = parseInt($(this).closest('tr').attr('id'));
                me.contraintes.forEach(function (element) {
                    if (element.codeContrainte === codeContrainteToRemove) {
                        me.removedContraintes[element.codeContrainte] = element.codeContrainte;
                        delete me.contraintes[codeContrainteToRemove];
                    }
                });
                me.addedContraintes.forEach(function (element) {
                    if (element.codeContrainte = codeContrainteToRemove) {
                        delete me.addedContraintes[codeContrainteToRemove];
                    }
                });
                $(this).closest('tr').remove();
                refreshAllSelect();
                $('.add_another').attr('disabled', false);
            });


            $('.add_another').click(function () {
                var date = new Date();
                var newId = 0;
                for (var kc in me.contraintes) {
                    var c = me.contraintes[kc];
                    if (newId <= c.codeContrainte) {
                        newId = parseInt(kc) + 1;
                    }
                }
                var newContrainte = {
                        DateCreation: date,
                        P1: null,
                        P2: null,
                        codeCalendrier: calendrier.codeCalendrier,
                        codeContrainte: newId,
                        typeContrainte: checkForFreeTC(me.typeContraintes)
                    }
                ;
                me.addedContraintes[newContrainte.codeContrainte] = newContrainte.codeContrainte;
                me.contraintes[newContrainte.codeContrainte] = newContrainte;
                var newTr = document.createElement("tr");
                newTr.id = newContrainte.codeContrainte;
                newTr.className = "trTable";
                var newTd = document.createElement("td");
                var newDiv_input = document.createElement('div');
                newDiv_input.id = 'div_input';
                var newSelectList = document.createElement("select");
                newSelectList.id = "typeContrainte";
                newSelectList.className = "select typeContrainte";
                //Récuperation de tous les typeContraintes
                if (typeContraintes != null) {
                    for (var k in typeContraintes) {
                        var typeContrainte = typeContraintes[k];
                        var option = document.createElement("option");
                        option.value = typeContraintes.indexOf(typeContrainte);
                        option.setAttribute('data-nb-input', typeContrainte.nbParametres);
                        option.setAttribute('data-nb-contraintes', me.contraintes.indexOf(newContrainte));
                        option.innerHTML = typeContrainte.libelle;
                        $(newSelectList).append(option);
                        if (newContrainte) {
                            if (typeContrainte.codeTypeContrainte === newContrainte.typeContrainte.codeTypeContrainte) {
                                option.setAttribute('selected', 'true');
                            }
                        }
                    }
                }

                //gestion du td contenant les champs: au lancement, on lance la fonction
                var newTdData = document.createElement('td');
                ChargementContraintes(newContrainte, newDiv_input);

                //gestion td avec bouton delete
                var newTdDelete = document.createElement('td')
                var newDeleteButton = document.createElement('a');
                newDeleteButton.className = "deleteRow btn-floating waves-effect waves-light red right-align";
                newDeleteButton.innerHTML = '<i class="material-icons">remove</i>';
                if (newSelectList != undefined && newSelectList != null)
                    if (newSelectList.selectedIndex === 0) {
                        $(newDeleteButton).addClass('disabled');
                    }
                $(newTdDelete).append(newDeleteButton); //gestion td avec bouton delete


                $(newTd).append(newSelectList);
                $(newTdData).append(newDiv_input);
                $(newTr).append(newTd);
                $(newTr).append(newTdData);
                $(newTr).append(newTdDelete);
                $(tBody).append(newTr);

                initDP();
                $('select').material_select();

                $('.deleteRow').click(function () {
                    var codeContrainteToRemove = parseInt($(this).closest('tr').attr('id'));
                    me.contraintes.forEach(function (element) {
                        if (element.codeContrainte === codeContrainteToRemove) {
                            me.removedContraintes[element.codeContrainte] = element.codeContrainte;
                            delete me.contraintes[codeContrainteToRemove];
                        }
                    });
                    me.addedContraintes.forEach(function (element) {
                        if (element.codeContrainte = codeContrainteToRemove) {
                            delete me.contraintes[codeContrainteToRemove];
                        }
                    });
                    $(this).closest('tr').remove();
                    refreshAllSelect();
                    $('.add_another').attr('disabled', false);
                });

                $('select').change(function () {

                    var value = $(this).val();

                    $(this).siblings('select').children('option').each(function () {
                        if ($(this).val() === value) {
                            $(this).attr('disabled', true).siblings().removeAttr('disabled');
                        }
                    });
                    refreshAllSelect();
                });

                if ($('select.typeContrainte').length === 6) {
                    $('.add_another').attr('disabled', 'disabled');
                }
                refreshAllSelect();
            });

            $('input.int').on('change keyup', function () {
                if (this.getAttribute('name') === 'val0') {
                    var input1 = $(this).closest('tr').find('input[name=val1]')[0];
                    if (input1 != undefined) {
                        input1.setAttribute('min', this.value);
                        if (input1.value != "" && this.value > input1.value && !$(this).hasClass('invalid')) {
                            //showToast('Le minimum ne peut pas être superieur au maximum', 'error');
                            $(this).attr('max', input1.value);
                            $(this).removeClass('valid');
                            $(this).addClass('invalid');
                        } else if (!$(this).hasClass('invalid')) {
                            $(this).removeClass('invalid');
                            $(this).addClass('valid');
                        }
                    }
                }
                else if (this.getAttribute('name') === 'val1') {
                    var input0 = $(this).closest('tr').find('input[name=val0]')[0];
                    input0.setAttribute('max', this.value);
                    if (input0.value != "" && this.value > input0.value && !$(this).hasClass('invalid')) {
                        //showToast('Le maximum ne peut pas être inferieur au minimum', 'error');
                        $(this).attr('min', input0.value);
                        $(this).removeClass('valid');
                        $(this).addClass('invalid');
                    } else if (!$(this).hasClass('invalid')) {
                        $(this).removeClass('invalid');
                        $(this).addClass('valid');
                    }
                }
                refreshAllSelect();
            });
            initDP();
        }, function () {
            dismissLoader();
        });
    };

    function ChargementContraintes(contrainte, div_input) {

        div_input.innerHTML = "";
        //pour chaque paramètre on créé l'input qui va bien
        for (var i = 0; i < contrainte.typeContrainte.nbParametres; i++) {

            //var div_input = document.createElement("div");
            div_input.setAttribute("class", "col s6 valign-wrapper div_input divInput" + i);
            div_input.setAttribute("id", "div_input");
            var type1;
            var type2;
            var input = document.createElement("input");
            input.name = "val" + i;
            input.required = "true";
            var label = document.createElement("Label");
            label.style.width = 'auto';
            //selon le typecontrainte, on va avoir un input différent
            switch (contrainte.typeContrainte.codeTypeContrainte) {

                //cas 1 : deux dates Période contractuelle
                case 1:
                    initDP();
                    type1 = 'Date';
                    type2 = 'Date';

                    input.type = "text";
                    if (i === 0) {
                        label.htmlFor = "dateDebut";
                        label.innerHTML = "Du ";
                        input.className = "datepicker dateDebut inputContrainte";
                        input.id = "dateDebut";
                        $(div_input).append(label);
                        $(div_input).append(input);
                        initDP();
                        $(input).attr('data-value', contrainte.P1);
                    } else {
                        label.htmlFor = "dateFin";
                        label.innerHTML = "Au ";
                        input.className = "datepicker dateFin inputContrainte";
                        input.id = "dateFin"

                        initDP();

                        $(input).attr('data-value', contrainte.P2);
                    }

                    $(div_input).append(label);
                    $(div_input).append(input);
                    break;

                //cas 2 : deux int Volume horaire
                case 2:
                    type1 = 'int';
                    type2 = 'int';
                    input.type = "number";
                    if (i === 0) {
                        input.min = "0";
                        label.htmlFor = "minVolume";
                        label.innerHTML = "Min ";
                        input.id = "minVolume";
                        input.className = "inputContrainte int validate";
                        input.value = contrainte.P1;
                    } else {
                        var min = $("#minVolume").val()
                        var minLimit = typeof min != "undefined" ? min : 0;
                        input.min = minLimit;
                        label.htmlFor = "maxVolume";
                        label.innerHTML = "Max ";
                        input.id = "maxVolume"
                        input.className = "inputContrainte int validate";
                        input.value = contrainte.P2;
                    }
                    $(div_input).append(label);
                    $(div_input).append(input);
                    break;
                //cas 3 deux int Ecart début de la formation
                case 3:
                    type1 = 'int';
                    type2 = 'int';
                    input.type = "number";
                    if (i === 0) {
                        input.min = "0";
                        label.htmlFor = "minEcartDebut";
                        label.innerHTML = "Min ";
                        input.id = "minEcartDebut";
                        input.className = "inputContrainte int validate";
                        input.value = contrainte.P1;
                    } else {
                        var min = $("#minEcartDebut").val()
                        var minEcart = typeof min != "undefined" ? min : 0;
                        input.min = minEcart;
                        label.htmlFor = "maxEcartDebut";
                        label.innerHTML = "Max ";
                        input.id = "maxEcartDebut";
                        input.className = "inputContrainte int validate";
                        input.value = contrainte.P2;
                    }
                    $(div_input).append(label);
                    $(div_input).append(input);
                    break;
                //cas 4 deux int Ecart fin de la formation
                case 4:
                    type1 = 'int';
                    type2 = 'int';
                    input.type = "number";
                    if (i === 0) {
                        input.min = "0";
                        label.htmlFor = "minEcartFin";
                        label.innerHTML = "Min ";
                        input.id = "minEcartFin"
                        input.value = contrainte.P1;
                        input.className = "inputContrainte int validate";
                    } else {
                        var min = $("#minEcartFin").val()
                        var minEcart = typeof min != "undefined" ? min : 0;
                        input.min = minEcart;
                        label.htmlFor = "maxEcartFin";
                        label.innerHTML = "Max ";
                        input.id = "maxEcartFin";
                        input.className = "inputContrainte int validate";
                        input.value = contrainte.P2;
                    }
                    $(div_input).append(label);
                    $(div_input).append(input);
                    break;
                //cas 5 1 int Semaines en formation (max)
                case 5:
                    type1 = 'int';
                    input.type = "number";
                    input.min = "0";
                    input.id = "maxSemaines";
                    input.className = "inputContrainte int validate";
                    input.placeholder = "Nb. de semaines successives max. en formation";
                    input.value = contrainte.P1;
                    $(div_input).append(input);
                    break;
                //cas 6 1 string Non recouvrement stagiaire
                case 6:

                    var div = document.createElement('div');
                    div.style.width = 'auto';
                    type2 = 'int';
                    input.type = "text";
                    input.id = "rechercheStagiaire";
                    input.className = "inputContrainte autocomplete validate";
                    input.placeholder = "Nom du stagiaire";
                    input.autocomplete = "off";
                    input.value = contrainte.P1;
                    $(div_input).append(div);
                    $(div).append(input);
                    $.ajax({
                            type: "GET",
                            url: Routing.generate('all_Stagiaires', true),
                            success: function (response) {
                                var stagaireArray = response;
                                me.stagiaires = stagaireArray;
                                var dataStagiaire = {};
                                for (var i = 0; i < stagaireArray.length; i++) {
                                    dataStagiaire[stagaireArray[i].nom + ' ' + stagaireArray[i].prenom] = null;
                                }
                                $('input.autocomplete').autocomplete({
                                    data: dataStagiaire,
                                    limit: 5, // The max amount of results that can be shown at once. Default: Infinity.
                                });
                            }
                            ,
                            error: function () {
                                console.log('an error occured');
                                console.log(arguments);//get debugging!
                            }
                        }
                    )
                    ;
                    break;

                default:
                    break;
            }
        }
        $('input.int').on(' change keyup', function () {
            if (this.getAttribute('name') === 'val0') {
                var input1 = $(this).closest('tr').find('input[name=val1]')[0];
                if (input1 != undefined) {
                    input1.setAttribute('min', this.value);
                    if (input1.value != "" && this.value > input1.value && !$(this).hasClass('invalid')) {
                        //showToast('Le minimum ne peut pas être superieur au maximum', 'error');
                        $(this).attr('min', input1.value);
                        $(this).removeClass('valid');
                        $(this).addClass('invalid');
                    } else if (!$(this).hasClass('invalid')) {
                        $(this).removeClass('invalid');
                        $(this).addClass('valid');
                    }
                }
            }
            else if (this.getAttribute('name') === 'val1') {
                var input0 = $(this).closest('tr').find('input[name=val0]')[0];
                input0.setAttribute('max', this.value);
                if (input0.value != "" && this.value > input0.value && !$(this).hasClass('invalid')) {
                    //showToast('Le maximum ne peut pas être inferieur au minimum', 'error');3
                    $(this).attr('min', input0.value);
                    $(this).removeClass('valid');
                    $(this).addClass('invalid');
                } else if (!$(this).hasClass('invalid')) {
                    $(this).removeClass('invalid');
                    $(this).addClass('valid');
                }
            }
            refreshAllSelect();
        });

    }
};

function initDP() {
    initDatePicker('#dateDebut', onSetDateDebut);
    initDatePicker('#dateFin', onSetDateFin);

    var from_picker = getDateDebutPicker('#dateDebut');
    var to_picker = getDateFinPicker('#dateFin');
    if (from_picker != undefined) {
        if (from_picker.get('value')) {
            to_picker.set('min', from_picker.get('select'))
        }
        if (to_picker != undefined) {
            if (to_picker.get('value')) {
                from_picker.set('max', to_picker.get('select'))
            }
        }
    }

    $('select').material_select();
}

//region récupération des contraintes
function getContraintesCalendrier(calendrier) {
    return $.get(Routing.generate('calendrier_contraintes', {"codeCalendrier": calendrier}), function (data) {

    });
}


//region récupération des contraintes
function getAllTypeContraintes(url) {
    var result = null;
    $.ajax({
            type: "GET",
            url: url,
            async: false,
            success: function (response) {
                result = response;
            }
            ,
            error: function () {
                console.log('an error occured');
                console.log(arguments);//get debugging!
            }
        }
    );
    return result;
}

function refreshAllSelect() {
    $('select.typeContrainte').each(function () {
        for (i = 0; i < this.length; i++) {
            this.options[i].disabled = false;
        }
    });

    $('select.typeContrainte').each(function () {
        for (i = 0; i < this.length; i++) {
            if (this.selectedIndex === i) {
                var thisSelect = this;
                $('select.typeContrainte').each(function () {
                    if (this != thisSelect) {
                        for (j = 0; j < this.length; j++) {
                            if (j === i) {
                                this.options[i].disabled = true;
                                $(this.options[i]).attr('disabled', 'disabled');
                            }
                        }
                    }
                })
            }
        }
    });
    $('select').material_select();
}

function checkForFreeTC(typeContraintes) {
    for (i = 0; i < typeContraintes.length; i++) {
        {
            var is_set = false;
            $('select.typeContrainte').each(function () {
                if (this.selectedIndex === i) {
                    is_set = true;
                    return;
                }
            });
            if (is_set === false)
                return typeContraintes[i];
        }
    }
    return typeContraintes[0]
}