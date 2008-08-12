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
 * Language file: import.inc.php
 * Provides language strings.
 * Language: English
 */
$l_import['title'] = 'Kreator importu';
$l_import['wxml_import'] = 'Import webEdition XML';
$l_import['gxml_import'] = 'Import zwyk³ego XML';
$l_import['csv_import'] = 'Import CSV';
$l_import['import'] = 'Importuj';
$l_import['none'] = '-- ¿aden --';
$l_import['any'] = '-- brak --';
$l_import['source_file'] = 'Plik Ÿród³owy';
$l_import['import_dir'] = 'Katalog docelowy';
$l_import['select_source_file'] = 'Wybierz plik Ÿród³owy.';
$l_import['we_title'] = 'Tytu³';
$l_import['we_description'] = 'Tekst opisu';
$l_import['we_keywords'] = 'S³owa kluczowe';
$l_import['uts'] = 'Unix-Timestamp'; // TRANSLATE
$l_import['unix_timestamp'] = 'Unix-Timestamp liczy sekundy od pocz¹tku epoki Uniksa (01.01.1970).';
$l_import['gts'] = 'GMT Timestamp'; // TRANSLATE
$l_import['gmt_timestamp'] = 'General Mean Time ew. Greenwich Mean Time (w skrócie GMT).';
$l_import['fts'] = 'W³asny format';
$l_import['format_timestamp'] = 'We wskazaniu formatu dopuszcza siê nastêpuj¹ce symbole: Y (czterocyfrowe przedstawienie roku: 2004), y (dwucyfrowe przedstawienie roku: 04), m (Miesi¹c z zerem na pocz¹tku: 01 do 12), n (Miesi¹c bez zera na pocz¹tku: 1 do 12), d (Dzieñ miesi¹ca dwucyfrowo z zerem na pocz¹tku: 01 do 31), j (Dzieñ miesi¹ca bez zera na pocz¹tku: 1 do 31), H (godzina w formacie 24-godzinnym: 00 do 23), G (godzina w formacie 24-godzinnym bez zera na pocz¹tku: 0 do 23), i (minuty: 00 do 59), s (sekundy z zerem na pocz¹tku: 00 do 59)';
$l_import['import_progress'] = 'Importuj';
$l_import['prepare_progress'] = 'Przygotowanie';
$l_import['finish_progress'] = 'Gotowe';
$l_import['finish_import'] = 'Import zakoñczony!';
$l_import['import_file'] = 'Import pliku';
$l_import['import_data'] = 'Import danych';
$l_import['file_import'] = 'Import lokalnych plików';
$l_import['txt_file_import'] = 'Importuj jeden lub wiêcej plików z lokalnego dysku twardego.';
$l_import['site_import'] = 'Importuj pliki z serwera';
$l_import['site_import_isp'] = 'Importuj obrazki z serwera';
$l_import['txt_site_import_isp'] = 'Importuj obrazki z katalogu serwera. Wybierz, które obrazki maj¹ byæ importowane.';
$l_import['txt_site_import'] = 'Importuj pliki z katalogu na serwerze. Wybierz za pomoc¹ ustawienia opcji fitra, czy maj¹ byæ importowane obrazki, strony HTML, pliki Flash, Javascript, CSS, dokumenty tekstowe lub inne pliki.';
$l_import['txt_wxml_import'] = 'Pliki XML webEdition zawieraj¹ informacje o dokumentach, szablonach i obiektach webEdition. Ustaw do którego katalogu importowaæ te dokumenty i obiekty.';
$l_import['txt_gxml_import'] = 'Import "flat" XML files, such as those provided by phpMyAdmin. The dataset fields have to be allocated to the webEdition dataset fields. Use this to import XML files exported from webEdition without the export module.'; // TRANSLATE
$l_import['txt_csv_import'] = 'Import plików CSV (Comma Separated Values) lub opartych na nich formatach tekstowych (np. *.txt). Pola danych przyporz¹dkowuje siê polom webEdition.';
$l_import['add_expat_support'] = 'Interfejs importu XML wymaga rozszerzenia XML expat autorstwa Jamesa Clark. Skompiluj ponownie PHP z rozszerzeniem expat, ¿eby program móg³ wspieraæ funkcjê  importu XML.';
$l_import['xml_file'] = 'Plik XML';
$l_import['templates'] = 'Szablony';
$l_import['classes'] = 'Klasy';
$l_import['predetermined_paths'] = 'Domyœlna œcie¿ka';
$l_import['maintain_paths'] = 'Zachowaj œcie¿ki';
$l_import['import_options'] = 'Opcje importu';
$l_import['file_collision'] = 'Przy istniej¹cym pliku';
$l_import['collision_txt'] = 'Przy imporcie plików do katalogu, który zawiera plik o identycznej nazwie, dochodzi do konfliktów. Podaj, w jaki sposób Kreator importu powinien traktowaæ takie pliki.';
$l_import['replace'] = 'Zast¹p';
$l_import['replace_txt'] = 'Usun¹æ istniej¹ce dane przed zapisaniem Twojego nowego pliku.';
$l_import['rename'] = 'Zmieñ nazwê';
$l_import['rename_txt'] = 'Do nazwy plików zostanie dodane jednoznaczne rozszerzenie ID. Wszystkie odnoœniki, które wskazuj¹ na ten plik zostan¹ odpowiednio dopasowane.';
$l_import['skip'] = 'Pomiñ';
$l_import['skip_txt'] = 'Przy pomijaniu danego pliku zostanie zachowany plik istniej¹cy.';
$l_import['extra_data'] = 'Dodatkowe dane';
$l_import['integrated_data'] = 'Importuj zintegrowane dane';
$l_import['integrated_data_txt'] = 'Je¿eli wybierzesz t¹ opcjê, to dane zawarte w szablonach lub dokumentach bêd¹ importowane.';
$l_import['max_level'] = 'do poziomu';
$l_import['import_doctypes'] = 'Importuj typy dokumentów';
$l_import['import_categories'] = 'Importuj kategorie';
$l_import['invalid_wxml'] = 'Mo¿na importowaæ tylko te dokumenty XML, któe odpowiadaj¹ Definicji Typu Dokumentu (DTD) webEdition.';
$l_import['valid_wxml'] = 'Dokument XML jest dobrze sformatowany i prawid³owy tzn. opdowiada Definicji Typu Dokumentu (DTD) webEdition.';
$l_import['specify_docs'] = 'Wybierz dokumenty, które chcesz importowaæ.';
$l_import['specify_objs'] = 'Wybierz obiekty, które chcesz importowaæ.';
$l_import['specify_docs_objs'] = 'Wybierz, czy chcesz importowaæ dokumenty i/lub obiekty.';
$l_import['no_object_rights'] = 'Nie masz uprawnieñ do importu obiektów.';
$l_import['display_validation'] = 'Wyœwietl walidacjê XML';
$l_import['xml_validation'] = 'Walidacja XML';
$l_import['warning'] = 'Ostrze¿enie';
$l_import['attribute'] = 'Atrybut';
$l_import['invalid_nodes'] = 'Nieprawid³owy wêze³ XML w pozycji ';
$l_import['no_attrib_node'] = 'Brakuj¹cy element XML "attrib" w pozycji ';
$l_import['invalid_attributes'] = 'Nieprawid³owy atrybut w pozycji ';
$l_import['attrs_incomplete'] = 'Lista atrybutów zdefiniowanych jako #required i #fixed jest niekompletna w pozycji ';
$l_import['wrong_attribute'] = 'Nazwy atrybutu nie zdefiniowano ani jako #required, ani jako #implied w pozycji ';
$l_import['documents'] = 'Dokumenty';
$l_import['objects'] = 'Obiekty';
$l_import['fileselect_server'] = 'Pobierz plik Ÿród³owy z serwera';
$l_import['fileselect_local'] = 'Za³aduj plik Ÿród³owy z lokalnego dysku twardego';
$l_import['filesize_local'] = 'Ze wzglêdu na ograniczenia PHP plik do za³adowania nie mo¿e byæ wiêkszy ni¿ %s !';
$l_import['xml_mime_type'] = 'Nie mo¿na zaimportowaæ wybranego pliku. Mime-Typ:';
$l_import['invalid_path'] = 'Nieprawid³owa œcie¿ka do pliku Ÿród³owego.';
$l_import['ext_xml'] = 'Wybierz plik Ÿród³owy z rozszerzeniem ".xml".';
$l_import['store_docs'] = 'Katalog docelowy dokumentów';
$l_import['store_tpls'] = 'Katalog docelowy szablonów stron';
$l_import['store_objs'] = 'Katalog docelowy obiektów';
$l_import['doctype'] = 'Document type';
$l_import['gxml'] = 'Zwyk³y XML';
$l_import['data_import'] = 'Importuj dane';
$l_import['documents'] = 'Dokumenty';
$l_import['objects'] = 'Obiekty';
$l_import['type'] = 'Typ';
$l_import['template'] = 'Szablony';
$l_import['class'] = 'Klasa';
$l_import['categories'] = 'Kategorie';
$l_import['isDynamic'] = 'Generuj dynamicznie stronê';
$l_import['extension'] = 'Rozszerzenie';
$l_import['filetype'] = 'Typ pliku';
$l_import['directory'] = 'Katalog';
$l_import['select_data_set'] = 'Wybierz zestaw danych';
$l_import['select_docType'] = 'Wybierz szablon.';
$l_import['file_exists'] = 'Wybrany plik Ÿród³owy nie istnieje. SprawdŸ podan¹ œcie¿kê. Œcie¿ka: ';
$l_import['file_readable'] = 'Wybrany plik Ÿró³owy nie ma ustawionych uprawnieñ do odczytu i nie mo¿na go zaimportowaæ.';
$l_import['asgn_rcd_flds'] = 'Przyporz¹dkuj pola danych';
$l_import['we_flds'] = 'Pola webEdition&nbsp;';
$l_import['rcd_flds'] = 'Pola rekordów&nbsp;';
$l_import['name'] = 'Nazwa';
$l_import['auto'] = 'automatycznie';
$l_import['asgnd'] = 'przyporz¹dkowane';
$l_import['pfx'] = 'Prefiks';
$l_import['pfx_doc'] = 'Dokument';
$l_import['pfx_obj'] = 'Obiekt';
$l_import['rcd_fld'] = 'Pole rekordu';
$l_import['import_settings'] = 'Ustawienia importu';
$l_import['xml_valid_1'] = 'Plik XML jest prawid³owy i zawiera';
$l_import['xml_valid_s2'] = 'Elementów. Wybierz elementy, które chcesz importowaæ.';
$l_import['xml_valid_m2'] = 'Wêze³ potomny XML pierwszego poziomu ma ró¿ne nazwy. Wybierz wêz³y XML oraz liczbê elementów, które chcesz importowaæ.';
$l_import['well_formed'] = 'Dokument XML jest dobrze sformatowany.';
$l_import['not_well_formed'] = 'Dokument XML nie jest dobrze sformatowany i nie mo¿na go zaimportowaæ.';
$l_import['missing_child_node'] = 'Dokument XML jest dobrze sformatowany, nie zawiera jednak wêz³ów XML i dlatego nie mo¿na go zaimportowaæ.';
$l_import['select_elements'] = 'Wybierz elementy, które chcesz importowaæ.';
$l_import['num_elements'] = 'Wybierz liczbê elementów pomiêdzy 1 a ';
$l_import['xml_invalid'] = ''; // TRANSLATE
$l_import['option_select'] = 'Wybór..';
$l_import['num_data_sets'] = 'Rekordy:';
$l_import['to'] = 'do';
$l_import['assign_record_fields'] = 'Przyporz¹dkuj pola danych';
$l_import['we_fields'] = 'Pola webEdition';
$l_import['record_fields'] = 'Pola rekordów';
$l_import['record_field'] = 'Pole rekordu ';
$l_import['attributes'] = 'Atrybut';
$l_import['settings'] = 'Ustawienia';
$l_import['field_options'] = 'Opcje pola';
$l_import['csv_file'] = 'Plik CSV';
$l_import['csv_settings'] = 'Ustawienia CSV';
$l_import['xml_settings'] = 'Ustawienia XML';
$l_import['file_format'] = 'Format pliku';
$l_import['field_delimiter'] = 'separator';
$l_import['comma'] = ', {Przecinek}';
$l_import['semicolon'] = '; {Srednik}';
$l_import['colon'] = ': {Dwukropek}';
$l_import['tab'] = "\\t {Tab}";
$l_import['space'] = '  {Spacja}';
$l_import['text_delimiter'] = 'Ogranicznik tekstu';
$l_import['double_quote'] = '" {Cudzyslow}';
$l_import['single_quote'] = '\' {Cudzyslow prosty}';
$l_import['contains'] = 'Pierwszy wiersz zawiera nazwy pól';
$l_import['split_xml'] = 'Importuj rekordy wg kolejnoœci';
$l_import['wellformed_xml'] = 'Sprawdzenie formatowania XML';
$l_import['validate_xml'] = 'Walidacja XML';
$l_import['select_csv_file'] = 'Wybierz plik Ÿród³owy CSV.';
$l_import['select_seperator'] = 'Wybierz separator.';
$l_import['format_date'] = 'Format daty';
$l_import['info_sdate'] = 'Wybierz format daty dla pola webEdition';
$l_import['info_mdate'] = 'Wybierz format daty dla pól webEdition';
$l_import['remark_csv'] = 'Mo¿na importowaæ pliki CSV (Comma Separated Values) lub oparte na nich formaty tekstowe (np. *.txt). Przy imporcie tych formatów danych mo¿na ustawiæ znak separatora(np. , ; Tab, spacja) oraz ogranicznik tekstu (= znak, który zamyka wpis tekstowy).';
$l_import['remark_xml'] = 'Wybierz opcjê "Importuj rekordy pojedynczo", ¿eby mo¿na by³o importowaæ du¿e pliki w ci¹gu zdefiniowanego jako limit (Timeout) czasu wykonywania skryptu PHP.<br>Je¿eli nie jeseœ pewien, czy wybrany plik jest plikiem XML webEdition, to mo¿esz przed importem sprawdziæ plik pod k¹tem jego dobrego sformatowania i poprawnoœci typu.';

