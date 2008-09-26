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
 * Language: Deutsch
 */

/**
 *	This file contains the text-entries for the java-menu
 *	Only module names come from file: we_defines.inc.php
 *	And the doctypes are always the same, come from table
 */

##################################
######### Menu Datei #############
##################################

$l_javaMenu["file"] = "Datei";
$l_javaMenu["new"] = "Neu";


	##################################
	###### SubMenu Datei/Neu #########
	##################################

	$l_javaMenu["webEdition_page"] = "webEdition-Seite";
	$l_javaMenu["empty_page"] = "Leere Seite";

	$l_javaMenu["image"] = "Grafik";
	$l_javaMenu["other"] = "Sonstige";

		##################################
		### SubMenu Datei/Neu/Sonstige ###
		##################################

		$l_javaMenu["html_page"] = "HTML-Datei";
		$l_javaMenu["flash_movie"] = "Flash-Datei";
		$l_javaMenu["quicktime_movie"] = "Quicktime-Datei";
		$l_javaMenu["text_plain"] = "Text-Datei";
		$l_javaMenu["text_xml"] = "XML-Datei";
		$l_javaMenu["javascript"] = "Javascript-Datei";
		$l_javaMenu["css_stylesheet"] = "CSS-Datei";
		$l_javaMenu["other_files"] = "Sonstige Datei";


		#####################################################
		########## End SubMenu Datei/Neu/Sonstige ###########
		#####################################################

	$l_javaMenu["template"] = "Vorlage";

		##################################
		## SubMenu Datei/Neu/Verzeichnis #
		##################################

		$l_javaMenu["document_directory"] = "Dokumenten Verzeichnis";
		$l_javaMenu["template_directory"] = "Vorlagen Verzeichnis";

		#################################################
		######## End Submenu Datei/Neu/Verzeichnis  #####
		#################################################

	$l_javaMenu["directory"] = "Verzeichnis";
	$l_javaMenu["wizards"] = "Wizards";

		##################################
		## SubMenu Datei/Neu/Wizards #####
		##################################

		$l_javaMenu["first_steps_wizard"] = "First Steps Wizard";

		##################################
		## End SubMenu Datei/Neu/Wizards #
		##################################


	############################################
	######## End Submenu Datei/Neu  ############
	############################################

	$l_javaMenu["open"] = "Öffnen";


	##################################
	###### End SubMenu Datei/Open ####
	##################################
	$l_javaMenu["open_document"] = "Dokument";
	$l_javaMenu["open_template"] = "Vorlage";

	## close documents
$l_javaMenu["close_single_document"] = "Schließe Dokument";
$l_javaMenu["close_all_documents"] = "Schließe alle Dokumente";
$l_javaMenu["close_all_but_active_document"] = "Schließe inaktive Dokumente";
$l_javaMenu["delete_active_document"] = "Lösche aktuelles Dokument";



	##################################
	###### SubMenu Datei/Open ########
	##################################

$l_javaMenu["save"] = "Speichern";
$l_javaMenu["publish"] = "Veröffentlichen";
$l_javaMenu["delete"] = "Löschen";

	##################################
	##### SubMenu Datei/Löschen ######
	##################################

	$l_javaMenu["documents"] = "Dokumente";
	$l_javaMenu["templates"] = "Vorlagen";
	$l_javaMenu["cache"] = "Cache";

	##################################
	######## End Submenu  ############
	##################################

$l_javaMenu["move"] = "Verschieben";

	#########################################
	#####	   Import/export	    	#####
    #########################################

    $l_javaMenu["import_export"] = "Import/Export";

    $l_javaMenu["import"]        = "Import";
    $l_javaMenu["export"]        = "Export";

    #########################################
	#####	End Import/export	        #####
    #########################################

$l_javaMenu["backup"] = "Backup";

	##################################
	### SubMenu Datei/Backup ####
	##################################

	$l_javaMenu["make_backup"] = "Backup erstellen";
	$l_javaMenu["recover_backup"] = "Backup wiederherstellen";

	##################################
	### SubMenu Datei/Backup ####
	##################################

