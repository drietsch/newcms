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
$l_export["save_changed_export"] = "Export has been changed.\\nDo you want to save your changes?"; // TRANSLATE
$l_export["auto_selection"] = "S�lection automatique";
$l_export["txt_auto_selection"] = "Exporte automatiquement - d'apr�s type-de-document ou classe- les documents ou objects choisis.";
$l_export["txt_auto_selection_csv"] = "Exports objects automatically according to their class."; // TRANSLATE
$l_export["manual_selection"] = "S�lection manuelle";
$l_export["txt_manual_selection"] = "Export manuel des document et object choisis.";
$l_export["txt_manual_selection_csv"] = "Exports manually selected objects."; // TRANSLATE
$l_export["element"] = "S�lection d'elements";
$l_export["documents"] = "Documents"; // TRANSLATE
$l_export["objects"] = "Objects"; // TRANSLATE
$l_export["step1"] = "D�finir la s�l�ction d'elements";
$l_export["step2"] = "Choisissez les elements � exporter";
$l_export["step3"] = "Export G�n�rique";
$l_export["step10"] = "Export termin�e";
$l_export["step99"] = "Erreur en exportant";
$l_export["step99_notice"] = "L'export n'est pas possible";
$l_export["server_finished"] = "Le fichier export a �t� enregistr� sur le serveur.";
$l_export["backup_finished"] = "L'export a �t� termin� avec succ�s.";
$l_export["download_starting"] = "Le t�l�chargement du fichier a �t� d�marr�.<br><br>Si le t�l�chargement ne commence pas dans 10 secondes,<br>";
$l_export["download"] = "s'il vous pla�t cliquez ici.";
$l_export["download_failed"] = "Le fichier demand� n'existe pas ou vous n'avez pas l'authorisation de le t�l�charger.";
$l_export["file_format"] = "Format de fichier";
$l_export["export_to"] = "Exporter �";
$l_export["export_to_server"] = "Serveur";
$l_export["export_to_local"] = "Disque dur local";
$l_export["cdata"] = "Codage";
$l_export["export_xml_cdata"] = "Ajouter des s�ctions-CDATA";
$l_export["export_xml_entities"] = "Remplacer les entit�s";
$l_export["filename"] = "Nom de fichier";
$l_export["path"] = "Chemin";
$l_export["doctypename"] = "Documents du Type-de-Document";
$l_export["classname"] = "Objects de la classe";
$l_export["dir"] = "Verzeichnis";
$l_export["categories"] = "Cat�gories";
$l_export["wizard_title"] = "Assistan d'Export";
$l_export["xml_format"] = "XML"; // TRANSLATE
$l_export["csv_format"] = "CSV"; // TRANSLATE
$l_export["csv_delimiter"] = "S�perateur";
$l_export["csv_enclose"] = "Limiteur de texte";
$l_export["csv_escape"] = "�space";
$l_export["csv_lineend"] = "Format de fichier";
$l_export["csv_null"] = "Remplacement-NULL";
$l_export["csv_fieldnames"] = "La premi�re ligne contient le nom de champ";
$l_export["windows"] = "Format Windows";
$l_export["unix"] = "Format UNIX";
$l_export["mac"] = "Format Mac";
$l_export["generic_export"] = "Export G�n�rique";
$l_export["title"] = "Assistan d'Export";
$l_export["gxml_export"] = "Export G�n�rique XML ";
$l_export["txt_gxml_export"] = "Export de documents et objects de webEdition au format XMl \"plat\" (3 plans).";
$l_export["csv_export"] = "Export CSV";
$l_export["txt_csv_export"] = "Export d'objects webEdition au format CSV (Comma Separated Values).";
$l_export["csv_params"] = "Pr�f�rences";
$l_export["error"] = "L'export n'a pas �t� termin� avec succ�s!";
$l_export["error_unknown"] = "Une erreur inconnue s'est produit!";
$l_export["error_object_module"] = "L'export de document au forma CSV n'est pas support� en ce moment!<br><br>Comme le modul de base de donn�es/objects n'est pas install�, l'export au format CSV n'est pas disponible.";
$l_export["error_nothing_selected_docs"] = "L'export n'a pas �t� �ffectu�!<br><br>Aucun document choisi.";
$l_export["error_nothing_selected_objs"] = "L'export n'a pas �t� �ffectu�!<br><br>Aucun document ou object choisi.";
$l_export["error_download_failed"] = "Le fichier export ne pouvait pas �tre t�l�charg�..";
$l_export["comma"] = ", {Virgule}";
$l_export["semicolon"] = "; {Point Vigule}";
$l_export["colon"] = ": {Double Point}";
$l_export["tab"] = "\\t {Tab}";
$l_export["space"] = "  {�space}";
$l_export["double_quote"] = "\" {Guillemets}";
$l_export["single_quote"] = "' {Apostrophe}";
$l_export['we_export'] = 'wE Export';
$l_export['wxml_export'] = 'Export XML de webEdition';
$l_export['txt_wxml_export'] = 'Export de documents, mod�les, objects et de classes de webEdition, correspondantent au DTD(Document-Type-Definition) sp�cifique de webEdition.';

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
$l_export['handle_doctype_options'] = 'Doctypes/<br>Categorys/<br>Navigation';
$l_export['handle_doctypes'] = 'Doctypes'; // TRANSLATE
$l_export['handle_categorys'] = 'Categorys';
$l_export['export_depth'] = 'Export depth'; // TRANSLATE
$l_export['to_level'] = 'to level'; // TRANSLATE
$l_export['select_export'] ='Pour exporter une entr�e cochez la case � cocher correspondante dans l&rsquo;arbre de fichier. Important: Tous les elements marqu�s de tous les branches seront exporter et si vous exporter un r�pertoire tous les documents de ce r�pertoire seront exporter �galement!';
$l_export['templates'] = 'Templates'; // TRANSLATE
$l_export['classes'] = 'Classes'; // TRANSLATE

