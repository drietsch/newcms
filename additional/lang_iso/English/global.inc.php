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
 * Language file: global.inc.php
 * Provides language strings.
 * Language: English
 */
include_once(dirname(__FILE__)."/enc_".basename(__FILE__));

$GLOBALS["l_global"]["new_link"] = "New Link"; // It is important to use the GLOBALS ARRAY because in linklists, the file is included in a function.
$GLOBALS["l_global"]["load_menu_info"] = "Loading Data!<br>This can take some time when loading several menu elements ...";
$GLOBALS["l_global"]["text"] = "Text";
$GLOBALS["l_global"]["yes"] = "Yes";
$GLOBALS["l_global"]["no"] = "No";
$GLOBALS["l_global"]["checked"] = "Checked";
$GLOBALS["l_global"]["max_file_size"] = "Maximum file size (in bytes)";
$GLOBALS["l_global"]["default"] = "Default";
$GLOBALS["l_global"]["values"] = "Values";
$GLOBALS["l_global"]["name"] = "Name";
$GLOBALS["l_global"]["type"] = "Type";
$GLOBALS["l_global"]["attributes"] = "Attributes";
$GLOBALS["l_global"]["formmailerror"] = "The form was not submitted because of the following reason:";
$GLOBALS["l_global"]["email_notallfields"] = "You have not filled all required fields!";
$GLOBALS["l_global"]["email_ban"] = "You do not have the rights to use this script!";
$GLOBALS["l_global"]["email_recipient_invalid"] = "The recipient's address is invalid!";
$GLOBALS["l_global"]["email_no_recipient"] = "The recipient's address does not exist!";
$GLOBALS["l_global"]["email_invalid"] = "Your <b>E-mail address</b> is invalid!";
$GLOBALS["l_global"]["captcha_invalid"] = "The entered security code is wrong!";
$GLOBALS["l_global"]["question"] = "Question";
$GLOBALS["l_global"]["warning"] = "Warning";
$GLOBALS["l_global"]["we_alert"] = "This function is not availabe in the demo version of webEdition!";
$GLOBALS["l_global"]["index_table"] = "Index table";
$GLOBALS["l_global"]["cannotconnect"] = "Cannot connect to the webEdition server!";
$GLOBALS["l_global"]["recipients"] = "Formmail recipients";
$GLOBALS["l_global"]["recipients_txt"] = "Please enter all E-mail addresses which should receive forms sent by the formmail function (&lt;we:form type=&quot;formmail&quot; ..&gt;). If you do not enter an E-mail address, you cannot send forms using the formmail function!";
$GLOBALS["l_global"]["std_mailtext_newObj"] = "A new object %s of class %s has been created!";
$GLOBALS["l_global"]["std_subject_newObj"] = "New object";
$GLOBALS["l_global"]["std_subject_newDoc"] = "New document";
$GLOBALS["l_global"]["std_mailtext_newDoc"] = "A new document %s has been created!";
$GLOBALS["l_global"]["std_subject_delObj"] = "Object deleted";
$GLOBALS["l_global"]["std_mailtext_delObj"] = "The object %s has been deleted!";
$GLOBALS["l_global"]["std_subject_delDoc"] = "Document deleted";
$GLOBALS["l_global"]["std_mailtext_delDoc"] = "The document %s has been deleted!";
$GLOBALS["l_global"]["we_make_same"]["text/html"] = "New page after saving";
$GLOBALS["l_global"]["we_make_same"]["text/webedition"] = $GLOBALS["l_global"]["we_make_same"]["text/html"];
$GLOBALS["l_global"]["we_make_same"]["objectFile"] = "New object after saving";
$GLOBALS["l_global"]["no_entries"] = "No entries found!";
$GLOBALS["l_global"]["save_temporaryTable"] = "Resave temporary documents";
$GLOBALS["l_global"]["save_mainTable"] = "Resave main database table";
$GLOBALS["l_global"]["add_workspace"] = "Add workspace";
$GLOBALS["l_global"]["folder_not_editable"] = "This directory cannot be chosen!";
$GLOBALS["l_global"]["modules"] = "Modules";
$GLOBALS["l_global"]["modules_and_tools"] = "Modules and Tools";
$GLOBALS["l_global"]["center"] = "Center";
$GLOBALS["l_global"]["jswin"] = "Pop-up window";
$GLOBALS["l_global"]["open"] = "Open";
$GLOBALS["l_global"]["posx"] = "x position";
$GLOBALS["l_global"]["posy"] = "y position";
$GLOBALS["l_global"]["status"] = "Status";
$GLOBALS["l_global"]["scrollbars"] = "Scroll bars";
$GLOBALS["l_global"]["menubar"] = "Menu bar";
$GLOBALS["l_global"]["toolbar"] = "Toolbar";
$GLOBALS["l_global"]["resizable"] = "Resizable";
$GLOBALS["l_global"]["location"] = "Location";
$GLOBALS["l_global"]["title"] = "Title";
$GLOBALS["l_global"]["description"] = "Description";
$GLOBALS["l_global"]["required_field"] = "Required field";
$GLOBALS["l_global"]["from"] = "From";
$GLOBALS["l_global"]["to"] = "To";
$GLOBALS["l_global"]["search"]="Search";
$GLOBALS["l_global"]["in"]="in";
$GLOBALS["l_global"]["we_rebuild_at_save"] = "Automatic rebuild";
$GLOBALS["l_global"]["we_publish_at_save"] = "Publish after saving";
$GLOBALS["l_global"]["we_new_doc_after_save"] = "New Document after saving";
$GLOBALS["l_global"]["we_new_folder_after_save"] = "New folder after saving";
$GLOBALS["l_global"]["we_new_entry_after_save"] = "New entry after saving";
$GLOBALS["l_global"]["wrapcheck"] = "Wrapping";
$GLOBALS["l_global"]["static_docs"] = "Static documents";
$GLOBALS["l_global"]["save_templates_before"] = "Save templates in advance";
$GLOBALS["l_global"]["specify_docs"] = "Documents with following criteria";
$GLOBALS["l_global"]["object_docs"] = "All objects";
$GLOBALS["l_global"]["all_docs"] = "All documents";
$GLOBALS["l_global"]["ask_for_editor"] = "Ask for editor";
$GLOBALS["l_global"]["cockpit"] = "Cockpit";
$GLOBALS["l_global"]["introduction"] = "Introduction";
$GLOBALS["l_global"]["doctypes"] = "Document types";
$GLOBALS["l_global"]["content"] = "Content";
$GLOBALS["l_global"]["site_not_exist"] = "Page does not exist!";
$GLOBALS["l_global"]["site_not_published"] = "Page not yet published!";
$GLOBALS["l_global"]["required"] = "Entry required";
$GLOBALS["l_global"]["all_rights_reserved"] = "All rights reserved";
$GLOBALS["l_global"]["width"] = "Width";
$GLOBALS["l_global"]["height"] = "Height";
$GLOBALS["l_global"]["new_username"] = "New user name";
$GLOBALS["l_global"]["username"] = "User name";
$GLOBALS["l_global"]["password"] = "Password";
$GLOBALS["l_global"]["documents"] = "Documents";
$GLOBALS["l_global"]["templates"] = "Templates";
$GLOBALS["l_global"]["objects"] = "Objects";
$GLOBALS["l_global"]["licensed_to"] = "Licensed to";
$GLOBALS["l_global"]["left"] = "Left";
$GLOBALS["l_global"]["right"] = "Right";
$GLOBALS["l_global"]["top"] = "Top";
$GLOBALS["l_global"]["bottom"] = "Bottom";
$GLOBALS["l_global"]["topleft"] = "Top left";
$GLOBALS["l_global"]["topright"] = "Top right";
$GLOBALS["l_global"]["bottomleft"] = "Bottom left";
$GLOBALS["l_global"]["bottomright"] = "Bottom right";
$GLOBALS["l_global"]["true"] = "Yes";
$GLOBALS["l_global"]["false"] = "No";
$GLOBALS["l_global"]["showall"] = "Show all";
$GLOBALS["l_global"]["noborder"] = "No border";
$GLOBALS["l_global"]["border"] = "Border";
$GLOBALS["l_global"]["align"] = "Alignment";
$GLOBALS["l_global"]["hspace"] = "Hspace";
$GLOBALS["l_global"]["vspace"] = "Vspace";
$GLOBALS["l_global"]["exactfit"] = "Exact fit";
$GLOBALS["l_global"]["select_color"] = "Select color";
$GLOBALS["l_global"]["changeUsername"] = "Change user name";
$GLOBALS["l_global"]["changePass"] = "Change password";
$GLOBALS["l_global"]["oldPass"] = "Old password";
$GLOBALS["l_global"]["newPass"] = "New password";
$GLOBALS["l_global"]["newPass2"] = "Repeat new password";
$GLOBALS["l_global"]["pass_not_confirmed"] = "The entries do not match!";
$GLOBALS["l_global"]["pass_not_match"] = "Old password incorrect!";
$GLOBALS["l_global"]["passwd_not_match"] = "The passwords do not match!";
$GLOBALS["l_global"]["pass_to_short"] = "Passwords must have at least 4 characters!";
$GLOBALS["l_global"]["pass_changed"] = "Password successfully changed!";
$GLOBALS["l_global"]["pass_wrong_chars"] = "Passwords may only contain alpha-numeric characters (a-z, A-Z and 0-9)!";
$GLOBALS["l_global"]["username_wrong_chars"] = "Username may only contain alpha-numeric characters (a-z, A-Z and 0-9) and '.', '_' or '-'!";
$GLOBALS["l_global"]["all"] = "All";
$GLOBALS["l_global"]["selected"] = "Selected";
$GLOBALS["l_global"]["username_to_short"] = "The user name must have at least 4 characters!";
$GLOBALS["l_global"]["username_changed"] = "User name successfully changed!";
$GLOBALS["l_global"]["published"] = "Published";
$GLOBALS["l_global"]["help_welcome"] = "Welcome to webEdition Help";
$GLOBALS["l_global"]["edit_file"] = "Edit file";
$GLOBALS["l_global"]["docs_saved"] = "Documents successfully saved!";
$GLOBALS["l_global"]["preview"] = "Preview";
$GLOBALS["l_global"]["close"] = "Close window";
$GLOBALS["l_global"]["loginok"] =  "<strong>Login ok! Please wait!</strong><br>webEdition will open up in a new window. If that window does not open up, make sure that you have not blocked pop-up windows in your browser!";
$GLOBALS["l_global"]["apple"] = "&#x2318;";
$GLOBALS["l_global"]["shift"] = "SHIFT";
$GLOBALS["l_global"]["ctrl"] = "CTRL";
$GLOBALS["l_global"]["required_fields"] = "Required fields";
$GLOBALS["l_global"]["no_file_uploaded"] = "<p class=\"defaultfont\">At the moment no document is uploaded.</p>";
$GLOBALS["l_global"]["openCloseBox"] = "Open/Close";
$GLOBALS["l_global"]["rebuild"] = "Rebuild";
$GLOBALS["l_global"]["welcome_to_we"] = "Welcome to webEdition 4";
$GLOBALS["l_global"]["tofit"] = "Welcome to webEdition 4";
$GLOBALS["l_global"]["unlocking_document"] = "unlocking doocument";
$GLOBALS["l_global"]["variant_field"] = "Variant field";
$GLOBALS["l_global"]["redirect_to_login_failed"] = "Please press the following link, if you are not redirected within the next 30 seconds ";
$GLOBALS["l_global"]["redirect_to_login_name"] = "webEdition login";
$GLOBALS["l_global"]["untitled"] = "Untitled";
$GLOBALS["l_global"]["no_document_opened"] = "There is no document opened!";
?>