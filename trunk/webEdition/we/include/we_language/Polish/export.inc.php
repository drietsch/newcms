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
 * Language file: export.inc.php
 * Provides language strings.
 * Language: English
 */
$l_export["auto_selection"] = "Automatic selection"; // TRANSLATE
$l_export["txt_auto_selection"] = "Eksportuje automatycznie - wg typu lub klasy dokumentu - wybrane dokumenty lub obiekty.";
$l_export["manual_selection"] = "Wybór rêczny";
$l_export["txt_manual_selection"] = "Eksportuje rêcznie wybrane dokumenty lub obiekty";
$l_export["element"] = "Wybór elementów";
$l_export["documents"] = "Dokumenty";
$l_export["objects"] = "Obiekty";
$l_export["step1"] = "Okre¶l wybór elementów";
$l_export["step2"] = "Wybierz elementy do wyeksportowania";
$l_export["step3"] = "Generic Export";
$l_export["step10"] = "Zakoñcz eksport";
$l_export["step99"] = "B³±d w trakcie eksportowania";
$l_export["step99_notice"] = "Eksport jest nie mo¿liwy";
$l_export["server_finished"] = "Plik eksportu zosta³ zapisany na serwerze.";
$l_export["backup_finished"] = "Eksport zosta³ zakoñczony.";
$l_export["download_starting"] = "Rozpoczêto pobieranie pliku eksportu.<br><br>Je¿eli pobieranie pliku nie rozpocznie siê w ci±gu 10 sekund,<br>";
$l_export["download"] = "kliknij tutaj.";
$l_export["download_failed"] = "¯±dany plik albo nie istnieje albo nie masz uprawnieñ do pobrania go.";
$l_export["file_format"] = "Format pliku";
$l_export["export_to"] = "Eksport do";
$l_export["export_to_server"] = "Serwer";
$l_export["export_to_local"] = "Lokalny dysk twardy";
$l_export["cdata"] = "Kodowanie";
$l_export["export_xml_cdata"] = "Dodaj wycinki CDATA";
$l_export["export_xml_entities"] = "Zast±p encje";
$l_export["filename"] = "Nazwa pliku";
$l_export["path"] = "¦cie¿ka";
$l_export["doctypename"] = "Dokumenty danego typu";
$l_export["classname"] = "Obiekty klasy";
$l_export["dir"] = "Katalog";
$l_export["categories"] = "Kategorie";
$l_export["wizard_title"] = "Kreator eksportu";
$l_export["xml_format"] = "XML"; // TRANSLATE
$l_export["csv_format"] = "CSV"; // TRANSLATE
$l_export["csv_delimiter"] = "Separator";
$l_export["csv_enclose"] = "Ogranicznik tekstu";
$l_export["csv_escape"] = "Znak ESC";
$l_export["csv_lineend"] = "Format pliku";
$l_export["csv_null"] = "Zast±pienie NULL";
$l_export["csv_fieldnames"] = "Pierwszy wiersz zawiera nazwy pól";
$l_export["windows"] = "Format Windows";
$l_export["unix"] = "Format UNIX";
$l_export["mac"] = "Format Mac";
$l_export["generic_export"] = "Generic Export";
$l_export["title"] = "Kreator eksportu";
$l_export["gxml_export"] = "Generic XML Export";
$l_export["txt_gxml_export"] = "Eksport dokumentów i obiektów webEdition do  \"p³askiego\" pliku XML (3 poziomy).";
$l_export["csv_export"] = "Eksport do CSV";
$l_export["txt_csv_export"] = "Eksport obiektów CSV do pliku CSV (Comma Separated Values).";
$l_export["csv_params"] = "Ustawienia";
$l_export["error"] = "Eksport przebieg³ z problemami!";
$l_export["error_unknown"] = "Wyst±pi³ nieznany b³±d!";
$l_export["error_object_module"] = "Eksport danych do plików CSV nie jest obecnie wspierany!<br><br>Poniewa¿ nie zainstalowano modu³u DB/Obiekt, eksport do plików CSV nie jest dostêpny.";
$l_export["error_nothing_selected_docs"] = "Eksport nie zosta³ wykonany!<br><br>Nie wybrano dokumentów.";
$l_export["error_nothing_selected_objs"] = "Eksport nie zosta³ wykonany!<br><br>Nie wybrano dokumentów ani obiektów";
$l_export["error_download_failed"] = "Nie mo¿na pobraæ pliku eksportu.";
$l_export["comma"] = ", {Przecinek}";
$l_export["semicolon"] = "; {Srednik}";
$l_export["colon"] = ": {Dwukropek}";
$l_export["tab"] = "\\t {Tab}";
$l_export["space"] = "  {Spacja}";
$l_export["double_quote"] = "\" {Czudzyslow}";
$l_export["single_quote"] = "' {Cudzyslow prosty}";
$l_export['we_export'] = 'Eksport wE';
$l_export['wxml_export'] = 'Eksport XML webEdition';
$l_export['txt_wxml_export'] = 'Eksport dokumentów, szablonów, obiektów i klas webEdition, zgodnie ze specyficzn± DTD (Definicja Typu Dokumentu).';

