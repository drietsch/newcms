<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


/**
 * Language file: SEEM.inc.php
 * Provides language strings.
 * Language: English
 */
$l_we_SEEM["ext_doc_selected"] = "You have selected a link which points to a document that is not administered by webEdition. Continue?";
$l_we_SEEM["ext_document_on_other_server_selected"] = "You have chosen a link which points to a document on another Web server.\\nThis will open in a new browser window. Continue?";
$l_we_SEEM["ext_form_target_other_server"] = "You are about to submit a form to another Web server.\\nThis will open in a new window. Continue? ";
$l_we_SEEM["ext_form_target_we_server"] = "The form will send data to a document, which is not not administered by webEdition.\\nContinue?";

$l_we_SEEM["ext_doc"] = "The current document: <b>%s</b> is <u>not</u> editable with webEdition.";
$l_we_SEEM["ext_doc_not_found"] = "Could not find the selected page <b>%s</b>.";
$l_we_SEEM["ext_doc_tmp"] = "This document was not opened correctly by webEdition. Please use the normal navigation of the website to reach your desired document.";

$l_we_SEEM["info_ext_doc"] = "No webEdition link";
$l_we_SEEM["info_doc_with_parameter"] = "Link with parameter";
$l_we_SEEM["link_does_not_work"] = "This link is deactivated in the preview mode. Please use the main navigation to move on the page.";
$l_we_SEEM["info_link_does_not_work"] = "Deactivated.";

$l_we_SEEM["open_link_in_SEEM_edit_include"] = "You are about to change the content of the webEdition main window. This window will be closed. Continue?";

//  Used in we_info.inc.php
$l_we_SEEM["start_mode"] = "Mode";
$l_we_SEEM["start_mode_normal"] = "Normal";
$l_we_SEEM["start_mode_seem"] = "seeMode";

//	When starting webedition in SEEMode
$l_we_SEEM["start_with_SEEM_no_startdocument"] = "You have not the required permissions to open the Cockpit. Your administrator can assign a valid start document in the user settings to you.";
$l_we_SEEM["only_seem_mode_allowed"] = "You do not have the required permissions to start webEdition in normal mode.\\nStarting seeMode instead ...";

//	Workspace - the SEEM startdocument
$l_we_SEEM["workspace_seem_startdocument"] = "Start document<br>for seeMode";

//	Desired document is locked by another user
$l_we_SEEM["try_doc_again"] = "Try again";

//	no permission to work with document
$l_we_SEEM["no_permission_to_work_with_document"] = "You do not have permission to edit this document.";

//	started seem with no startdocument - can select startdocument.
$l_we_SEEM["question_change_startdocument"] = "You have not the required permissions to open the Cockpit. Do you want to select a valid start document in the preferences dialogue now?";

//	started seem with no startdocument - can select startdocument.
$l_we_SEEM["no_permission_to_edit_document"] = "You do not have permission to edit this document.";

$l_we_SEEM["confirm"]["change_to_preview"] = "Do you want switch back to preview?";

$l_we_SEEM["alert"]["changed_include"] = "An included file has been changed. Main document is reloaded.";
$l_we_SEEM["alert"]["close_include"] = "This file is no webEdition document. The include window is closed.";
?>