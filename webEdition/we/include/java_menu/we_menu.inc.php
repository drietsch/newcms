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
 * @package    webEdition_javamenu
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/global.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/weModuleInfo.class.php");

$we_menu = array();

// File
$we_menu["1000000"]["text"] = $l_javaMenu["file"];
$we_menu["1000000"]["parent"] = "0000000";
$we_menu["1000000"]["enabled"] = "1";

	// File > New
	$we_menu["1010000"]["text"] = $l_javaMenu["new"];
	$we_menu["1010000"]["parent"] = "1000000";
	$we_menu["1010000"]["enabled"] = "1";

		// File > New > webEdition Document
		$we_menu["1010100"]["text"] = $l_javaMenu["webEdition_page"];
		$we_menu["1010100"]["parent"] = "1010000";
        $we_menu["1010100"]["perm"] = "NEW_WEBEDITIONSITE || ADMINISTRATOR";
		$we_menu["1010100"]["enabled"] = "1";

		// File > New > webEdition Document > empty page
		if(we_hasPerm("NO_DOCTYPE")){
			$we_menu["1010101"]["text"] = $l_javaMenu["empty_page"];
			$we_menu["1010101"]["parent"] = "1010100";
			$we_menu["1010101"]["cmd"] = "new_webEditionPage";
            $we_menu["1010101"]["perm"] = "NEW_WEBEDITIONSITE || ADMINISTRATOR";
		}

		$q=getDoctypeQuery($DB_WE);
		$DB_WE->query("SELECT ID,DocType FROM " . DOC_TYPES_TABLE . " $q");
		if($DB_WE->num_rows() && we_hasPerm("NO_DOCTYPE")){
			$we_menu["1010102"]["parent"] = "1010100"; // separator
		}
		// File > New > webEdition Document > Doctypes*
		$nr = 103;
		while($DB_WE->next_record()){

			$foo = $DB_WE->f("DocType");
			$foo = str_replace('"',"",$foo);
			$foo = str_replace("'","",$foo);
			$foo = str_replace(','," ",$foo);

			$we_menu["1010" . $nr]["text"] = $foo;

			$we_menu["1010" . $nr]["parent"] = "1010100";
			$we_menu["1010" . $nr]["cmd"] = "new_dtPage".$DB_WE->f("ID");
			$we_menu["1010" . $nr]["perm"] = "NEW_WEBEDITIONSITE || ADMINISTRATOR";
			$we_menu["1010" . $nr]["enabled"] = "1";
			$nr++;
			if($nr == 197) break;
		}

		if(we_hasPerm("NO_DOCTYPE")){
			$we_menu["1010198"]["parent"] = "1010100"; // separator

			// File > New > Others (Import)
			$we_menu["1010199"]["text"] = $l_javaMenu["other"];
			$we_menu["1010199"]["parent"] = "1010100";
			$we_menu["1010199"]["cmd"] = "openFirstStepsWizardDetailTemplates";
	        $we_menu["1010199"]["perm"] = "ADMINISTRATOR";
			$we_menu["1010199"]["enabled"] = "1";

		}

		// File > Image
		$we_menu["1010200"]["text"] = $l_javaMenu["image"];
		$we_menu["1010200"]["parent"] = "1010000";
		$we_menu["1010200"]["cmd"] = "new_image";
        $we_menu["1010200"]["perm"] = "NEW_GRAFIK || ADMINISTRATOR";
		$we_menu["1010200"]["enabled"] = "1";

		// File > New > Other
		$we_menu["1010300"]["text"] = $l_javaMenu["other"];
		$we_menu["1010300"]["parent"] = "1010000";
		$we_menu["1010300"]["enabled"] = "1";

			// File > New > Other > html
			$we_menu["1010301"]["text"] = $l_javaMenu["html_page"];
			$we_menu["1010301"]["parent"] = "1010300";
			$we_menu["1010301"]["cmd"] = "new_html_page";
            $we_menu["1010301"]["perm"] = "NEW_HTML || ADMINISTRATOR";
			$we_menu["1010301"]["enabled"] = "1";

			// File > New > Other > Flash
			$we_menu["1010302"]["text"] = $l_javaMenu["flash_movie"];
			$we_menu["1010302"]["parent"] = "1010300";
			$we_menu["1010302"]["cmd"] = "new_flash_movie";
            $we_menu["1010302"]["perm"] = "NEW_FLASH || ADMINISTRATOR";
			$we_menu["1010302"]["enabled"] = "1";

			// File > New Other > quicktime
			$we_menu["1010303"]["text"] = $l_javaMenu["quicktime_movie"];
			$we_menu["1010303"]["parent"] = "1010300";
			$we_menu["1010303"]["cmd"] = "new_quicktime_movie";
            $we_menu["1010303"]["perm"] = "NEW_QUICKTIME || ADMINISTRATOR";
			$we_menu["1010303"]["enabled"] = "1";

			// File > New > Other > Javascript
			$we_menu["1010304"]["text"] = $l_javaMenu["javascript"];
			$we_menu["1010304"]["parent"] = "1010300";
			$we_menu["1010304"]["cmd"] = "new_javascript";
            $we_menu["1010304"]["perm"] = "NEW_JS || ADMINISTRATOR";
			$we_menu["1010304"]["enabled"] = "1";

			// File > New > Other > CSS
			$we_menu["1010305"]["text"] = $l_javaMenu["css_stylesheet"];
			$we_menu["1010305"]["parent"] = "1010300";
			$we_menu["1010305"]["cmd"] = "new_css_stylesheet";
            $we_menu["1010305"]["perm"] = "NEW_CSS || ADMINISTRATOR";
			$we_menu["1010305"]["enabled"] = "1";

			// File > New > Other > Text
			$we_menu["1010306"]["text"] = $l_javaMenu["text_plain"];
			$we_menu["1010306"]["parent"] = "1010300";
			$we_menu["1010306"]["cmd"] = "new_text_plain";
            $we_menu["1010306"]["perm"] = "NEW_TEXT || ADMINISTRATOR";
			$we_menu["1010306"]["enabled"] = "1";

			// File > New > Other > XML
			$we_menu["1010307"]["text"] = $l_javaMenu["text_xml"];
			$we_menu["1010307"]["parent"] = "1010300";
			$we_menu["1010307"]["cmd"] = "new_text_xml";
            $we_menu["1010307"]["perm"] = "NEW_TEXT || ADMINISTRATOR";
			$we_menu["1010307"]["enabled"] = "1";

			// File > New > Other > Other (Binary)
			$we_menu["1010308"]["text"] = $l_javaMenu["other_files"];
			$we_menu["1010308"]["parent"] = "1010300";
			$we_menu["1010308"]["cmd"] = "new_binary_document";
            $we_menu["1010308"]["perm"] = "NEW_SONSTIGE || ADMINISTRATOR";
			$we_menu["1010308"]["enabled"] = "1";

		$we_menu["1010400"]["parent"] = "1010000"; // separator

		// File > New > Template
		$we_menu["1010500"]["text"] = $l_javaMenu["template"];
		$we_menu["1010500"]["parent"] = "1010000";
		$we_menu["1010500"]["cmd"] = "new_template";
		$we_menu["1010500"]["perm"] = "NEW_TEMPLATE || ADMINISTRATOR";
		$we_menu["1010500"]["enabled"] = "1";

		$we_menu["1010600"]["parent"] = "1010000"; // separator

		// File > New > Directory
		$we_menu["1011000"]["text"] = $l_javaMenu["directory"];
		$we_menu["1011000"]["parent"] = "1010000";
		$we_menu["1011000"]["enabled"] = "1";

			// File > New > Directory > Document
			$we_menu["1011001"]["text"] = $l_javaMenu["document_directory"];
			$we_menu["1011001"]["parent"] = "1011000";
			$we_menu["1011001"]["cmd"] = "new_document_folder";
            $we_menu["1011001"]["perm"] = "NEW_DOC_FOLDER || ADMINISTRATOR";
			$we_menu["1011001"]["enabled"] = "1";

			// File > New > Directory > Template
			$we_menu["1011002"]["text"] = $l_javaMenu["template_directory"];
			$we_menu["1011002"]["parent"] = "1011000";
			$we_menu["1011002"]["cmd"] = "new_template_folder";
            $we_menu["1011002"]["perm"] = "NEW_TEMP_FOLDER || ADMINISTRATOR";
			$we_menu["1011002"]["enabled"] = "1";

			// File > New > Directory > Object

		$we_menu["1011100"]["parent"] = "1010000"; // separator

		// File > New > Wizards
		$we_menu["1011200"]["text"] = $l_javaMenu["wizards"] . "...";
		$we_menu["1011200"]["parent"] = "1010000";
		$we_menu["1011200"]["enabled"] = "1";

			// File > New > Wizard > First Steps Wizard
			$we_menu["1011201"]["text"] = $l_javaMenu["first_steps_wizard"];
			$we_menu["1011201"]["parent"] = "1011200";
			$we_menu["1011201"]["cmd"] = "openFirstStepsWizardMasterTemplate";
			$we_menu["1011201"]["perm"] = "ADMINISTRATOR";
			$we_menu["1011201"]["enabled"] = "1";

		$we_menu["1020000"]["parent"] = "1000000"; // separator

	// File > Open
	$we_menu["1030000"]["text"] = $l_javaMenu["open"];
	$we_menu["1030000"]["parent"] = "1000000";
	$we_menu["1030000"]["enabled"] = "1";

		// File > Open > Document
		$we_menu["1030100"]["text"] = $l_javaMenu["open_document"] . "...";
		$we_menu["1030100"]["parent"] = "1030000";
		$we_menu["1030100"]["cmd"] = "open_document";
	    $we_menu["1030100"]["perm"] = "CAN_SEE_DOCUMENTS || ADMINISTRATOR";
		$we_menu["1030100"]["enabled"] = "1";

		// File > Open > Template
		$we_menu["1030200"]["text"] = $l_javaMenu["open_template"] . "...";
		$we_menu["1030200"]["parent"] = "1030000";
		$we_menu["1030200"]["cmd"] = "open_template";
	    $we_menu["1030200"]["perm"] = "CAN_SEE_TEMPLATES || ADMINISTRATOR";
		$we_menu["1030200"]["enabled"] = "1";

		// File > Open > Object
		// File > Open > Class

	// File > Close
	$we_menu["1040000"]["text"] = $l_javaMenu["close_single_document"];
	$we_menu["1040000"]["parent"] = "1000000";
	$we_menu["1040000"]["cmd"] = "close_document";
    $we_menu["1040000"]["perm"] = "";
	$we_menu["1040000"]["enabled"] = "1";

	// File > Close All
	$we_menu["1050000"]["text"] = $l_javaMenu["close_all_documents"];
	$we_menu["1050000"]["parent"] = "1000000";
	$we_menu["1050000"]["cmd"] = "close_all_documents";
    $we_menu["1050000"]["perm"] = "";
	$we_menu["1050000"]["enabled"] = "1";
	
	// File > Close All But this
	$we_menu["1050100"]["text"] = $l_javaMenu["close_all_but_active_document"];
	$we_menu["1050100"]["parent"] = "1000000";
	$we_menu["1050100"]["cmd"] = "close_all_but_active_document";
    $we_menu["1050100"]["perm"] = "";
	$we_menu["1050100"]["enabled"] = "1";
	
	// File > Delete Active Document
	$we_menu["1050200"]["text"] = $l_javaMenu["delete_active_document"];//$l_javaMenu["delete_single_document"];
	$we_menu["1050200"]["parent"] = "1000000";
	$we_menu["1050200"]["cmd"] = "delete_single_document_question";
    $we_menu["1050200"]["perm"] = "";
	$we_menu["1050200"]["enabled"] = "1";
	
	
	$we_menu["1060000"]["parent"] = "1000000"; // separator

	// File > Save
	$we_menu["1070000"]["text"] = $l_javaMenu["save"];
	$we_menu["1070000"]["parent"] = "1000000";
	$we_menu["1070000"]["cmd"] = "trigger_save_document";
    $we_menu["1070000"]["perm"] = "SAVE_DOCUMENT_TEMPLATE || ADMINISTRATOR";
	$we_menu["1070000"]["enabled"] = "1";

	$we_menu["1070001"]["text"] = $l_javaMenu["publish"];
	$we_menu["1070001"]["parent"] = "1000000";
	$we_menu["1070001"]["cmd"] = "trigger_publish_document";
    $we_menu["1070001"]["perm"] = "PUBLISH || ADMINISTRATOR";
	$we_menu["1070001"]["enabled"] = "1";

	// File > Delete
	$we_menu["1080000"]["text"] = $l_javaMenu["delete"];
	$we_menu["1080000"]["parent"] = "1000000";
	$we_menu["1080000"]["enabled"] = "1";

		// File > Delete > Documents
		$we_menu["1080100"]["text"] = $l_javaMenu["documents"];
		$we_menu["1080100"]["parent"] = "1080000";
		$we_menu["1080100"]["cmd"] = "delete_documents";
        $we_menu["1080100"]["perm"] = "DELETE_DOCUMENT || ADMINISTRATOR";
		$we_menu["1080100"]["enabled"] = "1";

		// File > Delete > Templates
		$we_menu["1080200"]["text"] = $l_javaMenu["templates"];
		$we_menu["1080200"]["parent"] = "1080000";
		$we_menu["1080200"]["cmd"] = "delete_templates";
        $we_menu["1080200"]["perm"] = "DELETE_TEMPLATE || ADMINISTRATOR";
		$we_menu["1080200"]["enabled"] = "1";

		// File > Delete > Classes
		// File > Delete > Objects
		if(we_hasPerm("ADMINISTRATOR")){
			$we_menu["1080500"]["text"] = $l_javaMenu["cache"] . " (".$l_javaMenu["documents"] . ")";
			$we_menu["1080500"]["parent"] = "1080000";
			$we_menu["1080500"]["cmd"] = "delete_documents_cache";
	        $we_menu["1080500"]["perm"] = "ADMINISTRATOR";
			$we_menu["1080500"]["enabled"] = "1";
		}
		// File > Delete > Objectscache

	// File > Move
	$we_menu["1090000"]["text"] = $l_javaMenu["move"];
	$we_menu["1090000"]["parent"] = "1000000";
	$we_menu["1090000"]["enabled"] = "1";

		// File > Move > Documents
		$we_menu["1090100"]["text"] = $l_javaMenu["documents"];
		$we_menu["1090100"]["parent"] = "1090000";
		$we_menu["1090100"]["cmd"] = "move_documents";
        $we_menu["1090100"]["perm"] = "MOVE_DOCUMENT || ADMINISTRATOR";
		$we_menu["1090100"]["enabled"] = "1";

		// File > Move > Templates
		$we_menu["1090200"]["text"] = $l_javaMenu["templates"];
		$we_menu["1090200"]["parent"] = "1090000";
		$we_menu["1090200"]["cmd"] = "move_templates";
        $we_menu["1090200"]["perm"] = "MOVE_TEMPLATE || ADMINISTRATOR";
		$we_menu["1090200"]["enabled"] = "1";

		// File > Move > Objects

	$we_menu["1100000"]["parent"] = "1000000"; // separator

	// File > unpublished pages
	$we_menu["1110000"]["text"] = $l_javaMenu["unpublished_pages"] . "...";
	$we_menu["1110000"]["parent"] = "1000000";
	$we_menu["1110000"]["cmd"] = "openUnpublishedPages";
    $we_menu["1110000"]["perm"] = "CAN_SEE_DOCUMENTS || ADMINISTRATOR";
	$we_menu["1110000"]["enabled"] = "1";

	// File > unpublished objects, comes here !

	$we_menu["1120000"]["parent"] = "1000000"; // separator

	// File > Search
	$we_menu["1130000"]["text"] = $l_javaMenu["search"] . "...";
	$we_menu["1130000"]["parent"] = "1000000";
	$we_menu["1130000"]["cmd"] = "tool_weSearch_edit";
    $we_menu["1130000"]["perm"] = "";
	$we_menu["1130000"]["enabled"] = "1";

    $we_menu["1140000"]["parent"] = "1000000"; // separator

    // File > Import/Export
    $we_menu["1150000"]["text"] = $l_javaMenu["import_export"];
	$we_menu["1150000"]["parent"] = "1000000";
	$we_menu["1150000"]["enabled"] = "1";

	// File > Import/Export > Import
	$we_menu["1150100"]["text"] = $l_javaMenu["import"] . "...";
    $we_menu["1150100"]["cmd"] = "import";
    $we_menu["1150100"]["parent"] = "1150000";
    if(we_hasPerm("FILE_IMPORT") || we_hasPerm("SITE_IMPORT")  || we_hasPerm("GENERICXML_IMPORT")  || we_hasPerm("CSV_IMPORT")  || we_hasPerm("WXML_IMPORT")){
		$we_menu["1150100"]["perm"] = "NEW_GRAFIK || NEW_WEBEDITIONSITE || NEW_HTML || NEW_FLASH || NEW_QUICKTIME || NEW_JS || NEW_CSS || NEW_TEXT || NEW_SONSTIGE || ADMINISTRATOR";
	}else{
		$we_menu["1150100"]["perm"] = "ADMINISTRATOR";
	}
    $we_menu["1150100"]["enabled"] = "1";

    // File > Import/Export > Export
    $we_menu["1150200"]["text"] = $l_javaMenu["export"] . "...";
    $we_menu["1150200"]["cmd"] = "export";
    $we_menu["1150200"]["parent"] = "1150000";
    $we_menu["1150200"]["perm"] =  "GENERICXML_EXPORT || CSV_EXPORT || ADMINISTRATOR";
	$we_menu["1150200"]["enabled"] = "1";

	// File > Backup
    $we_menu["1160000"]["text"] = $l_javaMenu["backup"];
	$we_menu["1160000"]["parent"] = "1000000";
	$we_menu["1160000"]["enabled"] = "1";

		// File > Backup > make
		$we_menu["1160100"]["text"] = $l_javaMenu["make_backup"] . "...";
		$we_menu["1160100"]["parent"] = "1160000";
		$we_menu["1160100"]["cmd"] = "make_backup";
		$we_menu["1160100"]["perm"] = "EXPORT || ADMINISTRATOR";
		$we_menu["1160100"]["enabled"] = "1";

		// File > Backup > recover
		$we_menu["1160200"]["text"] = $l_javaMenu["recover_backup"] . "...";
		$we_menu["1160200"]["parent"] = "1160000";
		$we_menu["1160200"]["cmd"] = "recover_backup";
		$we_menu["1160200"]["perm"] = "IMPORT || ADMINISTRATOR";
		$we_menu["1160200"]["enabled"] = "1";

	// File > Backup > rebuild
    $we_menu["1180000"]["text"] = $l_javaMenu["rebuild"] . "...";
	$we_menu["1180000"]["parent"] = "1000000";
	$we_menu["1180000"]["cmd"] = "rebuild";
    $we_menu["1180000"]["perm"] = "REBUILD || ADMINISTRATOR";
	$we_menu["1180000"]["enabled"] = "1";

	$we_menu["1190000"]["text"] = $l_javaMenu["clear_cache"];
	$we_menu["1190000"]["parent"] = "1000000";
	$we_menu["1190000"]["cmd"] = "clear_cache";
	$we_menu["1190000"]["perm"] = "ADMINISTRATOR";
	$we_menu["1190000"]["enabled"] = "1";

	$we_menu["1200000"]["parent"] = "1000000"; // separator

	// File > Browse server
	$we_menu["1210000"]["text"] = $l_javaMenu["browse_server"] . "...";
	$we_menu["1210000"]["parent"] = "1000000";
	$we_menu["1210000"]["cmd"] = "browse_server";
	$we_menu["1210000"]["perm"] = "BROWSE_SERVER || ADMINISTRATOR";
	$we_menu["1210000"]["enabled"] = "1";

	$we_menu["1220000"]["parent"] = "1000000"; // separator

	// File > Quit
	$we_menu["1230000"]["text"] = $l_javaMenu["quit"];
	$we_menu["1230000"]["parent"] = "1000000";
	$we_menu["1230000"]["cmd"] = "dologout";
	$we_menu["1230000"]["enabled"] = "1";


	// Cockpit
	$we_menu["2000000"]["text"] = $l_global["cockpit"];
	$we_menu["2000000"]["parent"] = "0000000";
	$we_menu["2000000"]["enabled"] = we_hasPerm("CAN_SEE_QUICKSTART");

		// Cockpit > Display
		$we_menu["2010000"]["text"] = $l_javaMenu["display"];
		$we_menu["2010000"]["parent"] = "2000000";
		$we_menu["2010000"]["cmd"] = "home";
		$we_menu["2010000"]["perm"] = "";
		$we_menu["2010000"]["enabled"] = we_hasPerm("CAN_SEE_QUICKSTART");

		// Cockpit > new Widget
		$we_menu["2020000"]["text"] = $l_javaMenu["new_widget"];
		$we_menu["2020000"]["parent"] = "2000000";
		$we_menu["2020000"]["perm"] = "";
		$we_menu["2020000"]["enabled"] = we_hasPerm("CAN_SEE_QUICKSTART");

			// Cockpit > new Widget > shortcuts
			$we_menu["2020100"]["text"] = $l_javaMenu["shortcuts"];
			$we_menu["2020100"]["parent"] = "2020000";
			$we_menu["2020100"]["cmd"] = "new_widget_sct";
			$we_menu["2020100"]["perm"] = "";
			$we_menu["2020100"]["enabled"] = we_hasPerm("CAN_SEE_QUICKSTART");

			// Cockpit > new Widget > RSS
			$we_menu["2020200"]["text"] = $l_javaMenu["rss_reader"];
			$we_menu["2020200"]["parent"] = "2020000";
			$we_menu["2020200"]["cmd"] = "new_widget_rss";
			$we_menu["2020200"]["perm"] = "";
			$we_menu["2020200"]["enabled"] = we_hasPerm("CAN_SEE_QUICKSTART");

			// Cockpit > new Widget > messaging
			if (defined("MESSAGING_SYSTEM")){
				$we_menu["2020300"]["text"] = $l_javaMenu["todo_messaging"];
				$we_menu["2020300"]["parent"] = "2020000";
				$we_menu["2020300"]["cmd"] = "new_widget_msg";
				$we_menu["2020300"]["perm"] = "";
				$we_menu["2020300"]["enabled"] = we_hasPerm("CAN_SEE_QUICKSTART");
			}

			// Cockpit > new Widget > online users
			$we_menu["2020400"]["text"] = $l_javaMenu["users_online"];
			$we_menu["2020400"]["parent"] = "2020000";
			$we_menu["2020400"]["cmd"] = "new_widget_usr";
			$we_menu["2020400"]["perm"] = "";
			$we_menu["2020400"]["enabled"] = we_hasPerm("CAN_SEE_QUICKSTART");

			// Cockpit > new Widget > lastmodified
			$we_menu["2020500"]["text"] = $l_javaMenu["last_modified"];
			$we_menu["2020500"]["parent"] = "2020000";
			$we_menu["2020500"]["cmd"] = "new_widget_mfd";
			$we_menu["2020500"]["perm"] = "";
			$we_menu["2020500"]["enabled"] = we_hasPerm("CAN_SEE_QUICKSTART");

			// Cockpit > new Widget > unpublished
			$we_menu["2020600"]["text"] = $l_javaMenu["unpublished"];
			$we_menu["2020600"]["parent"] = "2020000";
			$we_menu["2020600"]["cmd"] = "new_widget_upb";
			$we_menu["2020600"]["perm"] = "";
			$we_menu["2020600"]["enabled"] = we_hasPerm("CAN_SEE_QUICKSTART");

			// Cockpit > new Widget > my Documents
			$we_menu["2020700"]["text"] = $l_javaMenu["my_documents"];
			$we_menu["2020700"]["parent"] = "2020000";
			$we_menu["2020700"]["cmd"] = "new_widget_mdc";
			$we_menu["2020700"]["perm"] = "";
			$we_menu["2020700"]["enabled"] = we_hasPerm("CAN_SEE_QUICKSTART");

			// Cockpit > new Widget > Notepad
			$we_menu["2020800"]["text"] = $l_javaMenu["notepad"];
			$we_menu["2020800"]["parent"] = "2020000";
			$we_menu["2020800"]["cmd"] = "new_widget_pad";
			$we_menu["2020800"]["perm"] = "";
			$we_menu["2020800"]["enabled"] = we_hasPerm("CAN_SEE_QUICKSTART");

			// Cockpit > new Widget > pageLogger
			if(defined("WE_TRACKER_DIR") && WE_TRACKER_DIR &&
				file_exists($_SERVER["DOCUMENT_ROOT"].WE_TRACKER_DIR."/includes/showme.inc.php")) {
				$we_menu["2020900"]["text"] = $l_javaMenu["pagelogger"];
				$we_menu["2020900"]["parent"] = "2020000";
				$we_menu["2020900"]["cmd"] = "new_widget_plg";
				$we_menu["2020900"]["perm"] = "";
				$we_menu["2020900"]["enabled"] = we_hasPerm("CAN_SEE_QUICKSTART");
			}

		// Cockpit > new Widget > default settings
		$we_menu["2030000"]["text"] = $l_javaMenu["default_settings"];
		$we_menu["2030000"]["parent"] = "2000000";
		$we_menu["2030000"]["cmd"] = "reset_home";
		$we_menu["2030000"]["perm"] = "";
		$we_menu["2030000"]["enabled"] = we_hasPerm("CAN_SEE_QUICKSTART");