$l_export['options'] = 'Options'; // TRANSLATE
$l_export['handle_document_options'] = 'Documents'; // TRANSLATE
$l_export['handle_template_options'] = 'Templates'; // TRANSLATE
$l_export['handle_def_templates'] = 'Export default templates'; // TRANSLATE
$l_export['handle_document_includes'] = 'Export included documents'; // TRANSLATE
$l_export['handle_document_linked'] = 'Export linked documents'; // TRANSLATE
$l_export['handle_object_options'] = 'Objects'; // TRANSLATE
$l_export['handle_def_classes'] = 'Export default classes'; // TRANSLATE
$l_export['handle_object_includes'] = 'Export included objects'; // TRANSLATE
$l_export['handle_classes_options'] = 'Classes'; // TRANSLATE
$l_export['handle_class_defs'] = 'Default value'; // TRANSLATE
$l_export['handle_object_embeds'] = 'Export embedded objects'; // TRANSLATE
$l_export['handle_doctype_options'] = 'Doctypes/<br>Categorys/<br>Navigation'; // TRANSLATE
$l_export['handle_doctypes'] = 'Doctypes'; // TRANSLATE
$l_export['handle_categorys'] = 'Categorys'; // TRANSLATE
$l_export['export_depth'] = 'Export depth'; // TRANSLATE
$l_export['to_level'] = 'to level'; // TRANSLATE
$l_export['select_export'] ='To export an entry, please mark the referring check box in the tree. Important note: All marked items from all branches will be exported and if you export a directory all documents in this directory will be exported as well!'; // TRANSLATE
$l_export['templates'] = 'Templates'; // TRANSLATE
$l_export['classes'] = 'Classes'; // TRANSLATE

