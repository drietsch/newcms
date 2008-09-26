<?php

/**
 * webEdition CMS
 *
 * This source is part of webEdition CMS. webEdition CMS is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package    webEdition_language
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */


/**
 * Language file: javaMenu.inc.php
 * Provides language strings.
 * Language: English
 */

/**
 *	This file contains the text-entries for the java-menu
 *	Only module names come from file: we_defines.inc.php
 *	And the doctypes are always the same, come from table
 */

##################################
######### Menu Datei #############
##################################

$l_javaMenu["file"] = "Fichier";
$l_javaMenu["new"] = "Nouveau";


	##################################
	###### SubMenu Datei/Neu #########
	##################################

	$l_javaMenu["webEdition_page"] = "Site webEdition";
	$l_javaMenu["empty_page"] = "Site vide";

	$l_javaMenu["image"] = "Graphique";
	$l_javaMenu["other"] = "Autres";

		##################################
		### SubMenu Datei/Neu/Sonstige ###
		##################################

		$l_javaMenu["html_page"] = "Site HTML";
		$l_javaMenu["flash_movie"] = "Vidéo Flash";
		$l_javaMenu["quicktime_movie"] = "Film de Quicktime";
		$l_javaMenu["text_plain"] = "Document de Texte";
		$l_javaMenu["text_xml"] = "XML Document"; // TRANSLATE
		$l_javaMenu["javascript"] = "Javascript"; // TRANSLATE
		$l_javaMenu["css_stylesheet"] = "CSS Stylesheet"; // TRANSLATE
		$l_javaMenu["other_files"] = "Autres Fichiers";


		#####################################################
		########## End SubMenu Datei/Neu/Sonstige ###########
		#####################################################

	$l_javaMenu["template"] = "Modèle";

		##################################
		## SubMenu Datei/Neu/Verzeichnis #
		##################################

		$l_javaMenu["document_directory"] = "Répertoire de documents";
		$l_javaMenu["template_directory"] = "Répertoire de modèles";

		#################################################
		######## End Submenu Datei/Neu/Verzeichnis  #####
		#################################################

	$l_javaMenu["directory"] = "Répertoire";
	$l_javaMenu["wizards"] = "Wizards"; // TRANSLATE

		##################################
		## SubMenu Datei/Neu/Wizards #####
		##################################

		$l_javaMenu["first_steps_wizard"] = "First Steps Wizard"; // TRANSLATE


	############################################
	######## End Submenu Datei/Neu  ############
	############################################

	$l_javaMenu["open"] = "Ouvrir";


	##################################
	###### SubMenu Datei/Open ########
	##################################
	$l_javaMenu["open_document"] = "Document"; // TRANSLATE
	$l_javaMenu["open_template"] = "Modèle";

	##################################
	###### End SubMenu Datei/Open ####
	##################################

	// close
$l_javaMenu["close_single_document"] = "Close Document"; // TRANSLATE
$l_javaMenu["close_all_documents"] = "Close all Documents"; // TRANSLATE
$l_javaMenu["close_all_but_active_document"] = "Close inactive documents"; // TRANSLATE
$l_javaMenu["delete_active_document"] = "Delete active document"; // TRANSLATE



$l_javaMenu["save"] = "Enregistrer";
$l_javaMenu["publish"] = "Publish"; // TRANSLATE
$l_javaMenu["delete"] = "Supprimer";

	##################################
	##### SubMenu Datei/Löschen ######
	##################################

	$l_javaMenu["documents"] = "Document";
	$l_javaMenu["templates"] = "Modèle";
	$l_javaMenu["cache"] = "Cache"; // TRANSLATE

	##################################
	######## End Submenu  ############
	##################################

$l_javaMenu["move"] = "Move"; // TRANSLATE

	#########################################
	#####   	 Import/export		    #####
    #########################################

    $l_javaMenu["import_export"] = "Import/Export"; // TRANSLATE

    $l_javaMenu["import"]        = "Import"; // TRANSLATE
    $l_javaMenu["export"]        = "Export"; // TRANSLATE

    #########################################
	#####	    End Import/export	    #####
    #########################################

$l_javaMenu["backup"] = "Sauvegardes";

	##################################
	### SubMenu Datei/Backup ####
	##################################

	$l_javaMenu["make_backup"] = "Créer une Sauvegarde";
	$l_javaMenu["recover_backup"] = "Restaurer une sauvegarde";

	##################################
	### SubMenu Datei/Backup ####
	##################################