// Modules
$we_menu["3000000"]["text"] = $l_javaMenu["modules"];
$we_menu["3000000"]["parent"] = "0000000";

	$z = 100;

	// order all modules
	$buyableModules = weModuleInfo::getNoneIntegratedModules();
	weModuleInfo::orderModuleArray($buyableModules);

	$userHasAllModules = true;
	$moduleList = "schedpro|";

	if (sizeof($_we_installed_modules) > 0) {

		foreach ($buyableModules as $m) {

			if (weModuleInfo::showModuleInMenu($m["name"])) {
				// workarround (old module names) for not installed Modules WIndow
				if ($m["name"] == "customer") {
					$moduleList .= "customerpro|" ;
				}
				$moduleList .= $m["name"] . "|" ;
				$menNr = "3000$z";
				$we_menu[$menNr]["text"] = $m["text"] . "...";
				$we_menu[$menNr]["parent"] = "3000000";
				$we_menu[$menNr]["cmd"] = "edit_".$m["name"]."_ifthere";
				$we_menu[$menNr]["perm"] = isset($m["perm"]) ? $m["perm"] : "";
				$we_menu[$menNr]["enabled"] = "1";
				$z++;
			} else if(in_array($m["name"],$_we_installed_modules)) {
				$moduleList .= $m["name"] . "|" ;
			}
			if (!weModuleInfo::isModuleInstalled($m["name"])) {
				$userHasAllModules = false;
			}
		}
		$we_menu["3010000"]["parent"] = "3000000"; // separator
	} else {
		$userHasAllModules = false;
	}
	// usermanagement pro is the only promodule that is left

	// Are there any promodules in version 5 or do we remove them, what happens with BV?
	if(sizeof($_pro_modules) > 0){
		foreach($we_pro_modules_available as $m){
			if(in_array($m, $_pro_modules)){
				$moduleList .= $m . "|" ;
			}else{
				$userHasAllModules = false;
			}
		}
	}else{
		$userHasAllModules = false;
	}

	if ( defined('BIG_USER_MODULE') ) {

		$m = $_we_available_modules['users'];

		$we_menu["3010001"]["text"] = $m["text"] . "...";
		$we_menu["3010001"]["parent"] = "3000000";
		$we_menu["3010001"]["cmd"] = "edit_".$m["name"]."_ifthere";
		$we_menu["3010001"]["perm"] = isset($m["perm"]) ? $m["perm"] : "";
		$we_menu["3010001"]["enabled"] = "1";

		$we_menu["3010002"]["parent"] = "3000000"; // separator

	}

	foreach($_we_available_modules as $key=>$val) {
		if($val["integrated"]) {
			$moduleList .= $key . "|";
		}
	}
	$_SESSION["we_module_list"] = ereg_replace('^(.+)\|$','\1',$moduleList);

	// Modules > pagelogger
	if(defined("WE_TRACKER_DIR") && WE_TRACKER_DIR){
		$we_menu["3020000"]["text"] = 'pageLogger';
		$we_menu["3020000"]["parent"] = "3000000";
		$we_menu["3020000"]["cmd"] = "we_tracker";
		$we_menu["3020000"]["perm"] = "";
		$we_menu["3020000"]["enabled"] = "1";
		$we_menu["3030000"]["parent"] = "3000000"; // separator
	}

	// Modules > not installed modules
	if(!$userHasAllModules){
		$we_menu["3040000"]["text"] = $l_javaMenu["not_installed_modules"] . "...";
		$we_menu["3040000"]["parent"] = "3000000";
		$we_menu["3040000"]["cmd"] = "not_installed_modules";
		$we_menu["3040000"]["perm"] = "";
		$we_menu["3040000"]["enabled"] = "1";

		$we_menu["3050000"]["parent"] = "3000000"; // separator
	}

	// Modules > moduleinstallation
	$we_menu["3060000"]["text"] = $l_javaMenu["module_installation"] . "...";
	$we_menu["3060000"]["parent"] = "3000000";
	$we_menu["3060000"]["cmd"] = "moduleinstallation";
    $we_menu["3060000"]["perm"] = "ADMINISTRATOR";
	$we_menu["3060000"]["enabled"] = "1";


