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
$l_we_editor["doubble_field_alert"] = "The field '%s' already exists! A field name must be unique!"; // TRANSLATE
$l_we_editor["variantNameInvalid"] = "The name of an article variant can not be empty!"; // TRANSLATE

$l_we_editor["folder_save_nok_parent_same"] = "Wybrany katalog nadrzędny leży wewnštrz aktualnego katalogu! Wybierz inny katalog i spróbuj jeszcze raz!";
$l_we_editor["pfolder_notsave"] = "Nie można zapisać katalogu w wybranym katalogu!";
$l_we_editor["required_field_alert"] = "Pole '%s' jest obowišzkowe i należy je wypełnić!";

$l_we_editor["category"]["response_save_ok"] = "Udało się zapisać kategorię '%s'!";
$l_we_editor["category"]["response_save_notok"] = "Błšd zapisu kategorii '%s'!";
$l_we_editor["category"]["response_path_exists"] = "Nie udało się zapisać kategorii '%s', ponieważ w tym miejscu znajduje się już inna kategoria!";
$l_we_editor["category"]["we_filename_notValid"] = "Podana nazwa jest nieprawidłowa!\\nDopuszczalne sš wszystkie znaki poza \\\", ' / < > i \\\\";
$l_we_editor["category"]["filename_empty"]       = "Nazwa nie może być pusta";
$l_we_editor["category"]["name_komma"] = "Podana nazwa jest nieprawidłowa!\\nPrzecinki sš niedozwolone";

$l_we_editor["text/webedition"]["response_save_ok"] = "Udało się zapisać stronę webEdition '%s'!";
$l_we_editor["text/webedition"]["response_publish_ok"] = "Opublikowano stronę webEdition '%s'!";
$l_we_editor["text/webedition"]["response_publish_notok"] = "Błšd w trakcie publikowania strony webEdition '%s'!";
$l_we_editor["text/webedition"]["response_unpublish_ok"] = "Udało się wycofać stronę webEdition '%s'!";
$l_we_editor["text/webedition"]["response_unpublish_notok"] = "Błšd w trakcie wycofywania strony webEdition '%s'!";
$l_we_editor["text/webedition"]["response_not_published"] = "Nie wycofano strony webEdition '%s'!";
$l_we_editor["text/webedition"]["response_save_notok"] = "Błšd zapisu strony webEdition '%s'!";
$l_we_editor["text/webedition"]["response_path_exists"] = "Nie udało się zapisać strony webEdition '%s', ponieważ w tym miejscu znajduje się już plik lub katalog!";
$l_we_editor["text/webedition"]["filename_empty"] = "Nie wprowadzono nazwy pliku!";
$l_we_editor["text/webedition"]["we_filename_notValid"] = "Wprowadzona nazwa pliku jest nieprawidłowa!\\nDozwolone znaki to litery od a do z (wielkie lub małe) , cyfry, znak podkrelenia (_), minus (-) oraz kropka (.).";
$l_we_editor["text/webedition"]["we_filename_notAllowed"] = "Wprowadzona nazwa pliku jest niedozwolona!";
$l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"] = "Nie można było zapisać pliku, ponieważ nie masz wystarczajšcych uprawnień do zakładania nowych katalogów (%s) !";
$l_we_editor["text/webedition"]["autoschedule"] = "Strona webEdition zostanie automatycznie opublikowana dn. %s !";

