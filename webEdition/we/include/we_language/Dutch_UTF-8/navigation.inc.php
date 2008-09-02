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
 * Language file: navigation.inc.php
 * Provides language strings.
 * Language: Dutch
 */

$l_navigation = array();
$l_navigation['no_perms'] = 'U bent niet bevoegd om deze optie te selecteren.';
$l_navigation['delete_alert'] = 'Verwijder huidige invoer/map.\\n Weet u het zeker?';
$l_navigation['nothing_to_delete'] = 'De invoer kan niet verwijderd worden!';
$l_navigation['nothing_to_save'] = 'De invoer kan niet bewaard worden!';
$l_navigation['nothing_selected'] = 'Selecteer a.u.b. de invoer/map die verwijderd moet worden.';
$l_navigation['we_filename_notValid'] = 'De gebruikersnaam is niet juist!\\nAlfa-numerieke karakters, bovenkast en onderkast, evenals underscore, koppelteken, punt en leeg karakter {blank; space} (a-z, A-Z, 0-9, _,-.,) zijn geldig';

$l_navigation['menu_new'] = 'Nieuw';
$l_navigation['menu_save'] = 'Bewaar';
$l_navigation['menu_delete'] = 'Verwijder';
$l_navigation['menu_exit'] = 'Stop';

$l_navigation['menu_options'] = 'Opties';
$l_navigation['menu_generate'] = 'Genereer broncode';

$l_navigation['menu_settings'] = 'Instellingen';
$l_navigation['menu_highlight_rules'] = 'Regels voor Highlighting';

$l_navigation['menu_info'] = 'Info'; 
$l_navigation['menu_help'] = 'Help';

$l_navigation['property'] = 'Eigenschappen';
$l_navigation['preview'] = 'Voorvertoning';
$l_navigation['preview_code'] = 'Voorvertoning - broncode';
$l_navigation['navigation'] = 'Navigatie';
$l_navigation['group'] = 'Map';
$l_navigation['name'] = 'Naam';
$l_navigation['newFolder'] = 'Nieuwe map';
$l_navigation['save_group_ok'] = 'De map is bewaard.';
$l_navigation['save_ok'] = 'De navigatie is bewaard.';

$l_navigation['path_nok'] = 'Het pad is niet juist!';
$l_navigation['name_empty'] = 'De naam mag niet leeg zijn!';
$l_navigation['name_exists'] = 'De naam bestaat al!';
$l_navigation['wrongtext'] = 'De naam is niet geldig!\\nGeldige karakters zijn letters van a tot z (bovenkast of onderkast), figuren, underscore (_), scheidingsteken (-), punt (.), lege karakters ( ) en appenstaart symbolen (@). ';
$l_navigation['wrongTitleField'] = 'The navigation folder could not be saved, because the given title field doesn\'t  exist. Please correct the title field on the "content" tab and save again.'; // TRANSLATE
$l_navigation['folder_path_exists'] = 'Er bestaat al een invoer/map met dezelfde naam.';
$l_navigation['navigation_deleted'] = 'De invoer/map is succesvol verwijderd.';
$l_navigation['group_deleted'] = 'De map is succesvol verwijderd.';

$l_navigation['selection'] = 'Selectie';
$l_navigation['icon'] = 'Afbeelding';
$l_navigation['presentation'] = 'Representatie';
$l_navigation['text'] = 'Tekst';
$l_navigation['title'] = 'Titel';

$l_navigation['dir'] = 'Directorie';
$l_navigation['categories'] = 'Categoriën';
$l_navigation['stat_selection'] = 'Statische selectie';
$l_navigation['dyn_selection'] = 'Dynamische selectie';
$l_navigation['manual_selection'] = 'Handmatige selectie';
$l_navigation['txt_dyn_selection'] = 'Uitleg tekst voor de dynamische selectie';
$l_navigation['txt_stat_selection'] = 'Uitleg tekst voor de statische selectie. Gekoppeld aan het selecteerde document of object.';

