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

$l_we_editor["folder_save_nok_parent_same"] = "Wybrany katalog nadrzêdny le¿y wewn¹trz aktualnego katalogu! Wybierz inny katalog i spróbuj jeszcze raz!";
$l_we_editor["pfolder_notsave"] = "Nie mo¿na zapisaæ katalogu w wybranym katalogu!";
$l_we_editor["required_field_alert"] = "Pole '%s' jest obowi¹zkowe i nale¿y je wype³niæ!";

$l_we_editor["category"]["response_save_ok"] = "Uda³o siê zapisaæ kategoriê '%s'!";
$l_we_editor["category"]["response_save_notok"] = "B³¹d zapisu kategorii '%s'!";
$l_we_editor["category"]["response_path_exists"] = "Nie uda³o siê zapisaæ kategorii '%s', poniewa¿ w tym miejscu znajduje siê ju¿ inna kategoria!";
$l_we_editor["category"]["we_filename_notValid"] = "Podana nazwa jest nieprawid³owa!\\nDopuszczalne s¹ wszystkie znaki poza \\\", ' / < > i \\\\";
$l_we_editor["category"]["filename_empty"]       = "Nazwa nie mo¿e byæ pusta";
$l_we_editor["category"]["name_komma"] = "Podana nazwa jest nieprawid³owa!\\nPrzecinki s¹ niedozwolone";

$l_we_editor["text/webedition"]["response_save_ok"] = "Uda³o siê zapisaæ stronê webEdition '%s'!";
$l_we_editor["text/webedition"]["response_publish_ok"] = "Opublikowano stronê webEdition '%s'!";
$l_we_editor["text/webedition"]["response_publish_notok"] = "B³¹d w trakcie publikowania strony webEdition '%s'!";
$l_we_editor["text/webedition"]["response_unpublish_ok"] = "Uda³o siê wycofaæ stronê webEdition '%s'!";
$l_we_editor["text/webedition"]["response_unpublish_notok"] = "B³¹d w trakcie wycofywania strony webEdition '%s'!";
$l_we_editor["text/webedition"]["response_not_published"] = "Nie wycofano strony webEdition '%s'!";
$l_we_editor["text/webedition"]["response_save_notok"] = "B³¹d zapisu strony webEdition '%s'!";
$l_we_editor["text/webedition"]["response_path_exists"] = "Nie uda³o siê zapisaæ strony webEdition '%s', poniewa¿ w tym miejscu znajduje siê ju¿ plik lub katalog!";
$l_we_editor["text/webedition"]["filename_empty"] = "Nie wprowadzono nazwy pliku!";
$l_we_editor["text/webedition"]["we_filename_notValid"] = "Wprowadzona nazwa pliku jest nieprawid³owa!\\nDozwolone znaki to litery od a do z (wielkie lub ma³e) , cyfry, znak podkreœlenia (_), minus (-) oraz kropka (.).";
$l_we_editor["text/webedition"]["we_filename_notAllowed"] = "Wprowadzona nazwa pliku jest niedozwolona!";
$l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"] = "Nie mo¿na by³o zapisaæ pliku, poniewa¿ nie masz wystarczaj¹cych uprawnieñ do zak³adania nowych katalogów (%s) !";
$l_we_editor["text/webedition"]["autoschedule"] = "Strona webEdition zostanie automatycznie opublikowana dn. %s !";

