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

$l_javaMenu["file"] = "Tiedosto";
$l_javaMenu["new"] = "Uusi";


	##################################
	###### SubMenu Datei/Neu #########
	##################################

	$l_javaMenu["webEdition_page"] = "webEdition sivu";
	$l_javaMenu["empty_page"] = "Tyhjä sivu";

	$l_javaMenu["image"] = "Kuva";
	$l_javaMenu["other"] = "Muu tiedosto";

		##################################
		### SubMenu Datei/Neu/Sonstige ###
		##################################

		$l_javaMenu["html_page"] = "HTML Sivu";
		$l_javaMenu["flash_movie"] = "Flash Tiedosto";
		$l_javaMenu["quicktime_movie"] = "Quicktime Tiedosto";
		$l_javaMenu["text_plain"] = "Tekstitiedosto";
		$l_javaMenu["text_xml"] = "XML Dokumentti";
		$l_javaMenu["javascript"] = "Javascript -tiedosto";
		$l_javaMenu["css_stylesheet"] = "CSS tyylitiedosto";
		$l_javaMenu["other_files"] = "Muut tiedostot";


		#####################################################
		########## End SubMenu Datei/Neu/Sonstige ###########
		#####################################################

	$l_javaMenu["template"] = "Sivupohja";

		##################################
		## SubMenu Datei/Neu/Verzeichnis #
		##################################

		$l_javaMenu["document_directory"] = "Dokumenttihakemisto";
		$l_javaMenu["template_directory"] = "Sivupohjahakemisto";

		#################################################
		######## End Submenu Datei/Neu/Verzeichnis  #####
		#################################################

	$l_javaMenu["directory"] = "Hakemisto";
	$l_javaMenu["wizards"] = "Velhot";

		##################################
		## SubMenu Datei/Neu/Wizards #####
		##################################

		$l_javaMenu["first_steps_wizard"] = "Aloitusvelho";


	############################################
	######## End Submenu Datei/Neu  ############
	############################################

	$l_javaMenu["open"] = "Avaa";


	##################################
	###### SubMenu Datei/Open ########
	##################################
	$l_javaMenu["open_document"] = "Dokumentti";
	$l_javaMenu["open_template"] = "Sivupohja";

	##################################
	###### End SubMenu Datei/Open ####
	##################################

	// close
$l_javaMenu["close_single_document"] = "Sulje dokumentti";
$l_javaMenu["close_all_documents"] = "Sulje kaikki dokumentit";
$l_javaMenu["close_all_but_active_document"] = "Close inactive documents"; // TRANSLATE
$l_javaMenu["delete_active_document"] = "Delete active document"; // TRANSLATE



$l_javaMenu["save"] = "Tallenna";
$l_javaMenu["publish"] = "Julkaise";
$l_javaMenu["delete"] = "Poista";

	##################################
	##### SubMenu Datei/Löschen ######
	##################################

	$l_javaMenu["documents"] = "Dokumentteja";
	$l_javaMenu["templates"] = "Sivupohjia";
	$l_javaMenu["cache"] = "Välimuisti";

	##################################
	######## End Submenu  ############
	##################################

$l_javaMenu["move"] = "Siirrä";

	#########################################
	#####   	 Import/export		    #####
    #########################################

    $l_javaMenu["import_export"] = "Tuo/Vie";

    $l_javaMenu["import"]        = "Tuo";
    $l_javaMenu["export"]        = "Vie";

    #########################################
	#####	    End Import/export	    #####
    #########################################

$l_javaMenu["backup"] = "Varmuuskopioi";

	##################################
	### SubMenu Datei/Backup ####
	##################################

	$l_javaMenu["make_backup"] = "Luo varmuuskopio";
	$l_javaMenu["recover_backup"] = "Palauta varmuuskopiosta";

	##################################
	### SubMenu Datei/Backup ####
	##################################

$l_javaMenu["rebuild"] = "Rakenna uudelleen";
$l_javaMenu["clear_cache"] = "Tyhjennä välimuisti";