$l_javaMenu["rebuild"] = "Rebuild"; // TRANSLATE
$l_javaMenu["clear_cache"] = "Clear cache"; // TRANSLATE

$l_javaMenu["browse_server"] = "Fouiller le server";
$l_javaMenu["quit"] = "Quitter";

		##################################
		### SubMenu Cockpit           ####
		##################################

		$l_javaMenu["display"] = "Display"; // TRANSLATE
		$l_javaMenu["new_widget"] = "Add Widget"; // TRANSLATE

			###############################################
			### SubMenu Cockpit/New Widget             ####
			###############################################

			$l_javaMenu["shortcuts"] = "Shortcuts"; // TRANSLATE
			$l_javaMenu["rss_reader"] = "RSS Reader"; // TRANSLATE
			$l_javaMenu["last_modified"] = "last modified";
			$l_javaMenu["todo_messaging"] = "ToDo/Messaging"; // TRANSLATE
			$l_javaMenu["users_online"] = "Users Online"; // TRANSLATE
			$l_javaMenu["unpublished"] = "unpublished";
			$l_javaMenu["my_documents"] = "My documents"; // TRANSLATE
			$l_javaMenu["notepad"] = "Notepad"; // TRANSLATE
			$l_javaMenu["pagelogger"] = "pageLogger"; // TRANSLATE

			###############################################
			### SubMenu Cockpit/Standard Einstellungen ####
			###############################################

		$l_javaMenu["default_settings"] = "Reset default settings"; // TRANSLATE

		##################################
		### End SubMenu Cockpit       ####
		##################################

########################################
######### End / Menu Datei #############
########################################


##################################
###### Menu Bearbeiten ###########
##################################

$l_javaMenu["edit"] = "Options"; // TRANSLATE
$l_javaMenu["document_types"] = "Types de documents";
$l_javaMenu["categories"] = "Catégories";
$l_javaMenu["thumbnails"] = "Imagettes";
$l_javaMenu["metadata"] = "Metadata fields"; // TRANSLATE
$l_javaMenu["navigation"] = "Navigation"; // TRANSLATE
$l_javaMenu["change_username"] = "Changer l'identifiant ";
$l_javaMenu["change_password"] = "Changer le mot de passe";

$l_javaMenu["formmail_recipients"] = "Destinataire de Formmail";
$l_javaMenu["proxy_server"] = "Serveur proxy";
$l_javaMenu["unpublished_pages"] = "Sites non publiés";
$l_javaMenu["preferences"] = "Préférences";
$l_javaMenu["versioning"] = "Version-Wizard"; // TRANSLATE
$l_javaMenu["versioning_log"] = "Version-Log"; // TRANSLATE


##################################
###### End Menu Bearbeiten #######
##################################


##############################
###### Menu Module ###########
##############################

$l_javaMenu["modules"] = "Modules"; // TRANSLATE
$l_javaMenu["module_installation"] = "Installation de module";

//	The content is generated dynamically
$l_javaMenu["extras"] = "Extras"; // TRANSLATE
$l_javaMenu["inactive_extras"] = "Inactive Extras"; // TRANSLATE


#################################
###### End Menu Module ###########
##################################

##################################
######### Menu Hilfe #############
##################################

$l_javaMenu["help"] = "Aide";
$l_javaMenu["onlinehelp"] = "Aide en ligne";
$l_javaMenu["webEdition_online"] = "webEdition online"; // TRANSLATE
$l_javaMenu["sidebar"] = "Sidebar"; // TRANSLATE
$l_javaMenu["update"] = "Mise à jour";
$l_javaMenu["upgrade"] = "Update webEdition 5"; // TRANSLATE
$l_javaMenu["register"] = "Enrégistrer";
$l_javaMenu["info"] = "À propos";

########################################################
######### Navigation back - forward - home #############
########################################################

$l_javaMenu["close"]   = "Close"; // TRANSLATE
$l_javaMenu["home"]   = "Page d'accueil";
$l_javaMenu["back"]   = "Reculer";
$l_javaMenu["next"]   = "Avancer";
$l_javaMenu["reload"] = "Actualiser";

$l_javaMenu["not_installed_modules"] = "Modules non installés";

$l_javaMenu["search"] = "Search"; // TRANSLATE

$l_javaMenu["common"] = "Common"; // TRANSLATE
$l_javaMenu["sysinfo"] = "System information"; // TRANSLATE

?>