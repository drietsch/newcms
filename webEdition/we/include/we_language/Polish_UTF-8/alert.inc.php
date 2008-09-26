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
$l_alert[FILE_TABLE]["in_wf_warning"] = "Przed dołączeniem dokumentu do Workflow, należy go zapisać!\\nCzy zapisać dokument?";
if( defined("OBJECT_FILES_TABLE") ){
  $l_alert[OBJECT_FILES_TABLE]["in_wf_warning"] = "Przed dołączeniem obiektu do Workflow, należy go zapisać!\\nCzy zapisać teraz dokument?";
  $l_alert[OBJECT_TABLE]["in_wf_warning"] = "Przed dołączeniem klasy do Workflow, należy ją zapisać!\\nCzy zapisać teraz klasę?";
}
$l_alert[TEMPLATES_TABLE]["in_wf_warning"] = "Przed dołączeniem szablonu do Workflow, należy go zapisać!\\nCzy zapisać teraz szablon?";
$l_alert[FILE_TABLE]["not_im_ws"] = "Plik nie znajduje się w twoim obszarze roboczym!";
$l_alert["folder"]["not_im_ws"] = "Ten katalog nie znajduje się w twoim obszarze roboczym!";
$l_alert[TEMPLATES_TABLE]["not_im_ws"] = "Szablon nie znajduje się w twoim obszarze roboczym!";
$l_alert["delete_recipient"] = "Czy naprawdę chcesz usunąć wybrany adres e-mail?";
$l_alert["recipient_exists"] = "Adres e-mail już istnieje!";
$l_alert["input_name"] = "Wprowadź nowy adres e-mail!";
$l_alert['input_file_name'] = "Enter a filename."; // TRANSLATE
$l_alert["max_name_recipient"] = "Adres e-mail może składać się najwyżej z 255 znaków!";
$l_alert["not_entered_recipient"] = "Nie wprowadzono adresu e-mail!";
$l_alert["recipient_new_name"] = "Zmiana adresu e-mail!";
$l_alert["no_new"]["objectFile"] = "Nie możesz stworzyć obiektów, gdyż albo brakuje ci uprawnień<br>albo nie istnieje klasa, w której ważny jest jeden z Twoich obszarów pracy!";
$l_alert["required_field_alert"] = "Pole '%s' jest polem obowiązkowym i należy je wypełnić!";
$l_alert["phpError"] = "Nie można uruchomić webEdition";
$l_alert["3timesLoginError"] = "Logowanie %sx nie powiodło się! Odczekaj %s minut i spróbuj ponownie!";
$l_alert["popupLoginError"] = "Nie można otworzyć okna webEdition!\\n\\n Uruchomienie webEdition jest możliwe tylko wtedy, gdy twoja przeglądarka zezwala na otwieranie okien wyskakujących.";
$l_alert['publish_when_not_saved_message'] = "Nie zapisano dokumentu! Czy mimo to chcesz go opublikować?";
$l_alert["template_in_use"] = "Szablon jest używany i dlatego nie można go usunąć!";
$l_alert["no_cookies"] = "Nie aktywowano Cookies. Aktywuj Cookies w swojej przeglądarce, żeby program webEdition zadziałał prawidłowo!";
$l_alert["doctype_hochkomma"] = "Nazwa typu dokumentu nie może zawierać ' (apostrofu) ani , (przecinka)!";
$l_alert["thumbnail_hochkomma"] = "Nazwa widoku miniatur nie może zawierać ' (apostrofu) ani , (przecinka)!";
$l_alert["can_not_open_file"] = "Nie udało się otworzyć pliku %s !";
$l_alert["no_perms_title"] = "Brak uprawnień";
$l_alert["no_perms_action"] = "You don't have the permission to perform this action."; // TRANSLATE
$l_alert["access_denied"] = "Odmowa dostępu!";
$l_alert["no_perms"] = "Jeżeli potrzebujesz praw dostępu, zwróć się do właściciela (%s)<br>lub administratora!";
$l_alert["temporaere_no_access"] = "Chwilowy brak dostępu";
$l_alert["temporaere_no_access_text"] = "Plik (%s) jest chwilowo edytowany przez użytkownika '%s' .";
$l_alert["file_locked_footer"] = "This document is edited by \"%s\" at the moment."; // TRANSLATE
$l_alert["file_no_save_footer"] = "Nie masz uprawnień wymaganych do zapisania tego pliku.";
$l_alert["login_failed"] = "Błędna nazwa użytkownika i/lub hasło!";
$l_alert["login_failed_security"] = "Nie można uruchomić webEdition!\\n\\nZe względów bezpieczeństwa logowanie zostało przerwane, ponieważ przekroczono maksymalny czas logowania!\\n\\nZaloguj się ponownie.";
$l_alert["perms_no_permissions"] = "Brak uprawnień do wykonania tej operacji!\\nZaloguj się ponownie!";
$l_alert["no_image"] = "Wybrany plik nie jest obrazkiem!";
$l_alert["delete_ok"] = "Pliki lub katalogi usunięto!";
$l_alert["delete_cache_ok"] = "Cache successfully deleted!"; // TRANSLATE
$l_alert["nothing_to_delete"] = "Nie wybrano niczego do skasowania!";
$l_alert["delete"] = "Usunąć wybrane wpisy?\\n/Na pewno?";
$l_alert["delete_cache"] = "Delete cache for the selected entries?\\nDo you want to continue?"; // TRANSLATE
$l_alert["delete_folder"] = "Usunąć wybrany katalog?\\nPamiętaj,że wtedy wraz z nim zostaną usunięte automatycznie zawarte w katalogu pliki i katalogi!\\nNa pewno?";
$l_alert["delete_nok_error"] = "Nie można usunąć pliku '%s'.";
$l_alert["delete_nok_file"] = "Nie można usunąć pliku '%s'.\\nMożliwe, że plik jest chroniony przed zapisem.";
$l_alert["delete_nok_folder"] = "Nie można usunąć katalogu '%s'.\\nMożliwe, że katalog jest chroniony przed zapisem.";
$l_alert["delete_nok_noexist"] = "Plik '%s' nie istnieje!";
$l_alert["noResourceTitle"] = "No Item!";
$l_alert["noResource"] = "The document or directory does not exist!";
$l_alert["move_exit_open_docs_question"] = "Before documents of a table can be moved, all documents of this table must be closed. All not saved changes will be lost during this process. The following document will be closed:\\n\\n"; // TRANSLATE
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
$l_alert["thumbnail_exists"] = "Widok miniatur już istnieje!";
$l_alert["thumbnail_not_exists"] = "Widok miniatur nie istnieje!";
$l_alert["doctype_exists"] = "Typ dokumentu juź istnieje!";
$l_alert["doctype_empty"] = "Nie podano nazwy!";
$l_alert["delete_cat"] = "Czy napewno chcesz usunąć wybraną kategorię?";
$l_alert["delete_cat_used"] = "Kategoria jest już używana i dlatego nie można jej usunąć!";
$l_alert["cat_exists"] = "Kategoria już istnieje!";
$l_alert["cat_changed"] = "Kategoria jest już używana! Jeżeli pokazano ją w dokumentach, należy zapisać te dokumenty na nowo!\\nCzy mimo to zmienić kategorię?";
$l_alert["max_name_cat"] = "Nazwa kategorii może składać się najwyżej z 32 znaków!";
$l_alert["not_entered_cat"] = "Nie wprowadzono nazwy kategorii!";
$l_alert["cat_new_name"] = "Wprowadź nową nazwę kategorii!";
$l_alert["we_backup_import_upload_err"] = "Wystąpił błąd przy ładowaniu pliku kopii zapasowej! /Maksymalna dozwolona wielkość pliku do załadowania wynosi %s. Jeżeli twój plik kopii zapasowej jest większy, skopiuj go na serwer za pomocą FTP do katalogu webEdition/we_backup a następnie wybierz '".$l_backup["import_from_server"]."'!";
$l_alert["rebuild_nodocs"] = "Brak dokumentów spełniających wymagane kryteria!";
$l_alert["we_name_not_allowed"] = "Nazwy 'we' oraz 'webEdition' są używane przez sam program webEdition i dlatego nie wolno ich stosować!";
$l_alert["we_filename_empty"] = "Nie wprowadzono nazwy pliku dla tego dokumentu bądź katalogu!";
$l_alert["exit_multi_doc_question"] = "Several open documents contain unsaved changes. If you continue all unsaved changes are discarded. Do you want to continue and discard all modifications?"; // TRANSLATE
$l_alert["exit_doc_question_".FILE_TABLE] = "Dokument został zmieniony.<br>Czy zapisać zmiany?";
$l_alert["exit_doc_question_".TEMPLATES_TABLE] = "Szablon został zmieniony.<br>Zapisać zmiany?";
if( defined("OBJECT_FILES_TABLE") ){
	$l_alert["exit_doc_question_".OBJECT_TABLE] = "Klasa została zmieniona.<br>Zapisać zmiany?";
	$l_alert["exit_doc_question_".OBJECT_FILES_TABLE] = "Obiekt został zmieniony.<br>Zapisać zmiany?";
}
$l_alert["deleteTempl_notok_used"] = "Nie można wykonać operacji, ponieważ przynajmniej jeden z szablonów, które mają być usunięte, jest używany!";
$l_alert["delete_notok"] = "Wystąpił błąd przy usuwaniu!";
$l_alert["nothing_to_save"] = "Nie można wykonać w tej chwili operacji zapisu!";
$l_alert["nothing_to_publish"] = "The publish function is disabled at the moment!"; // TRANSLATE
$l_alert["we_filename_notValid"] = "Invalid filename\\nValid characters are alpha-numeric, upper and lower case, as well as underscore, hyphen and dot (a-z, A-Z, 0-9, _, -, .)";
$l_alert["empty_image_to_save"] = "Wybrany obrazek jest pusty.\\nKontynuować mimo to?";
$l_alert["path_exists"] = "Nie można zapisać dokumentu bądź katalogu %s , ponieważ w tym miejscu znajduje się już inny dokument!";
$l_alert["folder_not_empty"] = "Ponieważ co najmniej jeden z katalogów do skasowania nie był pusty, nie można było go całkiem usunąć z serwera! Usuń plik ręcznie.\\nDotyczy to następujących katalogów:\\n%s";
$l_alert["name_nok"] = "Nazwy nie mogą zawierać znaków '<' i '>'!";
$l_alert["found_in_workflow"] = "Co najmniej jeden z wpisów do skasowania znajduje się w tej chwili w Workflow! Czy chcesz usunąć te wpisy z Workflow?";
$l_alert["import_we_dirs"] = "Próbujesz importu z katalogu zarządzanego przez webEdition!\\n
Te katalogi są chronione i z tego powodu nie można z nich importować!";
$l_alert["wrong_file"]["image/*"] = "Nie można dodać pliku. Albo nie jest to obrazek, albo wyczerpało się miejsce na dysku (Webspace)!";
$l_alert["wrong_file"]["application/x-shockwave-flash"] = "Nie można dodać pliku. Albo nie jest to animacja Flash-Movie albo wyczerpało się miejsce na dysku twardym!";
$l_alert["wrong_file"]["video/quicktime"] = "Nie można dodać pliku. Albo nie jest to plik Quicktime-Movie albo wyczerpało się miejsce na dysku twardym!";
$l_alert["no_file_selected"] = "Nie wybrano plików do załadowania!";
$l_alert["browser_crashed"] = "Nie można otworzyć okna, ponieważ przeglądarka spowodowała błąd!  Zapisz swoją pracę i uruchom ponownie przeglądarkę.";
$l_alert["copy_folders_no_id"] = "Należy najpierw zapisać aktualny katalog!";
$l_alert["copy_folder_not_valid"] =  "Nie można skopiować tego samego katalogu lub jednego z katalogów nadrzędnych!";
$l_alert['no_views']['headline'] = 'Attention'; // TRANSLATE
$l_alert['no_views']['description'] = 'Dla tego dokumentu widok nie jest dostępny.';
$l_alert['navigation']['last_document'] = 'You edit the last document.'; // TRANSLATE
$l_alert['navigation']['first_document'] = 'Znajdujesz się przy pierwszym dokumencie.';
$l_alert['navigation']['doc_not_found'] = 'Could not find matching document.'; // TRANSLATE
$l_alert['navigation']['no_entry'] = 'No entry found in history.'; // TRANSLATE
$l_alert['navigation']['no_open_document'] = 'There is no open document.'; // TRANSLATE
$l_alert['delete_single']['confirm_delete'] = 'Delete this document?'; // TRANSLATE
$l_alert['delete_single']['no_delete'] = 'This document could not be deleted.'; // TRANSLATE
$l_alert['delete_single']['return_to_start'] = 'Plik został skasowany.\\nPowrót do seeMode dokumentu startowego.';
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


$l_alert["we_filename_notValid"] = "Wprowadzona nazwa pliku jest nieprawidłowa!\\nDopuszczalne znaki to litery od a do z (wielkie i małe) , cyfry, znak podkreślenia (_), minus (-) oraz kropka (.)."; // CHECK
// changed from: "Invalid filename\\nValid characters are alpha-numeric, upper and lower case, as well as underscore, hyphen and dot (a-z, A-Z, 0-9, _, -, .)"
// changed to  : "Invalid file name\\nValid characters are alpha-numeric, upper and lower case, as well as underscore, hyphen and dot (a-z, A-Z, 0-9, _, -, .)"
$l_alert['error_fields_value_not_valid'] = 'Invalid entries in input fields!';


?>