$l_we_editor["text/html"]["response_save_ok"] = "Uda³o siê zapisaæ stronê HTML '%s'!";
$l_we_editor["text/html"]["response_publish_ok"] = "Uda³o siê opublikowaæ stronê HTML '%s'!";
$l_we_editor["text/html"]["response_publish_notok"] = "B³¹d w trakcie publikowania strony HTML'%s'!";
$l_we_editor["text/html"]["response_unpublish_ok"] = "Uda³o siê wycofaæ stronê HTML '%s'!";
$l_we_editor["text/html"]["response_unpublish_notok"] = "B³¹d w trakcie wycofywania strony HTML '%s'!";
$l_we_editor["text/html"]["response_not_published"] = "Nie opublikowano strony HTML '%s'!";
$l_we_editor["text/html"]["response_save_notok"] = "B³¹d zapisu strony HTML '%s'!";
$l_we_editor["text/html"]["response_path_exists"] = "Nie uda³o siê zapisaæ strony '%s', poniewa¿ w tym miejscu znajduje siê ju¿ plik lub katalog!";
$l_we_editor["text/html"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/html"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/html"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/html"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];
$l_we_editor["text/html"]["autoschedule"] = "The HTML page will be published automatically on %s.";

$l_we_editor["text/weTmpl"]["response_save_ok"] = "Uda³o siê zapisaæ szablon '%s'!";
$l_we_editor["text/weTmpl"]["response_publish_ok"] = "Uda³o siê opublikowaæ szablon '%s'!";
$l_we_editor["text/weTmpl"]["response_unpublish_ok"] = "Uda³o siê wycofaæ szablon '%s'!";
$l_we_editor["text/weTmpl"]["response_save_notok"] = "B³¹d zapisu szablonu '%s'!";
$l_we_editor["text/weTmpl"]["response_path_exists"] = "Nie uda³o siê zapisaæ szablonu '%s', poniewa¿ w tym miejscu znajduje siê ju¿ plik lub katalog!";
$l_we_editor["text/weTmpl"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/weTmpl"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/weTmpl"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/weTmpl"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];
$l_we_editor["text/weTmpl"]["no_template_save"] = "Templates " . "can " . "not " . "saved " . "in the " . "de" . "mo" . " of" . " webEdition.";

$l_we_editor["text/css"]["response_save_ok"] = "Uda³o siê zapisaæ arkusz stylu CSS '%s'!";
$l_we_editor["text/css"]["response_publish_ok"] = "Uda³o siê opublikowaæ arkusz stylu CSS '%s' !";
$l_we_editor["text/css"]["response_unpublish_ok"] = "Uda³o siê wycofaæ arkusz stylu '%s'!";
$l_we_editor["text/css"]["response_save_notok"] = "B³¹d zapisu arkusza stylu CSS '%s'!";
$l_we_editor["text/css"]["response_path_exists"] = "Nie uda³o siê zapisaæ arkusza stylu CSS '%s', poniewa¿ w tym miejscu znajduje siê ju¿ plik lub katalog!";
$l_we_editor["text/css"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/css"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/css"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/css"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["text/js"]["response_save_ok"] = "The JavaScript '%s' has been successfully saved!";
$l_we_editor["text/js"]["response_publish_ok"] = "Uda³o siê opublikowaæ plik Javascript '%s'!";
$l_we_editor["text/js"]["response_unpublish_ok"] = "Uda³o siê wycofaæ plik Javascript '%s'!";
$l_we_editor["text/js"]["response_save_notok"] = "B³¹d zapisu pliku Javascripts '%s'!";
$l_we_editor["text/js"]["response_path_exists"] = "Nie uda³o siê zapisaæ pliku Javascript '%s', poniewa¿ w tym miejscu znajduje siê ju¿ plik lub katalog!";
$l_we_editor["text/js"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/js"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/js"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/js"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["text/plain"]["response_save_ok"] = "The text file '%s' has been successfully saved!";
$l_we_editor["text/plain"]["response_publish_ok"] = "Uda³o siê opublikowaæ pliku tekstowego '%s'!";
$l_we_editor["text/plain"]["response_unpublish_ok"] = "Uda³o siê wycofaæ plik tekstowy '%s'!";
$l_we_editor["text/plain"]["response_save_notok"] = "B³¹d zapisu pliku tekstowego '%s'!";
$l_we_editor["text/plain"]["response_path_exists"] = "Nie uda³o siê zapisaæ pliku tekstowego '%s', poniewa¿ w tym miejscu znajduje siê ju¿ plik lub katalog!";
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
$l_we_editor["folder"]["response_publish_ok"] = "Uda³o siê opublikowaæ katalog '%s'!";
$l_we_editor["folder"]["response_unpublish_ok"] = "Uda³o siê wycofaæ katalog '%s'!";
$l_we_editor["folder"]["response_save_notok"] = "B³¹d zapisu katalogu '%s'!";
$l_we_editor["folder"]["response_path_exists"] = "Nie uda³o siê zapisaæ katalogu '%s', poniewa¿ w tym miejscu znajduje siê ju¿ plik lub katalog!";
$l_we_editor["folder"]["filename_empty"] = "Nie wprowadzono jeszcze nazwy dla katalogu!";
$l_we_editor["folder"]["we_filename_notValid"] = "Wprowadzona nazwa katalogu jest nieprawid³owa!\\nDozwolone znaki to litery od a do z (wielkie lub ma³e) , cyfry, znak podkreœlenia (_), minus (-) oraz kropka (.).";
$l_we_editor["folder"]["we_filename_notAllowed"] = "Wprowadzona nazwa katalogu jest niedozwolona!";
$l_we_editor["folder"]["response_save_noperms_to_create_folders"] = "Nie mo¿na by³o zapisaæ katalogu, poniewa¿ nie posiadasz wystarczaj¹cych uprawnieñ do zak³adania nowych katalogów (%s)!";

$l_we_editor["image/*"]["response_save_ok"] = "Uda³o siê zapisaæ obrazek '%s'!";
$l_we_editor["image/*"]["response_publish_ok"] = "Uda³o siê opublikowaæ obrazek '%s'";
$l_we_editor["image/*"]["response_unpublish_ok"] = "Uda³o siê wycofaæ obrazek '%s'";
$l_we_editor["image/*"]["response_save_notok"] = "B³¹d zapisu obrazka '%s'!";
$l_we_editor["image/*"]["response_path_exists"] = "Nie uda³o siê zapisaæ obrazka '%s', poniewa¿ w tym miejscu znajduje siê ju¿ plik lub katalog!";
$l_we_editor["image/*"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["image/*"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["image/*"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["image/*"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["application/*"]["response_save_ok"] = "The document '%s' has been successfully saved!";
$l_we_editor["application/*"]["response_publish_ok"] = "Uda³o siê opublikowaæ plik '%s'!";
$l_we_editor["application/*"]["response_unpublish_ok"] = "Uda³o siê wycofaæ plik '%s'!";
$l_we_editor["application/*"]["response_save_notok"] = "B³¹d zapisu pliku '%s'!";
$l_we_editor["application/*"]["response_path_exists"] = "Nie uda³o siê zapisaæ pliku '%s', poniewa¿ w tym miejscu znajduje siê ju¿ plik lub katalog!";
$l_we_editor["application/*"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["application/*"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["application/*"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["application/*"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];
$l_we_editor["application/*"]["we_description_missing"] = "Please enter a desription in the 'Desription' field!";
$l_we_editor["application/*"]["response_save_wrongExtension"] =  "B³¹d zapisu '%s' \\nRozszerzenie nazwy pliku '%s' jest niedozwolonoe dla innych plików!\\nWprowadŸ w tym celu stronê HTML!";

$l_we_editor["application/x-shockwave-flash"]["response_save_ok"] = "Uda³o siê zapisaæ animacjê Flash '%s'!";
$l_we_editor["application/x-shockwave-flash"]["response_publish_ok"] = "Uda³o siê opublikowaæ animacjê Flash '%s'!";
$l_we_editor["application/x-shockwave-flash"]["response_unpublish_ok"] = "Uda³o siê wycofaæ animacjê Flashe '%s'!";
$l_we_editor["application/x-shockwave-flash"]["response_save_notok"] = "B³¹d zapisu animacji Flash '%s'!";
$l_we_editor["application/x-shockwave-flash"]["response_path_exists"] = "Nie uda³o siê zapisaæ animacji Flash '%s' '%s', poniewa¿ w tym miejscu znajduje siê ju¿ plik lub katalog!";
$l_we_editor["application/x-shockwave-flash"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["application/x-shockwave-flash"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["application/x-shockwave-flash"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["application/x-shockwave-flash"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["video/quicktime"]["response_save_ok"] = "The Quicktime movie '%s' has been successfully saved!";
$l_we_editor["video/quicktime"]["response_publish_ok"] = "Uda³o siê opublikowaæ film Quicktime '%s'!";
$l_we_editor["video/quicktime"]["response_unpublish_ok"] = "Uda³o siê wycofaæ film Quicktime '%s'!";
$l_we_editor["video/quicktime"]["response_save_notok"] = "B³¹d zapisu filmu Quicktime '%s'!";
$l_we_editor["video/quicktime"]["response_path_exists"] = "Nie uda³o siê zapisaæ filmu Quicktime '%s', poniewa¿ w tym miejscu znajduje siê ju¿ plik lub katalog!";
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