// Extras
$we_menu["4000000"]["text"] = $l_javaMenu["extras"];
$we_menu["4000000"]["parent"] = "0000000";
$we_menu["4000000"]["enabled"] = "1";

	// Extras > Integrated Modules
	$_activeIntModules = weModuleInfo::getIntegratedModules(true);
	weModuleInfo::orderModuleArray($_activeIntModules);

	if (sizeof($_activeIntModules)) {

		$z = 100;

		foreach ($_activeIntModules as $key => $modInfo) {
			if (weModuleInfo::showModuleInMenu($modInfo["name"])) {
				$we_menu["4000$z"]["text"] = $modInfo["text"] . "...";
				$we_menu["4000$z"]["parent"] = "4000000";
				$we_menu["4000$z"]["cmd"] = "edit_".$modInfo["name"]."_ifthere";
				$we_menu["4000$z"]["perm"] = isset($modInfo["perm"]) ? $modInfo["perm"] : "";
				$we_menu["4000$z"]["enabled"] = "1";
				$z++;
			}
		}

		$we_menu["4010000"]["parent"] = "4000000"; // separator
	}

	// Extras > Inactive Extras
/*
	$_inactiveIntModules = weModuleInfo::getIntegratedModules(false);
	if (sizeof($_inactiveIntModules) > 0) {

		$we_menu["4020000"]["text"] = $l_javaMenu["inactive_extras"]; // separator
		$we_menu["4020000"]["parent"] = "4000000"; // separator
		$we_menu["4020000"]["enabled"] = "1";

		$z = 100;

		foreach ($_inactiveIntModules as $key => $modInfo) {
			
			$we_menu["4020$z"]["text"] = $modInfo["text"] . "...";
			$we_menu["4020$z"]["parent"] = "4020000";
			$we_menu["4020$z"]["cmd"] = "edit_".$modInfo["name"]."_ifthere";
			$we_menu["4020$z"]["perm"] = isset($modInfo["perm"]) ? $modInfo["perm"] : "";
			$we_menu["4020$z"]["enabled"] = "0";
			$z++;

		}
		$we_menu["4030000"]["parent"] = "4000000"; // separator
	}
*/

	// Extras > Navigation
	$we_menu["4031000"]["text"] = $l_javaMenu["navigation"] . "...";
	$we_menu["4031000"]["parent"] = "4000000";
	$we_menu["4031000"]["cmd"] = "tool_navigation_edit";
	$we_menu["4031000"]["perm"] = "EDIT_NAVIGATION || ADMINISTRATOR";
	$we_menu["4031000"]["enabled"] = "1";

	// Extras > Dokument-Typen
	$we_menu["4032000"]["text"] = $l_javaMenu["document_types"] . "...";
	$we_menu["4032000"]["parent"] = "4000000";
	$we_menu["4032000"]["cmd"] = "doctypes";
	$we_menu["4032000"]["perm"] = "EDIT_DOCTYPE || ADMINISTRATOR";
	$we_menu["4032000"]["enabled"] = "1";

	// Extras > Kategorien
	$we_menu["4033000"]["text"] = $l_javaMenu["categories"] . "...";
	$we_menu["4033000"]["parent"] = "4000000";
	$we_menu["4033000"]["cmd"] = "editCat";
	$we_menu["4033000"]["perm"] = "EDIT_KATEGORIE || ADMINISTRATOR";
	$we_menu["4033000"]["enabled"] = "1";

	$we_menu["4040000"]["parent"] = "4000000"; // separator

	// Extras > Tools
	
	include(weToolLookup::getLanguageInclude('toolfactory'));
	if(isset($metaInfo['realname'])) {
		$toolfactoryName = $metaInfo['realname'];
	}
	else {
		$toolfactoryName = $metaInfo['name'];
	}
	$we_menu["4044000"]["text"] = $toolfactoryName . "...";
	$we_menu["4044000"]["parent"] = "4000000";
	$we_menu["4044000"]["cmd"] = "tool_toolfactory_edit";
	$we_menu["4044000"]["perm"] = "EDIT_APP_TOOLFACTORY || ADMINISTRATOR";
	$we_menu["4044000"]["enabled"] = "1";
	
	/*
	include(weToolLookup::getLanguageInclude('weSearch'));
	$we_menu["4045000"]["text"] = $l_weSearch["weSearch"] . "...";
	$we_menu["4045000"]["parent"] = "4000000";
	$we_menu["4045000"]["cmd"] = "tool_weSearch_edit";
	$we_menu["4045000"]["perm"] = "";
	$we_menu["4045000"]["enabled"] = "1";
	*/
	
	// Extras > Tools > Custom tools
	include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_classes/tools/weToolLookup.class.php');
	$_tools = weToolLookup::getAllCustomTools();
	foreach ($_tools as $_k=>$_tool) {
		$we_menu["405" . sprintf("%04d", $_k)]["text"] = $_tool['text'] . "...";
		$we_menu["405" . sprintf("%04d", $_k)]["parent"] = "4000000";
		$we_menu["405" . sprintf("%04d", $_k)]["cmd"] = 'tool_' . $_tool['name'] . '_edit';
		$we_menu["405" . sprintf("%04d", $_k)]["perm"] = $_tool['startpermission'];
		$we_menu["405" . sprintf("%04d", $_k)]["enabled"] = "1";
	}
	
	$we_menu["4125000"]["parent"] = "4000000"; // separator

	// Extras > Thumbnails
	$we_menu["4130000"]["text"] = $l_javaMenu["thumbnails"] . "...";
	$we_menu["4130000"]["parent"] = "4000000";
	$we_menu["4130000"]["cmd"] = "editThumbs";
	$we_menu["4130000"]["perm"] = "EDIT_THUMBS || ADMINISTRATOR";
	$we_menu["4130000"]["enabled"] = "1";
	
	// Extras > Metadata fields
	$we_menu["4140000"]["text"] = $l_javaMenu["metadata"] . "...";
	$we_menu["4140000"]["parent"] = "4000000";
	$we_menu["4140000"]["cmd"] = "editMetadataFields";
	$we_menu["4140000"]["perm"] = "ADMINISTRATOR";
	$we_menu["4140000"]["enabled"] = "1";
	
	//$we_menu["4140000"]["parent"] = "4000000"; // separator
	/*
	// Extras > change username
	$we_menu["4150000"]["text"] = $l_javaMenu["change_username"] . "...";
	$we_menu["4150000"]["parent"] = "4000000";
	$we_menu["4150000"]["cmd"] = "change_username";
    $we_menu["4150000"]["perm"] = "EDIT_USER || ADMINISTRATOR";
	$we_menu["4150000"]["enabled"] = "1";
	*/
	// Extras > change password
	$we_menu["4160000"]["text"] = $l_javaMenu["change_password"] . "...";
	$we_menu["4160000"]["parent"] = "4000000";
	$we_menu["4160000"]["cmd"] = "change_passwd";
    $we_menu["4160000"]["perm"] = "EDIT_PASSWD || ADMINISTRATOR";
	$we_menu["4160000"]["enabled"] = "1";
	