$l_import["import_docs"]="Importuj dokumenty";
$l_import["import_templ"]="Importuj szablony";
$l_import["import_objs"]="Importuj obiekty";
$l_import["import_classes"]="Importuj klasy";
$l_import["import_doctypes"]="Importuj typy dokumentu";
$l_import["import_cats"]="Importuj kategorie";
$l_import["documents_desc"]="Podaj katalog, do którego maj¹ zostaæ zaimportowane dokumenty. W przypadku gdy wybrano opcjê \"".$l_import['maintain_paths']."\", to odpowiednie œcie¿ki zostan¹ ustawione automatycznie, w innym zaœ przypadku, bêd¹ one zignorowane.";
$l_import["templates_desc"]="Podaj katalog, do którego maj¹ zostaæ zaimportowane szablony. W przypadku gdy wybrano opcjê \"".$l_import['maintain_paths']."\", to odpowiednie œcie¿ki zostan¹ ustawione automatycznie, w innym zaœ przypadku, bêd¹ one zignorowane.";
$l_import['handle_document_options'] = 'Dokumenty';
$l_import['handle_template_options'] = 'Szablony';
$l_import['handle_object_options'] = 'Obiekty';
$l_import['handle_class_options'] = 'Klasa';
$l_import["handle_doctype_options"] = "Typy dokumentów";
$l_import["handle_category_options"] = "Kategorie";
$l_import['log'] = 'Details'; // TRANSLATE
$l_import['start_import'] = 'Rozpoczêcie importu';
$l_import['prepare'] = 'Przygotowanie...';
$l_import['update_links'] = 'Aktualizacja odnoœników...';
$l_import['doctype'] = 'Typ dokumentu';
$l_import['category'] = 'Kategoria';
$l_import['end_import'] = 'Import zakoñczony';