$l_export['nothing_to_delete'] = "Rien � supprimer.";
$l_export['nothing_to_save'] = 'Rien � enregistrer!';
$l_export['no_perms'] = 'Vous n\'�tes pas authoris�!';
$l_export['new'] = 'Nouveau';
$l_export['export'] = 'Export'; // TRANSLATE
$l_export['group'] = 'Groupe';
$l_export['save'] = 'Enregistrer';
$l_export['delete'] = 'Supprimer';
$l_export['quit'] = 'Quitter';
$l_export['property'] = 'Pr�f�rences';
$l_export['name'] = 'Nom';
$l_export['save_to'] = 'Enregistrer sous:';
$l_export['selection'] = 'S�l�ction';
$l_export['save_ok'] = 'L\'Export a �t� enregistr�.';
$l_export['save_group_ok'] = 'Le Groupe a �t� enregistr�.';
$l_export['log'] = 'Journal';
$l_export['start_export'] = 'Export d�marre';
$l_export['prepare'] = 'Pr�paration de l\'Export...';
$l_export['doctype'] = 'Type-de-Document';
$l_export['category'] = 'Cat�gorie';
$l_export['end_export'] = 'Export termin�';
$l_export['newFolder'] = "Nouveau Groupe";
$l_export['folder_empty'] = "Le Groupe est vide";
$l_export['folder_path_exists'] = "Ce Groupe existe d�j�!";
$l_export['wrongtext'] = "Ce nom n'est pas valide!";
$l_export['wrongfilename'] = "The filename is not valid!"; // TRANSLATE
$l_export['folder_exists'] = "Ce groupe existe d�j�!";
$l_export['delete_ok'] = 'L\'Export a �t� supprim�.';
$l_export['delete_nok'] = 'Erreur: L\'Export n\'a pas �t� supprim�';
$l_export['delete_group_ok'] = 'Le Groupe a �t� supprim�.';
$l_export['delete_group_nok'] = 'Erreur: Le Groupe n\'a pas �t� supprim�';
$l_export['delete_question'] = 'Voulez-vous supprim� l\'Export actuel?';
$l_export['delete_group_question'] = 'Voulez-vous supprim� le Groupe actuel?';
$l_export['download_starting2'] = 'Le t�l�chargement du fichier Export a �t� d�marr�.';
$l_export['download_starting3'] = 'Si le t�l�chargement ne d�marre pas dans 10 secondes,';
$l_export['working'] = 'en train...';

$l_export['txt_document_options'] = 'Le mod�le standard est le mod�le qui a �t� defini dans les propri�t�s du Document. Les documents inclus sont les documents internes qui sont inclus par les Tags we:include, we:form, we:url, we:linkToSeeMode, we:a, we:href, we:link, we:css, we:js et we:addDelNewsletterEmail dans le document export�. Ces Objects sonst les object qui sont inclus par les Tags we:objekt et we:form  dans le document export�. Les documenst li�s sont les documents internes qui sont li� par les Tags-HTML body, a, img, table, td au document export�.';
$l_export['txt_object_options'] = 'Die Standard-Klasse ist die Klasse die in den Objekt-Eigenschaften definiert wurde.';
$l_export['txt_exportdeep_options'] = 'La Profondeur d\'Export est la profondeur jusqu\'� la quelle les documents ou bien objects seront export�s. Le champ doit �tre numerique!';
$l_export['name_empty'] = 'Le nom ne doit pas �tre vide!';
$l_export['name_exists'] = 'Le nom existe d�j�!';

$l_export['help'] = 'Aide';
$l_export['info'] = 'Info'; // TRANSLATE
$l_export['path_nok'] = 'Le chemin n\'est pas valide';

$l_export['must_save'] = "L'export a �t� modififi�.\\nVous devez d'abord enregistrer les donn�es de l'export avant que vous puissiez d�marrer l'export!";
$l_export['handle_owners_option'] = 'Donn�es de l\'utilisateur';
$l_export['handle_owners'] = 'Exporter les donn�es de l\'utilisateur.';
$l_export['txt_owners'] = 'Exporter les donn�es de l\'utilisateur li�es';

$l_export['weBinary'] = 'File'; // TRANSLATE
$l_export['handle_navigation'] = 'Navigation'; // TRANSLATE
$l_export['weNavigation'] = 'Navigation'; // TRANSLATE
$l_export['weNavigationRule'] = 'Navigation rule'; // TRANSLATE
$l_export['weThumbnail'] = 'Thumbnails'; // TRANSLATE
$l_export['handle_thumbnails'] = 'Thumbnails'; // TRANSLATE

$l_export['navigation_hint'] = 'To export the navigation entries, the template on which the navigation is displayed has also to be exported!'; // TRANSLATE

?>