$l_we_editor["text/html"]["response_save_ok"] = "Udało się zapisać stronę HTML '%s'!";
$l_we_editor["text/html"]["response_publish_ok"] = "Udało się opublikować stronę HTML '%s'!";
$l_we_editor["text/html"]["response_publish_notok"] = "Błšd w trakcie publikowania strony HTML'%s'!";
$l_we_editor["text/html"]["response_unpublish_ok"] = "Udało się wycofać stronę HTML '%s'!";
$l_we_editor["text/html"]["response_unpublish_notok"] = "Błšd w trakcie wycofywania strony HTML '%s'!";
$l_we_editor["text/html"]["response_not_published"] = "Nie opublikowano strony HTML '%s'!";
$l_we_editor["text/html"]["response_save_notok"] = "Błšd zapisu strony HTML '%s'!";
$l_we_editor["text/html"]["response_path_exists"] = "Nie udało się zapisać strony '%s', ponieważ w tym miejscu znajduje się już plik lub katalog!";
$l_we_editor["text/html"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/html"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/html"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/html"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];
$l_we_editor["text/html"]["autoschedule"] = "The HTML page will be published automatically on %s.";

$l_we_editor["text/weTmpl"]["response_save_ok"] = "Udało się zapisać szablon '%s'!";
$l_we_editor["text/weTmpl"]["response_publish_ok"] = "Udało się opublikować szablon '%s'!";
$l_we_editor["text/weTmpl"]["response_unpublish_ok"] = "Udało się wycofać szablon '%s'!";
$l_we_editor["text/weTmpl"]["response_save_notok"] = "Błšd zapisu szablonu '%s'!";
$l_we_editor["text/weTmpl"]["response_path_exists"] = "Nie udało się zapisać szablonu '%s', ponieważ w tym miejscu znajduje się już plik lub katalog!";
$l_we_editor["text/weTmpl"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/weTmpl"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/weTmpl"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/weTmpl"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];
$l_we_editor["text/weTmpl"]["no_template_save"] = "Templates " . "can " . "not " . "saved " . "in the " . "de" . "mo" . " of" . " webEdition.";

$l_we_editor["text/css"]["response_save_ok"] = "Udało się zapisać arkusz stylu CSS '%s'!";
$l_we_editor["text/css"]["response_publish_ok"] = "Udało się opublikować arkusz stylu CSS '%s' !";
$l_we_editor["text/css"]["response_unpublish_ok"] = "Udało się wycofać arkusz stylu '%s'!";
$l_we_editor["text/css"]["response_save_notok"] = "Błšd zapisu arkusza stylu CSS '%s'!";
$l_we_editor["text/css"]["response_path_exists"] = "Nie udało się zapisać arkusza stylu CSS '%s', ponieważ w tym miejscu znajduje się już plik lub katalog!";
$l_we_editor["text/css"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/css"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/css"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/css"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["text/js"]["response_save_ok"] = "The JavaScript '%s' has been successfully saved!";
$l_we_editor["text/js"]["response_publish_ok"] = "Udało się opublikować plik Javascript '%s'!";
$l_we_editor["text/js"]["response_unpublish_ok"] = "Udało się wycofać plik Javascript '%s'!";
$l_we_editor["text/js"]["response_save_notok"] = "Błšd zapisu pliku Javascripts '%s'!";
$l_we_editor["text/js"]["response_path_exists"] = "Nie udało się zapisać pliku Javascript '%s', ponieważ w tym miejscu znajduje się już plik lub katalog!";
$l_we_editor["text/js"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/js"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/js"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/js"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["text/plain"]["response_save_ok"] = "The text file '%s' has been successfully saved!";
$l_we_editor["text/plain"]["response_publish_ok"] = "Udało się opublikować pliku tekstowego '%s'!";
$l_we_editor["text/plain"]["response_unpublish_ok"] = "Udało się wycofać plik tekstowy '%s'!";
$l_we_editor["text/plain"]["response_save_notok"] = "Błšd zapisu pliku tekstowego '%s'!";
$l_we_editor["text/plain"]["response_path_exists"] = "Nie udało się zapisać pliku tekstowego '%s', ponieważ w tym miejscu znajduje się już plik lub katalog!";
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
$l_we_editor["folder"]["response_publish_ok"] = "Udało się opublikować katalog '%s'!";
$l_we_editor["folder"]["response_unpublish_ok"] = "Udało się wycofać katalog '%s'!";
$l_we_editor["folder"]["response_save_notok"] = "Błšd zapisu katalogu '%s'!";
$l_we_editor["folder"]["response_path_exists"] = "Nie udało się zapisać katalogu '%s', ponieważ w tym miejscu znajduje się już plik lub katalog!";
$l_we_editor["folder"]["filename_empty"] = "Nie wprowadzono jeszcze nazwy dla katalogu!";
$l_we_editor["folder"]["we_filename_notValid"] = "Wprowadzona nazwa katalogu jest nieprawidłowa!\\nDozwolone znaki to litery od a do z (wielkie lub małe) , cyfry, znak podkrelenia (_), minus (-) oraz kropka (.).";
$l_we_editor["folder"]["we_filename_notAllowed"] = "Wprowadzona nazwa katalogu jest niedozwolona!";
$l_we_editor["folder"]["response_save_noperms_to_create_folders"] = "Nie można było zapisać katalogu, ponieważ nie posiadasz wystarczajšcych uprawnień do zakładania nowych katalogów (%s)!";

$l_we_editor["image/*"]["response_save_ok"] = "Udało się zapisać obrazek '%s'!";
$l_we_editor["image/*"]["response_publish_ok"] = "Udało się opublikować obrazek '%s'";
$l_we_editor["image/*"]["response_unpublish_ok"] = "Udało się wycofać obrazek '%s'";
$l_we_editor["image/*"]["response_save_notok"] = "Błšd zapisu obrazka '%s'!";
$l_we_editor["image/*"]["response_path_exists"] = "Nie udało się zapisać obrazka '%s', ponieważ w tym miejscu znajduje się już plik lub katalog!";
$l_we_editor["image/*"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["image/*"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["image/*"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["image/*"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["application/*"]["response_save_ok"] = "The document '%s' has been successfully saved!";
$l_we_editor["application/*"]["response_publish_ok"] = "Udało się opublikować plik '%s'!";
$l_we_editor["application/*"]["response_unpublish_ok"] = "Udało się wycofać plik '%s'!";
$l_we_editor["application/*"]["response_save_notok"] = "Błšd zapisu pliku '%s'!";
$l_we_editor["application/*"]["response_path_exists"] = "Nie udało się zapisać pliku '%s', ponieważ w tym miejscu znajduje się już plik lub katalog!";
$l_we_editor["application/*"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["application/*"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["application/*"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["application/*"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];
$l_we_editor["application/*"]["we_description_missing"] = "Please enter a desription in the 'Desription' field!";
$l_we_editor["application/*"]["response_save_wrongExtension"] =  "Błšd zapisu '%s' \\nRozszerzenie nazwy pliku '%s' jest niedozwolonoe dla innych plików!\\nWprowad w tym celu stronę HTML!";

$l_we_editor["application/x-shockwave-flash"]["response_save_ok"] = "Udało się zapisać animację Flash '%s'!";
$l_we_editor["application/x-shockwave-flash"]["response_publish_ok"] = "Udało się opublikować animację Flash '%s'!";
$l_we_editor["application/x-shockwave-flash"]["response_unpublish_ok"] = "Udało się wycofać animację Flashe '%s'!";
$l_we_editor["application/x-shockwave-flash"]["response_save_notok"] = "Błšd zapisu animacji Flash '%s'!";
$l_we_editor["application/x-shockwave-flash"]["response_path_exists"] = "Nie udało się zapisać animacji Flash '%s' '%s', ponieważ w tym miejscu znajduje się już plik lub katalog!";
$l_we_editor["application/x-shockwave-flash"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["application/x-shockwave-flash"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["application/x-shockwave-flash"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["application/x-shockwave-flash"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["video/quicktime"]["response_save_ok"] = "The Quicktime movie '%s' has been successfully saved!";
$l_we_editor["video/quicktime"]["response_publish_ok"] = "Udało się opublikować film Quicktime '%s'!";
$l_we_editor["video/quicktime"]["response_unpublish_ok"] = "Udało się wycofać film Quicktime '%s'!";
$l_we_editor["video/quicktime"]["response_save_notok"] = "Błšd zapisu filmu Quicktime '%s'!";
$l_we_editor["video/quicktime"]["response_path_exists"] = "Nie udało się zapisać filmu Quicktime '%s', ponieważ w tym miejscu znajduje się już plik lub katalog!";
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