if(we_hasPerm("ADMINISTRATOR")) {
	// Extras > versioning
	$we_menu["4161000"]["text"] = $l_javaMenu["versioning"] . "...";
	$we_menu["4161000"]["parent"] = "4000000";
	$we_menu["4161000"]["cmd"] = "versions_wizard";
    $we_menu["4161000"]["perm"] = "ADMINISTRATOR";
	$we_menu["4161000"]["enabled"] = "1";
	
	// Extras > versioning-log
	$we_menu["4162000"]["text"] = $l_javaMenu["versioning_log"] . "...";
	$we_menu["4162000"]["parent"] = "4000000";
	$we_menu["4162000"]["cmd"] = "versioning_log";
    $we_menu["4162000"]["perm"] = "ADMINISTRATOR";
	$we_menu["4162000"]["enabled"] = "1";
}

	$we_menu["4170000"]["parent"] = "4000000"; // separator

	// Extras > Einstellungen

	$we_menu["4180000"]["text"] = $l_javaMenu["preferences"];
	$we_menu["4180000"]["parent"] = "4000000";
	$we_menu["4180000"]["enabled"] = "1";


	$we_menu["4181000"]["text"] = $l_javaMenu["common"] . "...";
	$we_menu["4181000"]["parent"] = "4180000";
	$we_menu["4181000"]["cmd"] = "openPreferences";
    $we_menu["4181000"]["perm"] = "EDIT_SETTINGS || ADMINISTRATOR";
	$we_menu["4181000"]["enabled"] = "1";

	$we_menu["4183000"]["parent"] = "4180000"; // separator

	$_activeIntModules = weModuleInfo::getIntegratedModules(true);
	weModuleInfo::orderModuleArray($_activeIntModules);

	if (sizeof($_activeIntModules)) {

		$z = 100;

		foreach ($_activeIntModules as $key => $modInfo) {
			if($modInfo['hasSettings']) {
				$we_menu["4184$z"]["text"] = $modInfo["text"] . "...";
				$we_menu["4184$z"]["parent"] = "4180000";
				$we_menu["4184$z"]["cmd"] = "edit_settings_".$modInfo["name"]."";
				$we_menu["4184$z"]["perm"] = isset($modInfo["perm"]) ? $modInfo["perm"] : "";
				$we_menu["4184$z"]["enabled"] = "1";
				$z++;
			}
		}
	}

	$we_menu["4185000"]["parent"] = "4180000"; // separator

	$z = 100;

	// order all modules
	$buyableModules = weModuleInfo::getNoneIntegratedModules();
	weModuleInfo::orderModuleArray($buyableModules);

	$userHasAllModules = true;

	if (sizeof($_we_installed_modules) > 0) {

		foreach ($buyableModules as $m) {

			if (weModuleInfo::showModuleInMenu($m["name"])) {
				if($m['hasSettings']) {
					$menNr = "4186$z";
					$we_menu[$menNr]["text"] = $m["text"] . "...";
					$we_menu[$menNr]["parent"] = "4180000";
					$we_menu[$menNr]["cmd"] = "edit_settings_".$m["name"];
					$we_menu[$menNr]["perm"] = isset($m["perm"]) ? $m["perm"] : "";
					$we_menu[$menNr]["enabled"] = "1";
					$z++;
				}
			}

		}

	}


