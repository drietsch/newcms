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
 * Language file: we_editor.inc.php
 * Provides language strings.
 * Language: English
 */
$l_we_editor["doubble_field_alert"] = "The field '%s' already exists! A field name must be unique!"; // TRANSLATE
$l_we_editor["variantNameInvalid"] = "The name of an article variant can not be empty!"; // TRANSLATE

$l_we_editor["folder_save_nok_parent_same"] = "Le r�pertoire-parent est dans le r�pertoire actuel! S'il vous pla�t choisissez un autre r�pertoire et essayez de nouveau!";
$l_we_editor["pfolder_notsave"] = "Le r�pertoire ne peut pas �tre enregistr� dans le r�pertoir choisi!";
$l_we_editor["required_field_alert"] = "Le champ '%s' est obligatoire et doit �tre rempli!";

$l_we_editor["category"]["response_save_ok"] = "La cat�gorie '%s' a �t� enregistr� avec succ�s!";
$l_we_editor["category"]["response_save_notok"] = "Erreur en enregistrant la cat�gorie '%s'!";
$l_we_editor["category"]["response_path_exists"] = "La cat�gorie '%s' n'a pas pu �tre enregistr�, parce qu'il existe d�j� une cat�gorie � cet endroit!";
$l_we_editor["category"]["we_filename_notValid"] = "Le nom saisi n'est pas valid!\\nPermit sont tous les signes sauf \\\", ' / < > et \\\\";
$l_we_editor["category"]["filename_empty"]       = "The file name cannot be empty."; // TRANSLATE
$l_we_editor["category"]["name_komma"] = "Le nom saisi n'est pas valid!\\nDes virgule ne sont pas permit";

$l_we_editor["text/webedition"]["response_save_ok"] = "Le site-webEdition '%s' a �t� enregistr� avec succ�s!";
$l_we_editor["text/webedition"]["response_publish_ok"] = "Le site-webEdition '%s' a �t� publi� avec succ�s!";
$l_we_editor["text/webedition"]["response_publish_notok"] = "Erreur en publiant le site-webEdition '%s'!";
$l_we_editor["text/webedition"]["response_unpublish_ok"] = "Le site-webEdition '%s' a �t� depubli� avec succ�s!";
$l_we_editor["text/webedition"]["response_unpublish_notok"] = "Erreur en depubliant le site-webEdition '%s'!";
$l_we_editor["text/webedition"]["response_not_published"] = "Le site-webEdition '%s' n'est pas publi�!";
$l_we_editor["text/webedition"]["response_save_notok"] = "Erreur en enregistrant le site-webEdition '%s'!";
$l_we_editor["text/webedition"]["response_path_exists"] = "Le site-webEdition '%s' ne pouvait pas �tre enregistr�, parce qu'il existe d�j� un autre fichier ou un autre r�pertoire a cet endroit!";
$l_we_editor["text/webedition"]["filename_empty"] = "Vous n'avez pas encore saisi un nom pour le fichier!";
$l_we_editor["text/webedition"]["we_filename_notValid"] = "Le nom saisi pour le fichier n'est pas valide!\\nSignes permis sont les lettres de a � z (majuscule- ou minuscule) , nombres, soulignage (_), signe moins (-), point (.)";
$l_we_editor["text/webedition"]["we_filename_notAllowed"] = "Le nom du fichier n'est pas permis!";
$l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"] = "Le fichier n'a pas pu �tre enregistr�, parce que vous n'avez pas les droits n�cessaires, pour cr�er des nouveaux r�pertoire (%s)!";
$l_we_editor["text/webedition"]["autoschedule"] = "Le site-webEdition sera publi� automatiquement le %s!";

