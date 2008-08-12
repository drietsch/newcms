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
 * Language file: alert.inc.php
 * Provides language strings.
 * Language: English
 */
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/backup.inc.php");
if (!isset($l_backup)) {
	include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/backup.inc.php");
}

$l_alert["notice"] = "Notice";
$l_alert["warning"] = "Warning"; // TRANSLATE
$l_alert["error"] = "Error"; // TRANSLATE

$l_alert["noRightsToDelete"] = "\\'%s\\' cannot be deleted! You do not have permission to perform this action!"; // TRANSLATE
$l_alert["noRightsToMove"] = "\\'%s\\' cannot be moved! You do not have permission to perform this action!"; // TRANSLATE
$l_alert[FILE_TABLE]["in_wf_warning"] = "Avant que le document puisse �tre pass� dans le Gestion de Flux, il doit �tre enregistr�!\\nEnregistrer le document maintenant?";
if( defined("OBJECT_FILES_TABLE") ){
  $l_alert[OBJECT_FILES_TABLE]["in_wf_warning"] = "Avant que l\\'object puisse �tre pass� dans le Gestion de Flux, il doit �tre enregistr�!\\nEnregistrer l\\'object maintenant?";
  $l_alert[OBJECT_TABLE]["in_wf_warning"] = "Avant que la classe puisse �tre pass�e dans le Gestion de Flux, elle doit �tre enregistr�e!\\nEnregistrer la classe maintenant";
}
$l_alert[TEMPLATES_TABLE]["in_wf_warning"] = "Avant que le mod�le puisse �tre pass� dans le Gestion de Flux, il doit �tre enregistr�!\\nEnregistrer le mod�le maintenant?";
$l_alert[FILE_TABLE]["not_im_ws"] = "Le fichier n'est pas dans votre �space de travail!";
$l_alert["folder"]["not_im_ws"] = "Le r�pertoire n'est pas dans votre �space de travail!";
$l_alert[TEMPLATES_TABLE]["not_im_ws"] = "Le mod�le n'est pas dans votre �space de travail!";
$l_alert["delete_recipient"] = "Voulez-vous vraiment supprimer l'adresse E-Mail s�lectionn�?";
$l_alert["recipient_exists"] = "Cette adresse E-Mail existe d�j�!";
$l_alert["input_name"] = "S'il vous pla�t saisissez une nouvelle adresse E-Mail!";
$l_alert['input_file_name'] = "Enter a filename."; // TRANSLATE
$l_alert["max_name_recipient"] = "L'adresse E-Mail doit avoir une longeur maximale de 32 signe!!";
$l_alert["not_entered_recipient"] = "Vous n'avez pas encore saisi une adresse E-Mail!";
$l_alert["recipient_new_name"] = "Changer l'adresse E-Mail!";
$l_alert["no_new"]["objectFile"] = "Vous ne pouvez pas cr�er des nouveaux objects, parce que ou vous n'avez pas les droits n�cessaires<br>ou parce qu'il n'y a aucune classe qui est valide dans un de votre �spaces de travail!";
$l_alert["required_field_alert"] = "Le champ '%s' est obligatoire et doit �tre rempli!";
$l_alert["phpError"] = "webEdition ne peut pas �tre d�marr�";
$l_alert["3timesLoginError"] = "L'authentification a �chou�e %sx ! S'il vous pla�t attendez %s minutes et l'essayez de nouveau!";
$l_alert["popupLoginError"] = "La fen�tre de webEdition n\'a pas pu etre ouvert!\\n\\nwebEdition ne peut �tre d�marer que si votre navigateur ne supprime pas le Pop-Up.";
$l_alert['publish_when_not_saved_message'] = "Le document n'est pas encore enregistr�!Voulez-vous le publier quand m�me?";
$l_alert["template_in_use"] = "Le mod�le est utilis� en ce moment et ne peut pas �tre enlever alors!";
$l_alert["no_cookies"] = "Vous n\'avez pas activ� les cookies. S'il vous pla�t activez les cookies dans votre navigateur, pour que webEdition puisse fonctionner!";
$l_alert["doctype_hochkomma"] = "Le nom du type-de-document ne doit pas contenir de ' (apostroph) et pas de , (virgule)!";
$l_alert["thumbnail_hochkomma"] = "Le nom d'une imagettes ne doit pas contenir de  ' (apostroph) et pas de , (virgule)!";
$l_alert["can_not_open_file"] = "Le fichier %s ne pouvait pas �tre ouvert!";
$l_alert["no_perms_title"] = "Non authoris�";
$l_alert["no_perms_action"] = "You don't have the permission to perform this action."; // TRANSLATE
$l_alert["access_denied"] = "Acc�s r�fus�!";
$l_alert["no_perms"] = "S'il vous pla�t contacter le propri�taire (%s)<br>ou l'administrateur, si vous n�cessiter acc�s!";
$l_alert["temporaere_no_access"] = "Acc�s non possible pour l'instant";
$l_alert["temporaere_no_access_text"] = "Le fichier (%s) est �diter par l'utilisateur '%s' en ce moment.";
$l_alert["file_locked_footer"] = "This document is edited by \"%s\" at the moment."; // TRANSLATE
$l_alert["file_no_save_footer"] = "Vous n'avez pas le droits n�cessaires, pour enregistrer le document.";
$l_alert["login_failed"] = "Votre nom d'utilisateur ou votre mot de passe n'est pas reconnu!";
$l_alert["login_failed_security"] = "webEdition ne pouvait pas �tre d�marr�!\\n\\n� cause des raisons de s�curit� l'authentification a �t� arr�t�, parc que le temps maximal pour l'authentification a �t� d�pass�!\\n\\nS'il vous pla�t reauthentifiez vous.";
$l_alert["perms_no_permissions"] = "Vous n'�tes pas authoris� pour cette action!\\nS'il vous pla�t reauthentifiez vous!";
$l_alert["no_image"] = "Le fichier choisi n'est pas une graphique!";
$l_alert["delete_ok"] = "Fichiers ou bien r�pertoires supprim� avec succ�s!";
$l_alert["delete_cache_ok"] = "Cache successfully deleted!"; // TRANSLATE
$l_alert["nothing_to_delete"] = "Rien choisi � supprimer!";
$l_alert["delete"] = "Supprimer les entr�es s�lectionn�?\\n�tes-vous s�r?";
$l_alert["delete_cache"] = "Delete cache for the selected entries?\\nDo you want to continue?"; // TRANSLATE
$l_alert["delete_folder"] = "Supprimer le r�pertoire s�lectionn�?\\nConsiderez que tous les documents et r�pertoires qui se trouve dans le r�pertoire seront supprim� �galement!\\n�tes-vous s�r?";
$l_alert["delete_nok_error"] = "Le fichier '%s' ne peut pas �tre supprim�.";
$l_alert["delete_nok_file"] = "Le fichier '%s' ne peut pas �tre supprim�.\\nIl est possible qu'il soit prot�ct�.";
$l_alert["delete_nok_folder"] = "Le r�pertoire '%s' ne peut pas �tre supprim�.\\nIl est possible qu'il soit prot�ct�.";
$l_alert["delete_nok_noexist"] = "Le fichier '%s' n'existe pas!";
$l_alert["noResourceTitle"] = "No Item!"; // TRANSLATE
$l_alert["noResource"] = "The document or directory does not exist!"; // TRANSLATE
$l_alert["move_exit_open_docs_question"] = "Before moving all %s must be closed.\\nIf you continue, the following %s will be closed, unsaved changes will not be saved.\\n\\n"; // TRANSLATE
$l_alert["move_exit_open_docs_continue"] = 'Continue?'; // TRANSLATE
$l_alert["move"] = "Move selected entries?\\nDo you want to continue?"; // TRANSLATE
$l_alert["move_ok"] = "Files successfully moved!"; // TRANSLATE
$l_alert["move_duplicate"] = "There are files with the same name in the target directory!\\nThe files cannot be moved."; // TRANSLATE
$l_alert["move_nofolder"] = "The selected files cannot be moved.\\nIt isn't possible to move directories."; // TRANSLATE
$l_alert["move_onlysametype"] = "The selected objects cannnot be moved.\\nObjects can only be moved in there own classdirectory."; // TRANSLATE
$l_alert["move_no_dir"] = "Please choose a target directory!"; // TRANSLATE
$l_alert["document_move_warning"] = "After moving documents it is  necessary to do a rebuild.<br />Would you like to do this now?"; // TRANSLATE
$l_alert["nothing_to_move"] = "There is nothing marked to move!"; // TRANSLATE
$l_alert["move_of_files_failed"] = "One or more files couldn't moved! Please move these files manually.\\nThe following files are affected:\\n%s"; // TRANSLATE
$l_alert["template_save_warning"] = "This template is used by %s published documents. Should they be resaved? Attention: This procedure may take some time if you have many documents!"; // TRANSLATE
$l_alert["template_save_warning1"] = "This template is used by one published document. Should it be resaved?"; // TRANSLATE
$l_alert["template_save_warning2"] = "This template is used by other templates and documents, should they be resaved?"; // TRANSLATE
$l_alert["thumbnail_exists"] = "Cette imagette existe d�j�!";
$l_alert["thumbnail_not_exists"] = "Cette imagette n'existe pas!";
$l_alert["doctype_exists"] = "Ce type-de-document existe d�j�!";
$l_alert["doctype_empty"] = "Vous n'avez pas encore saisi un nom!";
$l_alert["delete_cat"] = "Voulez-vous vraiment supprimez la cat�gories s�l�ction�e?";
$l_alert["delete_cat_used"] = "Cette cat�gorie est d�j� utilis� et ne peut pas �tre supprimer alors!";
$l_alert["cat_exists"] = "Cette cat�gorie existe d�j�!";
$l_alert["cat_changed"] = "Cette cat�gorie est d�ja utilis�! Si la cat�gorie est affich�e dans des document, vous devez reenregistrer ce document!\\nChanger la cat�gories quand m�me?";
$l_alert["max_name_cat"] = "Le nom de la cat�gorie doit avoir une longeur maximale de 32 signe!";
$l_alert["not_entered_cat"] = "Vous n'avez pas encore saisi un nom de cat�gorie!";
$l_alert["cat_new_name"] = "S'il vous pla�t saisissez le nouveau nom de la cat�gorie!";
$l_alert["we_backup_import_upload_err"] = "Erreur en t�l�chargant le fichier de sauvegarde! La taille de fichier maximale pour le t�l�chargement est %s. Si votre fichier de sauvegardes est plus grand, copier-le par FTP dans le r�p�rtoire webEdition/we_backup/ et choisissez '".$l_backup["import_from_server"]."'!";
$l_alert["rebuild_nodocs"] = "Il n'y aucun document, qui correspond aux crit�re choisis!";
$l_alert["we_name_not_allowed"] = "Les noms 'we' et 'webEdition' sont utilis�s par webEdition m�me et ne doivent pas �tre utilis�s alors!";
$l_alert["we_filename_empty"] = "Vous n'avez pas encore saisi un nom pour ce fichier ou bien r�pertoire!";
$l_alert["exit_multi_doc_question"] = "Several open documents contain unsaved changes. If you continue all unsaved changes are discarded. Do you want to continue and discard all modifications?"; // TRANSLATE
$l_alert["exit_doc_question_".FILE_TABLE] = "Le document a �t� modifi�.<br>Souhaitez-vous enregistrer les modifications apport�es?";
$l_alert["exit_doc_question_".TEMPLATES_TABLE] = "Le mod�le a �t� modifi�.<br>Souhaitez-vous enregistrer les modifications apport�es?";
if( defined("OBJECT_FILES_TABLE") ){
	$l_alert["exit_doc_question_".OBJECT_TABLE] = "La classe a �t� modifi�e.<br>Souhaitez-vous enregistrer les modifications apport�es?";
	$l_alert["exit_doc_question_".OBJECT_FILES_TABLE] = "L'object a �t� modifi�.<br>Souhaitez-vous enregistrer les modifications apport�es?";
}
$l_alert["deleteTempl_notok_used"] = "L'action ne pouvat pas �tre �ff�ctu�e, comme un ou plusieur mod�le � supprimer sont d�j� en utilisation!";
$l_alert["deleteClass_notok_used"] = "One or more of the classes are in use and could not be deleted!"; // TRANSLATE
$l_alert["delete_notok"] = "Erreur en supprimant!";
$l_alert["nothing_to_save"] = "La fonction enregistrer ne peut pas �tre �ff�ctu� en ce moment !";
$l_alert["nothing_to_publish"] = "The publish function is disabled at the moment!"; // TRANSLATE
$l_alert["we_filename_notValid"] = "Invalid filename\\nValid characters are alpha-numeric, upper and lower case, as well as underscore, hyphen and dot (a-z, A-Z, 0-9, _, -, .)";
$l_alert["empty_image_to_save"] = "La graphique choisi est vide.\\nPoursuivre";
$l_alert["path_exists"] = "Le document ou bien le r�pertoire %s ne pouvait pas �tre enregistr�, parce qu'il y d�j� un autre document au m�me endroit!";
$l_alert["folder_not_empty"] = "Comme un ou plusieurs r�pertoire n'ont pas �te compl�tement vide, il n'�tait pas possible de les supprimer compl�tement du serveur! Supprimer ces fichiers � main.\\n Les r�pertoires suivant sont concern�:\\n%s";
$l_alert["name_nok"] = "Des nome ne doivent pas contenir les signe '<' et '>'!";
$l_alert["found_in_workflow"] = "Une ou plusieurs  entr�es � supprimer se trouve dans le Gestion de Flux en ce moment! Voulez-vous enlever ces entr�es du Gestion de Flux?";
$l_alert["import_we_dirs"] = "Vous essayez d'importer d'un r�pertoire de webEdition!\\nCes r�pertoires sont protect�s et c'est pourquoi un import n'est pas possible!";
$l_alert["wrong_file"]["image/*"] = "Le fichier ne pouvait pas �tre cr��. Ou ce n\\'est pas une graphique ou votre espace web est plein !";
$l_alert["wrong_file"]["application/x-shockwave-flash"] = "Le fichier ne pouvait pas �tre cr��. Ou ce n\\'est pas un vid�o flash ou votre espace web est plein!";
$l_alert["wrong_file"]["video/quicktime"] = "Le fichier ne pouvait pas �tre cr��. Ou ce n\\'est pas un film quicktime ou votre espace web est plein";
$l_alert["no_file_selected"] = "Vous n\\'avez choisi aucun fichier � t�l�charger!";
$l_alert["browser_crashed"] = "La fen�tre ne pouvait pas �tre ouvert, pace que votre navigateur a caus� une erreur! S'il vous pla�t enregistrez votre travail et red�marrez le navigateur.";
$l_alert["copy_folders_no_id"] = "La fen�tre actuelle doit �tre enregistr� d'abord!";
$l_alert["copy_folder_not_valid"] =  "Le r�pertoire m�me ou un des r�pertoire parental ne peut pas �tre copier!";
$l_alert['no_views']['headline'] = 'Attention'; // TRANSLATE
$l_alert['no_views']['description'] = 'Ce document n\'a pas de vue.';
$l_alert['navigation']['last_document'] = 'You edit the last document.'; // TRANSLATE
$l_alert['navigation']['first_document'] = 'Vous �tes sur le premier document.';
$l_alert['navigation']['doc_not_found'] = 'Could not find matching document.'; // TRANSLATE
$l_alert['navigation']['no_entry'] = 'No entry found in history.'; // TRANSLATE
$l_alert['navigation']['no_open_document'] = 'There is no open document.'; // TRANSLATE
$l_alert['delete_single']['confirm_delete'] = 'Delete this document?'; // TRANSLATE
$l_alert['delete_single']['no_delete'] = 'This document could not be deleted.'; // TRANSLATE
$l_alert['delete_single']['return_to_start'] = 'Le fichier a �t� supprim� avec succ�s.\\n De retour � la page d\'accueil du seeMode.';
$l_alert['move_single']['return_to_start'] = 'The document was moved. \\nBack to seeMode startdocument.'; // TRANSLATE
$l_alert['move_single']['no_delete'] = 'This document could not be moved'; // TRANSLATE
$l_alert['cockpit_not_activated'] = 'The action could not be performed because the cockpit is not activated.'; // TRANSLATE
$l_alert['cockpit_reset_settings'] = 'Are you sure to delete the current Cockpit settings and reset the default settings?'; // TRANSLATE
$l_alert['save_error_fields_value_not_valid'] = 'The highlighted fields contain invalid data.\\nPlease enter valid data.'; // TRANSLATE

