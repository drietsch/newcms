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
 * Language file: export.inc.php
 * Provides language strings.
 * Language: English
 */
$l_export["save_changed_export"] = "Export has been changed.\\nDo you want to save your changes?"; // TRANSLATE
$l_export["auto_selection"] = "Sélection automatique";
$l_export["txt_auto_selection"] = "Exporte automatiquement - d'après type-de-document ou classe- les documents ou objects choisis.";
$l_export["txt_auto_selection_csv"] = "Exports objects automatically according to their class."; // TRANSLATE
$l_export["manual_selection"] = "Sélection manuelle";
$l_export["txt_manual_selection"] = "Export manuel des document et object choisis.";
$l_export["txt_manual_selection_csv"] = "Exports manually selected objects."; // TRANSLATE
$l_export["element"] = "Sélection d'elements";
$l_export["documents"] = "Documents"; // TRANSLATE
$l_export["objects"] = "Objects"; // TRANSLATE
$l_export["step1"] = "Définir la séléction d'elements";
$l_export["step2"] = "Choisissez les elements à exporter";
$l_export["step3"] = "Export Générique";
$l_export["step10"] = "Export terminée";
$l_export["step99"] = "Erreur en exportant";
$l_export["step99_notice"] = "L'export n'est pas possible";
$l_export["server_finished"] = "Le fichier export a été enregistré sur le serveur.";
$l_export["backup_finished"] = "L'export a été terminé avec succès.";
$l_export["download_starting"] = "Le téléchargement du fichier a été démarré.<br><br>Si le téléchargement ne commence pas dans 10 secondes,<br>";
$l_export["download"] = "s'il vous plaît cliquez ici.";
$l_export["download_failed"] = "Le fichier demandé n'existe pas ou vous n'avez pas l'authorisation de le télécharger.";
$l_export["file_format"] = "Format de fichier";
$l_export["export_to"] = "Exporter à";
$l_export["export_to_server"] = "Serveur";
$l_export["export_to_local"] = "Disque dur local";
$l_export["cdata"] = "Codage";
$l_export["export_xml_cdata"] = "Ajouter des séctions-CDATA";
$l_export["export_xml_entities"] = "Remplacer les entités";
$l_export["filename"] = "Nom de fichier";
$l_export["path"] = "Chemin";
$l_export["doctypename"] = "Documents du Type-de-Document";
$l_export["classname"] = "Objects de la classe";
$l_export["dir"] = "Verzeichnis";
$l_export["categories"] = "Catégories";
$l_export["wizard_title"] = "Assistan d'Export";
$l_export["xml_format"] = "XML"; // TRANSLATE
$l_export["csv_format"] = "CSV"; // TRANSLATE
$l_export["csv_delimiter"] = "Séperateur";
$l_export["csv_enclose"] = "Limiteur de texte";
$l_export["csv_escape"] = "Éspace";
$l_export["csv_lineend"] = "Format de fichier";
$l_export["csv_null"] = "Remplacement-NULL";
$l_export["csv_fieldnames"] = "La première ligne contient le nom de champ";
$l_export["windows"] = "Format Windows";
$l_export["unix"] = "Format UNIX";
$l_export["mac"] = "Format Mac";
$l_export["generic_export"] = "Export Générique";
$l_export["title"] = "Assistan d'Export";
$l_export["gxml_export"] = "Export Générique XML ";
$l_export["txt_gxml_export"] = "Export de documents et objects de webEdition au format XMl \"plat\" (3 plans).";
$l_export["csv_export"] = "Export CSV";
$l_export["txt_csv_export"] = "Export d'objects webEdition au format CSV (Comma Separated Values).";
$l_export["csv_params"] = "Préférences";
$l_export["error"] = "L'export n'a pas été terminé avec succès!";
$l_export["error_unknown"] = "Une erreur inconnue s'est produit!";
$l_export["error_object_module"] = "L'export de document au forma CSV n'est pas supporté en ce moment!<br><br>Comme le modul de base de données/objects n'est pas installé, l'export au format CSV n'est pas disponible.";
$l_export["error_nothing_selected_docs"] = "L'export n'a pas été éffectué!<br><br>Aucun document choisi.";
$l_export["error_nothing_selected_objs"] = "L'export n'a pas été éffectué!<br><br>Aucun document ou object choisi.";
$l_export["error_download_failed"] = "Le fichier export ne pouvait pas être téléchargé..";
$l_export["comma"] = ", {Virgule}";
$l_export["semicolon"] = "; {Point Vigule}";
$l_export["colon"] = ": {Double Point}";
$l_export["tab"] = "\\t {Tab}";
$l_export["space"] = "  {Éspace}";
$l_export["double_quote"] = "\" {Guillemets}";
$l_export["single_quote"] = "' {Apostrophe}";
$l_export['we_export'] = 'wE Export';
$l_export['wxml_export'] = 'Export XML de webEdition';
$l_export['txt_wxml_export'] = 'Export de documents, modèles, objects et de classes de webEdition, correspondantent au DTD(Document-Type-Definition) spécifique de webEdition.';

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
$l_export['select_export'] ='Pour exporter une entrée cochez la case à cocher correspondante dans l&rsquo;arbre de fichier. Important: Tous les elements marqués de tous les branches seront exporter et si vous exporter un répertoire tous les documents de ce répertoire seront exporter également!';
$l_export['templates'] = 'Templates'; // TRANSLATE
$l_export['classes'] = 'Classes'; // TRANSLATE

