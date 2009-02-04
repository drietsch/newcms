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
 * Language file: we_editor.inc.php
 * Provides language strings.
 * Language: English
 */
$l_we_editor["doubble_field_alert"] = "The field '%s' already exists! A field name must be unique!"; // TRANSLATE
$l_we_editor["variantNameInvalid"] = "The name of an article variant can not be empty!"; // TRANSLATE

$l_we_editor["folder_save_nok_parent_same"] = "Le répertoire-parent est dans le répertoire actuel! S'il vous plaît choisissez un autre répertoire et essayez de nouveau!";
$l_we_editor["pfolder_notsave"] = "Le répertoire ne peut pas être enregistré dans le répertoir choisi!";
$l_we_editor["required_field_alert"] = "Le champ '%s' est obligatoire et doit être rempli!";

$l_we_editor["category"]["response_save_ok"] = "La catégorie '%s' a été enregistré avec succès!";
$l_we_editor["category"]["response_save_notok"] = "Erreur en enregistrant la catégorie '%s'!";
$l_we_editor["category"]["response_path_exists"] = "La catégorie '%s' n'a pas pu être enregistré, parce qu'il existe déjà une catégorie à cet endroit!";
$l_we_editor["category"]["we_filename_notValid"] = "Le nom saisi n'est pas valid!\\nPermit sont tous les signes sauf \\\", ' / < > et \\\\";
$l_we_editor["category"]["filename_empty"]       = "The file name cannot be empty."; // TRANSLATE
$l_we_editor["category"]["name_komma"] = "Le nom saisi n'est pas valid!\\nDes virgule ne sont pas permit";

$l_we_editor["text/webedition"]["response_save_ok"] = "Le site-webEdition '%s' a été enregistré avec succès!";
$l_we_editor["text/webedition"]["response_publish_ok"] = "Le site-webEdition '%s' a été publié avec succès!";
$l_we_editor["text/webedition"]["response_publish_notok"] = "Erreur en publiant le site-webEdition '%s'!";
$l_we_editor["text/webedition"]["response_unpublish_ok"] = "Le site-webEdition '%s' a été depublié avec succès!";
$l_we_editor["text/webedition"]["response_unpublish_notok"] = "Erreur en depubliant le site-webEdition '%s'!";
$l_we_editor["text/webedition"]["response_not_published"] = "Le site-webEdition '%s' n'est pas publié!";
$l_we_editor["text/webedition"]["response_save_notok"] = "Erreur en enregistrant le site-webEdition '%s'!";
$l_we_editor["text/webedition"]["response_path_exists"] = "Le site-webEdition '%s' ne pouvait pas être enregistré, parce qu'il existe déjà un autre fichier ou un autre répertoire a cet endroit!";
$l_we_editor["text/webedition"]["filename_empty"] = "Vous n'avez pas encore saisi un nom pour le fichier!";
$l_we_editor["text/webedition"]["we_filename_notValid"] = "Le nom saisi pour le fichier n'est pas valide!\\nSignes permis sont les lettres de a à z (majuscule- ou minuscule) , nombres, soulignage (_), signe moins (-), point (.)";
$l_we_editor["text/webedition"]["we_filename_notAllowed"] = "Le nom du fichier n'est pas permis!";
$l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"] = "Le fichier n'a pas pu être enregistré, parce que vous n'avez pas les droits nécessaires, pour créer des nouveaux répertoire (%s)!";
$l_we_editor["text/webedition"]["autoschedule"] = "Le site-webEdition sera publié automatiquement le %s!";