$l_export['nothing_to_delete'] = "Nie ma nic do usuniêcia.";
$l_export['nothing_to_save'] = 'Nie ma nic do zapisania!';
$l_export['no_perms'] = 'Nie masz uprawnieñ!';
$l_export['new'] = 'Nowy';
$l_export['export'] = 'Eksport';
$l_export['group'] = 'Grupa';
$l_export['save'] = 'Zapisz';
$l_export['delete'] = 'Usuñ';
$l_export['quit'] = 'Zakoñcz';
$l_export['property'] = 'W³a¶ciwo¶ci';
$l_export['name'] = 'Nazwa';
$l_export['save_to'] = 'Zapisz jako:';
$l_export['selection'] = 'Wybór';
$l_export['save_ok'] = 'Eksport zosta³ zapamiêtany.';
$l_export['save_group_ok'] = 'Grupa zosta³a zapisana.';
$l_export['log'] = 'Szczegó³y';
$l_export['start_export'] = 'Rozpocznij eksport';
$l_export['prepare'] = 'Przygotowanie eksportu...';
$l_export['doctype'] = 'Typ dokumentu';
$l_export['category'] = 'Kategoria';
$l_export['end_export'] = 'Eksport zakoñczony';
$l_export['newFolder'] = "Nowa grupa";
$l_export['folder_empty'] = "Grupa jest pusta";
$l_export['folder_path_exists'] = "Grupa ju¿ istnieje!";
$l_export['wrongtext'] = "Nazwa jest nieprawid³owa!";
$l_export['wrongfilename'] = "The filename is not valid!"; // TRANSLATE
$l_export['folder_exists'] = "Grupa ju¿ istnieje!";
$l_export['delete_ok'] = 'Eksport zosta³ usuniêty.';
$l_export['delete_nok'] = 'B£¡D: Nie usuniêto eksportu';
$l_export['delete_group_ok'] = 'Grupa zosta³a usuniêta.';
$l_export['delete_group_nok'] = 'B£¡D: Grupa nie zosta³a usuniêta';
$l_export['delete_question'] = 'Czy chcesz usun±æ aktualny eksport?';
$l_export['delete_group_question'] = 'Czy chcesz usun±æ aktualn± grupê?';
$l_export['download_starting2'] = 'Pobieranie plików eksportu rozpoczê³o siê.';
$l_export['download_starting3'] = 'Je¿eli pobieranie nie rozpocznie siê po 10 sekundach,';
$l_export['working'] = 'Praca';

$l_export['txt_document_options'] = 'Standardowy szablon to szablon zdefiniowany we w³a¶ciwo¶ciach dokumentu. Zawarte dokumenty to wewnêtrzne dokumenty powi±zane za pomoc± znaczników we:include, we:form, we:url, we:linkToSeeMode, we:a, we:href, we:link, we:css, we:js, we:addDelNewsletterEmail z eksportowanym dokumentem. Zawarte obiekty to obiekty które zosta³y powi±zane za pomoc± we:object i we:form z eksportowanym dokumentem. Po³±czone dokumenty to dokumenty wewnêtrzne po³±czone z eksportowanym dokumentem za pomoc± znaczników HTML body, a, img, table, td .';
$l_export['txt_object_options'] = 'Standardowa klasa to klasa która zosta³a zdefiniowana we w³asno¶ciach dokumentu.';
$l_export['txt_exportdeep_options'] = 'G³êboko¶æ eksportu to g³êboko¶æ toDo której bêd± eksportowane zawarte dokumenty wzglêdnie obiekty. Pole musi zawieraæ liczbê!';
$l_export['name_empty'] = 'Nazwa nie mo¿e byæ pusta!';
$l_export['name_exists'] = 'Nazwa ju¿ istnieje!';

$l_export['help'] = 'Pomoc';
$l_export['info'] = 'Informacje';
$l_export['path_nok'] = '¦cie¿ka jest nieprawid³owa!';

$l_export['must_save'] = 'Eksport zosta³ zmieniony.\\nZanim bêdziesz móg³ dokonaæ eksportu, powiniene¶ zapisaæ dane eksportu!';
$l_export['handle_owners_option'] = 'Dane w³a¶ciciela';
$l_export['handle_owners'] = 'Eksport danych w³a¶ciciela';
$l_export['txt_owners'] = 'Eksportuj wraz z za³±czonymi danymi u¿ytkownika.';

$l_export['weBinary'] = 'File'; // TRANSLATE
$l_export['handle_navigation'] = 'Navigation'; // TRANSLATE
$l_export['weNavigation'] = 'Navigation'; // TRANSLATE
$l_export['weNavigationRule'] = 'Navigation rule'; // TRANSLATE
$l_export['weThumbnail'] = 'Thumbnails'; // TRANSLATE
$l_export['handle_thumbnails'] = 'Thumbnails'; // TRANSLATE
?>