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
$l_import['title'] = 'Assistant-d\'Import';
$l_import['wxml_import'] = 'Import XML de webEdition  ';
$l_import['gxml_import'] = 'Import Générique de XML ';
$l_import['csv_import'] = 'Import de CSV';
$l_import['import'] = 'Importer';
$l_import['none'] = '-- Aucun --';
$l_import['any'] = '-- Sans --';
$l_import['source_file'] = 'Fichier de Source';
$l_import['import_dir'] = 'Répertoire de Cible';
$l_import['select_source_file'] = 'S\'il vous plaît choisissez un fichier source.';
$l_import['we_title'] = 'Titre';
$l_import['we_description'] = 'Texte de Déscription';
$l_import['we_keywords'] = 'Mots-clé';
$l_import['uts'] = 'Unix-Timestamp'; // TRANSLATE
$l_import['unix_timestamp'] = 'Le timestamp est un format qui indique le nombre de secondes écoulées depuis le début de l’époque Unix (01.01.1970).';
$l_import['gts'] = 'GMT Timestamp'; // TRANSLATE
$l_import['gmt_timestamp'] = 'General Mean Time ou bien Greenwich Mean Time (GMT).';
$l_import['fts'] = 'Propre format';
$l_import['format_timestamp'] = 'Dans la chaîne format est symbol suivant sont permit: Y (Année, 4 chiffres), y (Année, 2 chiffres), m (Mois au format numérique, avec zéros initiaux), n (Mois sans les zéros initiaux), d (Mois sans les zéros initiaux), j (Mois sans les zéros initiaux), H (Heure, au format 24h, avec les zéros initiaux), G (	Heure, au format 24h, sans les zéros initiaux), i (Minutes avec les zéros initiaux), s (	Secondes, avec zéros initiaux)';
$l_import['import_progress'] = 'Importer';
$l_import['prepare_progress'] = 'Préparation';
$l_import['finish_progress'] = 'Terminé';
$l_import['finish_import'] = 'L\'import a été terminé avec succès!';
$l_import['import_file'] = 'Import de fichier';
$l_import['import_data'] = 'Import de données';
$l_import['file_import'] = 'Importer des fichiers locals';
$l_import['txt_file_import'] = 'Importer une ou plusieurs fichiers du disque dur local.';
$l_import['site_import'] = 'Importer des fichiers du serveur';
$l_import['site_import_isp'] = 'Importer';
$l_import['txt_site_import_isp'] = 'Importer des graphique d\'un répertoire serveur.Choisissez, quelles graphiques doivent être importées.';
$l_import['txt_site_import'] = 'Importer des fichiers d\'un répertoire de serveur. Choisissez par les options de filtre si des Graphiques, des site-HTML, des vidéo-Flash, Fichier-JavaScript,des Fichier-CSS, des Document de texte clair ou autre document doivent être importés';
$l_import['txt_wxml_import'] = 'Des fichiers XML de webEdition contiennent des informations sur les documents de webEdition webEdition. Définissez dans quel répertoire les objects et documents seront importés.';
$l_import['txt_gxml_import'] = 'Import "flat" XML files, such as those provided by phpMyAdmin. The dataset fields have to be allocated to the webEdition dataset fields. Use this to import XML files exported from webEdition without the export module.'; // TRANSLATE
$l_import['txt_csv_import'] = 'Import des fichier-CSV (Comma Separated Values) ou des formats comparables (p.ex. *.txt). Les champs d\'enregistrement vont être assignés à des champs de webEdtion.';
$l_import['add_expat_support'] = 'L\'interface d\'import XML nécessite l\'extension XML expat de James Clark. Compilez PHP de nouveau avec l\'extension expat, pour que la functionalité de l\'import XML est garanti.';
$l_import['xml_file'] = 'Fichier-XML';
$l_import['templates'] = 'Modèle';
$l_import['classes'] = 'Classes'; // TRANSLATE
$l_import['predetermined_paths'] = 'Chemins allégués';
$l_import['maintain_paths'] = 'Conserver les chemin';
$l_import['import_options'] = 'Outils d\'Import';
$l_import['file_collision'] = 'Si un fichier existe';
$l_import['collision_txt'] = 'Important des fichiers dans un répertoire, qui contient déja un fichier avec le même nom, peut créer des conflits. Définissez comment l\'assistant-d\'import doit traiter ces fichiers.';
$l_import['replace'] = 'Remplacer';
$l_import['replace_txt'] = 'Supprimer le fichier existant et remplacer avec les entrées du fichier actuel.';
$l_import['rename'] = 'Renommer';
$l_import['rename_txt'] = 'Au nom du fichier sera ajouté une ID univalent. Tous les liens, qui mennent au fichier, seront réajusté.';
$l_import['skip'] = 'Enjamber';
$l_import['skip_txt'] = 'En enjambant le fichier actuel le fichier existant sera préservé.';
$l_import['extra_data'] = 'Données extra';
$l_import['integrated_data'] = 'Importer les données inlcues';
$l_import['integrated_data_txt'] = 'Choisissez cette option, si les données ou bien documents inclues par les modèles doivent être importés.';
$l_import['max_level'] = 'jusqu\'au plan';
$l_import['import_doctypes'] = 'Importer des types de documents';
$l_import['import_categories'] = 'Importer des catégories';
$l_import['invalid_wxml'] = 'Il n\'est possible d\'importer que des fichiers-XML, qui correspondent à la Document-Type-Definition (DTD) de webEdition.';
$l_import['valid_wxml'] = 'Le fichier-XML est bien formé est valide, c\'est-à-dire il correspond à la Document-Type-Definition (DTD) de webEdition.';
$l_import['specify_docs'] = 'S\'il vous plaît choisissez les documents, que vous voulez importer.';
$l_import['specify_objs'] = 'S\'il vous plaît choisissez les objects, que vous voulez importer.';
$l_import['specify_docs_objs'] = 'S\'il vous plaît choisissez les documents et/ou documents que vous voulez importer.';
$l_import['no_object_rights'] = 'Vous n\'êtes pas authorisé d\'importer des objects .';
$l_import['display_validation'] = 'afficher la Validation-XML';
$l_import['xml_validation'] = 'Validation-XML';
$l_import['warning'] = 'Avertissement';
$l_import['attribute'] = 'Attribut';
$l_import['invalid_nodes'] = 'noeud-XML invalide à la position ';
$l_import['no_attrib_node'] = 'Manque de l\'element-XML "attrib" à la position ';
$l_import['invalid_attributes'] = 'Attributs invalides à la position ';
$l_import['attrs_incomplete'] = 'la liste des attributs définits comme #required et #fixed est imcomplète à la position ';
$l_import['wrong_attribute'] = 'le nom d\'attribut n\'a été défini ni comme #required et ni comme #implied à la position ';
$l_import['documents'] = 'Documents'; // TRANSLATE
$l_import['objects'] = 'Objects'; // TRANSLATE
$l_import['fileselect_server'] = 'Charger le fichier source du serveur';
$l_import['fileselect_local'] = 'Charger le fichier source du disque dur local';
$l_import['filesize_local'] = 'Le fichier à télécharger ne doit être plus grand que %s à cause des limitation de PHP!';
$l_import['xml_mime_type'] = 'Le fichier choisi ne peut pas être importé. Type-Mime:';
$l_import['invalid_path'] = 'Le chemin du fichier source est invalide.';
$l_import['ext_xml'] = 'S\'il vous plaît choisissez un fichier source avec une extension de fichier ".xml".';
$l_import['store_docs'] = 'Répertoire source des documents';
$l_import['store_tpls'] = 'Répertoire source des modèles';
$l_import['store_objs'] = 'Répertoire source des objects';
$l_import['doctype'] = 'Document type';
$l_import['gxml'] = 'XML Générique';
$l_import['data_import'] = 'Importer des Données';
$l_import['documents'] = 'Documents'; // TRANSLATE
$l_import['objects'] = 'Objects'; // TRANSLATE
$l_import['type'] = 'Typ';
$l_import['template'] = 'Modèle';
$l_import['class'] = 'Classe';
$l_import['categories'] = 'Catégories';
$l_import['isDynamic'] = 'Créer le site dynamiquement';
$l_import['extension'] = 'Extension'; // TRANSLATE
$l_import['filetype'] = 'Typ de fichier';
$l_import['directory'] = 'Répertoire';
$l_import['select_data_set'] = 'Choisir un enregistrement';
$l_import['select_docType'] = 'S\'il vous plaît choisissez un modèle.';
$l_import['file_exists'] = 'Le fichier source choisi n\'existe pas. S\'il vous plaît vérifié le chemin, chemin: ';
$l_import['file_readable'] = 'Le fichier source choisi, n\'a pas lisible et ne peut pas être importé alors.';
$l_import['asgn_rcd_flds'] = 'Assigner les champs de données';
$l_import['we_flds'] = 'Champs de webEdition';
$l_import['rcd_flds'] = 'Champs d\'enregistrement';
$l_import['name'] = 'Nom';
$l_import['auto'] = 'automatiquement';
$l_import['asgnd'] = 'assigné';
$l_import['pfx'] = 'Préfix';
$l_import['pfx_doc'] = 'Document'; // TRANSLATE
$l_import['pfx_obj'] = 'Object'; // TRANSLATE
$l_import['rcd_fld'] = 'Champ d\'enregistrement';
$l_import['import_settings'] = 'Préférences d\'Import';
$l_import['xml_valid_1'] = 'Le fichier-XML est valide et contient';
$l_import['xml_valid_s2'] = 'Elements. Choisissez les elements, que vous voulez importés.';
$l_import['xml_valid_m2'] = 'Des noeuds-XML-enfant au premier plan avec des noms differents. S\'il vous plaît choisissez le noeud-XML et le nombre d\'elements que vous voulez importer.';
$l_import['well_formed'] = 'Le document-XML est bien formé.';
$l_import['not_well_formed'] = 'Le document-XML n\'est pas bien formé et ne peut pas être importé.';
$l_import['missing_child_node'] = 'Le document-XML est bien formé, mais ne contient pas de noeuds-XML et ne peut pas être importé alors.';
$l_import['select_elements'] = 'S\'il vous plaît choisissez les enregistrement, que vous voulez importer.';
$l_import['num_elements'] = 'S\'il vous plaît choisissez un nombre d\'enregistrement entre 1 et ';
$l_import['xml_invalid'] = ''; // TRANSLATE
$l_import['option_select'] = 'Séléction..';
$l_import['num_data_sets'] = 'Enregistrements:';
$l_import['to'] = 'à';
$l_import['assign_record_fields'] = 'Assigner les champs donnée';
$l_import['we_fields'] = 'Champs de webEdition';
$l_import['record_fields'] = 'Champs d\'enregistrement';
$l_import['record_field'] = 'Champ d\'enregistrement';
$l_import['attributes'] = 'Attribut';
$l_import['settings'] = 'Préférences';
$l_import['field_options'] = 'Outils de champ';
$l_import['csv_file'] = 'Fichier CSV';
$l_import['csv_settings'] = 'Préférences CSV';
$l_import['xml_settings'] = 'Préférences XML';
$l_import['file_format'] = 'Format de fichier';
$l_import['field_delimiter'] = 'Séperateur';
$l_import['comma'] = ', {Virgule}';
$l_import['semicolon'] = '; {Point Virgule}';
$l_import['colon'] = ': {Double-Point}';
$l_import['tab'] = "\\t {Tab}";
$l_import['space'] = '  {Éspace}';
$l_import['text_delimiter'] = 'Limiteur de Texte';
$l_import['double_quote'] = '" {Guillemets}';
$l_import['single_quote'] = '\' {Apostrophe}';
$l_import['contains'] = 'La première ligne contient le nom de champ';
$l_import['split_xml'] = 'Importer les enregistrements un par un';
$l_import['wellformed_xml'] = 'Vérifier si le document est bien formé';
$l_import['validate_xml'] = 'Validation-XML';
$l_import['select_csv_file'] = 'S\'il vous plaît choissisez un fichier source CSV.';
$l_import['select_seperator'] = 'S\'il vous plaît choissisez un sépérateur.';
$l_import['format_date'] = 'Format de date';
$l_import['info_sdate'] = 'Choisissez le format de date pour le champ webEdition';
$l_import['info_mdate'] = 'Choisissez le format de date pour les champs webEdition';
$l_import['remark_csv'] = 'Vous pouvez importer des fichiers-CSV(Comma Separated Values) ou des formats comparable (p.ex. *.txt). Avec l\'import de ces format de fichier il est possible de choisir le séperateur (p.ex , ; Tab, Éspace) et le limiteur de texte (= le signe, qui emballe le texte).';
$l_import['remark_xml'] = 'Choisissez l\'option \"Importez les enregistrement isolément \", pour que des grandes fichier peuvent être importé dans le temps de timeout d\'un script PHP.<br> Si vous n\'êtes pas sûr que le fichier séléctioné est un document webEdition-XML, vous pouvez vérifier s\'il est bien formé et valide.';

