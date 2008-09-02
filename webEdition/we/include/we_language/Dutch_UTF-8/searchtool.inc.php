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

include($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_language/'.$GLOBALS['WE_LANGUAGE'].'/tools.inc.php');

$GLOBALS['l_weSearch']['save_group_ok'] = $l_tools['save_group_ok']; 
$GLOBALS['l_weSearch']['save_ok'] = $l_tools['save_ok']; 
$GLOBALS['l_weSearch']['save_group_failed'] = $l_tools['save_group_failed']; 
$GLOBALS['l_weSearch']['save_failed'] = $l_tools['save_failed']; 
$l_weSearch['weSearch'] = 'Zoeken';
$GLOBALS['l_weSearch']['weSearch'] = 'Zoeken'; 
$GLOBALS['l_weSearch']['perm_group_title'] = $GLOBALS['l_weSearch']['weSearch'];
$l_weSearch['perm_group_title'] = $GLOBALS['l_weSearch']['weSearch'];

$GLOBALS['l_weSearch']['suchen'] = 'Zoeken'; 

$l_weSearch["permission_titles"]["NEW_SUCHE"] = "De gebruiker is bevoegd om nieuwe zoek onderdelen aan te maken"; 
$l_weSearch["permission_titles"]["DELETE_SUCHE"] = "De gebruiker is bevoegd om zoek onderdelen te verwijderen"; 
$l_weSearch["permission_titles"]["EDIT_SUCHE"] = "De gebruiker is bevoegd om zoek onderdelen te wijzigen";


$l_weSearch["import_tool_weSearch_data"] = "Herstel " . $GLOBALS['l_weSearch']['weSearch'] . " gegevens"; 
$l_weSearch["export_tool_weSearch_data"] = "Bewaar " . $GLOBALS['l_weSearch']['weSearch'] . " gegevens";


//Tree
$GLOBALS['l_weSearch']['vordefinierteSuchanfragen'] = 'Voor gedefineerde zoekopdrachten'; 
$GLOBALS['l_weSearch']['dokumente'] = 'documenten'; 
$GLOBALS['l_weSearch']['objekte'] = 'objecten';
$GLOBALS['l_weSearch']['unveroeffentlicheDokumente'] = 'ongepubliceerde documenten'; 
$GLOBALS['l_weSearch']['statischeDokumente'] = 'statische documenten'; 
$GLOBALS['l_weSearch']['dynamischeDokumente'] = 'dynamische documenten';
$GLOBALS['l_weSearch']['unveroeffentlicheObjekte'] = 'ongepubliceerde objecten';
$GLOBALS['l_weSearch']['eigeneSuchanfragen'] = 'eigen zoekopdrachten';
$GLOBALS['l_weSearch']['versionen'] = 'versions';
$GLOBALS['l_weSearch']['geloeschteDokumente'] = 'deleted documents';
$GLOBALS['l_weSearch']['geloeschteObjekte'] = 'deleted objects';

//Navigation
$GLOBALS['l_weSearch']['menu_suche'] = 'Zoeken';
$GLOBALS['l_weSearch']['menu_info'] = 'Info'; 
$GLOBALS['l_weSearch']['menu_help'] = 'Help';
$GLOBALS['l_weSearch']['menu_new'] = 'Nieuwe zoekopdracht'; 
$GLOBALS['l_weSearch']['menu_save'] = 'Bewaren'; 
$GLOBALS['l_weSearch']['menu_delete'] = 'Verwijderen';
$GLOBALS['l_weSearch']['menu_exit'] = 'Sluiten';
$GLOBALS['l_weSearch']['forDocuments'] = 'Voor documenten';
$GLOBALS['l_weSearch']['forTemplates'] = 'Voor sjablonen';
$GLOBALS['l_weSearch']['forObjects'] = 'Voor objecten'; 
$GLOBALS['l_weSearch']['menu_new_group'] = 'Nieuwe groep';
$GLOBALS['l_weSearch']['menu_advSearch'] = 'Geavanceerd zoeken'; 

//Tabs
$GLOBALS['l_weSearch']['documents'] = 'Documenten'; 
$GLOBALS['l_weSearch']['templates'] = 'Sjablonen'; 
$GLOBALS['l_weSearch']['advSearch'] = 'Geavanceerd zoeken';
$GLOBALS['l_weSearch']['properties'] = 'Eigenschappen'; 

$GLOBALS['l_weSearch']['objects'] = 'Objecten';
$GLOBALS['l_weSearch']['classes'] = 'Classes'; 

//Top
$GLOBALS['l_weSearch']['topDir'] = 'Map'; 
$GLOBALS['l_weSearch']['topSuche'] = 'Zoeken'; 

//Content
$GLOBALS['l_weSearch']['general'] = 'Algemeen'; 
$GLOBALS['l_weSearch']['suchenIn'] = "Zoeken in"; 
$GLOBALS['l_weSearch']['text'] = 'Tekst';
$GLOBALS['l_weSearch']['anzeigen'] = 'Tonen'; 
$GLOBALS['l_weSearch']['dir'] = 'Map'; 
$GLOBALS['l_weSearch']['optionen'] = 'Opties'; 

//Fields
$GLOBALS['l_weSearch']['allFields'] = 'alle velden'; 
$GLOBALS['l_weSearch']['ID'] = 'ID van invoer';
$GLOBALS['l_weSearch']['Text'] = 'Naam van invoer'; 
$GLOBALS['l_weSearch']['Path'] = 'Pad van invoer'; 
$GLOBALS['l_weSearch']['ParentIDDoc'] = 'Hoofd invoer documenten'; 
$GLOBALS['l_weSearch']['ParentIDTmpl'] = 'Hoofd invoer sjablonen';
$GLOBALS['l_weSearch']['ParentIDObj'] = 'Hoofd invoer objecten'; 
$GLOBALS['l_weSearch']['temp_template_id'] = 'Sjabloon'; 
$GLOBALS['l_weSearch']['MasterTemplateID'] = 'Hoofdsjabloon';
$GLOBALS['l_weSearch']['ContentType'] = 'Soort content'; 
$GLOBALS['l_weSearch']['temp_doc_type'] = 'Document-type'; 
$GLOBALS['l_weSearch']['temp_category'] = 'Categorie'; 
$GLOBALS['l_weSearch']['CreatorID'] = 'ID van eigenaar'; 
$GLOBALS['l_weSearch']['CreatorName'] = 'Naam van eigenaar';
$GLOBALS['l_weSearch']['WebUserID'] = 'ID van webgebruiker';
$GLOBALS['l_weSearch']['WebUserName'] = 'Naam van webgebruiker'; 
$GLOBALS['l_weSearch']['Status'] = 'Status'; 
$GLOBALS['l_weSearch']['Speicherart'] = 'Bewaar type'; 
$GLOBALS['l_weSearch']['Published'] = 'Datum van publicatie';
$GLOBALS['l_weSearch']['CreationDate'] = 'Datum van creatie'; 
$GLOBALS['l_weSearch']['ModDate'] = 'Datum van modificatie';

$GLOBALS['l_weSearch']['CONTAIN'] = 'bevat'; 
$GLOBALS['l_weSearch']['IS'] = 'gelijk aan (=)'; 
$GLOBALS['l_weSearch']['START'] = 'begint met'; 
$GLOBALS['l_weSearch']['END'] = 'eindigt op'; 
$GLOBALS['l_weSearch']['<'] = 'minder dan (<)';
$GLOBALS['l_weSearch']['<='] = 'kleiner dan (<=)';
$GLOBALS['l_weSearch']['>='] = 'groter dan (>=)';
$GLOBALS['l_weSearch']['>'] = 'meer dan (>)'; 

$GLOBALS['l_weSearch']['jeder'] = 'toon alle'; 
$GLOBALS['l_weSearch']['geparkt'] = 'ongepuliceerd'; 
$GLOBALS['l_weSearch']['veroeffentlicht'] = 'gepubliceerd'; 
$GLOBALS['l_weSearch']['geaendert'] = 'gewijzigd'; 
$GLOBALS['l_weSearch']['veroeff_geaendert'] = 'gepubliceerd en gewijzigd'; 
$GLOBALS['l_weSearch']['geparkt_geaendert'] = 'ongepubliceerd en gewijzigd'; 
$GLOBALS['l_weSearch']['dynamisch'] = 'dynamisch'; 
$GLOBALS['l_weSearch']['statisch'] = 'statisch'; 
$GLOBALS['l_weSearch']['deleted'] = 'deleted';


$GLOBALS['l_weSearch']['onlyTitle'] = "In yitel"; 
$GLOBALS['l_weSearch']['onlyFilename'] = "In bestandsnaam"; 
$GLOBALS['l_weSearch']['Content'] = "In alle gegevens"; 


//result columns
$GLOBALS['l_weSearch']['dateiname'] = "Bestandsnaam"; 
$GLOBALS['l_weSearch']['seitentitel'] = "Titel"; 
$GLOBALS['l_weSearch']['created'] = "Aangemaakt"; 
$GLOBALS['l_weSearch']['modified'] = "Gewijzigd"; 


//messages
$GLOBALS['l_weSearch']['predefinedSearchmodify'] = "Het is niet mogelijk om vooraf gedefineerde zoekopdrachten te bewaren!";
$GLOBALS['l_weSearch']['predefinedSearchdelete'] = "Het is niet mogelijk om vooraf gedefineerde zoekopdrachten te verwijderen!";
$GLOBALS['l_weSearch']['nameForSearch'] = "Kies een naam voor uw zoekopdracht:"; 
$GLOBALS['l_weSearch']["no_hochkomma"] = "Ongeldige naam! Ongeldige karakters zijn ' (apostrophe) of \" (quote)!";
$GLOBALS['l_weSearch']['confirmDel'] = 'Invoer verwijderen.\\nWeet u het zeker?';
$GLOBALS['l_weSearch']['nameTooLong'] = 'De naam mag maximaal 30 karakters bevatten!'; 
$GLOBALS['l_weSearch']['nothingCheckedAdv'] = 'Er is geen zoekopdracht geselecteerd!';
$GLOBALS['l_weSearch']['nothingCheckedTmplDoc'] = 'Er zij geen zoekonderdelen geselecteerd!';
$GLOBALS['l_weSearch']['noTempTableRightsSearch'] = 'In order to use the search it is necessary to generate a temporary table or to be able to delete tables. Therefore you do not have the specific mysql-user-right.';
$GLOBALS['l_weSearch']['noTempTableRightsDoclist'] = 'In order to show all included documents it is necessary to generate a temporary table or to be able to delete tables. Therefore you do not have the specific mysql-user-right.';

$GLOBALS['l_weSearch']["date_format"] = 'd.m.Y'; 

$GLOBALS['l_weSearch']['eintraege_pro_seite'] = 'Toon'; 
$GLOBALS['l_weSearch']["no_template"] = "-"; 
$GLOBALS['l_weSearch']["creator"] 	= "eigenaar";
$GLOBALS['l_weSearch']["nobody"] 		= "niemand"; 
$GLOBALS['l_weSearch']["template"] 	= "sjabloon"; 
$GLOBALS['l_weSearch']["metafelder"] = "Metavelden (max. 6)"; 

$GLOBALS['l_weSearch']['dateityp'] = 'Bestands type'; 
$GLOBALS['l_weSearch']['groesse'] = 'Grootte';
$GLOBALS['l_weSearch']['aufloesung'] = 'Resolutie'; 
$GLOBALS['l_weSearch']['beschreibung'] = 'Omschrijving'; 
$GLOBALS['l_weSearch']['idDiv'] = 'ID'; 

$GLOBALS['l_weSearch']['publish_docs'] = 'Do you want to publish the market documents?';
$GLOBALS['l_weSearch']['notChecked'] = 'No documents are selected.';
$GLOBALS['l_weSearch']['publishOK'] = 'Documents were published.';
?>