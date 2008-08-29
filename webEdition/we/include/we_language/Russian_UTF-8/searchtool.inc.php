<?php
include($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_language/'.$GLOBALS['WE_LANGUAGE'].'/tools.inc.php');

$GLOBALS['l_weSearch']['save_group_ok'] = $l_tools['save_group_ok'];// TRANSLATE
$GLOBALS['l_weSearch']['save_ok'] = $l_tools['save_ok'];// TRANSLATE
$GLOBALS['l_weSearch']['save_group_failed'] = $l_tools['save_group_failed'];// TRANSLATE
$GLOBALS['l_weSearch']['save_failed'] = $l_tools['save_failed'];// TRANSLATE
$l_weSearch['weSearch'] = 'Search';// TRANSLATE
$GLOBALS['l_weSearch']['weSearch'] = 'Search';// TRANSLATE
$GLOBALS['l_weSearch']['perm_group_title'] = $GLOBALS['l_weSearch']['weSearch'];// TRANSLATE
$l_weSearch['perm_group_title'] = $GLOBALS['l_weSearch']['weSearch'];// TRANSLATE

$GLOBALS['l_weSearch']['suchen'] = 'Search';// TRANSLATE

$l_weSearch["permission_titles"]["NEW_SUCHE"] = "The user is allowed to create new items in the search";// TRANSLATE
$l_weSearch["permission_titles"]["DELETE_SUCHE"] = "The user is allowed to delete items from the search";// TRANSLATE
$l_weSearch["permission_titles"]["EDIT_SUCHE"] = "The user is allowed to edit items in the search";// TRANSLATE


$l_weSearch["import_tool_weSearch_data"] = "Restore " . $GLOBALS['l_weSearch']['weSearch'] . " data";// TRANSLATE
$l_weSearch["export_tool_weSearch_data"] = "Save " . $GLOBALS['l_weSearch']['weSearch'] . " data";// TRANSLATE


//Tree
$GLOBALS['l_weSearch']['vordefinierteSuchanfragen'] = 'predefined searches';// TRANSLATE
$GLOBALS['l_weSearch']['dokumente'] = 'documents';// TRANSLATE
$GLOBALS['l_weSearch']['objekte'] = 'objects';// TRANSLATE
$GLOBALS['l_weSearch']['unveroeffentlicheDokumente'] = 'unpublished documents';// TRANSLATE
$GLOBALS['l_weSearch']['statischeDokumente'] = 'static documents';// TRANSLATE
$GLOBALS['l_weSearch']['dynamischeDokumente'] = 'dynamic documents';// TRANSLATE
$GLOBALS['l_weSearch']['unveroeffentlicheObjekte'] = 'unpublished objects';// TRANSLATE
$GLOBALS['l_weSearch']['eigeneSuchanfragen'] = 'own searches';// TRANSLATE
$GLOBALS['l_weSearch']['versionen'] = 'versions';// TRANSLATE
$GLOBALS['l_weSearch']['geloeschteDokumente'] = 'deleted documents';// TRANSLATE
$GLOBALS['l_weSearch']['geloeschteObjekte'] = 'deleted objects';// TRANSLATE

//Navigation
$GLOBALS['l_weSearch']['menu_suche'] = 'Search';// TRANSLATE
$GLOBALS['l_weSearch']['menu_info'] = 'Info';// TRANSLATE
$GLOBALS['l_weSearch']['menu_help'] = 'Help';// TRANSLATE
$GLOBALS['l_weSearch']['menu_new'] = 'New Search';// TRANSLATE
$GLOBALS['l_weSearch']['menu_save'] = 'Save';// TRANSLATE
$GLOBALS['l_weSearch']['menu_delete'] = 'Delete';// TRANSLATE
$GLOBALS['l_weSearch']['menu_exit'] = 'Close';// TRANSLATE
$GLOBALS['l_weSearch']['forDocuments'] = 'For Documents';// TRANSLATE
$GLOBALS['l_weSearch']['forTemplates'] = 'For Templates';// TRANSLATE
$GLOBALS['l_weSearch']['forObjects'] = 'For Objects';// TRANSLATE
$GLOBALS['l_weSearch']['menu_new_group'] = 'New Group';// TRANSLATE
$GLOBALS['l_weSearch']['menu_advSearch'] = 'Advanced Search';// TRANSLATE

//Tabs
$GLOBALS['l_weSearch']['documents'] = 'Documents';// TRANSLATE
$GLOBALS['l_weSearch']['templates'] = 'Templates';// TRANSLATE
$GLOBALS['l_weSearch']['advSearch'] = 'Advanced Search';// TRANSLATE
$GLOBALS['l_weSearch']['properties'] = 'Properties';// TRANSLATE

$GLOBALS['l_weSearch']['objects'] = 'Objects';// TRANSLATE
$GLOBALS['l_weSearch']['classes'] = 'Classes';// TRANSLATE

//Top
$GLOBALS['l_weSearch']['topDir'] = 'Folder';// TRANSLATE
$GLOBALS['l_weSearch']['topSuche'] = 'Search';// TRANSLATE

//Content
$GLOBALS['l_weSearch']['general'] = 'General';// TRANSLATE
$GLOBALS['l_weSearch']['suchenIn'] = "Search in";// TRANSLATE
$GLOBALS['l_weSearch']['text'] = 'Text';// TRANSLATE
$GLOBALS['l_weSearch']['anzeigen'] = 'Show';// TRANSLATE
$GLOBALS['l_weSearch']['dir'] = 'Folder';// TRANSLATE
$GLOBALS['l_weSearch']['optionen'] = 'Options';// TRANSLATE

//Fields
$GLOBALS['l_weSearch']['allFields'] = 'all fields';// TRANSLATE
$GLOBALS['l_weSearch']['ID'] = 'ID of entry';// TRANSLATE
$GLOBALS['l_weSearch']['Text'] = 'Name of entry';// TRANSLATE
$GLOBALS['l_weSearch']['Path'] = 'Path of entry';// TRANSLATE
$GLOBALS['l_weSearch']['ParentIDDoc'] = 'parent entry documents';// TRANSLATE
$GLOBALS['l_weSearch']['ParentIDTmpl'] = 'parent entry templates';// TRANSLATE
$GLOBALS['l_weSearch']['ParentIDObj'] = 'parent entry objects';// TRANSLATE
$GLOBALS['l_weSearch']['temp_template_id'] = 'Template';// TRANSLATE
$GLOBALS['l_weSearch']['MasterTemplateID'] = 'Mastertemplate';// TRANSLATE
$GLOBALS['l_weSearch']['ContentType'] = 'Type of content';// TRANSLATE
$GLOBALS['l_weSearch']['temp_doc_type'] = 'Document-type';// TRANSLATE
$GLOBALS['l_weSearch']['temp_category'] = 'Category';// TRANSLATE
$GLOBALS['l_weSearch']['CreatorID'] = 'ID of owner';// TRANSLATE
$GLOBALS['l_weSearch']['CreatorName'] = 'Name of owner';// TRANSLATE
$GLOBALS['l_weSearch']['WebUserID'] = 'ID of webuser';// TRANSLATE
$GLOBALS['l_weSearch']['WebUserName'] = 'Name of webuser';// TRANSLATE
$GLOBALS['l_weSearch']['Status'] = 'Status';// TRANSLATE
$GLOBALS['l_weSearch']['Speicherart'] = 'Save type';// TRANSLATE
$GLOBALS['l_weSearch']['Published'] = 'Date of publishing';// TRANSLATE
$GLOBALS['l_weSearch']['CreationDate'] = 'Date of creation';// TRANSLATE
$GLOBALS['l_weSearch']['ModDate'] = 'Date of modification';// TRANSLATE

$GLOBALS['l_weSearch']['CONTAIN'] = 'contains';// TRANSLATE
$GLOBALS['l_weSearch']['IS'] = 'equal (=)';// TRANSLATE
$GLOBALS['l_weSearch']['START'] = 'starts with';// TRANSLATE
$GLOBALS['l_weSearch']['END'] = 'ends with';// TRANSLATE
$GLOBALS['l_weSearch']['<'] = 'less then (<)';// TRANSLATE
$GLOBALS['l_weSearch']['<='] = 'less equal (<=)';// TRANSLATE
$GLOBALS['l_weSearch']['>='] = 'greater equal (>=)';// TRANSLATE
$GLOBALS['l_weSearch']['>'] = 'greater then (>)';// TRANSLATE


$GLOBALS['l_weSearch']['jeder'] = 'show all';// TRANSLATE
$GLOBALS['l_weSearch']['geparkt'] = 'unpublished';// TRANSLATE
$GLOBALS['l_weSearch']['veroeffentlicht'] = 'published';// TRANSLATE
$GLOBALS['l_weSearch']['geaendert'] = 'modified';// TRANSLATE
$GLOBALS['l_weSearch']['veroeff_geaendert'] = 'published and modified';// TRANSLATE
$GLOBALS['l_weSearch']['geparkt_geaendert'] = 'unpublished and modified';// TRANSLATE
$GLOBALS['l_weSearch']['dynamisch'] = 'dynamic';// TRANSLATE
$GLOBALS['l_weSearch']['statisch'] = 'static';// TRANSLATE
$GLOBALS['l_weSearch']['deleted'] = 'deleted';// TRANSLATE



$GLOBALS['l_weSearch']['onlyTitle'] = "In Title";// TRANSLATE
$GLOBALS['l_weSearch']['onlyFilename'] = "In Filename"// TRANSLATE;
$GLOBALS['l_weSearch']['Content'] = "In complete Content";// TRANSLATE



//result columns
$GLOBALS['l_weSearch']['dateiname'] = "Filename";// TRANSLATE
$GLOBALS['l_weSearch']['seitentitel'] = "Title";// TRANSLATE
$GLOBALS['l_weSearch']['created'] = "Created";// TRANSLATE
$GLOBALS['l_weSearch']['modified'] = "Modified";// TRANSLATE


//messages
$GLOBALS['l_weSearch']['predefinedSearchmodify'] = "It is not possible to safe predefined searches!";// TRANSLATE
$GLOBALS['l_weSearch']['predefinedSearchdelete'] = "It is not possible to delete predefined searches!";// TRANSLATE
$GLOBALS['l_weSearch']['nameForSearch'] = "Choose a name for your search:";// TRANSLATE
$GLOBALS['l_weSearch']["no_hochkomma"] = "Invalid name! Invalid character are ' (apostrophe) or \" (quote)!";// TRANSLATE
$GLOBALS['l_weSearch']['confirmDel'] = 'Delete entry.\\nAre you sure?';// TRANSLATE
$GLOBALS['l_weSearch']['nameTooLong'] = 'In the name there are allowed at most 30 characters!';// TRANSLATE
$GLOBALS['l_weSearch']['nothingCheckedAdv'] = 'Nothing is checked to search for!';// TRANSLATE
$GLOBALS['l_weSearch']['nothingCheckedTmplDoc'] = 'Nothing is checked to search for!';// TRANSLATE
$GLOBALS['l_weSearch']['noTempTableRightsSearch'] = 'In order to use the search it is necessary to generate a temporary table or to be able to delete tables. Therefore you do not have the specific mysql-user-right.';// TRANSLATE
$GLOBALS['l_weSearch']['noTempTableRightsDoclist'] = 'In order to show all included documents it is necessary to generate a temporary table or to be able to delete tables. Therefore you do not have the specific mysql-user-right.';// TRANSLATE

$GLOBALS['l_weSearch']["date_format"] = 'd.m.Y';// TRANSLATE

$GLOBALS['l_weSearch']['eintraege_pro_seite'] = 'View';// TRANSLATE
$GLOBALS['l_weSearch']["no_template"] = "-";// TRANSLATE
$GLOBALS['l_weSearch']["creator"] 	= "owner";// TRANSLATE
$GLOBALS['l_weSearch']["nobody"] 		= "nobody";// TRANSLATE
$GLOBALS['l_weSearch']["template"] 	= "template";// TRANSLATE
$GLOBALS['l_weSearch']["metafelder"] = "Metafields (max. 6)";// TRANSLATE

$GLOBALS['l_weSearch']['dateityp'] = 'File Type';// TRANSLATE
$GLOBALS['l_weSearch']['groesse'] = 'Size';// TRANSLATE
$GLOBALS['l_weSearch']['aufloesung'] = 'Resolution';// TRANSLATE
$GLOBALS['l_weSearch']['beschreibung'] = 'Description';// TRANSLATE
$GLOBALS['l_weSearch']['idDiv'] = 'ID';// TRANSLATE

$GLOBALS['l_weSearch']['publish_docs'] = 'Do you want to publish the market documents?';// TRANSLATE
$GLOBALS['l_weSearch']['notChecked'] = 'No documents are selected.';// TRANSLATE
$GLOBALS['l_weSearch']['publishOK'] = 'Documents were published.';// TRANSLATE


?>