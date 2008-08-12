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
$l_import['gxml_import'] = 'Import G�n�rique de XML ';
$l_import['csv_import'] = 'Import de CSV';
$l_import['import'] = 'Importer';
$l_import['none'] = '-- Aucun --';
$l_import['any'] = '-- Sans --';
$l_import['source_file'] = 'Fichier de Source';
$l_import['import_dir'] = 'R�pertoire de Cible';
$l_import['select_source_file'] = 'S\'il vous pla�t choisissez un fichier source.';
$l_import['we_title'] = 'Titre';
$l_import['we_description'] = 'Texte de D�scription';
$l_import['we_keywords'] = 'Mots-cl�';
$l_import['uts'] = 'Unix-Timestamp'; // TRANSLATE
$l_import['unix_timestamp'] = 'Le timestamp est un format qui indique le nombre de secondes �coul�es depuis le d�but de l��poque Unix (01.01.1970).';
$l_import['gts'] = 'GMT Timestamp'; // TRANSLATE
$l_import['gmt_timestamp'] = 'General Mean Time ou bien Greenwich Mean Time (GMT).';
$l_import['fts'] = 'Propre format';
$l_import['format_timestamp'] = 'Dans la cha�ne format est symbol suivant sont permit: Y (Ann�e, 4 chiffres), y (Ann�e, 2 chiffres), m (Mois au format num�rique, avec z�ros initiaux), n (Mois sans les z�ros initiaux), d (Mois sans les z�ros initiaux), j (Mois sans les z�ros initiaux), H (Heure, au format 24h, avec les z�ros initiaux), G (	Heure, au format 24h, sans les z�ros initiaux), i (Minutes avec les z�ros initiaux), s (	Secondes, avec z�ros initiaux)';
$l_import['import_progress'] = 'Importer';
$l_import['prepare_progress'] = 'Pr�paration';
$l_import['finish_progress'] = 'Termin�';
$l_import['finish_import'] = 'L\'import a �t� termin� avec succ�s!';
$l_import['import_file'] = 'Import de fichier';
$l_import['import_data'] = 'Import de donn�es';
$l_import['file_import'] = 'Importer des fichiers locals';
$l_import['txt_file_import'] = 'Importer une ou plusieurs fichiers du disque dur local.';
$l_import['site_import'] = 'Importer des fichiers du serveur';
$l_import['site_import_isp'] = 'Importer';
$l_import['txt_site_import_isp'] = 'Importer des graphique d\'un r�pertoire serveur.Choisissez, quelles graphiques doivent �tre import�es.';
$l_import['txt_site_import'] = 'Importer des fichiers d\'un r�pertoire de serveur. Choisissez par les options de filtre si des Graphiques, des site-HTML, des vid�o-Flash, Fichier-JavaScript,des Fichier-CSS, des Document de texte clair ou autre document doivent �tre import�s';
$l_import['txt_wxml_import'] = 'Des fichiers XML de webEdition contiennent des informations sur les documents de webEdition webEdition. D�finissez dans quel r�pertoire les objects et documents seront import�s.';
$l_import['txt_gxml_import'] = 'Import "flat" XML files, such as those provided by phpMyAdmin. The dataset fields have to be allocated to the webEdition dataset fields. Use this to import XML files exported from webEdition without the export module.'; // TRANSLATE
$l_import['txt_csv_import'] = 'Import des fichier-CSV (Comma Separated Values) ou des formats comparables (p.ex. *.txt). Les champs d\'enregistrement vont �tre assign�s � des champs de webEdtion.';
$l_import['add_expat_support'] = 'L\'interface d\'import XML n�cessite l\'extension XML expat de James Clark. Compilez PHP de nouveau avec l\'extension expat, pour que la functionalit� de l\'import XML est garanti.';
$l_import['xml_file'] = 'Fichier-XML';
$l_import['templates'] = 'Mod�le';
$l_import['classes'] = 'Classes'; // TRANSLATE
$l_import['predetermined_paths'] = 'Chemins all�gu�s';
$l_import['maintain_paths'] = 'Conserver les chemin';
$l_import['import_options'] = 'Outils d\'Import';
$l_import['file_collision'] = 'Si un fichier existe';
$l_import['collision_txt'] = 'Important des fichiers dans un r�pertoire, qui contient d�ja un fichier avec le m�me nom, peut cr�er des conflits. D�finissez comment l\'assistant-d\'import doit traiter ces fichiers.';
$l_import['replace'] = 'Remplacer';
$l_import['replace_txt'] = 'Supprimer le fichier existant et remplacer avec les entr�es du fichier actuel.';
$l_import['rename'] = 'Renommer';
$l_import['rename_txt'] = 'Au nom du fichier sera ajout� une ID univalent. Tous les liens, qui mennent au fichier, seront r�ajust�.';
$l_import['skip'] = 'Enjamber';
$l_import['skip_txt'] = 'En enjambant le fichier actuel le fichier existant sera pr�serv�.';
$l_import['extra_data'] = 'Donn�es extra';
$l_import['integrated_data'] = 'Importer les donn�es inlcues';
$l_import['integrated_data_txt'] = 'Choisissez cette option, si les donn�es ou bien documents inclues par les mod�les doivent �tre import�s.';
$l_import['max_level'] = 'jusqu\'au plan';
$l_import['import_doctypes'] = 'Importer des types de documents';
$l_import['import_categories'] = 'Importer des cat�gories';
$l_import['invalid_wxml'] = 'Il n\'est possible d\'importer que des fichiers-XML, qui correspondent � la Document-Type-Definition (DTD) de webEdition.';
$l_import['valid_wxml'] = 'Le fichier-XML est bien form� est valide, c\'est-�-dire il correspond � la Document-Type-Definition (DTD) de webEdition.';
$l_import['specify_docs'] = 'S\'il vous pla�t choisissez les documents, que vous voulez importer.';
$l_import['specify_objs'] = 'S\'il vous pla�t choisissez les objects, que vous voulez importer.';
$l_import['specify_docs_objs'] = 'S\'il vous pla�t choisissez les documents et/ou documents que vous voulez importer.';
$l_import['no_object_rights'] = 'Vous n\'�tes pas authoris� d\'importer des objects .';
$l_import['display_validation'] = 'afficher la Validation-XML';
$l_import['xml_validation'] = 'Validation-XML';
$l_import['warning'] = 'Avertissement';
$l_import['attribute'] = 'Attribut';
$l_import['invalid_nodes'] = 'noeud-XML invalide � la position ';
$l_import['no_attrib_node'] = 'Manque de l\'element-XML "attrib" � la position ';
$l_import['invalid_attributes'] = 'Attributs invalides � la position ';
$l_import['attrs_incomplete'] = 'la liste des attributs d�finits comme #required et #fixed est imcompl�te � la position ';
$l_import['wrong_attribute'] = 'le nom d\'attribut n\'a �t� d�fini ni comme #required et ni comme #implied � la position ';
$l_import['documents'] = 'Documents'; // TRANSLATE
$l_import['objects'] = 'Objects'; // TRANSLATE
$l_import['fileselect_server'] = 'Charger le fichier source du serveur';
$l_import['fileselect_local'] = 'Charger le fichier source du disque dur local';
$l_import['filesize_local'] = 'Le fichier � t�l�charger ne doit �tre plus grand que %s � cause des limitation de PHP!';
$l_import['xml_mime_type'] = 'Le fichier choisi ne peut pas �tre import�. Type-Mime:';
$l_import['invalid_path'] = 'Le chemin du fichier source est invalide.';
$l_import['ext_xml'] = 'S\'il vous pla�t choisissez un fichier source avec une extension de fichier ".xml".';
$l_import['store_docs'] = 'R�pertoire source des documents';
$l_import['store_tpls'] = 'R�pertoire source des mod�les';
$l_import['store_objs'] = 'R�pertoire source des objects';
$l_import['doctype'] = 'Document type';
$l_import['gxml'] = 'XML G�n�rique';
$l_import['data_import'] = 'Importer des Donn�es';
$l_import['documents'] = 'Documents'; // TRANSLATE
$l_import['objects'] = 'Objects'; // TRANSLATE
$l_import['type'] = 'Typ';
$l_import['template'] = 'Mod�le';
$l_import['class'] = 'Classe';
$l_import['categories'] = 'Cat�gories';
$l_import['isDynamic'] = 'Cr�er le site dynamiquement';
$l_import['extension'] = 'Extension'; // TRANSLATE
$l_import['filetype'] = 'Typ de fichier';
$l_import['directory'] = 'R�pertoire';
$l_import['select_data_set'] = 'Choisir un enregistrement';
$l_import['select_docType'] = 'S\'il vous pla�t choisissez un mod�le.';
$l_import['file_exists'] = 'Le fichier source choisi n\'existe pas. S\'il vous pla�t v�rifi� le chemin, chemin: ';
$l_import['file_readable'] = 'Le fichier source choisi, n\'a pas lisible et ne peut pas �tre import� alors.';
$l_import['asgn_rcd_flds'] = 'Assigner les champs de donn�es';
$l_import['we_flds'] = 'Champs de webEdition';
$l_import['rcd_flds'] = 'Champs d\'enregistrement';
$l_import['name'] = 'Nom';
$l_import['auto'] = 'automatiquement';
$l_import['asgnd'] = 'assign�';
$l_import['pfx'] = 'Pr�fix';
$l_import['pfx_doc'] = 'Document'; // TRANSLATE
$l_import['pfx_obj'] = 'Object'; // TRANSLATE
$l_import['rcd_fld'] = 'Champ d\'enregistrement';
$l_import['import_settings'] = 'Pr�f�rences d\'Import';
$l_import['xml_valid_1'] = 'Le fichier-XML est valide et contient';
$l_import['xml_valid_s2'] = 'Elements. Choisissez les elements, que vous voulez import�s.';
$l_import['xml_valid_m2'] = 'Des noeuds-XML-enfant au premier plan avec des noms differents. S\'il vous pla�t choisissez le noeud-XML et le nombre d\'elements que vous voulez importer.';
$l_import['well_formed'] = 'Le document-XML est bien form�.';
$l_import['not_well_formed'] = 'Le document-XML n\'est pas bien form� et ne peut pas �tre import�.';
$l_import['missing_child_node'] = 'Le document-XML est bien form�, mais ne contient pas de noeuds-XML et ne peut pas �tre import� alors.';
$l_import['select_elements'] = 'S\'il vous pla�t choisissez les enregistrement, que vous voulez importer.';
$l_import['num_elements'] = 'S\'il vous pla�t choisissez un nombre d\'enregistrement entre 1 et ';
$l_import['xml_invalid'] = ''; // TRANSLATE
$l_import['option_select'] = 'S�l�ction..';
$l_import['num_data_sets'] = 'Enregistrements:';
$l_import['to'] = '�';
$l_import['assign_record_fields'] = 'Assigner les champs donn�e';
$l_import['we_fields'] = 'Champs de webEdition';
$l_import['record_fields'] = 'Champs d\'enregistrement';
$l_import['record_field'] = 'Champ d\'enregistrement';
$l_import['attributes'] = 'Attribut';
$l_import['settings'] = 'Pr�f�rences';
$l_import['field_options'] = 'Outils de champ';
$l_import['csv_file'] = 'Fichier CSV';
$l_import['csv_settings'] = 'Pr�f�rences CSV';
$l_import['xml_settings'] = 'Pr�f�rences XML';
$l_import['file_format'] = 'Format de fichier';
$l_import['field_delimiter'] = 'S�perateur';
$l_import['comma'] = ', {Virgule}';
$l_import['semicolon'] = '; {Point Virgule}';
$l_import['colon'] = ': {Double-Point}';
$l_import['tab'] = "\\t {Tab}";
$l_import['space'] = '  {�space}';
$l_import['text_delimiter'] = 'Limiteur de Texte';
$l_import['double_quote'] = '" {Guillemets}';
$l_import['single_quote'] = '\' {Apostrophe}';
$l_import['contains'] = 'La premi�re ligne contient le nom de champ';
$l_import['split_xml'] = 'Importer les enregistrements un par un';
$l_import['wellformed_xml'] = 'V�rifier si le document est bien form�';
$l_import['validate_xml'] = 'Validation-XML';
$l_import['select_csv_file'] = 'S\'il vous pla�t choissisez un fichier source CSV.';
$l_import['select_seperator'] = 'S\'il vous pla�t choissisez un s�p�rateur.';
$l_import['format_date'] = 'Format de date';
$l_import['info_sdate'] = 'Choisissez le format de date pour le champ webEdition';
$l_import['info_mdate'] = 'Choisissez le format de date pour les champs webEdition';
$l_import['remark_csv'] = 'Vous pouvez importer des fichiers-CSV(Comma Separated Values) ou des formats comparable (p.ex. *.txt). Avec l\'import de ces format de fichier il est possible de choisir le s�perateur (p.ex , ; Tab, �space) et le limiteur de texte (= le signe, qui emballe le texte).';
$l_import['remark_xml'] = 'Choisissez l\'option \"Importez les enregistrement isol�ment \", pour que des grandes fichier peuvent �tre import� dans le temps de timeout d\'un script PHP.<br> Si vous n\'�tes pas s�r que le fichier s�l�ction� est un document webEdition-XML, vous pouvez v�rifier s\'il est bien form� et valide.';

