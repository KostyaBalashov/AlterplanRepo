/**
 * Created by void on 10/08/2017.
 * This file is part of Alterplan.
 *
 * Alterplan is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 *
 * Alterplan is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License along with Alterplan. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Regroupe les méthodes pour manipuler les groupes, sous groupes et les modules. Fait le suivit dans le Json.
 * @param formationJson La formation au format Json
 * @constructor
 */
function OrdreLogique(formationJson) {
    this.formation = new Formation(formationJson);

    /**
     * Invoque la suppression de l'élément de son conteneur
     * @param container le conteneur
     * @param element l'élément supprimé
     */
    this.handleRemove = function (container, element) {
        if(container instanceof GroupeModule){
            container.removeSousGroupe(element);
        }else if (container instanceof SousGroupe){
            container.removeModule(element);
        }
    };

    /**
     * Crée les modules disponibles
     */
    this.createModulesDisponibles = function () {
        var modulesJson = this.formation.getModulesDisponibles();
        var container = document.getElementsByClassName('droite')[0];
        $('.droite > module-disponible').each(function () {
            $(this).remove();
        });
        for (var i = 0, len = modulesJson.length; i < len; i++){
            var module = new Module();
            module.identifiant = modulesJson[i]['idModule'];
            module.libelle = modulesJson[i]['libelle'];
            container.appendChild(module);
        }
    };

    /**
     * Crée les groupes avec les sous groupes
     */
    this.createGroupesModules = function () {
        var groupesJson = this.formation.getGroupesModules();
        var container = document.getElementsByClassName('centre')[0];
        $('.centre > groupe-module').each(function () {
            $(this).remove();
        });

        for(grp in groupesJson){
            if (groupesJson.hasOwnProperty(grp)){
                var groupe = this.createGroupe();
                groupe.identifiant = groupesJson[grp].codeGroupe;

                var sousGroupes = this.createSousGroupes(groupesJson[grp].sousGroupes);
                for (var j = 0, jLen = sousGroupes.length; j < jLen; j++){
                    sousGroupes[j].groupeParent = groupe.identifiant;
                    groupe.getDraggableContainer().appendChild(sousGroupes[j]);
                }
                groupe.nbElements = groupe.getSousGroupes().length;
                container.appendChild(groupe);
            }
        }
    };

    /**
     * Crée les sous groupes à partir d'une liste de sous groupes Json
     * @param sousGroupesJson liste de sous groupes au format Json
     * @returns {Array} tableau de SousGroupe
     */
    this.createSousGroupes = function (sousGroupesJson) {
        var sousGroupes = [];
        for (ssGrp in sousGroupesJson){
            if (sousGroupesJson.hasOwnProperty(ssGrp)){
                var sousGroupe = this.createSousGroupe();
                sousGroupe.identifiant = sousGroupesJson[ssGrp].codeSousGroupe;

                var modulesJson = sousGroupesJson[ssGrp].modules;
                for (m in modulesJson){
                    if (modulesJson.hasOwnProperty(m)){
                        var module = new Module();
                        module.identifiant = modulesJson[m].idModule;
                        module.libelle = modulesJson[m].libelle;
                        sousGroupe.getDraggableContainer().appendChild(module);
                    }
                }
                sousGroupe.nbElements = sousGroupe.getModules().length;
                sousGroupes.push(sousGroupe);
            }
        }
        return sousGroupes;
    };

    /**
     * Crée un SousGroupe
     */
    this.createSousGroupe = function () {
        var ordre = this;
        var sousGroupe = new SousGroupe();

        sousGroupe.addEventListener('sousGroupeRemoved', function (e) {
            ordre.formation.removeSousGroupe(e.data['sousGroupe'], e.data['groupe']);
        }, false);
        sousGroupe.addEventListener('moduleAdded', function (e) {
            ordre.formation.addModuleToSousGroupe(e.data['sousGroupe'], e.data['module']);
        }, false);
        sousGroupe.addEventListener('moduleRemoved', function (e) {
            ordre.formation.removeModuleFromSousGroupe(e.data['sousGroupe'], e.data['module']);
        }, false);

        return sousGroupe;
    };

    /**
     * Crée un GroupeModule
     */
    this.createGroupe = function () {
        var ordre = this;
        var groupe = new GroupeModule();

        groupe.addEventListener('groupeRemoved', function (e) {
            ordre.formation.removeGroupe(e.data['groupe']);
        }, false);

        groupe.addEventListener('sousGroupeAdded', function (e) {
            ordre.formation.addSousGroupeToGroupe(e.data['groupe'], e.data['sousGroupe']);
        }, false);

        groupe.addEventListener('sousGroupeRemoved', function (e) {
            ordre.formation.removeSousGroupe(e.data['sousGroupe'], e.data['groupe']);
        }, false);

        return groupe;
    };

    this.isContainer = function (el) {
        //On définit les conteneurs
        return $(el).hasClass('draggable-container') || el instanceof DraggableContainer;
    };

    this.moves = function (el, source, handle, sibling) {
        //On définit les éléments qui peuvent être bouger en fonction du conteneur

        //Si la source est le conteneur de droite (modules disponibles)
        if (source.classList.contains('droite')) {
            //Seuls les modules bougent
            return el instanceof Module;

            //Si c'est le centre (conteneur de grupes)
        } else if (source.classList.contains('centre')) {
            //Seuls groupes bougent
            return el instanceof GroupeModule;

            //Si c'est un groupe (conteneur de sous groupes)
        } else if (source.parentElement instanceof GroupeModule) {
            //Seuls les sous groupes bougent
            return el instanceof SousGroupe;

            //Si c'est un Sous Groupe (conteneur de modules)
        } else if (source.parentElement instanceof SousGroupe) {
            //Seuls les modules bougent
            return el instanceof Module;
        }
    };

    this.accepts = function (el, target, source, sibling) {
        //On définit quels composants acceptent les conteneurs
        var jTarget = $(target);
        var jSibling = $(sibling);
        var ok = true;

        //Petit patche pour ne pas accepter des éléments au dessus des titres
        if(jSibling){
            ok = !jSibling.hasClass('card-title');
        }

        //Le conteneur de droite
        if(jTarget.hasClass('droite')){
            //Accepte les modules
            ok = ok && el instanceof Module;

            //Le conteneur de centre
        }else if (jTarget.hasClass('centre')) {
            //Accepter les Groupes et les Modules
            ok = ok && (el instanceof GroupeModule || el instanceof Module);

            //Le conteneur Groupe
        } else if (target.parentElement instanceof GroupeModule) {
            //Accepte les Sous Groupes et les Modules seulement si il a moins de deux éléments
            ok = ok && ((el instanceof SousGroupe || el instanceof Module)
                && (target.parentElement.nbElements < 2));

            //Le conteneur Sous Groupe
        } else if (target.parentElement instanceof SousGroupe){
            //Accepte les Modules s'il a moins de 4 éléments
            ok = ok && (el instanceof Module && (target.parentElement.nbElements < 4));
        }

        return ok;
    };

    var me = this;
    this.onDrop = function (el, target, source, sibling) {
        //Si c'est un Module
        if(el instanceof Module) {
            //Droppé depuis la droite
            if (source.classList.contains('droite')){
                //On supprime le module disponible depuis Json
                me.formation.removeModuleDisponible(el);
            }

            //Droppé au centre
            if (target.classList.contains('centre')){
                var idGroupe = -1;
                var groupes = target.getElementsByTagName('groupe-module');
                //Génération de l'id du groupe
                for (var i = 0, len = groupes.length; i < len; i++){
                    var id = parseInt(groupes[i].identifiant);
                    if (id > idGroupe){
                        idGroupe = id;
                    }
                }

                var sousGroupe = me.createSousGroupe();
                var groupe = me.createGroupe();
                groupe.identifiant = ++idGroupe;

                //Ajout du groupe dans le Json
                me.formation.addGroupe(groupe);
                groupe.addSousGroupe(sousGroupe);
                sousGroupe.addModule(el);

                if(sibling){
                    target.insertBefore(groupe, sibling);
                }else {
                    target.appendChild(groupe);
                }

                //Droppé dans un Groupe
            }else if(target.parentElement instanceof GroupeModule){
                var sousGroupe = me.createSousGroupe();
                target.parentElement.addSousGroupe(sousGroupe);
                sousGroupe.addModule(el);

                if (sibling){
                    target.insertBefore(sousGroupe, sibling);
                }else {
                    target.appendChild(sousGroupe);
                }

                //Droppé dans un Sous Groupe
            }else if(target.parentElement instanceof SousGroupe){
                target.parentElement.addModule(el);
                if (sibling){
                    target.insertBefore(el, sibling);
                }else {
                    target.appendChild(el);
                }
                //Droppé à droite
            } else if (target.classList.contains('droite')){
                if (!source.classList.contains('droite')){
                    //Ajout du module disponible dans le Json
                    me.formation.addModuleDisponible(el);
                }
            }

            //Si c'est un Sous Groupe
        }else if (el instanceof SousGroupe){
            //On l'ajoute au groupe (seul un Groupe accepte des Sous groupes cf. méthode accepts dessus)
            target.parentElement.addSousGroupe(el);
        }

        //On fait la suppression nécessaire au niveau du Json
        me.handleRemove(source.parentElement, el);
    };
}
