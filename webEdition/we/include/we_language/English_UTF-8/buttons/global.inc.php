<?php

/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_language
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */


/**
 * Language file: global.inc.php
 * Provides language strings.
 * Language: English
 */

include_once(dirname(__FILE__)."/enc_".basename(__FILE__));

/*****************************************************************************
 * LOGIN-SCREEN
 *****************************************************************************/

$l_button["login"]["value"] = "Login";
$l_button["login"]["alt"] = "Login into webEdition";
$l_button["login"]["width"] = 100;

$l_button["back_to_login"]["value"] = "Back";
$l_button["back_to_login"]["alt"] = "Back to the webEdition-Login";
$l_button["back_to_login"]["width"] = 100;

/*****************************************************************************
 * STARTMENU
 *****************************************************************************/

$l_button["open_document"]["value"] = "Open document";
$l_button["open_document"]["alt"] = "";
$l_button["open_document"]["width"] = 200;

$l_button["new_document"]["value"] = "New document";
$l_button["new_document"]["alt"] = "Create new document";
$l_button["new_document"]["width"] = 200;

$l_button["new_template"]["value"] = "New template";
$l_button["new_template"]["alt"] = "Create new template";
$l_button["new_template"]["width"] = 200;

$l_button["new_directory"]["value"] = "New directory";
$l_button["new_directory"]["alt"] = "Create new directory";
$l_button["new_directory"]["width"] = 200;

$l_button["unpublished_pages"]["value"] = "Unpublished documents";
$l_button["unpublished_pages"]["alt"] = "Survey of unpublished documents";
$l_button["unpublished_pages"]["width"] = 200;

$l_button["preferences"]["value"] = "Preferences";
$l_button["preferences"]["alt"] = "";
$l_button["preferences"]["width"] = 200;

/*****************************************************************************
 * DELETE SCREEN
 *****************************************************************************/

$l_button["quit_delete"]["value"] = "Finish delete mode";
$l_button["quit_delete"]["alt"] = "";
$l_button["quit_delete"]["width"] = 175;

/*****************************************************************************
 * MOVE SCREEN
 *****************************************************************************/

$l_button["quit_move"]["value"] = "Finish move mode";
$l_button["quit_move"]["alt"] = "";
$l_button["quit_move"]["width"] = 175;

/*****************************************************************************
 * STANDARD
 *****************************************************************************/

$l_button["ok"]["value"] = "OK";
$l_button["ok"]["alt"]   = "";
$l_button["ok"]["width"] = 100;

$l_button["cancel"]["value"] = "Cancel";
$l_button["cancel"]["alt"] = "";
$l_button["cancel"]["width"] = 100;

$l_button["yes"]["value"] = "Yes";
$l_button["yes"]["alt"]   = "";
$l_button["yes"]["width"] = 100;

$l_button["no"]["value"] = "No";
$l_button["no"]["alt"]   = "";
$l_button["no"]["width"] = 100;

$l_button["save"]["value"] = "Save";
$l_button["save"]["alt"] = "";
$l_button["save"]["width"] = 100;

$l_button["publish"]["value"] = "Publish";
$l_button["publish"]["alt"]   = "Save and publish the document";
$l_button["publish"]["width"] = 100;

$l_button["delete"]["value"] = "Delete";
$l_button["delete"]["alt"] = "";
$l_button["delete"]["width"] = 100;

$l_button["go"]["value"] = "Execute now";
$l_button["go"]["alt"]   = "";
$l_button["go"]["width"] = 120;

$l_button["openVersionWizard"]["value"] = "Versions-Wizard";
$l_button["openVersionWizard"]["alt"]   = "Versions-Wizard";
$l_button["openVersionWizard"]["width"] = 120;

$l_button["next"]["value"] = "Next";
$l_button["next"]["alt"]   = "";
$l_button["next"]["width"] = 100;

$l_button["back"]["value"] = "Back";
$l_button["back"]["alt"] = "";
$l_button["back"]["width"] = 100;

$l_button["open"]["value"] = "Open";
$l_button["open"]["alt"] = "";
$l_button["open"]["width"] = 100;

$l_button["default"]["value"] = "Default";
$l_button["default"]["alt"] = "";
$l_button["default"]["width"] = 100;