$l_navigation['sort'] = 'Sortering';
$l_navigation['ascending'] = 'oplopend';
$l_navigation['descending'] = 'aflopend';

$l_navigation['show_count'] = 'Aantal te tonen invoeren';
$l_navigation['title_field'] = 'Titel veld';
$l_navigation['select_field_txt'] = 'Selecteer een veld';

$l_navigation['content'] = 'Content'; 
$l_navigation['no_dyn_content'] = '- Geen dynamische content -';
$l_navigation['dyn_content'] = 'De map bevat dynamische content';
$l_navigation['link'] = 'Koppeling';
$l_navigation['docLink'] = 'Intern document';
$l_navigation['objLink'] = 'Object'; 
$l_navigation['catLink'] = 'Categorie';
$l_navigation['order'] = 'Volgorde';

$l_navigation['general'] = 'Algemeen';
$l_navigation['entry'] = 'Invoer';
$l_navigation['entries'] = 'Invoeren';
$l_navigation['save_populate_question'] = 'U heeft de dynamische content voor de map gedefinieerd. Na het bewaren worden de gegenereerde invoeren toegevoegd of vernieuwd. Wilt u verder gaan?';
$l_navigation['depopulate_question'] = 'De dynamische content wordt nu verwijderd. Wilt u verder gaan?';
$l_navigation['populate_question'] = 'De dynamische invoeren zijn nu bijgewerkt. Wilt u verder gaan?';
$l_navigation['depopulate_msg'] = 'De dynamische invoeren zijn verwijderd.';
$l_navigation['populate_msg'] = 'De dynamische invoeren zijn toegevoegd.';

$l_navigation['documents'] = 'Documenten';
$l_navigation['objects'] = 'Objecten';
$l_navigation['workspace'] = 'Workspace'; 
$l_navigation['no_workspace'] = 'Het object heeft geen workspace! Daardoor kan het object niet geselecteerd worden!';

$l_navigation['no_entry'] = '--allemaal hetzelfde--';
$l_navigation['parameter'] = 'Parameter'; 
$l_navigation['urlLink'] = 'Extern document';
$l_navigation['doctype'] = 'Document type'; 
$l_navigation['class'] = 'Class'; 

$l_navigation['parameter_text'] = 'In de parameter kunnen de volgende variabelen van de navigatie worden gebruikt: $LinkID, FolderID, $DocTypID, $ClassID, $Ordn en $WorkspaceID';

$l_navigation['intern'] = 'Interne koppeling';
$l_navigation['extern'] = 'Externe koppeling';
$l_navigation['linkSelection'] = 'Koppeling selectie';
$l_navigation['catParameter'] = 'Naam van de categorie parameter';

$l_navigation['rules']['navigation_rules'] = "Navigatie regels";
$l_navigation['rules']['available_rules'] = "Beschikbare rules";
$l_navigation['rules']['rule_name'] = "Naam van de regel";
$l_navigation['rules']['rule_navigation_link'] = "Actief navigatie item";
$l_navigation['rules']['rule_applies_for'] = "Regel geldt voor";
$l_navigation['rules']['rule_folder'] = "In map";
$l_navigation['rules']['rule_doctype'] = "Document type"; 
$l_navigation['rules']['rule_categories'] = "Categorieën";
$l_navigation['rules']['rule_class'] = "Van class"; 
$l_navigation['rules']['rule_workspace'] = "Workspace";
$l_navigation['rules']['invalid_name'] = "De naam mag alleen bestaan uit letters, figuren, koppeltekens en underscore";
$l_navigation['rules']['name_exists'] = "De name \"%s\" bestaat al, voer a.u.b een andere naam in.";
$l_navigation['rules']['saved_successful'] = "De invoer: \"%s\" is bewaard.";