// Help
$we_menu["5000000"]["text"] = $l_javaMenu["help"];
$we_menu["5000000"]["parent"] = "0000000";
$we_menu["5000000"]["enabled"] = "1";

	$we_menu["5010000"]["text"] = $l_javaMenu["onlinehelp"] . "...";
	$we_menu["5010000"]["parent"] = "5000000";
	$we_menu["5010000"]["cmd"] = "help";
    $we_menu["5010000"]["perm"] = "";
	$we_menu["5010000"]["enabled"] = "1";

	if(!defined("SIDEBAR_DISABLED") || SIDEBAR_DISABLED == 0) {
		$we_menu["5015000"]["text"] = $l_javaMenu["sidebar"] . "...";
		$we_menu["5015000"]["parent"] = "5000000";
		$we_menu["5015000"]["cmd"] = "openSidebar";
	    $we_menu["5015000"]["perm"] = "";
		$we_menu["5015000"]["enabled"] = "1";

	}

	$we_menu["5020000"]["text"] = $l_javaMenu["webEdition_online"] . "...";
	$we_menu["5020000"]["parent"] = "5000000";
	$we_menu["5020000"]["cmd"] = "webEdition_online";
    $we_menu["5020000"]["perm"] = "";
	$we_menu["5020000"]["enabled"] = "1";

