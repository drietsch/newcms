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

$l_we_class["ChangePark"] = "Cette propriété ne peut être changer si le document est depublié!";
$l_we_class["fieldusers"] = "Utilisateur";
$l_we_class["other"] = "Divers";
$l_we_class["use_object"] = "Utilise Object";
$l_we_class["language"] = "Language"; // TRANSLATE
$l_we_class["users"] = "Utilisateur standard";
$l_we_class["copytext/css"] = "Copier la feuille de style de CSS Stylesheet";
$l_we_class["copytext/js"] = "Copier le Javascript";
$l_we_class["copytext/html"] = "Copier le site-HTML";
$l_we_class["copytext/plain"] = "Copier le fichier texte";
$l_we_class["copytext/xml"] = "Copy XML document"; // TRANSLATE
$l_we_class["copyTemplate"] = "Copier le modèle";
$l_we_class["copyFolder"] = "Copier le répertoire";
$l_we_class["copy_owners_expl"] = "Choisissez un répertoire, dont vous voulez copier le contenu dans le répertoire actuel.";
$l_we_class["category"] = "Catégories";
$l_we_class["folder_saved_ok"] = "Le répertoire '%s' a été enregistré avec succès!";
$l_we_class["response_save_ok"] = "Le document '%s' a été enregistré avec succès!";
$l_we_class["response_publish_ok"] = "Le Document '%s' a été publié avec succès!";
$l_we_class["response_unpublish_ok"] = "Le Document '%s' a été publié avec succès!";
$l_we_class["response_save_notok"] = "Erreur en registrant le document '%s'!";
$l_we_class["response_path_exists"] = "Le Document ou bien le Répertoire %s n'a pas pu être enregistré, parc qu\\'il existe déjà un document à cet endroit!";
$l_we_class["width"] = "Largeur";
$l_we_class["height"] = "Hauteur";
$l_we_class["width_tmp"] = "Largeur";
$l_we_class["height_tmp"] = "Hauteur";
$l_we_class["percent_width_tmp"] = "Largeur en %";
$l_we_class["percent_height_tmp"] = "Hauteur en %";
$l_we_class["alt"] = "Texte Alternative";
$l_we_class["alt_kurz"] = "Texte-Alt";
$l_we_class["title"] = "Titre";
$l_we_class["use_meta_title"] = "Utiliser un titre-meta";
$l_we_class["longdesc_text"] = "Fichier pour Attribut-'longdesc'";
$l_we_class["align"] = "Alignement";
$l_we_class["name"] = "Nom";
$l_we_class["hspace"] = "Distance horizontale";
$l_we_class["vspace"] = "Distance vertical";
$l_we_class["border"] = "Bordure";
$l_we_class["fields"] = "Champs";
$l_we_class["AutoFolder"] = "Répertoire automatique";
$l_we_class["AutoFilename"] = "Nom de Fichier";
$l_we_class["import_ok"] = "Documents importés avec succès!";
$l_we_class["function"] = "Function"; // TRANSLATE
$l_we_class["contenttable"] = "Tableau de Contenu";
$l_we_class["quality"] = "Qualité";
$l_we_class["salign"] = "Alignement de Flash ";
$l_we_class["play"] = "Jouer";
$l_we_class["loop"] = "Répéter";
$l_we_class["scale"] = "Graduer";
$l_we_class["bgcolor"] = "Couleur pour l'arrière plan";
$l_we_class["response_save_noperms_to_create_folders"] = "Le document n'a pas pu être enregistré, parc que vous n'avez pas les droits nécéssaires pour créer des nouveaux répertoires (%s)!";
$l_we_class["file_on_liveserver"]="Ce fichier existe déjà!";
$l_we_class["defaults"] = "Valeurs standards";
$l_we_class["attribs"] = "Attributs";
$l_we_class["intern"] = "Intern"; // TRANSLATE
$l_we_class["extern"] = "Extern"; // TRANSLATE
$l_we_class["linkType"] = "Type de Lien";
$l_we_class["href"] = "Href"; // TRANSLATE
$l_we_class["target"] = "Cible";
$l_we_class["hyperlink"] = "Hyperlink"; // TRANSLATE
$l_we_class["nolink"] = "Pas de Lien";
$l_we_class["noresize"] = "Ne pas changer";
$l_we_class["pixel"] = "Pixel"; // TRANSLATE
$l_we_class["percent"] = "Pourcent";
$l_we_class["new_doc_type"] = "Nouveau Type-de-Document";
$l_we_class["doctypes"] = "Types&nbsp;de&nbsp;Document";
$l_we_class["subdirectory"] = "Sous-Répertoire";
$l_we_class["subdir"][SUB_DIR_NO] = "-- aucun --";
$l_we_class["subdir"][SUB_DIR_YEAR] = "Année";
$l_we_class["subdir"][SUB_DIR_YEAR_MONTH] = "Année/Mois";
$l_we_class["subdir"][SUB_DIR_YEAR_MONTH_DAY] = "Année/Mois/Jour";
$l_we_class["doctype_save_ok"] = "Type-de-Document '%s' a été enregistré avec succès!";
$l_we_class["doctype_save_nok_exist"] = "Le Type-de-Document avec le nom '%s' existe déjà.\\n S\\'il vous plaît choisissez un autre nom et essayez le de nouveau!";
$l_we_class["delete_doc_type"] = "'%s' supprimer";
$l_we_class["doctype_delete_prompt"] = "Supprimer le Type-de-Document '%s'! Êtes-vous sûr?";
$l_we_class["doctype_delete_nok"] = "Le Type-de-Document avec le nom '%s' est déjà utilisé!\\n Le Type-de-Document ne peut pas être supprimé!";
$l_we_class["doctype_delete_ok"] = "Le Type-de-Document avec le nom  '%s' été supprimé avec succès!";
$l_we_class["confirm_ext_change"] = "Vous avez changer \\'Créer site dynamiquement\\'!\\nVoulez-vous remettre l\\'extension de fichier à la valeur standard?";
$l_we_class["newDocTypeName"] = "S'il vous plaît saisissez le nom du nouveau Type-de-Document!";
$l_we_class["no_perms"] = "Vous n'avez pas la permission d'utiliser ce site!";
$l_we_class["workspaces"] = "Éspaces de Travail";
$l_we_class["extraWorkspaces"] = "Éspaces de Travail supplémentaires";
$l_we_class["edit"] = "Editer";
$l_we_class["edit_image"] = "Image editing"; // TRANSLATE
$l_we_class["workspace"] = "Éspace de Travail";
$l_we_class["information"] = "Information"; // TRANSLATE
$l_we_class["previeweditmode"] = "Preview Editmode"; // TRANSLATE
$l_we_class["preview"] = "Prévision";
$l_we_class["no_preview_available"] = "No preview available for this file. To view this file please download it first."; // TRANSLATE
$l_we_class["file_not_saved"] = "File wasn't saved yet."; // TRANSLATE
$l_we_class["download"] = "Download"; // TRANSLATE
$l_we_class["validation"] = "Validation"; // TRANSLATE
$l_we_class["variants"] = "Variantes";
$l_we_class["tab_properties"] = "Propriétés";
$l_we_class["metainfos"] = "Infos-Meta";
$l_we_class["fields"] = "Champs";
$l_we_class["search"] = "Recherche";
$l_we_class["schedpro"] = "Ordonnanceur PRO";
$l_we_class["generateTemplate"] = "Crée un modèle";
$l_we_class["autoplay"] = "Jouer autom.";
$l_we_class["controller"] = "Montre le Bord de contrôle";
$l_we_class["volume"] = "Volume"; // TRANSLATE
$l_we_class["hidden"] = "Caché";
$l_we_class["workspacesFromClass"] = "Adopter de la classe";
$l_we_class["image"] = "Graphique";
$l_we_class["thumbnails"] = "Imagettes";
$l_we_class["metadata"] = "Metadata"; // TRANSLATE
$l_we_class["edit_show"] = "Montre les options d \'Image";
$l_we_class["edit_hide"] = "Cacher les otions d'Image";
$l_we_class["resize"] = "Changer la taille";
$l_we_class["rotate"] = "Tourner la Graphique";
$l_we_class["rotate_hint"] = "Avec la version de la GD Library installée sur le serveur il n\\'est pas possible de tourner des Images!";
$l_we_class["crop"] = "Crop image"; // TRANSLATE
$l_we_class["quality"] = "Qualité";
$l_we_class["quality_hint"] = "Choisissez la qualité d\\'image pour la Compression-JPEG <br><br> 10: meilleur qualité, requérit le plus d'espace disque <br> 0: la plus mauvaise qualité d\\'image, requérit le moins d\\'espace disque";
$l_we_class["quality_maximum"] = "Maximum"; // TRANSLATE
$l_we_class["quality_high"] = "Élevée";
$l_we_class["quality_medium"] = "Moyenne";
$l_we_class["quality_low"] = "Moins Bon";
$l_we_class["convert"] = "Convertire";
$l_we_class["convert_gif"] = "Format-GIF";
$l_we_class["convert_jpg"] = "Format-JPEG";
$l_we_class["convert_png"] = "Format-PNG";
$l_we_class["rotate0"] = "sans rotation";
$l_we_class["rotate180"] = "180&deg;-Rotation";
$l_we_class["rotate90l"] = "90&deg; Gauche";
$l_we_class["rotate90r"] = "90&deg; Droite";
$l_we_class["change_compression"] = "Changer la compression";
$l_we_class["upload"] = "télécharger";
$l_we_class["type_not_supported_hint"] = "La version de la GD Library installée sur le serveur ne support pas %s comme format d\\'édition! S\\'il vous plaît convertez dabord la graphique dans un format compatible!";
$l_we_class["CSS"] = "CSS"; // TRANSLATE
$l_we_class['we_del_workspace_error'] = "L'espace de travail n'a pas pu être supprimé, parce qu'il est utilisé par des objects de la classe.";
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

$l_we_class['doctype_changed_question'] = "Should the default values for the document type be applied for this document?"; // TRANSLATE
$l_we_class['availableAfterSave'] = "The feature is only available after saving the entry."; // TRANSLATE
?>