$l_import["import_docs"]="Importer des Documents";
$l_import["import_templ"]="Importer des Modèles";
$l_import["import_objs"]="Importer des Objects";
$l_import["import_classes"]="Importer des Classes";
$l_import["import_doctypes"]="Importer des types de documents";
$l_import["import_cats"]="Importer des Catégories";
$l_import["documents_desc"]="S\'il vous plaît saisissez un répertoire, dans lequel les documents seront importés . Si l\'option \"".$l_import['maintain_paths']."\" est choisi les chemins correspondant seront réproduit automatiquement, autrement les chemins seront ignorés.";
$l_import["templates_desc"]="S\'il vous plaît saisissez un répertoire, dans lequel les modèles seront importés . Si l\'option \"".$l_import['maintain_paths']."\" est choisi les chemins correspondant seront réproduit automatiquement, autrement les chemins seront ignorés.";
$l_import['handle_document_options'] = 'Documents'; // TRANSLATE
$l_import['handle_template_options'] = 'Modèles';
$l_import['handle_object_options'] = 'Objects'; // TRANSLATE
$l_import['handle_class_options'] = 'Classe';
$l_import["handle_doctype_options"] = "Type-de-Document";
$l_import["handle_category_options"] = "Categories";
$l_import['log'] = 'Détails';
$l_import['start_import'] = 'Import démarre';
$l_import['prepare'] = 'Préparation...';
$l_import['update_links'] = 'Actualisations-Liens...';
$l_import['doctype'] = 'Type-de-Document';
$l_import['category'] = 'Catégorie';
$l_import['end_import'] = 'Import terminé';

