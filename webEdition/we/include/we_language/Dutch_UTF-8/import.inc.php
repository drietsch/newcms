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
 * Language file: import.inc.php
 * Provides language strings.
 * Language: English
 */
$l_import['title'] = 'Importeer Hulp';
$l_import['wxml_import'] = 'webEdition XML import'; // TRANSLATE
$l_import['gxml_import'] = 'Generieke XML import';
$l_import['csv_import'] = 'CSV import'; // TRANSLATE
$l_import['import'] = 'Bezig met importeren';
$l_import['none'] = '-- geen --';
$l_import['any'] = '-- geen --';
$l_import['source_file'] = 'Bron bestand';
$l_import['import_dir'] = 'Doel directory';
$l_import['select_source_file'] = 'Kies a.u.b. een bron bestand.';
$l_import['we_title'] = 'Titel';
$l_import['we_description'] = 'Omschrijving';
$l_import['we_keywords'] = 'Kernwoorden';
$l_import['uts'] = 'Unix-Tijdstempel';
$l_import['unix_timestamp'] = 'De unix tijd stempel is een manier om de tijd te volgen naar het totaal aantal verstreken seconden. Deze telling begon tijdens de Unix Expo op 1 Januari 1970.';
$l_import['gts'] = 'GMT Tijdstempel';
$l_import['gmt_timestamp'] = 'General Mean Time bijv. Greenwich Mean Time (GMT).';
$l_import['fts'] = 'Gespecificeerd format';
$l_import['format_timestamp'] = 'De volgende karakters zijn herkend in de format parameter string: Y (een volledig numerieke representatie van een jaar, 4 getallen), y (een 2-cijferige representatie van een jaar), m (numerieke representatie van een maand, voorafgaand door een 0), n (numerieke representatie van een maand, zonder 0), d (dag van de maand, 2 cijfers voorafgaand door een 0), j (dag van de maand, zonder 0), H (24-uurs aanduiding van een uur voorafgaand door een 0), G (24-uurs aanduiding van een uur, zonder 0), i (minuten voorafgaand door een 0), s (voorafgaand door een 0)';
$l_import['import_progress'] = 'Bezig met importeren';
$l_import['prepare_progress'] = 'Bezig met voorbereiden';
$l_import['finish_progress'] = 'Voltooid';
$l_import['finish_import'] = 'Het importeren was succesvol!';
$l_import['import_file'] = 'Bestands import';
$l_import['import_data'] = 'Gegevens import';
$l_import['file_import'] = 'Importeer lokale bestanden';
$l_import['txt_file_import'] = 'Importeer één of meerdere bestand vanaf lokale harde schijf.';
$l_import['site_import'] = 'Importeer bestanden vanaf server';
$l_import['site_import_isp'] = 'Importeer afbeeldingen vanaf server';
$l_import['txt_site_import_isp'] = 'Importeer afbeeldingen vanaf de hoofd-directory van de server. Stel filter opties in om te kiezen welke afbeeldingen er geïmporteerd moeten worden.';
$l_import['txt_site_import'] = 'Importeer bestanden vanaf de hoofd-directory van de server. Stel filter opties in om te kiezen of afbeeldingen, HTML pagina s, Flash, JavaScript, of CSS bestanden, platte-tekst documenten, of andere bestands typen geïmporteerd moeten worden.';
$l_import['txt_wxml_import'] = 'webEdition XML bestanden bevatten imformatie over webEdition documenten, sjablonen of objecten. Kies een directory waarin de bestanden geïmporteerd moeten worden.';
$l_import['txt_gxml_import'] = 'Importeer "platte" XML bestanden, zoals geleverd door phpMyAdmin. De dataset velden moeten toegekend worden aan de webEdition dataset velden. Gebruik dit om XML bestanden te importeren die geëxporteerd zijn met webEdition zonder de export module.';
$l_import['txt_csv_import'] = 'Importeer CSV bestanden (Komma gescheiden waardes) of aangepaste tekst formaten (bijv. *.txt). De dataset velden zijn ingedeeld bij de webEdition velden.';
$l_import['add_expat_support'] = 'Om support voor de XML expat parser te implementeren, moet u de PHP opnieuw samenstellen om support toe te voegen (voor deze bibliotheek) aan uw PHP opbouw. De expat extensie, gecreeërd door James Clark, kunt u vinden bij http://www.jclark.com/xml/.';
$l_import['xml_file'] = 'XML bestand';
$l_import['templates'] = 'Sjablonen';
$l_import['classes'] = 'Classen';
$l_import['predetermined_paths'] = 'Pad instellingen';
$l_import['maintain_paths'] = 'Behoud paden';
$l_import['import_options'] = 'Import opties';
$l_import['file_collision'] = 'Bestands botsing';
$l_import['collision_txt'] = 'Wanneer u een bestand importeert in een folder die een bestand bevat met dezelfde naam, onstaat er een bestandsnaam botsing. U kunt opgeven wat de importeer wizard moet doen met de nieuwe en bestaande bestanden.';
$l_import['replace'] = 'Vervang';
$l_import['replace_txt'] = 'Verwijder het huidige bestand en vervang het door het nieuwe bestand.';
$l_import['rename'] = 'Hernoem';
$l_import['rename_txt'] = 'Ken een unieke naam toe aan het nieuwe bestand. Alle koppelingen worden aangepast aan de nieuwe bestands naam.';
$l_import['skip'] = 'Sla over';
$l_import['skip_txt'] = 'Sla het huidige bestand over en behoud beide kopieën op de originele locaties.';
$l_import['extra_data'] = 'Extra gegevens';
$l_import['integrated_data'] = 'Importeer geïntegreerde data';
$l_import['integrated_data_txt'] = 'Selecteer deze optie om geïntegreerde data van sjablonen of documenten te importeren.';
$l_import['max_level'] = 'naar niveau';
$l_import['import_doctypes'] = 'Importeer doctypes';
$l_import['import_categories'] = 'Importeer categorieën';
$l_import['invalid_wxml'] = 'Het XML document is goed gevormd maar niet geldig. Het webEdition document type definitie (DTD) ontbreekt.';
$l_import['valid_wxml'] = 'Het XML document is goed gevormd en geldig.  Het webEdition document type definitie (DTD) is aanwezig.';
$l_import['specify_docs'] = 'Kies a.u.b. de documenten voor import.';
$l_import['specify_objs'] = 'Kies a.u.b. de objecten voor import.';
$l_import['specify_docs_objs'] = 'Kies a.u.b. of documenten en objecten geïmporteerd moeten worden.';
$l_import['no_object_rights'] = 'U heeft geen toestemming om objecten te importeren.';
$l_import['display_validation'] = 'Toon XML validatie';
$l_import['xml_validation'] = 'XML validatie';
$l_import['warning'] = 'Waarschuwing';
$l_import['attribute'] = 'Attribuut';
$l_import['invalid_nodes'] = 'Ongeldige XML node op plek ';
$l_import['no_attrib_node'] = 'Geen XML element "attrib" op plek ';
$l_import['invalid_attributes'] = 'Ongeldige attributen op plek ';
$l_import['attrs_incomplete'] = 'De lijst van #vereiste en #vaste attributen is inkompleet op plek ';
$l_import['wrong_attribute'] = 'De attribuut naam niet gedefineerd als #vereist nog als #geïmpliceerd op plek ';
$l_import['documents'] = 'Documenten';
$l_import['objects'] = 'Objecten';
$l_import['fileselect_server'] = 'Laad bestand vanaf server';
$l_import['fileselect_local'] = 'Upload bestand vanaf lokale hard disk';
$l_import['filesize_local'] = 'Vanwege restricties binnen PHP, mag het te uploaden bestand niet groter zijn dan %s.';
$l_import['xml_mime_type'] = 'Het geselecteerde bestand kan niet geïmporteerd worden. Mime-type:';
$l_import['invalid_path'] = 'Het pad van het bron bestand is ongeldig.';
$l_import['ext_xml'] = 'Selecteer a.u.b. een bron bestand met de extensie ".xml".';
$l_import['store_docs'] = 'Doel directory documenten';
$l_import['store_tpls'] = 'Doel directory sjablonen';
$l_import['store_objs'] = 'Doel directory objecten';
$l_import['doctype'] = 'Document type';
$l_import['gxml'] = 'Generiek XML';
$l_import['data_import'] = 'Importeer data';
$l_import['documents'] = 'Documenten';
$l_import['objects'] = 'Objecten';
$l_import['type'] = 'Type'; // TRANSLATE
$l_import['template'] = 'Sjabloon';
$l_import['class'] = 'Class'; // TRANSLATE
$l_import['categories'] = 'Categorieën';
$l_import['isDynamic'] = 'Genereer pagina dynamisch';
$l_import['extension'] = 'Extensie';
$l_import['filetype'] = 'Bestandstype';
$l_import['directory'] = 'Directorie';
$l_import['select_data_set'] = 'Selecteer dataset';
$l_import['select_docType'] = 'Kies a.u.b. een document type of een sjabloon.';
$l_import['file_exists'] = 'Het gekozen bron bestand bestaat niet. Controleer a.u.b. het opgegeven pad. Pad: ';
$l_import['file_readable'] = 'Het gekozen bron bestand is niet leesbaar en kan daardoor niet geïmporteerd worden.';
$l_import['asgn_rcd_flds'] = 'Ken data velden toe';
$l_import['we_flds'] = 'webEdition&nbsp;velden';
$l_import['rcd_flds'] = 'Dataset&nbsp;velden';
$l_import['name'] = 'Naam';
$l_import['auto'] = 'Automatisch';
$l_import['asgnd'] = 'Toegekend';
$l_import['pfx'] = 'Voorvoegsel';
$l_import['pfx_doc'] = 'Document'; // TRANSLATE
$l_import['pfx_obj'] = 'Object'; // TRANSLATE
$l_import['rcd_fld'] = 'Dataset veld';
$l_import['import_settings'] = 'Import instellingen';
$l_import['xml_valid_1'] = 'Het XML bestand is geldig en bevat';
$l_import['xml_valid_s2'] = 'elementen. Selecteer de te importeren elementen.';
$l_import['xml_valid_m2'] = 'XML child node in het eerste niveau met verschillende namen. Kies a.u.b. de XML node en het aantal elementen die geïmporteerd moeten worden.';
$l_import['well_formed'] = 'Het XML document is goed gevormd.';
$l_import['not_well_formed'] = 'Het XML document is niet goed gevormd en kan niet geïmporteerd worden.';
$l_import['missing_child_node'] = 'Het XML document is goed gevormd, maar bevat geen XML nodes en kan daardoor niet geïmporteerd worden.';
$l_import['select_elements'] = 'Kies a.u.b. de te importeren datasets.';
$l_import['num_elements'] = 'Kies a.u.b. het aantal datasets van 1 tot ';
$l_import['xml_invalid'] = ''; // TRANSLATE
$l_import['option_select'] = 'Selectie..';
$l_import['num_data_sets'] = 'Datasets:'; // TRANSLATE
$l_import['to'] = 'tot';
$l_import['assign_record_fields'] = 'Ken data velden toe';
$l_import['we_fields'] = 'webEdition velden';
$l_import['record_fields'] = 'Dataset velden';
$l_import['record_field'] = 'Dataset veld ';
$l_import['attributes'] = 'Attributen';
$l_import['settings'] = 'Instellingen';
$l_import['field_options'] = 'Veld opties';
$l_import['csv_file'] = 'CSV bestand';
$l_import['csv_settings'] = 'CSV instellingen';
$l_import['xml_settings'] = 'XML instellingen';
$l_import['file_format'] = 'Bestands formaat';
$l_import['field_delimiter'] = 'Scheidingsteken';
$l_import['comma'] = ', {komma}';
$l_import['semicolon'] = '; {punt komma}';
$l_import['colon'] = ': {dubbele punt}';
$l_import['tab'] = "\\t {tab}"; // TRANSLATE
$l_import['space'] = '  {spatie}';
$l_import['text_delimiter'] = 'Tekst scheiding';
$l_import['double_quote'] = '" {dubbele quote}';
$l_import['single_quote'] = '\' {enkele quote}';
$l_import['contains'] = 'Eerste regel bevat veld naam';
$l_import['split_xml'] = 'Importeer datasets sequentieël';
$l_import['wellformed_xml'] = 'Validatie voor goed gevormde XML';
$l_import['validate_xml'] = 'XML validiatie';
$l_import['select_csv_file'] = 'Kies a.u.b. een CSV bron bestand.';
$l_import['select_seperator'] = 'Kies a.u.b. een scheidingsteken.';
$l_import['format_date'] = 'Datum formaat';
$l_import['info_sdate'] = 'Selecteer het datum formaat voor het webEdition veld';
$l_import['info_mdate'] = 'Selecteer het datum formaat voor de webEdition velden';
$l_import['remark_csv'] = 'U heeft de mogelijkheid om CSV bestanden (Comma Seperated Values) of aangepaste tekst formaten (e. g. *.txt) te importeren. Het afbakenen van velden (bijv. , ; tab, spatie) en tekst (= welke de tekst invoer kort samenvat) kan vooraf ingesteld worden bij het importeren van deze bestands formaten.';
$l_import['remark_xml'] = 'Om de vooraf bepaalde timeout van een PHP-script te omzeilen, selecteer de optie "Importeer data-sets afzonderlijk", bij het importeren van grote bestanden.<br>Als u niet zeker weet of het geselecteerde bestand webEdition XML is of niet, kunt u het bestand testen voor validiteit en syntax.';