$l_button["reset"]["value"] = "Reset";
$l_button["reset"]["alt"] = "";
$l_button["reset"]["width"] = 100;

/*****************************************************************************
 * SAVING, PUBLISHING, ETC.
 *****************************************************************************/

$l_button["unpublish"]["value"] = "Unpublish";
$l_button["unpublish"]["alt"] = "";
$l_button["unpublish"]["width"] = 100;


/*****************************************************************************
 * MAKE AN NEW DOCUMENT BASED ON TEMPLATE
 *****************************************************************************/

$l_button["make_new_document"]["value"] = "New document";
$l_button["make_new_document"]["alt"] = "Create new document";
$l_button["make_new_document"]["width"] = 125;

/*****************************************************************************
 * SUPER-EASY-EDIT-MODE
 *****************************************************************************/

$l_button["preview"]["value"] = "Preview";
$l_button["preview"]["alt"] = "Show preview";
$l_button["preview"]["width"] = 100;

$l_button["properties"]["value"] = "Properties";
$l_button["properties"]["alt"] = "Show properties";
$l_button["properties"]["width"] = 100;

$l_button["thumbnails"]["value"] = "Thumbnails";
$l_button["thumbnails"]["alt"]   = "Show thumbnails";
$l_button["thumbnails"]["width"] = 100;

$l_button["shopVariants"]["value"] = "Variants";
$l_button["shopVariants"]["alt"] = "Edit variants";
$l_button["shopVariants"]["width"] = 100;

/*****************************************************************************
 * DOCUMENT TYPES
 *****************************************************************************/

$l_button["new_doctype"]["value"] = "New document type";
$l_button["new_doctype"]["alt"] = "Create a new document type";
$l_button["new_doctype"]["width"] = 174;

$l_button["delete_doctype"]["value"] = "Delete document type";
$l_button["delete_doctype"]["alt"] = "Delete the selected document type";
$l_button["delete_doctype"]["width"] = 174;

/*****************************************************************************
 * XML
 *****************************************************************************/

$l_button["import"]["value"] = "Import";
$l_button["import"]["alt"]   = "Import selected file";
$l_button["import"]["width"] = 100;

$l_button["export"]["value"] = "Export";
$l_button["export"]["alt"]   = "Export selected files";
$l_button["export"]["width"] = 100;

$l_button["browse"]["value"] = "Browse";
$l_button["browse"]["alt"] = "Browse directory";
$l_button["browse"]["width"] = 100;

/*****************************************************************************
 * FILE-SELECTOR
 *****************************************************************************/

$l_button["root_dir"]["value"] = "/";
$l_button["root_dir"]["alt"]   = "Go to the root directory";
$l_button["root_dir"]["width"] = 40;


/*****************************************************************************
 * UPLOAD-DIALOG
 *****************************************************************************/

$l_button["upload"]["value"] = "Upload";
$l_button["upload"]["alt"]   = "Upload file";
$l_button["upload"]["width"] = 100;

$l_button["close"]["value"] = "Close";
$l_button["close"]["alt"]   = "Closes this window";
$l_button["close"]["width"] = 100;

$l_button["overwrite"]["value"] = "Overwrite";
$l_button["overwrite"]["alt"]   = "Overwrite file";
$l_button["overwrite"]["width"] = 100;

$l_button["newName"]["value"] = "New name";
$l_button["newName"]["alt"]   = "Insert a new name";
$l_button["newName"]["width"] = 100;


/*****************************************************************************
 * PREFERENCES
 *****************************************************************************/

$l_button["add_languages"]["value"] = "Add languages";
$l_button["add_languages"]["alt"]   = "Installs other languages for webEdition";
$l_button["add_languages"]["width"] = 175;

$l_button["apply_current_dimension"]["value"] = "Apply current dimension";
$l_button["apply_current_dimension"]["alt"]   = "Applies the current size of the webEdition window";
$l_button["apply_current_dimension"]["width"] = 175;

$l_button["res_800"]["value"] = "800x600";
$l_button["res_800"]["alt"]   = "Set 800x600";
$l_button["res_800"]["width"] = 100;