$l_alert['eplugin_exit_doc'] = "The document has been edited with extern editor. The connection between webEdition and extern editor will be closed and the content will not be synchronized anymore.\\nDo you want to close the document?"; // TRANSLATE

$l_alert['delete_workspace_user'] = "The directory %s could not be deleted! It is defined as workspace for the following users or groups:\\n%s"; // TRANSLATE
$l_alert['delete_workspace_user_r'] = "The directory %s could not be deleted! Within the directory there are other directories which are defined as workspace for the following users or groups:\\n%s"; // TRANSLATE
$l_alert['delete_workspace_object'] = "The directory %s could not be deleted! It is defined as workspace for the following objects:\\n%s"; // TRANSLATE
$l_alert['delete_workspace_object_r'] = "The directory %s could not be deleted! Within the directory there are other directories which are defined as workspace in the following objects:\\n%s"; // TRANSLATE


$l_alert['field_contains_incorrect_chars'] = "A field (of the type %s) contains invalid characters."; // TRANSLATE
$l_alert['field_input_contains_incorrect_length'] = "The maximum length of a field of the type \'Text input\' is 255 characters. If you need more characters, use a field of the type \'Textarea\'."; // TRANSLATE
$l_alert['field_int_contains_incorrect_length'] = "The maximum length of a field of the type \'Integer\' is 10 characters."; // TRANSLATE
$l_alert['field_int_value_to_height'] = "The maximum value of a field of the type \'Integer\' is 2147483647."; // TRANSLATE