$l_import["import_docs"]="Importeer documenten";
$l_import["import_templ"]="Importeer sjablonen";
$l_import["import_objs"]="Importeer objecten";
$l_import["import_classes"]="Importeer classen";
$l_import["import_doctypes"]="Importeer DocTypes";
$l_import["import_cats"]="Importeer categorieën";
$l_import["documents_desc"]="Selecteer de directory waar de documenten geïmporteerd moeten worden. Als de optie \"".$l_import['maintain_paths']."\" is gekozen, worden de document paden hersteld, anders worden de document paden genegeerd.";
$l_import["templates_desc"]="Selecteer de directory waar de sjablonen geïmporteerd moeten worden. Als de optie \"".$l_import['maintain_paths']."\" is gekozen, worden de sjabloon paden hersteld, anders worden de sjabloon paden genegeerd.";
$l_import['handle_document_options'] = 'Documenten';
$l_import['handle_template_options'] = 'Sjablonen';
$l_import['handle_object_options'] = 'Objecten';
$l_import['handle_class_options'] = 'Classen';
$l_import["handle_doctype_options"] = "Doctype"; // TRANSLATE
$l_import["handle_category_options"] = "Categorie";
$l_import['log'] = 'Details'; // TRANSLATE
$l_import['start_import'] = 'Begin import';
$l_import['prepare'] = 'Bereid voor...';
$l_import['update_links'] = 'Werk koppelingen bij...';
$l_import['doctype'] = 'Document-Type'; // TRANSLATE
$l_import['category'] = 'Categorie';
$l_import['end_import'] = 'Importeren voltooid';

