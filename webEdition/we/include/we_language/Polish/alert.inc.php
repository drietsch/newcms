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
$l_alert[FILE_TABLE]["in_wf_warning"] = "Przed do³±czeniem dokumentu do Workflow, nale¿y go zapisaæ!\\nCzy zapisaæ dokument?";
if( defined("OBJECT_FILES_TABLE") ){
  $l_alert[OBJECT_FILES_TABLE]["in_wf_warning"] = "Przed do³±czeniem obiektu do Workflow, nale¿y go zapisaæ!\\nCzy zapisaæ teraz dokument?";
  $l_alert[OBJECT_TABLE]["in_wf_warning"] = "Przed do³±czeniem klasy do Workflow, nale¿y j± zapisaæ!\\nCzy zapisaæ teraz klasê?";
}
$l_alert[TEMPLATES_TABLE]["in_wf_warning"] = "Przed do³±czeniem szablonu do Workflow, nale¿y go zapisaæ!\\nCzy zapisaæ teraz szablon?";
$l_alert[FILE_TABLE]["not_im_ws"] = "Plik nie znajduje siê w twoim obszarze roboczym!";
$l_alert["folder"]["not_im_ws"] = "Ten katalog nie znajduje siê w twoim obszarze roboczym!";
$l_alert[TEMPLATES_TABLE]["not_im_ws"] = "Szablon nie znajduje siê w twoim obszarze roboczym!";
$l_alert["delete_recipient"] = "Czy naprawdê chcesz usun±æ wybrany adres e-mail?";
$l_alert["recipient_exists"] = "Adres e-mail ju¿ istnieje!";
$l_alert["input_name"] = "Wprowad¼ nowy adres e-mail!";
$l_alert['input_file_name'] = "Enter a filename."; // TRANSLATE
$l_alert["max_name_recipient"] = "Adres e-mail mo¿e sk³adaæ siê najwy¿ej z 255 znaków!";
$l_alert["not_entered_recipient"] = "Nie wprowadzono adresu e-mail!";
$l_alert["recipient_new_name"] = "Zmiana adresu e-mail!";
$l_alert["no_new"]["objectFile"] = "Nie mo¿esz stworzyæ obiektów, gdy¿ albo brakuje ci uprawnieñ<br>albo nie istnieje klasa, w której wa¿ny jest jeden z Twoich obszarów pracy!";
$l_alert["required_field_alert"] = "Pole '%s' jest polem obowi±zkowym i nale¿y je wype³niæ!";
$l_alert["phpError"] = "Nie mo¿na uruchomiæ webEdition";
$l_alert["3timesLoginError"] = "Logowanie %sx nie powiod³o siê! Odczekaj %s minut i spróbuj ponownie!";
$l_alert["popupLoginError"] = "Nie mo¿na otworzyæ okna webEdition!\\n\\n Uruchomienie webEdition jest mo¿liwe tylko wtedy, gdy twoja przegl±darka zezwala na otwieranie okien wyskakuj±cych.";
$l_alert['publish_when_not_saved_message'] = "Nie zapisano dokumentu! Czy mimo to chcesz go opublikowaæ?";
$l_alert["template_in_use"] = "Szablon jest u¿ywany i dlatego nie mo¿na go usun±æ!";
$l_alert["no_cookies"] = "Nie aktywowano Cookies. Aktywuj Cookies w swojej przegl±darce, ¿eby program webEdition zadzia³a³ prawid³owo!";
$l_alert["doctype_hochkomma"] = "Nazwa typu dokumentu nie mo¿e zawieraæ ' (apostrofu) ani , (przecinka)!";
$l_alert["thumbnail_hochkomma"] = "Nazwa widoku miniatur nie mo¿e zawieraæ ' (apostrofu) ani , (przecinka)!";
$l_alert["can_not_open_file"] = "Nie uda³o siê otworzyæ pliku %s !";
$l_alert["no_perms_title"] = "Brak uprawnieñ";
$l_alert["no_perms_action"] = "You don't have the permission to perform this action."; // TRANSLATE
$l_alert["access_denied"] = "Odmowa dostêpu!";
$l_alert["no_perms"] = "Je¿eli potrzebujesz praw dostêpu, zwróæ siê do w³a¶ciciela (%s)<br>lub administratora!";
$l_alert["temporaere_no_access"] = "Chwilowy brak dostêpu";
$l_alert["temporaere_no_access_text"] = "Plik (%s) jest chwilowo edytowany przez u¿ytkownika '%s' .";
$l_alert["file_locked_footer"] = "This document is edited by \"%s\" at the moment."; // TRANSLATE
$l_alert["file_no_save_footer"] = "Nie masz uprawnieñ wymaganych do zapisania tego pliku.";
$l_alert["login_failed"] = "B³êdna nazwa u¿ytkownika i/lub has³o!";
$l_alert["login_failed_security"] = "Nie mo¿na uruchomiæ webEdition!\\n\\nZe wzglêdów bezpieczeñstwa logowanie zosta³o przerwane, poniewa¿ przekroczono maksymalny czas logowania!\\n\\nZaloguj siê ponownie.";
$l_alert["perms_no_permissions"] = "Brak uprawnieñ do wykonania tej operacji!\\nZaloguj siê ponownie!";
$l_alert["no_image"] = "Wybrany plik nie jest obrazkiem!";
$l_alert["delete_ok"] = "Pliki lub katalogi usuniêto!";
$l_alert["delete_cache_ok"] = "Cache successfully deleted!"; // TRANSLATE
$l_alert["nothing_to_delete"] = "Nie wybrano niczego do skasowania!";
$l_alert["delete"] = "Usun±æ wybrane wpisy?\\n/Na pewno?";
$l_alert["delete_cache"] = "Delete cache for the selected entries?\\nDo you want to continue?"; // TRANSLATE
$l_alert["delete_folder"] = "Usun±æ wybrany katalog?\\nPamiêtaj,¿e wtedy wraz z nim zostan± usuniête automatycznie zawarte w katalogu pliki i katalogi!\\nNa pewno?";
$l_alert["delete_nok_error"] = "Nie mo¿na usun±æ pliku '%s'.";
$l_alert["delete_nok_file"] = "Nie mo¿na usun±æ pliku '%s'.\\nMo¿liwe, ¿e plik jest chroniony przed zapisem.";
$l_alert["delete_nok_folder"] = "Nie mo¿na usun±æ katalogu '%s'.\\nMo¿liwe, ¿e katalog jest chroniony przed zapisem.";
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
$l_alert["thumbnail_exists"] = "Widok miniatur ju¿ istnieje!";
$l_alert["thumbnail_not_exists"] = "Widok miniatur nie istnieje!";
$l_alert["doctype_exists"] = "Typ dokumentu ju¼ istnieje!";
$l_alert["doctype_empty"] = "Nie podano nazwy!";
$l_alert["delete_cat"] = "Czy napewno chcesz usun±æ wybran± kategoriê?";
$l_alert["delete_cat_used"] = "Kategoria jest ju¿ u¿ywana i dlatego nie mo¿na jej usun±æ!";
$l_alert["cat_exists"] = "Kategoria ju¿ istnieje!";
$l_alert["cat_changed"] = "Kategoria jest ju¿ u¿ywana! Je¿eli pokazano j± w dokumentach, nale¿y zapisaæ te dokumenty na nowo!\\nCzy mimo to zmieniæ kategoriê?";
$l_alert["max_name_cat"] = "Nazwa kategorii mo¿e sk³adaæ siê najwy¿ej z 32 znaków!";
$l_alert["not_entered_cat"] = "Nie wprowadzono nazwy kategorii!";
$l_alert["cat_new_name"] = "Wprowad¼ now± nazwê kategorii!";
$l_alert["we_backup_import_upload_err"] = "Wyst±pi³ b³±d przy ³adowaniu pliku kopii zapasowej! /Maksymalna dozwolona wielko¶æ pliku do za³adowania wynosi %s. Je¿eli twój plik kopii zapasowej jest wiêkszy, skopiuj go na serwer za pomoc± FTP do katalogu webEdition/we_backup a nastêpnie wybierz '".$l_backup["import_from_server"]."'!";
$l_alert["rebuild_nodocs"] = "Brak dokumentów spe³niaj±cych wymagane kryteria!";
$l_alert["we_name_not_allowed"] = "Nazwy 'we' oraz 'webEdition' s± u¿ywane przez sam program webEdition i dlatego nie wolno ich stosowaæ!";
$l_alert["we_filename_empty"] = "Nie wprowadzono nazwy pliku dla tego dokumentu b±d¼ katalogu!";
$l_alert["exit_multi_doc_question"] = "Several open documents contain unsaved changes. If you continue all unsaved changes are discarded. Do you want to continue and discard all modifications?"; // TRANSLATE
$l_alert["exit_doc_question_".FILE_TABLE] = "Dokument zosta³ zmieniony.<br>Czy zapisaæ zmiany?";
$l_alert["exit_doc_question_".TEMPLATES_TABLE] = "Szablon zosta³ zmieniony.<br>Zapisaæ zmiany?";
if( defined("OBJECT_FILES_TABLE") ){
	$l_alert["exit_doc_question_".OBJECT_TABLE] = "Klasa zosta³a zmieniona.<br>Zapisaæ zmiany?";
	$l_alert["exit_doc_question_".OBJECT_FILES_TABLE] = "Obiekt zosta³ zmieniony.<br>Zapisaæ zmiany?";
}
$l_alert["deleteTempl_notok_used"] = "Nie mo¿na wykonaæ operacji, poniewa¿ przynajmniej jeden z szablonów, które maj± byæ usuniête, jest u¿ywany!";
$l_alert["delete_notok"] = "Wyst±pi³ b³±d przy usuwaniu!";
$l_alert["nothing_to_save"] = "Nie mo¿na wykonaæ w tej chwili operacji zapisu!";
$l_alert["nothing_to_publish"] = "The publish function is disabled at the moment!"; // TRANSLATE
$l_alert["we_filename_notValid"] = "Invalid filename\\nValid characters are alpha-numeric, upper and lower case, as well as underscore, hyphen and dot (a-z, A-Z, 0-9, _, -, .)";
$l_alert["empty_image_to_save"] = "Wybrany obrazek jest pusty.\\nKontynuowaæ mimo to?";
$l_alert["path_exists"] = "Nie mo¿na zapisaæ dokumentu b±d¼ katalogu %s , poniewa¿ w tym miejscu znajduje siê ju¿ inny dokument!";
$l_alert["folder_not_empty"] = "Poniewa¿ co najmniej jeden z katalogów do skasowania nie by³ pusty, nie mo¿na by³o go ca³kiem usun±æ z serwera! Usuñ plik rêcznie.\\nDotyczy to nastêpuj±cych katalogów:\\n%s";
$l_alert["name_nok"] = "Nazwy nie mog± zawieraæ znaków '<' i '>'!";
$l_alert["found_in_workflow"] = "Co najmniej jeden z wpisów do skasowania znajduje siê w tej chwili w Workflow! Czy chcesz usun±æ te wpisy z Workflow?";
$l_alert["import_we_dirs"] = "Próbujesz importu z katalogu zarz±dzanego przez webEdition!\\n
Te katalogi s± chronione i z tego powodu nie mo¿na z nich importowaæ!";
$l_alert["wrong_file"]["image/*"] = "Nie mo¿na dodaæ pliku. Albo nie jest to obrazek, albo wyczerpa³o siê miejsce na dysku (Webspace)!";
$l_alert["wrong_file"]["application/x-shockwave-flash"] = "Nie mo¿na dodaæ pliku. Albo nie jest to animacja Flash-Movie albo wyczerpa³o siê miejsce na dysku twardym!";
$l_alert["wrong_file"]["video/quicktime"] = "Nie mo¿na dodaæ pliku. Albo nie jest to plik Quicktime-Movie albo wyczerpa³o siê miejsce na dysku twardym!";
$l_alert["no_file_selected"] = "Nie wybrano plików do za³adowania!";
$l_alert["browser_crashed"] = "Nie mo¿na otworzyæ okna, poniewa¿ przegl±darka spowodowa³a b³±d!  Zapisz swoj± pracê i uruchom ponownie przegl±darkê.";
$l_alert["copy_folders_no_id"] = "Nale¿y najpierw zapisaæ aktualny katalog!";
$l_alert["copy_folder_not_valid"] =  "Nie mo¿na skopiowaæ tego samego katalogu lub jednego z katalogów nadrzêdnych!";
$l_alert['no_views']['headline'] = 'Attention'; // TRANSLATE
$l_alert['no_views']['description'] = 'Dla tego dokumentu widok nie jest dostêpny.';
$l_alert['navigation']['last_document'] = 'You edit the last document.'; // TRANSLATE
$l_alert['navigation']['first_document'] = 'Znajdujesz siê przy pierwszym dokumencie.';
$l_alert['navigation']['doc_not_found'] = 'Could not find matching document.'; // TRANSLATE
$l_alert['navigation']['no_entry'] = 'No entry found in history.'; // TRANSLATE
$l_alert['navigation']['no_open_document'] = 'There is no open document.'; // TRANSLATE
$l_alert['delete_single']['confirm_delete'] = 'Delete this document?'; // TRANSLATE
$l_alert['delete_single']['no_delete'] = 'This document could not be deleted.'; // TRANSLATE
$l_alert['delete_single']['return_to_start'] = 'Plik zosta³ skasowany.\\nPowrót do seeMode dokumentu startowego.';
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


$l_alert["we_filename_notValid"] = "Wprowadzona nazwa pliku jest nieprawid³owa!\\nDopuszczalne znaki to litery od a do z (wielkie i ma³e) , cyfry, znak podkre¶lenia (_), minus (-) oraz kropka (.)."; // CHECK
// changed from: "Invalid filename\\nValid characters are alpha-numeric, upper and lower case, as well as underscore, hyphen and dot (a-z, A-Z, 0-9, _, -, .)"
// changed to  : "Invalid file name\\nValid characters are alpha-numeric, upper and lower case, as well as underscore, hyphen and dot (a-z, A-Z, 0-9, _, -, .)"
$l_alert['error_fields_value_not_valid'] = 'Invalid entries in input fields!';


?>