//	$we_menu["5030000"]["text"] = "Snippet Shop" . " (not in lng files yet)...";
//	$we_menu["5030000"]["parent"] = "5000000";
//	$we_menu["5030000"]["cmd"] = "snippet_shop";
//  $we_menu["5030000"]["perm"] = "";
//	$we_menu["5030000"]["enabled"] = "1";


	$we_menu["5040000"]["parent"] = "5000000"; // separator

	$we_menu["5050000"]["text"] = $l_javaMenu["update"] . "...";
	$we_menu["5050000"]["parent"] = "5000000";
	$we_menu["5050000"]["cmd"] = "update";
    $we_menu["5050000"]["perm"] = "ADMINISTRATOR";
	$we_menu["5050000"]["enabled"] = "1";

	$we_menu["5060000"]["parent"] = "5000000"; // separator

	/*
		$we_menu["5070000"]["text"] = $l_javaMenu["upgrade"] . "...";
		$we_menu["5070000"]["parent"] = "5000000";
		$we_menu["5070000"]["cmd"] = "upgrade";
	    $we_menu["5070000"]["perm"] = "ADMINISTRATOR";
		$we_menu["5070000"]["enabled"] = "1";
	
		$we_menu["5080000"]["parent"] = "5000000"; // separator
	*/

	$we_menu["5090000"]["text"] = $l_javaMenu["sysinfo"] . "...";
	$we_menu["5090000"]["parent"] = "5000000";
	$we_menu["5090000"]["cmd"] = "sysinfo";
    $we_menu["5090000"]["perm"] = "ADMINISTRATOR";
	$we_menu["5090000"]["enabled"] = "1";

	$we_menu["5100000"]["text"] = $l_javaMenu["info"] . "...";
	$we_menu["5100000"]["parent"] = "5000000";
	$we_menu["5100000"]["cmd"] = "info";
    $we_menu["5100000"]["perm"] = "";
	$we_menu["5100000"]["enabled"] = "1";

	reset($_we_available_modules);
	while(list($key, $val) = each($_we_available_modules)){

		if (!isset($val["integrated"]) || ( in_array($val["name"], $_we_active_modules) )) {

			if(file_exists($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/java_menu/modules/we_menu_" . $val["name"] . ".inc.php")){
				include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/java_menu/modules/we_menu_" . $val["name"] . ".inc.php");
			}
		}
	}
?>