$l_import['handle_owners_option'] = 'Gegevens eigenaar';
$l_import['txt_owners'] = 'Importeer gekoppelde gegevens eigenaar.';
$l_import['handle_owners'] = 'Herstel gegevens eigenaar';
$l_import['notexist_overwrite'] = 'Indien de gebruiker niet bestaat, wordt de optie "Overschrijf gegevens eigenaar" toegekend';
$l_import['owner_overwrite'] = 'Overschrijf gegevens eigenaar';

$l_import['name_collision'] = 'Naam botsing';

$l_import['item'] = 'Artikel';
$l_import['backup_file_found'] = 'Het bestand lijkt op een webEdition backup bestand. Gebruik a.u.b de \"Backup\" optie in het menu \"Bestand\" om de data te importeren.';
$l_import['backup_file_found_question'] = 'Wilt u het huidige dialoog venster sluiten en de backup hulp starten?';
$l_import['close'] = 'Sluit';
$l_import['handle_file_options'] = 'Bestanden';
$l_import['import_files'] = 'Importeer bestanden';
$l_import['weBinary'] = 'Bestand';
$l_import['format_unknown'] = 'Het bestandformaat is onbekend!';
$l_import['customer_import_file_found'] = 'Het bestand lijkt op een import bestand met klant gegevens. Gebruik a.u.b. de \"Importeer/Exporteer\" optie in de klanten module (PRO) om de data te importeren.';
$l_import['upload_failed'] = 'Het bestand kon niet ge-upload worden. Controleer a.u.b of het bestand groter is dan %s';

$l_import['import_navigation'] = 'Importeer navigatie';
$l_import['weNavigation'] = 'Navigatie';
$l_import['navigation_desc'] = 'Selecteer de directorie waar de navigatie geïmporteerd word.';
$l_import['weNavigationRule'] = 'Navigatie regel';
$l_import['weThumbnail'] = 'Thumbnail'; // TRANSLATE
$l_import['import_thumbnails'] = 'Importeer thumbnails';
$l_import['rebuild'] = 'Herbouw';
$l_import['rebuild_txt'] = 'Automatisch herbouwen';
$l_import['finished_success'] = 'Het importeren van de gegevens is succesvol afgerond.';
?>