$l_we_editor["text/html"]["response_save_ok"] = "Le site-HTML '%s' a été enregistré avec succès!";
$l_we_editor["text/html"]["response_publish_ok"] = "Le site-HTML '%s' a été publié avec succès!";
$l_we_editor["text/html"]["response_publish_notok"] = "Erreur en publiant le site-HTML '%s'!";
$l_we_editor["text/html"]["response_unpublish_ok"] = "Le site-HTML '%s' a été depublié avec succès!";
$l_we_editor["text/html"]["response_unpublish_notok"] = "Erreur en depubliant le site-HTML '%s'!";
$l_we_editor["text/html"]["response_not_published"] = "Le site-HTML '%s' n'est pas publié!";
$l_we_editor["text/html"]["response_save_notok"] = "Erreur en enregistrant le site-HTML '%s'!";
$l_we_editor["text/html"]["response_path_exists"] = "Le site-HTML '%s' n'a pas pu être enregistré, parce qu'il existe déjà un autre fichier ou un autre répertoire a cet endroit!";
$l_we_editor["text/html"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/html"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/html"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/html"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];
$l_we_editor["text/html"]["autoschedule"] = "The HTML page will be published automatically on %s.";

$l_we_editor["text/weTmpl"]["response_save_ok"] = "Le modèle '%s' a été enregistré avec succès!";
$l_we_editor["text/weTmpl"]["response_publish_ok"] = "Le modèle '%s' a été publié avec succès!";
$l_we_editor["text/weTmpl"]["response_unpublish_ok"] = "Le modèle '%s' a été depublié avec succès!";
$l_we_editor["text/weTmpl"]["response_save_notok"] = "Erreur en enregistrant le modèle '%s'!";
$l_we_editor["text/weTmpl"]["response_path_exists"] = "Le modèle '%s' n'a pas pu être enregistré, parce qu'il existe déjà un autre fichier ou un autre répertoire a cet endroit!";
$l_we_editor["text/weTmpl"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/weTmpl"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/weTmpl"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/weTmpl"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];
$l_we_editor["text/weTmpl"]["no_template_save"] = "Templates " . "can " . "not " . "saved " . "in the " . "de" . "mo" . " of" . " webEdition.";

$l_we_editor["text/css"]["response_save_ok"] = "Le feuille de style CSS '%s' a été enregistré avec succès!";
$l_we_editor["text/css"]["response_publish_ok"] = "Le feuille de style CSS '%s' a été publié avec succès!";
$l_we_editor["text/css"]["response_unpublish_ok"] = "Le feuille de style CSS '%s' a été depublié avec succès!";
$l_we_editor["text/css"]["response_save_notok"] = "Erreur en enregistrant le feuille de style CSS '%s'!";
$l_we_editor["text/css"]["response_path_exists"] = "Le feuille de style CSS '%s' ne pouvait pas être enregistré, parce qu'il existe déjà un autre fichier ou un autre répertoire a cet endroit!";
$l_we_editor["text/css"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/css"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/css"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/css"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["text/js"]["response_save_ok"] = "The JavaScript '%s' has been successfully saved!";
$l_we_editor["text/js"]["response_publish_ok"] = "Le Javascript '%s' a été publié avec succès!";
$l_we_editor["text/js"]["response_unpublish_ok"] = "Le Javascript '%s' a été depublié avec succès!";
$l_we_editor["text/js"]["response_save_notok"] = "Erreur en enregistrant le Javascripts '%s'!";
$l_we_editor["text/js"]["response_path_exists"] = "Le Javascript '%s' n'a pas pu être enregistré, parce qu'il existe déjà un autre fichier ou un autre répertoire a cet endroit!!";
$l_we_editor["text/js"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/js"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/js"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/js"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["text/plain"]["response_save_ok"] = "The text file '%s' has been successfully saved!";
$l_we_editor["text/plain"]["response_publish_ok"] = "Le fichier texte '%s' a été publié avec succès!";
$l_we_editor["text/plain"]["response_unpublish_ok"] = "Le fichier texte '%s' a été depublié avec succès!";
$l_we_editor["text/plain"]["response_save_notok"] = "Erreur en enregistrant le fichier texte '%s'!";
$l_we_editor["text/plain"]["response_path_exists"] = "Le fichier texte '%s' n'a pas pu être enregistré, parce qu'il existe déjà un autre fichier ou un autre répertoire a cet endroit!";
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
$l_we_editor["folder"]["response_publish_ok"] = "Le répertoire '%s' a été publié avec succès!";
$l_we_editor["folder"]["response_unpublish_ok"] = "Le répertoire '%s' a été depublié avec succès!";
$l_we_editor["folder"]["response_save_notok"] = "Erreur en enregistrant le répertoire '%s'!";
$l_we_editor["folder"]["response_path_exists"] = "Le répertoire '%s' n'a pas pu être enregistré, parce qu'il existe déjà un autre fichier ou un autre répertoire a cet endroit!";
$l_we_editor["folder"]["filename_empty"] = "Vous n'avez pas encore saisi un nom pour le répertoire!";
$l_we_editor["folder"]["we_filename_notValid"] = "Le nom saisi pour le répertoire n'est pas valide!\\nSignes permis sont les lettres de a à z (majuscule- ou minuscule) , nombres, soulignage (_), signe moins (-), point (.)";
$l_we_editor["folder"]["we_filename_notAllowed"] = "Le nom du répertoire n'est pas permis!";
$l_we_editor["folder"]["response_save_noperms_to_create_folders"] = "Le répertoire n'a pas pu être enregistré, parce que vous n'avez pas les droits nécessaires, pour créer des nouveaux répertoire (%s)!";

$l_we_editor["image/*"]["response_save_ok"] = "La graphique '%s' a été enregistrée avec succès!";
$l_we_editor["image/*"]["response_publish_ok"] = "La graphique '%s' a été publiée avec succès!";
$l_we_editor["image/*"]["response_unpublish_ok"] = "La graphique '%s' a été depubliée avec succès!";
$l_we_editor["image/*"]["response_save_notok"] = "Erreur en enregistrant la graphique '%s'!";
$l_we_editor["image/*"]["response_path_exists"] = "La graphique '%s' n'a pas pu être enregistrée, parce qu'il existe déjà un autre fichier ou un autre répertoire a cet endroit!";
$l_we_editor["image/*"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["image/*"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["image/*"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["image/*"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["application/*"]["response_save_ok"] = "The document '%s' has been successfully saved!";
$l_we_editor["application/*"]["response_publish_ok"] = "Le fichier '%s' a été publié avec succès!";
$l_we_editor["application/*"]["response_unpublish_ok"] = "Le fichier '%s' a été depublié avec succès!";
$l_we_editor["application/*"]["response_save_notok"] = "Erreur en enregistrant le fichier '%s'!";
$l_we_editor["application/*"]["response_path_exists"] = "Le fichier '%s' n''a pas pu être enregistré, parce qu'il existe déjà un autre fichier ou un autre répertoire a cet endroit!";
$l_we_editor["application/*"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["application/*"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["application/*"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["application/*"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];
$l_we_editor["application/*"]["we_description_missing"] = "Please enter a desription in the 'Desription' field!";
$l_we_editor["application/*"]["response_save_wrongExtension"] =  "Erreur en enregistrant '%s' \\nL'extension de fichier '%s' n'est pas valide pour des fichiers divers!\\nPour cela créer s'il vous plaît un fichier html!";

$l_we_editor["application/x-shockwave-flash"]["response_save_ok"] = "Le vidéo-Flash '%s' a été enregistré avec succès!";
$l_we_editor["application/x-shockwave-flash"]["response_publish_ok"] = "Le vidéo-Flash '%s' a été publié avec succès!";
$l_we_editor["application/x-shockwave-flash"]["response_unpublish_ok"] = "Le vidéo-Flash '%s' a été depublié avec succès!";
$l_we_editor["application/x-shockwave-flash"]["response_save_notok"] = "Erreur en enregistrant le vidéo-Flash '%s'!";
$l_we_editor["application/x-shockwave-flash"]["response_path_exists"] = "Le vidéo-Flash '%s' n'a pas pu être enregistré, parce qu'il existe déjà un autre fichier ou un autre répertoire a cet endroit!";
$l_we_editor["application/x-shockwave-flash"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["application/x-shockwave-flash"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["application/x-shockwave-flash"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["application/x-shockwave-flash"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["video/quicktime"]["response_save_ok"] = "The Quicktime movie '%s' has been successfully saved!";
$l_we_editor["video/quicktime"]["response_publish_ok"] = "Le film-Quicktime '%s' a été publié avec succès!";
$l_we_editor["video/quicktime"]["response_unpublish_ok"] = "Le film-Quicktime '%s' a été depublié avec succès!";
$l_we_editor["video/quicktime"]["response_save_notok"] = "Erreur en enregistrant le film-Quicktime '%s'!";
$l_we_editor["video/quicktime"]["response_path_exists"] = "Le film-Quicktime '%s' n'a pas pu être enregistré, parce qu'il existe déjà un autre fichier ou un autre répertoire a cet endroit!";
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