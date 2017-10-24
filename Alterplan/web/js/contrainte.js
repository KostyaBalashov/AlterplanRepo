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
    var me = this;
    //endregion

    /*
     //region Gestion Ajout/suppression des contraintes
     var add = function (contrainte) {
     if (!(contrainte.codeContrainte in me.addedContraintes)) {
     me.addedContraintes[contrainte.codeContrainte] = contrainte;
     }
     if (contrainte.codeContrainte in me.removedContraintes) {
     delete me.removedContraintes[contrainte.codeContrainte];
     }
     };

     var remove = function (contrainte) {
     if (!(contrainte.codeContrainte in me.removedContraintes)) {
     me.removedContraintes[contrainte.codeContrainte] = contrainte;
     }
     if (contrainte.codeContrainte in me.addedContraintes) {
     delete me.addedContraintes[contrainte.codeContrainte];
     }
     };
     //endregion
     */
    console.log(urlAllTC);
    this.onModaleOpen = function () {
        console.log(urlAllTC)
        console.log('OnModaleOpen')
        var contraintes = me.calendrier.contraintes;
        var typeContraintes = getAllContraintes(urlAllTC);
        var tBody = $('#tableauContraintes');
        for (var key in contraintes) {
            var contrainte = contraintes[key];
            console.log("on est passés!")

            //region Gestion TR
            var tr = $(document.createElement('tr'));
            tr.attr('id', contrainte.codeContrainte);
            tr.data('contrainte', contrainte);
            //endregion

            //region déclaration des TD
            var tdTypeContrainte = createTd();
            var tdValues = createTd();
            var tdDelete = createTd();
            //endregion


            //region Gestion de tdTypeContrainte
            tdTypeContrainte.id = 'tdContraintes'
            var selectList = document.createElement("select");
            selectList.id = "typeContrainte";
            selectList.class = "select";
            console.log('test');
            //Récuperation de tous les typeContraintes
            if (typeContraintes != null) {
                for (var k in typeContraintes) {
                    var typeContrainte = typeContraintes[k];
                    console.log(typeContrainte.libelle)
                    var option = document.createElement("option");
                    option.value = typeContrainte.codeTypeContrainte;
                    option.setAttribute('data-nb-input', typeContrainte.nbParametres);
                    option.innerHTML = typeContrainte.libelle;
                    selectList.append(option);
                    if (contrainte) {
                        if (typeContrainte.codeTypeContrainte === contrainte.typeContrainte.codeTypeContrainte) {
                            option.setAttribute('selected', 'true');
                        }
                    }
                }
            }

            tdTypeContrainte.append(selectList);
            $("#typeContrainte").change(changeSelect($("#typeContrainte")));
            selectList.setAttribute("onchange", function () {
                changeSelect(this)
            });

            //endregion
            function changeSelect(e) {
                //region Gestion de tdValues
                //création de la div qui va contenir les X divs contenant un input
                tdValues.empty();
                var div_container = document.createElement("div");
                div_container.setAttribute("id", "divContainer");
                div_container.setAttribute("class", "divContainer valign-wrapper");
                var number = contrainte.typeContrainte.nbParametres;

                for (var i = 0; i < number; i++) {

                    var div_input = document.createElement("div");
                    div_input.setAttribute("class", "col s6 valign-wrapper")
                    div_input.setAttribute("id", "divInput" + i)
                    var type1;
                    var type2;
                    var input = document.createElement("input");
                    input.name = "val" + i;
                    input.required = "true";
                    var label = document.createElement("Label");

                    switch (contrainte.typeContrainte.codeTypeContrainte) {
                        case '1':
                            type1 = 'Date';
                            type2 = 'Date';

                            input.type = "text";
                            if (i === 0) {
                                label.htmlFor = "dateDebut";
                                label.innerHTML = "Du ";
                                input.className = "datepicker dateDebut inputContrainte";
                                input.id = "dateDebut"
                            } else {
                                label.htmlFor = "dateFin";
                                label.innerHTML = "Au ";
                                input.className = "datepicker dateFin inputContrainte";
                                input.id = "dateFin"
                            }
                            div_input.append(label);
                            div_input.append(input);
                            break;
                        case '2':
                            type1 = 'int';
                            type2 = 'int';
                            input.type = "number";
                            if (i === 0) {
                                input.min = "0";
                                label.htmlFor = "minVolume";
                                label.innerHTML = "Min ";
                                input.id = "minVolume";
                                input.className = "inputContrainte";
                            } else {
                                var min = $("#minVolume").val()
                                var minLimit = typeof min != "undefined" ? min : 0;
                                input.min = minLimit;
                                label.htmlFor = "maxVolume";
                                label.innerHTML = "Max ";
                                input.id = "maxVolume"
                                input.className = "inputContrainte";
                            }
                            div_input.append(label);
                            div_input.append(input);
                            break;
                        case '3':
                            type1 = 'int';
                            type2 = 'int';
                            input.type = "number";
                            if (i === 0) {
                                input.min = "0";
                                label.htmlFor = "minEcartDebut";
                                label.innerHTML = "Min ";
                                input.id = "minEcartDebut";
                                input.className = "inputContrainte";
                            } else {
                                var min = $("#minEcartDebut").val()
                                var minEcart = typeof min != "undefined" ? min : 0;
                                input.min = minEcart;
                                label.htmlFor = "maxEcartDebut";
                                label.innerHTML = "Max ";
                                input.id = "maxEcartDebut";
                                input.className = "inputContrainte";
                            }
                            div_input.append(label);
                            div_input.append(input);
                            break;
                        case '4':
                            type1 = 'int';
                            type2 = 'int';
                            input.type = "number";
                            if (i === 0) {
                                input.min = "0";
                                label.htmlFor = "minEcartFin";
                                label.innerHTML = "Min ";
                                input.id = "minEcartFin"
                            } else {
                                var min = $("#minEcartFin").val()
                                var minEcart = typeof min != "undefined" ? min : 0;
                                input.min = minEcart;
                                label.htmlFor = "maxEcartFin";
                                label.innerHTML = "Max ";
                                input.id = "maxEcartFin";
                                input.className = "inputContrainte";
                            }
                            div_input.append(label);
                            div_input.append(input);
                            break;
                        case '5':
                            type1 = 'int';
                            input.type = "number";
                            input.min = "0";
                            input.id = "maxSemaines";
                            input.className = "inputContrainte";
                            div_container.append(input);
                            break;
                        case '6':
                            type2 = 'int';
                            div_container.setAttribute("class", "divContainer");
                            input.type = "text";
                            input.id = "rechercheStagiaire";
                            input.className = "inputContrainte autocomplete";
                            input.placeholder = "Nom du stagiaire";
                            input.autocomplete = "off";
                            div_container.append(input);
                            $.ajax({
                                type: "GET",
                                url: '{{ path("all_Stagiaires") }}',
                                success: function (response) {
                                    var countryArray = response;
                                    var dataCountry = {};
                                    for (var i = 0; i < countryArray.length; i++) {
                                        dataCountry[countryArray[i].nom + ' ' + countryArray[i].prenom] = null; //countryArray[i].flag or null
                                    }
                                    $('input.autocomplete').autocomplete({
                                        data: dataCountry,
                                        limit: 5, // The max amount of results that can be shown at once. Default: Infinity.
                                    });
                                },
                                error: function () {
                                    console.log('an error occured');
                                    console.log(arguments);//get debugging!
                                }
                            });


                            break;

                    }
                    div_container.append(div_input);
                }

                tdValues.append(div_container);
                if (contrainte.typeContrainte.codeTypeContrainte === '1') {
                    initDatePicker('#dateDebut', onSetDateDebut);
                    initDatePicker('#dateFin', onSetDateFin);

                    var from_picker = getDateDebutPicker();
                    var to_picker = getDateFinPicker();

                    if (from_picker.get('value')) {
                        to_picker.set('min', from_picker.get('select'))
                    }
                    if (to_picker.get('value')) {
                        from_picker.set('max', to_picker.get('select'))
                    }
                }
            }

            //endregions

            //region tdDelete
            var deleteButton = document.createElement('a');
            deleteButton.className = "deleteRow btn-floating waves-effect waves-light red right-align";
            deleteButton.innerHTML = '<i class="material-icons">remove</i>';
            deleteButton.onclick = function () {
                $(deleteButton.target).closest('tr').remove();
                contraintes.remove(contraintes.indexOf(key));
            }
            tdDelete.append(deleteButton);
            //endregion


            tr.append(tdTypeContrainte, tdValues, tdDelete);

            tBody.append(tr);
        }

        $('select:not([multiple])').material_select();


        var addButton = document.createElement('a');
        addButton.id = "addBtn"
        addButton.className = "add_another btn-floating btn-large waves-effect waves-light green right-align"
        addButton.innerHTML = '<i id="addBtn" class="material-icons">add</i>'

        $('.add_another').click(function () {
            console.log('test');
            //TODO AJOUTER A CONTRAINTES
            $("#tableauContraintes").append('<tr><td id="tdContraintes"><select id="typeContrainte" onchange="changeSelect(this)"><option value="" disabled selected>Type de contrainte</option>{% for typecontrainte in typeContraintes %}<option value="{{ typecontrainte.codeTypeContrainte }}" data-nb-input="{{ typecontrainte.nbParametres }}">{{ typecontrainte.libelle }}</option>{% endfor %}</select></td> <td></td><td id="tdDelete">  <a onClick="deleteRow(this)" class="deleteRow btn-floating waves-effect waves-light red right-align"><i class="material-icons">remove</i></a></td> </tr>');

        });
        $('.deleteRow').click(function () {
            //TODO supprimer de l'objet calendrier
            $(this).closest('tr').remove();
            var codeContrainte
            $(this).closest(('select'))
        });


        function getAllContraintes(url) {
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
    }
}