$l_navigation['exit_doc_question'] = 'Het lijkt erop dat u de navigatie gewijzigd heeft.<br>Wilt u de wijzigingen bewaren?';
$l_navigation['add_navigation'] = 'Voeg navigatie toe';
$l_navigation['begin'] = 'aan het begin';
$l_navigation['end'] = 'aan het eind';

$l_navigation['del_question'] = 'De invoer wordt definitief verwijderd. Weet u het zeker?';
$l_navigation['dellall_question'] = 'Alle invoeren worden definitief verwijderd. Weet u het zeker?';
$l_navigation['charset'] = 'Karakter codering';

$l_navigation['more_attributes'] = 'Meer eigenschappen';
$l_navigation['less_attributes'] = 'Minder eigenschappen';
$l_navigation['attributes'] = 'Attributen';
$l_navigation['title'] = 'Titel';
$l_navigation['anchor'] = 'Anker';
$l_navigation['language'] = 'Taal';
$l_navigation['target'] = 'Doel';
$l_navigation['link_language'] = 'Koppeling';
$l_navigation['href_language'] = 'Gekoppeld document';
$l_navigation['keyboard'] = 'Keyboard'; 
$l_navigation['accesskey'] = 'Accesskey'; 
$l_navigation['tabindex'] = 'Tabindex';
$l_navigation['relation'] = 'Relatie';
$l_navigation['link_attribute'] = 'Koppeling attributen';
$l_navigation['popup'] = 'Popup venster';
$l_navigation['popup_open'] = 'Open';
$l_navigation['popup_center'] = 'Centreer';
$l_navigation['popup_x'] = 'x positie';
$l_navigation['popup_y'] = 'y positie';
$l_navigation['popup_width'] = 'Breedte';
$l_navigation['popup_height'] = 'Hoogte';
$l_navigation['popup_status'] = 'Status';
$l_navigation['popup_scrollbars'] = 'Scrollbalken';
$l_navigation['popup_menubar'] = 'Menubalk';
$l_navigation['popup_resizable'] = 'Schaalaar';
$l_navigation['popup_location'] = 'Locatie';
$l_navigation['popup_toolbar'] = 'Knoppenbalk';

$l_navigation['icon_properties'] = 'Afbeelding eigenschappen';
$l_navigation['icon_properties_out'] = 'Verberg afbeelding eigenschappen';
$l_navigation['icon_width'] = 'Breedte';
$l_navigation['icon_height'] = 'Hoogte';
$l_navigation['icon_border'] = 'Rand';
$l_navigation['icon_align'] = 'Uitlijning';
$l_navigation['icon_hspace'] = 'horiz. uitlijnen';
$l_navigation['icon_vspace'] = 'vert. uitlijnen';
$l_navigation['icon_alt'] = 'Alt tekst';
$l_navigation['icon_title'] = 'Titel';

$l_navigation['linkprops_desc'] = 'Hier kunt u de additionele koppeling eigenschappen definieren. Bij dynamische onderdelen worden alleen doel koppeling en popup venster eigenschappen doorgevoerd.';
$l_navigation['charset_desc'] = 'De geselecteerde charset wordt doorgevoerd op de huidige map en alle map invoeren.';


$l_navigation['customers'] = 'Klanten';
$l_navigation['limit_access'] = 'Defineer klant toegang';
$l_navigation['customer_access'] = 'Alle klanten hebben toegang tot dit onderdeel';
$l_navigation['filter'] = 'Defineer filter'; 
$l_navigation['and'] = 'en'; 
$l_navigation['or'] = 'of'; 
$l_navigation['selected_customers'] = 'Alleen de volgende klanten hebben toegang tot dit onderdeel';
$l_navigation['useDocumentFilter'] = 'Use filter settings of document/object'; // TRANSLATE
$l_navigation['reset_customer_filter'] = 'Reset all customer filters'; // TRANSLATE
$l_navigation['reset_customerfilter_done_message'] = 'The cusomer filters were successfully reset!'; // TRANSLATE

?>