$l_javaMenu["rebuild"] = "Rebuild";
$l_javaMenu["clear_cache"] = "Cache leeren";

$l_javaMenu["browse_server"] = "Server durchsuchen";
$l_javaMenu["quit"] = "Beenden";

		##################################
		### SubMenu Cockpit           ####
		##################################

		$l_javaMenu["display"] = "Anzeigen";
		$l_javaMenu["new_widget"] = "Widget hinzufügen";

			###############################################
			### SubMenu Cockpit/Neues Widget           ####
			###############################################

			$l_javaMenu["shortcuts"] = "Shortcuts";
			$l_javaMenu["rss_reader"] = "RSS Reader";
			$l_javaMenu["last_modified"] = "zuletzt bearbeitet";
			$l_javaMenu["todo_messaging"] = "ToDo/Messaging";
			$l_javaMenu["users_online"] = "Benutzer Online";
			$l_javaMenu["unpublished"] = "unveröffentlicht";
			$l_javaMenu["my_documents"] = "Meine Dokumente";
			$l_javaMenu["notepad"] = "Notizfunktion";
			$l_javaMenu["pagelogger"] = "pageLogger";

			###############################################
			### SubMenu Cockpit/Standard Einstellungen ####
			###############################################

		$l_javaMenu["default_settings"] = "Standard-Einstellungen wiederherstellen";

		##################################
		### End SubMenu Cockpit       ####
		##################################

########################################
######### End / Menu Datei #############
########################################


##################################
###### Menu Bearbeiten ###########
##################################

$l_javaMenu["edit"] = "Optionen";
$l_javaMenu["document_types"] = "Dokument-Typen";
$l_javaMenu["categories"] = "Kategorien";
$l_javaMenu["thumbnails"] = "Miniaturansichten";
$l_javaMenu["metadata"] = "Metadatenfelder";
$l_javaMenu["navigation"] = "Navigation";
$l_javaMenu["change_username"] = "Benutzername ändern";
$l_javaMenu["change_password"] = "Kennwort ändern";
$l_javaMenu["versioning"] = "Versions-Wizard";
$l_javaMenu["versioning_log"] = "Versions-Log";

$l_javaMenu["formmail_recipients"] = "Formmail-Empfänger";
$l_javaMenu["proxy_server"] = "Proxy-Server";
$l_javaMenu["unpublished_pages"] = "Unveröffentlichte Dokumente";
$l_javaMenu["preferences"] = "Einstellungen";


##################################
###### End Menu Bearbeiten #######
##################################


##############################
###### Menu Module ###########
##############################

$l_javaMenu["modules"] = "Module";
$l_javaMenu["module_installation"] = "Modulinstallation";
//	The content is generated dynamically

$l_javaMenu["extras"] = "Extras";
$l_javaMenu["inactive_extras"] = "Inaktive Extras";


##################################
###### End Menu Module ###########
##################################

##################################
######### Menu Hilfe #############
##################################

$l_javaMenu["help"] = "Hilfe";
$l_javaMenu["onlinehelp"] = "Online-Hilfe";
$l_javaMenu["webEdition_online"] = "webEdition im Internet";
$l_javaMenu["sidebar"] = "Sidebar";
$l_javaMenu["update"] = "Update";
$l_javaMenu["upgrade"] = "Update webEdition 5";
$l_javaMenu["register"] = "Registrieren";
$l_javaMenu["info"] = "Info";

########################################################
######### Navigation back - forward - home #############
########################################################


$l_javaMenu["close"]   = "Beenden";
$l_javaMenu["home"]   = "Startseite";
$l_javaMenu["back"]   = "Zurück";
$l_javaMenu["next"]   = "Vor";
$l_javaMenu["reload"] = "Neu laden";

$l_javaMenu["not_installed_modules"] = "Nicht installierte Module";

$l_javaMenu["search"] = "Suche";

$l_javaMenu["common"] = "Allgemein";
$l_javaMenu["sysinfo"] = "Systeminformationen";

?>