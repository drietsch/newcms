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

$l_javaMenu["file"] = "Archivo";
$l_javaMenu["new"] = "Nuevo";


	##################################
	###### SubMenu Datei/Neu #########
	##################################

	$l_javaMenu["webEdition_page"] = "Página webEdition";
	$l_javaMenu["empty_page"] = "Página vacía";

	$l_javaMenu["image"] = "Imagen";
	$l_javaMenu["other"] = "Otra";

		##################################
		### SubMenu Datei/Neu/Sonstige ###
		##################################

		$l_javaMenu["html_page"] = "Página HTML";
		$l_javaMenu["flash_movie"] = "Película Flash";
		$l_javaMenu["quicktime_movie"] = "Película Quicktime";
		$l_javaMenu["text_plain"] = "Documento de texto simple";
		$l_javaMenu["text_xml"] = "XML Document"; // TRANSLATE
		$l_javaMenu["javascript"] = "Javascript"; // TRANSLATE
		$l_javaMenu["css_stylesheet"] = "Hoja de estilo en cascada CSS";
		$l_javaMenu["other_files"] = "Otros archivos";


		#####################################################
		########## End SubMenu Datei/Neu/Sonstige ###########
		#####################################################

	$l_javaMenu["template"] = "Plantilla";

		##################################
		## SubMenu Datei/Neu/Verzeichnis #
		##################################

		$l_javaMenu["document_directory"] = "Directorio de documentos";
		$l_javaMenu["template_directory"] = "Directorio de plantillas";

		#################################################
		######## End Submenu Datei/Neu/Verzeichnis  #####
		#################################################

	$l_javaMenu["directory"] = "Directorio";
	$l_javaMenu["wizards"] = "Wizards"; // TRANSLATE

		##################################
		## SubMenu Datei/Neu/Wizards #####
		##################################

		$l_javaMenu["first_steps_wizard"] = "First Steps Wizard"; // TRANSLATE


	############################################
	######## End Submenu Datei/Neu  ############
	############################################

	$l_javaMenu["open"] = "Abrir";


	##################################
	###### SubMenu Datei/Open ########
	##################################
	$l_javaMenu["open_document"] = "Documento";
	$l_javaMenu["open_template"] = "Plantilla";

	##################################
	###### End SubMenu Datei/Open ####
	##################################

	// close
$l_javaMenu["close_single_document"] = "Close Document"; // TRANSLATE
$l_javaMenu["close_all_documents"] = "Close all Documents"; // TRANSLATE
$l_javaMenu["close_all_but_active_document"] = "Close inactive documents"; // TRANSLATE
$l_javaMenu["delete_active_document"] = "Delete active document"; // TRANSLATE



$l_javaMenu["save"] = "Salvar";
$l_javaMenu["publish"] = "Publish"; // TRANSLATE
$l_javaMenu["delete"] = "Borrar";

	##################################
	##### SubMenu Datei/L�schen ######
	##################################

	$l_javaMenu["documents"] = "Documentos";
	$l_javaMenu["templates"] = "Plantillas";
	$l_javaMenu["cache"] = "Cache"; // TRANSLATE

	##################################
	######## End Submenu  ############
	##################################

$l_javaMenu["move"] = "Move"; // TRANSLATE

	#########################################
	#####   	 Import/export		    #####
    #########################################

    $l_javaMenu["import_export"] = "Importar/Exportar";

    $l_javaMenu["import"]        = "Importar";
    $l_javaMenu["export"]        = "Exportar";

    #########################################
	#####	    End Import/export	    #####
    #########################################

$l_javaMenu["backup"] = "Reserva";

	##################################
	### SubMenu Datei/Backup ####
	##################################

	$l_javaMenu["make_backup"] = "Crear Reserva";
	$l_javaMenu["recover_backup"] = "Restaurar Reserva";

	##################################
	### SubMenu Datei/Backup ####
	##################################

$l_javaMenu["rebuild"] = "Reconstruir";
$l_javaMenu["clear_cache"] = "Clear cache"; // TRANSLATE

$l_javaMenu["browse_server"] = "Navegar por el Servidor";
$l_javaMenu["quit"] = "Finalizar";

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

$l_javaMenu["edit"] = "Opciones";
$l_javaMenu["document_types"] = "Tipos de documentos";
$l_javaMenu["categories"] = "Categorías";
$l_javaMenu["thumbnails"] = "Imágenes en miniatura";
$l_javaMenu["metadata"] = "Metadata fields"; // TRANSLATE
$l_javaMenu["navigation"] = "Navigation"; // TRANSLATE
$l_javaMenu["change_username"] = "Cambiar nombre de usuario";
$l_javaMenu["change_password"] = "Cambiar contraseña";
$l_javaMenu["econda"] = "Econda";

$l_javaMenu["formmail_recipients"] = "Destinatarios de formas de correos";
$l_javaMenu["proxy_server"] = "Servidor Proxy";
$l_javaMenu["unpublished_pages"] = "Páginas inéditas";
$l_javaMenu["preferences"] = "Preferencias";
$l_javaMenu["versioning"] = "Version-Wizard"; // TRANSLATE
$l_javaMenu["versioning_log"] = "Version-Log"; // TRANSLATE


##################################
###### End Menu Bearbeiten #######
##################################


##############################
###### Menu Module ###########
##############################

$l_javaMenu["modules"] = "Módulos";
$l_javaMenu["module_installation"] = "Instalación de Módulos";

//	The content is generated dynamically
$l_javaMenu["extras"] = "Extras"; // TRANSLATE
$l_javaMenu["inactive_extras"] = "Inactive Extras"; // TRANSLATE


#################################
###### End Menu Module ###########
##################################

##################################
######### Menu Hilfe #############
##################################

$l_javaMenu["help"] = "Ayuda";
$l_javaMenu["onlinehelp"] = "Ayuda en línea";
$l_javaMenu["webEdition_online"] = "webEdition online"; // TRANSLATE
$l_javaMenu["sidebar"] = "Sidebar"; // TRANSLATE
$l_javaMenu["update"] = "Actualizar";
$l_javaMenu["upgrade"] = "Update webEdition 5"; // TRANSLATE
$l_javaMenu["register"] = "Registrar";
$l_javaMenu["info"] = "Info"; // TRANSLATE

########################################################
######### Navigation back - forward - home #############
########################################################

$l_javaMenu["close"]   = "Close"; // TRANSLATE
$l_javaMenu["home"]   = "Home"; // TRANSLATE
$l_javaMenu["back"]   = "Atras";
$l_javaMenu["next"]   = "Reenviar";
$l_javaMenu["reload"] = "Recargar";

$l_javaMenu["not_installed_modules"] = "Módulos no instalados";

$l_javaMenu["search"] = "Search"; // TRANSLATE

$l_javaMenu["common"] = "Common"; // TRANSLATE
$l_javaMenu["sysinfo"] = "System information"; // TRANSLATE

?>