$l_javaMenu["browse_server"] = "Selaa palvelinta";
$l_javaMenu["quit"] = "Poistu";

		##################################
		### SubMenu Cockpit           ####
		##################################

		$l_javaMenu["display"] = "Näytä";
		$l_javaMenu["new_widget"] = "Uusi vimpain";

			###############################################
			### SubMenu Cockpit/New Widget             ####
			###############################################

			$l_javaMenu["shortcuts"] = "Oikopolut";
			$l_javaMenu["rss_reader"] = "RSS lukija";
			$l_javaMenu["last_modified"] = "viimeksi muokattu";
			$l_javaMenu["todo_messaging"] = "Tehtävät/Viestintä";
			$l_javaMenu["users_online"] = "Käyttäjiä järjestelmässä";
			$l_javaMenu["unpublished"] = "julkaisematon";
			$l_javaMenu["my_documents"] = "Omat dokumentit";
			$l_javaMenu["notepad"] = "Muistio";
			$l_javaMenu["pagelogger"] = "pageLogger"; // TRANSLATE

			###############################################
			### SubMenu Cockpit/Standard Einstellungen ####
			###############################################

		$l_javaMenu["default_settings"] = "Palauta vakioasetukset";

		##################################
		### End SubMenu Cockpit       ####
		##################################

########################################
######### End / Menu Datei #############
########################################


##################################
###### Menu Bearbeiten ###########
##################################

$l_javaMenu["edit"] = "Muokkaa";
$l_javaMenu["document_types"] = "Dokumenttityypit";
$l_javaMenu["categories"] = "Kategoriat";
$l_javaMenu["thumbnails"] = "Esikatselukuvat";
$l_javaMenu["metadata"] = "Metadata fields"; // TRANSLATE
$l_javaMenu["navigation"] = "Navigaatio";
$l_javaMenu["change_username"] = "Vaihda käyttäjänimeä";
$l_javaMenu["change_password"] = "Vaihda salasanaa";

$l_javaMenu["formmail_recipients"] = "Formmail vastaanottajat";
$l_javaMenu["proxy_server"] = "Proxy-palvelin";
$l_javaMenu["unpublished_pages"] = "Julkaisemattomat sivut";
$l_javaMenu["preferences"] = "Asetukset";
$l_javaMenu["versioning"] = "Version-Wizard"; // TRANSLATE
$l_javaMenu["versioning_log"] = "Version-Log"; // TRANSLATE
$l_javaMenu["econda"] = "Econda"; // TRANSLATE

##################################
###### End Menu Bearbeiten #######
##################################


##############################
###### Menu Module ###########
##############################

$l_javaMenu["modules"] = "Moduulit";
$l_javaMenu["module_installation"] = "Moduulien asennus";

//	The content is generated dynamically
$l_javaMenu["extras"] = "Extrat";
$l_javaMenu["inactive_extras"] = "Toimettomat extrat";


#################################
###### End Menu Module ###########
##################################

##################################
######### Menu Hilfe #############
##################################

$l_javaMenu["help"] = "Ohje";
$l_javaMenu["onlinehelp"] = "Online ohje";
$l_javaMenu["webEdition_online"] = "webEdition online"; // TRANSLATE
$l_javaMenu["sidebar"] = "Sivupalkki";
$l_javaMenu["update"] = "Päivitä";
$l_javaMenu["upgrade"] = "Update webEdition 5"; // TRANSLATE
$l_javaMenu["register"] = "Rekisteröi";
$l_javaMenu["info"] = "Tietoja";

########################################################
######### Navigation back - forward - home #############
########################################################

$l_javaMenu["close"]   = "Sulje";
$l_javaMenu["home"]   = "Aloitus";
$l_javaMenu["back"]   = "Takaisin";
$l_javaMenu["next"]   = "Eteenpäin";
$l_javaMenu["reload"] = "Lataa uudelleen";

$l_javaMenu["not_installed_modules"] = "Asentamattomat moduulit";

$l_javaMenu["search"] = "Etsi";

$l_javaMenu["common"] = "Yleiset";
$l_javaMenu["sysinfo"] = "Järjestelmätiedot";

?>