$l_button["res_1024"]["value"] = "1024x768";
$l_button["res_1024"]["alt"]   = "Set 1024x768";
$l_button["res_1024"]["width"] = 100;

$l_button["res_1280"]["value"] = "1280x960";
$l_button["res_1280"]["alt"]   = "Set 1280x960";
$l_button["res_1280"]["width"] = 100;

$l_button["res_1600"]["value"] = "1600x1200";
$l_button["res_1600"]["alt"]   = "Set 1600x1200";
$l_button["res_1600"]["width"] = 100;

$l_button["apply_current_editor_dimension"]["value"] = "Apply current dimension";
$l_button["apply_current_editor_dimension"]["alt"]   = "Applies the current size of the editor";
$l_button["apply_current_editor_dimension"]["width"] = 175;

$l_button["res_500"]["value"] = "500x300";
$l_button["res_500"]["alt"]   = "Set 500x300";
$l_button["res_500"]["width"] = 100;

$l_button["res_700"]["value"] = "700x320";
$l_button["res_700"]["alt"]   = "Set 700x320";
$l_button["res_700"]["width"] = 100;

$l_button["res_960"]["value"] = "960x420";
$l_button["res_960"]["alt"]   = "Set 960x420";
$l_button["res_960"]["width"] = 100;

$l_button["res_1300"]["value"] = "1300x650";
$l_button["res_1300"]["alt"]   = "Set 1300x650";
$l_button["res_1300"]["width"] = 100;


/*****************************************************************************
 * Rebuild
 *****************************************************************************/

$l_button["rebuild"]["value"] = "Rebuild";
$l_button["rebuild"]["alt"]   = "Start rebuild";
$l_button["rebuild"]["width"] = 100;

/*****************************************************************************
 * UPDATE
 *****************************************************************************/

$l_button["demoversion"]["value"] = "Demo version";
$l_button["demoversion"]["alt"]   = "";
$l_button["demoversion"]["width"] = 100;

$l_button["register"]["value"] = "Register";
$l_button["register"]["alt"]   = "";
$l_button["register"]["width"] = 100;

$l_button["backup"]["value"] = "Backup";
$l_button["backup"]["alt"]   = "";
$l_button["backup"]["width"] = 100;

$l_button["search"]["value"] = "Search";
$l_button["search"]["alt"]   = "";
$l_button["search"]["width"] = 100;

/*****************************************************************************
 * Backup
 *****************************************************************************/

$l_button["restore_backup"]["value"] = "Recover Backup";
$l_button["restore_backup"]["alt"]   = "";
$l_button["restore_backup"]["width"] = 180;

$l_button["make_backup"]["value"] = "Create Backup";
$l_button["make_backup"]["alt"]   = "";
$l_button["make_backup"]["width"] = 150;

$l_button["delete_backup"]["value"] = "Delete backup file";
$l_button["delete_backup"]["alt"]   = "Delete selected backup file";
$l_button["delete_backup"]["width"] = 150;

/*****************************************************************************
 * Thumbnails
 *****************************************************************************/

$l_button["edit_all_thumbs"]["value"] = "Edit thumbnails...";
$l_button["edit_all_thumbs"]["alt"]   = "";
$l_button["edit_all_thumbs"]["width"] = 150;

/*****************************************************************************
 * Navigation
 *****************************************************************************/
$l_button["new_item"]["value"] = "New item";
$l_button["new_item"]["alt"]   = "";
$l_button["new_item"]["width"] = 200;

$l_button["new_folder"]["value"] = "New folder";
$l_button["new_folder"]["alt"]   = "";
$l_button["new_folder"]["width"] = 200;

/*****************************************************************************
 * Logbuch Formmail
 *****************************************************************************/
$l_button["clear_log"]["value"] = "Clear logbook";
$l_button["clear_log"]["alt"] = "";
$l_button["clear_log"]["width"] = 120;

$l_button["logbook"]["value"] = "Logbook";
$l_button["logbook"]["alt"]   = "";
$l_button["logbook"]["width"] = 100;

/*****************************************************************************
 * Info
 *****************************************************************************/
$l_button["revert_published"]["value"] = "Restore published version";
$l_button["revert_published"]["alt"] = "Discard changes and restore published version.";
$l_button["revert_published"]["width"] = 220;

?>