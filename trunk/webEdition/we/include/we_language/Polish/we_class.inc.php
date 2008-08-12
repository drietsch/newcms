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
 * Language file: we_class.inc.php
 * Provides language strings.
 * Language: English
 */
include_once(dirname(__FILE__)."/enc_".basename(__FILE__));

$l_we_class["ChangePark"] = "T� w�a�ciwo�� mo�na zmieni� tylko gdy wycofano dokument!";
$l_we_class["fieldusers"] = "U�ytkownicy";
$l_we_class["other"] = "Inne";
$l_we_class["use_object"] = "Obiekt u�ytkownika";
$l_we_class["language"] = "Language"; // TRANSLATE
$l_we_class["users"] = "Domy�lny w�a�ciciel";
$l_we_class["copytext/css"] = "Kopiuj arkusz stylu CSS";
$l_we_class["copytext/js"] = "Kopiuj Javascript";
$l_we_class["copytext/html"] = "Kopiuj stron� HTML";
$l_we_class["copytext/plain"] = "Kopiuj stron� tekstow�";
$l_we_class["copytext/xml"] = "Copy XML document"; // TRANSLATE
$l_we_class["copyTemplate"] = "Kopiuj szablon";
$l_we_class["copyFolder"] = "Kopiuj katalog";
$l_we_class["copy_owners_expl"] = "Wybierz katalog, kt�rego zawarto�� ma zosta� skopiowana do bie��cego katalogu.";
$l_we_class["category"] = "Kategoria";
$l_we_class["folder_saved_ok"] = "Zapami�tano katalog '%s' !";
$l_we_class["response_save_ok"] = "Zapami�tano dokument '%s' !";
$l_we_class["response_publish_ok"] = "Opublikowano dokument '%s' !";
$l_we_class["response_unpublish_ok"] = "Wycofano dokument '%s'!";
$l_we_class["response_save_notok"] = "B��d przy zapisywaniu dokumentu '%s'!";
$l_we_class["response_path_exists"] = "Nie mo�na zapisa� dokumentu lub katalogu %s, poniewa� w tym miejscu znajduje si� inny dokument!";
$l_we_class["width"] = "Szeroko��";
$l_we_class["height"] = "Wysoko��";
$l_we_class["width_tmp"] = "Szeroko��";
$l_we_class["height_tmp"] = "Wysoko��";
$l_we_class["percent_width_tmp"] = "Szeroko�� w %";
$l_we_class["percent_height_tmp"] = "Wysoko�� w %";
$l_we_class["alt"] = "Tekst alternatywny";
$l_we_class["alt_kurz"] = "Etykieta Alt";
$l_we_class["title"] = "Tytu�";
$l_we_class["use_meta_title"] = "Zastosuj Meta-Tytu�";
$l_we_class["longdesc_text"] = "Plik do atrybutu 'longdesc'";
$l_we_class["align"] = "Wyr�wnianie";
$l_we_class["name"] = "Nazwa";
$l_we_class["hspace"] = "Odst�p poziomy";
$l_we_class["vspace"] = "Odst�p pionowy";
$l_we_class["border"] = "Margines";
$l_we_class["fields"] = "Pola";
$l_we_class["AutoFolder"] = "Automatyczny katalog";
$l_we_class["AutoFilename"] = "Nazwa pliku";
$l_we_class["import_ok"] = "Zaimportowano dokument!";
$l_we_class["function"] = "Funkcja";
$l_we_class["contenttable"] = "Tabela zawarto�ci";
$l_we_class["quality"] = "Jako��";
$l_we_class["salign"] = "Wyr�wnanie animacji Flash";
$l_we_class["play"] = "Odtw�rz";
$l_we_class["loop"] = "Powt�rz";
$l_we_class["scale"] = "Skaluj";
$l_we_class["bgcolor"] = "Kolor t�a";
$l_we_class["response_save_noperms_to_create_folders"] = "Nie mo�na zapisa� dokumentu, poniewa� nie masz wystarczaj�cych uprawnie�, �eby utworzy� nowe katalogi (%s) !";
$l_we_class["file_on_liveserver"]="Ten plik ju� istnieje !";
$l_we_class["defaults"] = "Warto�� standardowa";
$l_we_class["attribs"] = "Atrybuty";
$l_we_class["intern"] = "Wewn�trzny";
$l_we_class["extern"] = "Zewn�trzny";
$l_we_class["linkType"] = "Typ odno�nika";
$l_we_class["href"] = "Href"; // TRANSLATE
$l_we_class["target"] = "Target"; // TRANSLATE
$l_we_class["hyperlink"] = "Hyperlink"; // TRANSLATE
$l_we_class["nolink"] = "Brak odno�nika";
$l_we_class["noresize"] = "Nie zmieniaj";
$l_we_class["pixel"] = "Piksel";
$l_we_class["percent"] = "Procent";
$l_we_class["new_doc_type"] = "Nowy typ dokumentu";
$l_we_class["doctypes"] = "Typy dokumentu&nbsp;";
$l_we_class["subdirectory"] = "Podkatalog";
$l_we_class["subdir"][SUB_DIR_NO] = "-- brak --";
$l_we_class["subdir"][SUB_DIR_YEAR] = "Rok";
$l_we_class["subdir"][SUB_DIR_YEAR_MONTH] = "Rok/Miesi�c";
$l_we_class["subdir"][SUB_DIR_YEAR_MONTH_DAY] = "Rok/Miesi�c/Dzie�";
$l_we_class["doctype_save_ok"] = "Zapisano typ dokumentu '%s'!";
$l_we_class["doctype_save_nok_exist"] = "Typ dokumentu o nazwie '%s' ju� istnieje.\\n Wybierz inn� nazw� i spr�buj ponownie!";
$l_we_class["delete_doc_type"] = "Kasuj '%s'";
$l_we_class["doctype_delete_prompt"] = "Kasowanie typu dokumentu '%s'! Na pewno?";
$l_we_class["doctype_delete_nok"] = "Typ dokumentuo nazwie '%s' jest ju� u�ywany!\\n Nie mo�na usun�� typu dokumentu!";
$l_we_class["doctype_delete_ok"] = "Usuni�to typ dokumentu o nazwie '%s'!";
$l_we_class["confirm_ext_change"] = "Zmieni�e� 'Dynamiczne generowanie strony' !\\nCzy chcesz przywr�ci� domy�ln� warto�� rozszerzenia pliku?";
$l_we_class["newDocTypeName"] = 'Wprowad� nazw� typu dokumentu!';
$l_we_class["no_perms"] = "Nie masz uprawnie� do korzystania z tej strony!";
$l_we_class["workspaces"] = "Obszary robocze";
$l_we_class["extraWorkspaces"] = "Dodatkowe obszary robocze";
$l_we_class["edit"] = "Edycja";
$l_we_class["workspace"] = "Obszar roboczy";
$l_we_class["information"] = "Informacja";
$l_we_class["previeweditmode"] = "Preview Editmode"; // TRANSLATE
$l_we_class["preview"] = "Podgl�d";
$l_we_class["no_preview_available"] = "No preview available for this file. To view this file please download it first."; // TRANSLATE
$l_we_class["file_not_saved"] = "File wasn't saved yet."; // TRANSLATE
$l_we_class["download"] = "Download"; // TRANSLATE
$l_we_class["validation"] = "Walidacja";
$l_we_class["variants"] = "Warianty";
$l_we_class["tab_properties"] = "W�a�ciwo�ci";
$l_we_class["metainfos"] = "Meta-Informacje";
$l_we_class["fields"] = "Pola";
$l_we_class["search"] = "Szukaj";
$l_we_class["schedpro"] = "Harmonogram PRO";
$l_we_class["generateTemplate"] = "Utw�rz szablon";
$l_we_class["autoplay"] = "Automatyczne odtwarzanie";
$l_we_class["controller"] = "Poka� listw� narz�dzi";
$l_we_class["volume"] = "G�o�no��";
$l_we_class["hidden"] = "Ukryj";
$l_we_class["workspacesFromClass"] = "Przejmij z klasy";
$l_we_class["image"] = "Obrazek";
$l_we_class["thumbnails"] = "Widoki miniatur";
$l_we_class["edit_show"] = "Wy�wietl opcje obrazu";
$l_we_class["edit_hide"] = "Ukryj opcje obrazu";
$l_we_class["resize"] = "Zmie� wielko��";
$l_we_class["rotate"] = "Obr�� obrazek";
$l_we_class["rotate_hint"] = "Zainstalowana na serwerze wersja biblioteki GD nie wspiera obrotu obrazk�w!";
$l_we_class["crop"] = "Crop image"; // TRANSLATE
$l_we_class["quality"] = "Jako��";
$l_we_class["quality_hint"] = "Ustaw jako�� obrazu dla kompresji JPEG. <br><br> 10: najlepsza jako�� obrazu, wymaga wi�kszej ilo�ci miejsca na dysku <br> 0: najgorsza jako�� obrazu, wymaga mniejszej ilo�ci miejsca";
$l_we_class["quality_maximum"] = "Maksymalna";
$l_we_class["quality_high"] = "Wysoka";
$l_we_class["quality_medium"] = "�rednia";
$l_we_class["quality_low"] = "Niska";
$l_we_class["convert"] = "Konwertuj";
$l_we_class["convert_gif"] = "Format GIF";
$l_we_class["convert_jpg"] = "Format JPEG";
$l_we_class["convert_png"] = "Format PNG";
$l_we_class["rotate0"] = "Bez obracania";
$l_we_class["rotate180"] = "Obr�t 180&deg;";
$l_we_class["rotate90l"] = "Obr�t 90&deg; w lewo";
$l_we_class["rotate90r"] = "Obr�t 90&deg; w prawo";
$l_we_class["change_compression"] = "Zmie� stopie� kompresji";
$l_we_class["upload"] = "Za�aduj";
$l_we_class["type_not_supported_hint"] = "Zainstalowana na serwerze wersja biblioteki GD nie wspiera  %s jako formatu wyj�ciowego! Przekonwertuj najpierw obrazek do kompatybilnego formatu!";
$l_we_class["CSS"] = "CSS"; // TRANSLATE
$l_we_class['we_del_workspace_error'] = "Nie mo�na usun�� obszaru roboczego, poniewa� jest on u�ywany przez obiekty klasy!";
$l_we_class["master_template"] = "Master template"; // TRANSLATE
$l_we_class["same_master_template"] = "The selected master template cannot be identical with the current template!"; // TRANSLATE
$l_we_class["documents"] = "Documents"; // TRANSLATE
$l_we_class["no_documents"] = "No document based on this template"; // TRANSLATE

$l_we_class["grant_language"] = "Change language"; // TRANSLATE
$l_we_class["grant_language_expl"] = "Change the language of all files and directories which reside in the current directory to the setting above."; // TRANSLATE
$l_we_class["grant_language_ok"] = "Language have been successfully changed!"; // TRANSLATE
$l_we_class["grant_language_notok"] = "There was an error while changing the language!"; // TRANSLATE
$l_we_class["notValidFolder"] = "The directory chosen is invalid!"; // TRANSLATE


$l_we_class["saveFirstMessage"] = "You need to save your changes before executing this command."; // TRANSLATE

$l_we_class["image_edit_null_not_allowed"] = "In the fields Width and Height only numbers greater than 0 are allowed!"; // TRANSLATE

?>