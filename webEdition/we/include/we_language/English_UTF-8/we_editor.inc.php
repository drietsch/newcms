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
 * Language file: we_editor.inc.php
 * Provides language strings.
 * Language: English
 */
$l_we_editor["doubble_field_alert"] = "The field '%s' already exists! A field name must be unique!";
$l_we_editor["variantNameInvalid"] = "The name of an article variant can not be empty!";

$l_we_editor["folder_save_nok_parent_same"] = "The chosen parent directory is within the actual directory! Please choose another directory and try again!";
$l_we_editor["pfolder_notsave"] = "The directory cannot be saved in the chosen directory!";
$l_we_editor["required_field_alert"] = "The field '%s' is required and must be filled!";

$l_we_editor["category"]["response_save_ok"] = "The category '%s' has been successfully saved!";
$l_we_editor["category"]["response_save_notok"] = "Error while saving category '%s'!";
$l_we_editor["category"]["response_path_exists"] = "The category '%s' could not be saved because another category is positioned at the same location!";
$l_we_editor["category"]["we_filename_notValid"] = 'Invalid name!\n", \' / < > and \\\\ are not allowed!';
$l_we_editor["category"]["filename_empty"]       = "The file name cannot be empty.";
$l_we_editor["category"]["name_komma"] = "Invalid name! A comma is not allowed!";

$l_we_editor["text/webedition"]["response_save_ok"] = "The webEdition page '%s' has been successfully saved!";
$l_we_editor["text/webedition"]["response_publish_ok"] = "The webEdition page '%s' has been successfully published!";
$l_we_editor["text/webedition"]["response_publish_notok"] = "Error while publishing webEdition page '%s'!";
$l_we_editor["text/webedition"]["response_unpublish_ok"] = "The webEdition page '%s' has been successfully unpublished!";
$l_we_editor["text/webedition"]["response_unpublish_notok"] = "Error while unpublishing webEdition page '%s'!";
$l_we_editor["text/webedition"]["response_not_published"] = "The webEdition page '%s' is not published!";
$l_we_editor["text/webedition"]["response_save_notok"] = "Error while saving webEdition page '%s'!";
$l_we_editor["text/webedition"]["response_path_exists"] = "The webEdition page '%s' could not be saved because another document or directory is positioned at the same location!";
$l_we_editor["text/webedition"]["filename_empty"] = "No name has been entered for this document!";
$l_we_editor["text/webedition"]["we_filename_notValid"] = "Invalid file name\\nValid characters are alpha-numeric, upper and lower case, as well as underscore, hyphen and dot (a-z, A-Z, 0-9, _, -, .)";
$l_we_editor["text/webedition"]["we_filename_notAllowed"] = "The file name you have entered is not allowed!";
$l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"] = "The document could not be saved because you do not have the neccessary rights to create folders (%s)!";
$l_we_editor["text/webedition"]["autoschedule"] = "The webEdition page will be published automatically on %s.";