$l_import["import_docs"]="Importer des Documents";
$l_import["import_templ"]="Importer des Mod�les";
$l_import["import_objs"]="Importer des Objects";
$l_import["import_classes"]="Importer des Classes";
$l_import["import_doctypes"]="Importer des types de documents";
$l_import["import_cats"]="Importer des Cat�gories";
$l_import["documents_desc"]="S\'il vous pla�t saisissez un r�pertoire, dans lequel les documents seront import�s . Si l\'option \"".$l_import['maintain_paths']."\" est choisi les chemins correspondant seront r�produit automatiquement, autrement les chemins seront ignor�s.";
$l_import["templates_desc"]="S\'il vous pla�t saisissez un r�pertoire, dans lequel les mod�les seront import�s . Si l\'option \"".$l_import['maintain_paths']."\" est choisi les chemins correspondant seront r�produit automatiquement, autrement les chemins seront ignor�s.";
$l_import['handle_document_options'] = 'Documents'; // TRANSLATE
$l_import['handle_template_options'] = 'Mod�les';
$l_import['handle_object_options'] = 'Objects'; // TRANSLATE
$l_import['handle_class_options'] = 'Classe';
$l_import["handle_doctype_options"] = "Type-de-Document";
$l_import["handle_category_options"] = "Categories";
$l_import['log'] = 'D�tails';
$l_import['start_import'] = 'Import d�marre';
$l_import['prepare'] = 'Pr�paration...';
$l_import['update_links'] = 'Actualisations-Liens...';
$l_import['doctype'] = 'Type-de-Document';
$l_import['category'] = 'Cat�gorie';
$l_import['end_import'] = 'Import termin�';