$l_import['handle_owners_option'] = 'Dane u¿ytkownika';
$l_import['txt_owners'] = 'Importuj wraz z danymi u¿ytkownika.';
$l_import['handle_owners'] = 'Przywróæ dane u¿ytkownika';
$l_import['notexist_overwrite'] = 'Je¿eli u¿ytkownik nie istnieje, wtedy stosuje siê opcjê "Nadpisz dane u¿ytkownika" .';
$l_import['owner_overwrite'] = 'Nadpisz dane u¿ytkownika';

$l_import['name_collision'] = 'Przy identycznych nazwach';

$l_import['item'] = 'Przedmiot';
$l_import['backup_file_found'] = 'Plik kopii zapasowej. U¿yj opcji \"Kopia zapasowa->Przywróæ kopiê zapasow¹\" z menu plik w celu importu danych.';
$l_import['backup_file_found_question'] = 'Czy chcesz zamkn¹æ aktualne okno i uruchomiæ Kreatora importu dla kopii zapasowych?';
$l_import['close'] = 'Zamkij';
$l_import['handle_file_options'] = 'Pliki';
$l_import['import_files'] = 'Importuj pliki';
$l_import['weBinary'] = 'Plik';
$l_import['format_unknown'] = 'Nieznany format pliku!';
$l_import['customer_import_file_found'] = 'Plik importu z modu³u Zarz¹dzanie klientami. U¿yj opcji \"Import/Eksport\" za modu³u Zarz¹dzanie klientami (PRO) w celu importowania danych.';
$l_import['upload_failed'] = 'Nie mo¿na za³adowaæ danych! SprawdŸ, czy wielkoœæ danych nie przekracza %s ';

$l_import['import_navigation'] = 'Import navigation'; // TRANSLATE
$l_import['weNavigation'] = 'Navigation'; // TRANSLATE
$l_import['navigation_desc'] = 'Select the directory where the navigation will be imported.'; // TRANSLATE
$l_import['weNavigationRule'] = 'Navigation rule'; // TRANSLATE
$l_import['weThumbnail'] = 'Thumbnail'; // TRANSLATE
$l_import['import_thumbnails'] = 'Import thumbnails'; // TRANSLATE
$l_import['rebuild'] = 'Rebuild'; // TRANSLATE
$l_import['rebuild_txt'] = 'Automatic rebuild'; // TRANSLATE
$l_import['finished_success'] = 'The import of the data has finished successfully.'; // TRANSLATE
?>