$l_export['nothing_to_delete'] = "Rien à supprimer.";
$l_export['nothing_to_save'] = 'Rien à enregistrer!';
$l_export['no_perms'] = 'Vous n\'êtes pas authorisé!';
$l_export['new'] = 'Nouveau';
$l_export['export'] = 'Export'; // TRANSLATE
$l_export['group'] = 'Groupe';
$l_export['save'] = 'Enregistrer';
$l_export['delete'] = 'Supprimer';
$l_export['quit'] = 'Quitter';
$l_export['property'] = 'Préférences';
$l_export['name'] = 'Nom';
$l_export['save_to'] = 'Enregistrer sous:';
$l_export['selection'] = 'Séléction';
$l_export['save_ok'] = 'L\'Export a été enregistré.';
$l_export['save_group_ok'] = 'Le Groupe a été enregistré.';
$l_export['log'] = 'Journal';
$l_export['start_export'] = 'Export démarre';
$l_export['prepare'] = 'Préparation de l\'Export...';
$l_export['doctype'] = 'Type-de-Document';
$l_export['category'] = 'Catégorie';
$l_export['end_export'] = 'Export terminé';
$l_export['newFolder'] = "Nouveau Groupe";
$l_export['folder_empty'] = "Le Groupe est vide";
$l_export['folder_path_exists'] = "Ce Groupe existe déjà!";
$l_export['wrongtext'] = "Ce nom n'est pas valide!";
$l_export['wrongfilename'] = "The filename is not valid!"; // TRANSLATE
$l_export['folder_exists'] = "Ce groupe existe déjà!";
$l_export['delete_ok'] = 'L\'Export a été supprimé.';
$l_export['delete_nok'] = 'Erreur: L\'Export n\'a pas été supprimé';
$l_export['delete_group_ok'] = 'Le Groupe a été supprimé.';
$l_export['delete_group_nok'] = 'Erreur: Le Groupe n\'a pas été supprimé';
$l_export['delete_question'] = 'Voulez-vous supprimé l\'Export actuel?';
$l_export['delete_group_question'] = 'Voulez-vous supprimé le Groupe actuel?';
$l_export['download_starting2'] = 'Le téléchargement du fichier Export a été démarré.';
$l_export['download_starting3'] = 'Si le téléchargement ne démarre pas dans 10 secondes,';
$l_export['working'] = 'en train...';

$l_export['txt_document_options'] = 'Le modèle standard est le modèle qui a été defini dans les propriétés du Document. Les documents inclus sont les documents internes qui sont inclus par les Tags we:include, we:form, we:url, we:linkToSeeMode, we:a, we:href, we:link, we:css, we:js et we:addDelNewsletterEmail dans le document exporté. Ces Objects sonst les object qui sont inclus par les Tags we:objekt et we:form  dans le document exporté. Les documenst liés sont les documents internes qui sont lié par les Tags-HTML body, a, img, table, td au document exporté.';
$l_export['txt_object_options'] = 'Die Standard-Klasse ist die Klasse die in den Objekt-Eigenschaften definiert wurde.';
$l_export['txt_exportdeep_options'] = 'La Profondeur d\'Export est la profondeur jusqu\'à la quelle les documents ou bien objects seront exportés. Le champ doit être numerique!';
$l_export['name_empty'] = 'Le nom ne doit pas être vide!';
$l_export['name_exists'] = 'Le nom existe déjà!';

$l_export['help'] = 'Aide';
$l_export['info'] = 'Info'; // TRANSLATE
$l_export['path_nok'] = 'Le chemin n\'est pas valide';

$l_export['must_save'] = "L'export a été modififié.\\nVous devez d'abord enregistrer les données de l'export avant que vous puissiez démarrer l'export!";
$l_export['handle_owners_option'] = 'Données de l\'utilisateur';
$l_export['handle_owners'] = 'Exporter les données de l\'utilisateur.';
$l_export['txt_owners'] = 'Exporter les données de l\'utilisateur liées';

$l_export['weBinary'] = 'File'; // TRANSLATE
$l_export['handle_navigation'] = 'Navigation'; // TRANSLATE
$l_export['weNavigation'] = 'Navigation'; // TRANSLATE
$l_export['weNavigationRule'] = 'Navigation rule'; // TRANSLATE
$l_export['weThumbnail'] = 'Thumbnails'; // TRANSLATE
$l_export['handle_thumbnails'] = 'Thumbnails'; // TRANSLATE

$l_export['navigation_hint'] = 'To export the navigation entries, the template on which the navigation is displayed has also to be exported!'; // TRANSLATE

?>