$l_we_editor["text/html"]["response_save_ok"] = "The HTML page '%s' has been successfully saved!";
$l_we_editor["text/html"]["response_publish_ok"] = "The HTML page '%s' has been successfully published!";
$l_we_editor["text/html"]["response_publish_notok"] = "Error while publishing HTML page '%s'!";
$l_we_editor["text/html"]["response_unpublish_ok"] = "The HTML page '%s' has been successfully unpublished!";
$l_we_editor["text/html"]["response_unpublish_notok"] = "Error while unpublishing HTML page '%s'!";
$l_we_editor["text/html"]["response_not_published"] = "The HTML page '%s' is not published!";
$l_we_editor["text/html"]["response_save_notok"] = "Error while saving HTML page '%s'!";
$l_we_editor["text/html"]["response_path_exists"] = "The HTML page '%s' could not be saved because another document or directory is positioned at the same location!";
$l_we_editor["text/html"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/html"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/html"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/html"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];
$l_we_editor["text/html"]["autoschedule"] = "The HTML page will be published automatically on %s.";

$l_we_editor["text/weTmpl"]["response_save_ok"] = "The template '%s' has been successfully saved!";
$l_we_editor["text/weTmpl"]["response_publish_ok"] = "The template'%s' has been successfully published!";
$l_we_editor["text/weTmpl"]["response_unpublish_ok"] = "The template '%s' has been successfully unpublished!";
$l_we_editor["text/weTmpl"]["response_save_notok"] = "Error while saving template '%s'!";
$l_we_editor["text/weTmpl"]["response_path_exists"] = "The template '%s' could not be saved because another document or directory is positioned at the same location!";
$l_we_editor["text/weTmpl"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/weTmpl"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/weTmpl"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/weTmpl"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];
$l_we_editor["text/weTmpl"]["no_template_save"] = "Templates " . "can " . "not " . "saved " . "in the " . "de" . "mo" . " of" . " webEdition.";

$l_we_editor["text/css"]["response_save_ok"] = "The style sheet '%s' has been successfully saved!";
$l_we_editor["text/css"]["response_publish_ok"] = "The style sheet '%s' has been successfully published!";
$l_we_editor["text/css"]["response_unpublish_ok"] = "The style sheet '%s' has been successfully unpublished!";
$l_we_editor["text/css"]["response_save_notok"] = "Error while saving style sheet '%s'!";
$l_we_editor["text/css"]["response_path_exists"] = "The style sheet '%s' could not be saved because another document or directory is positioned at the same location!";
$l_we_editor["text/css"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/css"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/css"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/css"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["text/js"]["response_save_ok"] = "The JavaScript '%s' has been successfully saved!";
$l_we_editor["text/js"]["response_publish_ok"] = "The JavaScript'%s' has been successfully published!";
$l_we_editor["text/js"]["response_unpublish_ok"] = "The JavaScript '%s' has been successfully unpublished!";
$l_we_editor["text/js"]["response_save_notok"] = "Error while saving JavaScript '%s'!";
$l_we_editor["text/js"]["response_path_exists"] = "The JavaScript '%s' could not be saved because another document or directory is positioned at the same location!";
$l_we_editor["text/js"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/js"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/js"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/js"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["text/plain"]["response_save_ok"] = "The text file '%s' has been successfully saved!";
$l_we_editor["text/plain"]["response_publish_ok"] = "The text file '%s' has been successfully published!";
$l_we_editor["text/plain"]["response_unpublish_ok"] = "The text file '%s' has been successfully unpublished!";
$l_we_editor["text/plain"]["response_save_notok"] = "Error while saving text file '%s'!";
$l_we_editor["text/plain"]["response_path_exists"] = "The text file '%s' could not be saved because another document or directory is positioned at the same location!";
$l_we_editor["text/plain"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/plain"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/plain"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/plain"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["text/xml"]["response_save_ok"] = "The XML file '%s' has been successfully saved!";
$l_we_editor["text/xml"]["response_publish_ok"] = "The XML file '%s' has been successfully published!";
$l_we_editor["text/xml"]["response_unpublish_ok"] = "The XML file '%s' has been successfully unpublished!";
$l_we_editor["text/xml"]["response_save_notok"] = "Error while saving XML file '%s'!";
$l_we_editor["text/xml"]["response_path_exists"] = "The XML file '%s' could not be saved because another document or directory is positioned at the same location!";
$l_we_editor["text/xml"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/xml"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/xml"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/xml"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["folder"]["response_save_ok"] = "The directory '%s' has been successfully saved!";
$l_we_editor["folder"]["response_publish_ok"] = "The directory '%s' has been successfully published!";
$l_we_editor["folder"]["response_unpublish_ok"] = "The directory '%s' has been successfully unpublished!";
$l_we_editor["folder"]["response_save_notok"] = "Error while saving directory '%s'!";
$l_we_editor["folder"]["response_path_exists"] = "The directory '%s' could not be saved because another document or directory is positioned at the same location!";
$l_we_editor["folder"]["filename_empty"] = "No name entered for this directory!";
$l_we_editor["folder"]["we_filename_notValid"] = "Invalid folder name\\nValid characters are alpha-numeric, upper and lower case, as well as underscore, hyphen and dot (a-z, A-Z, 0-9, _, -, .)";
$l_we_editor["folder"]["we_filename_notAllowed"] = "The name entered for the directory is not allowed!";
$l_we_editor["folder"]["response_save_noperms_to_create_folders"] = "The directory could not be saved because you do not have the neccessary rights to create folders (%s)!";

$l_we_editor["image/*"]["response_save_ok"] = "The image '%s' has been successfully saved!";
$l_we_editor["image/*"]["response_publish_ok"] = "The image '%s' has been successfully published!";
$l_we_editor["image/*"]["response_unpublish_ok"] = "The image '%s' has been successfully unpublished!";
$l_we_editor["image/*"]["response_save_notok"] = "Error while saving image '%s'!";
$l_we_editor["image/*"]["response_path_exists"] = "The image '%s' could not be saved because another document or directory is positioned at the same location!";
$l_we_editor["image/*"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["image/*"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["image/*"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["image/*"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["application/*"]["response_save_ok"] = "The document '%s' has been successfully saved!";
$l_we_editor["application/*"]["response_publish_ok"] = "The document '%s' has been successfully published!";
$l_we_editor["application/*"]["response_unpublish_ok"] = "The document '%s' has been successfully unpublished!";
$l_we_editor["application/*"]["response_save_notok"] = "Error while saving document '%s'!";
$l_we_editor["application/*"]["response_path_exists"] = "The document '%s' could not be saved because another document or directory is positioned at the same location!";
$l_we_editor["application/*"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["application/*"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["application/*"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["application/*"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];
$l_we_editor["application/*"]["we_description_missing"] = "Please enter a desription in the 'Desription' field!";
$l_we_editor["application/*"]["response_save_wrongExtension"] =  "Error while saving '%s' \\nThe file extension '%s' is not valid for other files!\\nPlease create an HTML page for that purpose!";

$l_we_editor["application/x-shockwave-flash"]["response_save_ok"] = "The Flash movie '%s' has been successfully saved!";
$l_we_editor["application/x-shockwave-flash"]["response_publish_ok"] = "The Flash movie '%s' has been successfully published!";
$l_we_editor["application/x-shockwave-flash"]["response_unpublish_ok"] = "The Flash movie '%s' has been successfully unpublished!";
$l_we_editor["application/x-shockwave-flash"]["response_save_notok"] = "Error while saving Flash movie '%s'!";
$l_we_editor["application/x-shockwave-flash"]["response_path_exists"] = "The Flash movie '%s' could not be saved because another document or directory is positioned at the same location!";
$l_we_editor["application/x-shockwave-flash"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["application/x-shockwave-flash"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["application/x-shockwave-flash"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["application/x-shockwave-flash"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["video/quicktime"]["response_save_ok"] = "The Quicktime movie '%s' has been successfully saved!";
$l_we_editor["video/quicktime"]["response_publish_ok"] = "The Quicktime movie '%s' has been successfully published!";
$l_we_editor["video/quicktime"]["response_unpublish_ok"] = "The Quicktime movie '%s' has been successfully unpublished!";
$l_we_editor["video/quicktime"]["response_save_notok"] = "Error while saving Quicktime movie '%s'!";
$l_we_editor["video/quicktime"]["response_path_exists"] = "The Quicktime movie '%s' could not be saved because another document or directory is positioned at the same location!";
$l_we_editor["video/quicktime"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["video/quicktime"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["video/quicktime"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["video/quicktime"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

/*****************************************************************************
 * PLEASE DON'T TOUCH THE NEXT LINES
 * UNLESS YOU KNOW EXACTLY WHAT YOU ARE DOING!
 *****************************************************************************/

$_language_directory = $_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules";
$_directory = dir($_language_directory);

while (false !== ($entry = $_directory->read())) {
	if (ereg('_we_editor', $entry)) {
		include_once($_language_directory."/".$entry);
	}
}
?>