$l_import['handle_owners_option'] = 'Données de l\'utilisateur';
$l_import['txt_owners'] = 'Importer les données de l\'utilisateur.';
$l_import['handle_owners'] = 'Restaurer les données de l\'utilisateur';
$l_import['notexist_overwrite'] = 'Si l\'utilisateur n\'existe pas, l\'option "Effacer les données de l\'utilisateur" sera utilisée';
$l_import['owner_overwrite'] = 'Effacer les données de l\'utilisateur';

$l_import['name_collision'] = 'Collision de nom';

$l_import['item'] = 'Article'; // TRANSLATE
$l_import['backup_file_found'] = 'Le fichier ressemble à un fichier de sauvegarde de webEdition. S\'il vous plaît utilisez l\'option \"Sauvegarde\" du menu \"Fichier\" pour importer les données.';
$l_import['backup_file_found_question'] = 'Voulez-vous fermer maintenant le dialogue actuel et démarrer l\'assistant-de sauvegarde?';
$l_import['close'] = 'Fermer';
$l_import['handle_file_options'] = 'Fichiers';
$l_import['import_files'] = 'Importer les fichiers';
$l_import['weBinary'] = 'Fichier';
$l_import['format_unknown'] = 'Le format du fichier est inconnu!';
$l_import['customer_import_file_found'] = 'Le fichier ressemble à un fichier d\'import du gestion clients. S\'il vous plaît utilisez l\'option \"Import/Export\" du gestio clients (PRO) pour importer les données.';
$l_import['upload_failed'] = 'Le fichier ne peut pas être téléchargé. S\'il vous plaît verifiez, si la taille du fichier dépasse %s';

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