$l_alert["we_filename_notValid"] = "Le nom de fichier saisi n'est pas valide!\\nnSignes permis sont les lettres de a � z (majuscule- ou minuscule) , nombres, soulignage (_), signe moins (-), point (.)";

$l_alert["login_denied_for_user"] = "The user cannot login. The user access is disabled."; // TRANSLATE
$l_alert["no_perm_to_delete_single_document"] = "You have not the needed permissions to delete the active document."; // TRANSLATE

$l_confim["applyWeDocumentCustomerFiltersDocument"] = "The document has been moved to a folder with divergent customer account policies. Should the settings of the folder be transmitted to this document?"; // TRANSLATE
$l_confim["applyWeDocumentCustomerFiltersFolder"]   = "The directory has been moved to a folder with divergent customers account policies. Should the settings be adopted for this directory and all subelements? "; // TRANSLATE

$l_alert['field_in_tab_notvalid_pre'] = "The settings could not be saved, because the following fields contain invalid values:"; // TRANSLATE
$l_alert['field_in_tab_notvalid'] = ' - field %s on tab %s'; // TRANSLATE
$l_alert['field_in_tab_notvalid_post'] = 'Correct the fields before saving the settings.'; // TRANSLATE 
$l_alert['discard_changed_data'] = 'There are unsaved changes that will be discarded. Are you sure?'; // TRANSLATE
?>