$l_we_editor["text/html"]["response_save_ok"] = "Le site-HTML '%s' a �t� enregistr� avec succ�s!";
$l_we_editor["text/html"]["response_publish_ok"] = "Le site-HTML '%s' a �t� publi� avec succ�s!";
$l_we_editor["text/html"]["response_publish_notok"] = "Erreur en publiant le site-HTML '%s'!";
$l_we_editor["text/html"]["response_unpublish_ok"] = "Le site-HTML '%s' a �t� depubli� avec succ�s!";
$l_we_editor["text/html"]["response_unpublish_notok"] = "Erreur en depubliant le site-HTML '%s'!";
$l_we_editor["text/html"]["response_not_published"] = "Le site-HTML '%s' n'est pas publi�!";
$l_we_editor["text/html"]["response_save_notok"] = "Erreur en enregistrant le site-HTML '%s'!";
$l_we_editor["text/html"]["response_path_exists"] = "Le site-HTML '%s' n'a pas pu �tre enregistr�, parce qu'il existe d�j� un autre fichier ou un autre r�pertoire a cet endroit!";
$l_we_editor["text/html"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/html"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/html"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/html"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];
$l_we_editor["text/html"]["autoschedule"] = "The HTML page will be published automatically on %s.";

$l_we_editor["text/weTmpl"]["response_save_ok"] = "Le mod�le '%s' a �t� enregistr� avec succ�s!";
$l_we_editor["text/weTmpl"]["response_publish_ok"] = "Le mod�le '%s' a �t� publi� avec succ�s!";
$l_we_editor["text/weTmpl"]["response_unpublish_ok"] = "Le mod�le '%s' a �t� depubli� avec succ�s!";
$l_we_editor["text/weTmpl"]["response_save_notok"] = "Erreur en enregistrant le mod�le '%s'!";
$l_we_editor["text/weTmpl"]["response_path_exists"] = "Le mod�le '%s' n'a pas pu �tre enregistr�, parce qu'il existe d�j� un autre fichier ou un autre r�pertoire a cet endroit!";
$l_we_editor["text/weTmpl"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/weTmpl"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/weTmpl"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/weTmpl"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];
$l_we_editor["text/weTmpl"]["no_template_save"] = "Templates " . "can " . "not " . "saved " . "in the " . "de" . "mo" . " of" . " webEdition.";

$l_we_editor["text/css"]["response_save_ok"] = "Le feuille de style CSS '%s' a �t� enregistr� avec succ�s!";
$l_we_editor["text/css"]["response_publish_ok"] = "Le feuille de style CSS '%s' a �t� publi� avec succ�s!";
$l_we_editor["text/css"]["response_unpublish_ok"] = "Le feuille de style CSS '%s' a �t� depubli� avec succ�s!";
$l_we_editor["text/css"]["response_save_notok"] = "Erreur en enregistrant le feuille de style CSS '%s'!";
$l_we_editor["text/css"]["response_path_exists"] = "Le feuille de style CSS '%s' ne pouvait pas �tre enregistr�, parce qu'il existe d�j� un autre fichier ou un autre r�pertoire a cet endroit!";
$l_we_editor["text/css"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/css"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/css"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/css"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["text/js"]["response_save_ok"] = "The JavaScript '%s' has been successfully saved!";
$l_we_editor["text/js"]["response_publish_ok"] = "Le Javascript '%s' a �t� publi� avec succ�s!";
$l_we_editor["text/js"]["response_unpublish_ok"] = "Le Javascript '%s' a �t� depubli� avec succ�s!";
$l_we_editor["text/js"]["response_save_notok"] = "Erreur en enregistrant le Javascripts '%s'!";
$l_we_editor["text/js"]["response_path_exists"] = "Le Javascript '%s' n'a pas pu �tre enregistr�, parce qu'il existe d�j� un autre fichier ou un autre r�pertoire a cet endroit!!";
$l_we_editor["text/js"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/js"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/js"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/js"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["text/plain"]["response_save_ok"] = "The text file '%s' has been successfully saved!";
$l_we_editor["text/plain"]["response_publish_ok"] = "Le fichier texte '%s' a �t� publi� avec succ�s!";
$l_we_editor["text/plain"]["response_unpublish_ok"] = "Le fichier texte '%s' a �t� depubli� avec succ�s!";
$l_we_editor["text/plain"]["response_save_notok"] = "Erreur en enregistrant le fichier texte '%s'!";
$l_we_editor["text/plain"]["response_path_exists"] = "Le fichier texte '%s' n'a pas pu �tre enregistr�, parce qu'il existe d�j� un autre fichier ou un autre r�pertoire a cet endroit!";
$l_we_editor["text/plain"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/plain"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/plain"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/plain"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["text/xml"]["response_save_ok"] = "The XML file '%s' has been successfully saved!";
$l_we_editor["text/xml"]["response_publish_ok"] = "The XML file '%s' has been successfully published!"; // TRANSLATE
$l_we_editor["text/xml"]["response_unpublish_ok"] = "The XML file '%s' has been successfully unpublished!"; // TRANSLATE
$l_we_editor["text/xml"]["response_save_notok"] = "Error while saving XML file '%s'!"; // TRANSLATE
$l_we_editor["text/xml"]["response_path_exists"] = "The XML file '%s' could not be saved because another document or directory is positioned at the same location!"; // TRANSLATE
$l_we_editor["text/xml"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/xml"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/xml"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/xml"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["folder"]["response_save_ok"] = "The directory '%s' has been successfully saved!";
$l_we_editor["folder"]["response_publish_ok"] = "Le r�pertoire '%s' a �t� publi� avec succ�s!";
$l_we_editor["folder"]["response_unpublish_ok"] = "Le r�pertoire '%s' a �t� depubli� avec succ�s!";
$l_we_editor["folder"]["response_save_notok"] = "Erreur en enregistrant le r�pertoire '%s'!";
$l_we_editor["folder"]["response_path_exists"] = "Le r�pertoire '%s' n'a pas pu �tre enregistr�, parce qu'il existe d�j� un autre fichier ou un autre r�pertoire a cet endroit!";
$l_we_editor["folder"]["filename_empty"] = "Vous n'avez pas encore saisi un nom pour le r�pertoire!";
$l_we_editor["folder"]["we_filename_notValid"] = "Le nom saisi pour le r�pertoire n'est pas valide!\\nSignes permis sont les lettres de a � z (majuscule- ou minuscule) , nombres, soulignage (_), signe moins (-), point (.)";
$l_we_editor["folder"]["we_filename_notAllowed"] = "Le nom du r�pertoire n'est pas permis!";
$l_we_editor["folder"]["response_save_noperms_to_create_folders"] = "Le r�pertoire n'a pas pu �tre enregistr�, parce que vous n'avez pas les droits n�cessaires, pour cr�er des nouveaux r�pertoire (%s)!";

$l_we_editor["image/*"]["response_save_ok"] = "La graphique '%s' a �t� enregistr�e avec succ�s!";
$l_we_editor["image/*"]["response_publish_ok"] = "La graphique '%s' a �t� publi�e avec succ�s!";
$l_we_editor["image/*"]["response_unpublish_ok"] = "La graphique '%s' a �t� depubli�e avec succ�s!";
$l_we_editor["image/*"]["response_save_notok"] = "Erreur en enregistrant la graphique '%s'!";
$l_we_editor["image/*"]["response_path_exists"] = "La graphique '%s' n'a pas pu �tre enregistr�e, parce qu'il existe d�j� un autre fichier ou un autre r�pertoire a cet endroit!";
$l_we_editor["image/*"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["image/*"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["image/*"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["image/*"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["application/*"]["response_save_ok"] = "The document '%s' has been successfully saved!";
$l_we_editor["application/*"]["response_publish_ok"] = "Le fichier '%s' a �t� publi� avec succ�s!";
$l_we_editor["application/*"]["response_unpublish_ok"] = "Le fichier '%s' a �t� depubli� avec succ�s!";
$l_we_editor["application/*"]["response_save_notok"] = "Erreur en enregistrant le fichier '%s'!";
$l_we_editor["application/*"]["response_path_exists"] = "Le fichier '%s' n''a pas pu �tre enregistr�, parce qu'il existe d�j� un autre fichier ou un autre r�pertoire a cet endroit!";
$l_we_editor["application/*"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["application/*"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["application/*"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["application/*"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];
$l_we_editor["application/*"]["we_description_missing"] = "Please enter a desription in the 'Desription' field!";
$l_we_editor["application/*"]["response_save_wrongExtension"] =  "Erreur en enregistrant '%s' \\nL'extension de fichier '%s' n'est pas valide pour des fichiers divers!\\nPour cela cr�er s'il vous pla�t un fichier html!";

$l_we_editor["application/x-shockwave-flash"]["response_save_ok"] = "Le vid�o-Flash '%s' a �t� enregistr� avec succ�s!";
$l_we_editor["application/x-shockwave-flash"]["response_publish_ok"] = "Le vid�o-Flash '%s' a �t� publi� avec succ�s!";
$l_we_editor["application/x-shockwave-flash"]["response_unpublish_ok"] = "Le vid�o-Flash '%s' a �t� depubli� avec succ�s!";
$l_we_editor["application/x-shockwave-flash"]["response_save_notok"] = "Erreur en enregistrant le vid�o-Flash '%s'!";
$l_we_editor["application/x-shockwave-flash"]["response_path_exists"] = "Le vid�o-Flash '%s' n'a pas pu �tre enregistr�, parce qu'il existe d�j� un autre fichier ou un autre r�pertoire a cet endroit!";
$l_we_editor["application/x-shockwave-flash"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["application/x-shockwave-flash"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["application/x-shockwave-flash"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["application/x-shockwave-flash"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["video/quicktime"]["response_save_ok"] = "The Quicktime movie '%s' has been successfully saved!";
$l_we_editor["video/quicktime"]["response_publish_ok"] = "Le film-Quicktime '%s' a �t� publi� avec succ�s!";
$l_we_editor["video/quicktime"]["response_unpublish_ok"] = "Le film-Quicktime '%s' a �t� depubli� avec succ�s!";
$l_we_editor["video/quicktime"]["response_save_notok"] = "Erreur en enregistrant le film-Quicktime '%s'!";
$l_we_editor["video/quicktime"]["response_path_exists"] = "Le film-Quicktime '%s' n'a pas pu �tre enregistr�, parce qu'il existe d�j� un autre fichier ou un autre r�pertoire a cet endroit!";
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