$l_import['handle_owners_option'] = 'Donn�es de l\'utilisateur';
$l_import['txt_owners'] = 'Importer les donn�es de l\'utilisateur.';
$l_import['handle_owners'] = 'Restaurer les donn�es de l\'utilisateur';
$l_import['notexist_overwrite'] = 'Si l\'utilisateur n\'existe pas, l\'option "Effacer les donn�es de l\'utilisateur" sera utilis�e';
$l_import['owner_overwrite'] = 'Effacer les donn�es de l\'utilisateur';

$l_import['name_collision'] = 'Collision de nom';

$l_import['item'] = 'Article'; // TRANSLATE
$l_import['backup_file_found'] = 'Le fichier ressemble � un fichier de sauvegarde de webEdition. S\'il vous pla�t utilisez l\'option \"Sauvegarde\" du menu \"Fichier\" pour importer les donn�es.';
$l_import['backup_file_found_question'] = 'Voulez-vous fermer maintenant le dialogue actuel et d�marrer l\'assistant-de sauvegarde?';
$l_import['close'] = 'Fermer';
$l_import['handle_file_options'] = 'Fichiers';
$l_import['import_files'] = 'Importer les fichiers';
$l_import['weBinary'] = 'Fichier';
$l_import['format_unknown'] = 'Le format du fichier est inconnu!';
$l_import['customer_import_file_found'] = 'Le fichier ressemble � un fichier d\'import du gestion clients. S\'il vous pla�t utilisez l\'option \"Import/Export\" du gestio clients (PRO) pour importer les donn�es.';
$l_import['upload_failed'] = 'Le fichier ne peut pas �tre t�l�charg�. S\'il vous pla�t verifiez, si la taille du fichier d�passe %s';

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