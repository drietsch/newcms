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
 * Language file: import_files.inc.php
 * Provides language strings.
 * Language: English
 */
$GLOBALS["l_import_files"]["destination_dir"] = "R�pertoire cible";
$GLOBALS["l_import_files"]["file"] = "Fichier";
$GLOBALS["l_import_files"]["sameName_expl"] = "D�finissez le comportement de webEdition, s'il exitste un fichier avec le m�me nom.";
$GLOBALS["l_import_files"]["sameName_overwrite"] = "�ffacer le fichier existant";
$GLOBALS["l_import_files"]["sameName_rename"] = "Renommer le nouveau fichier";
$GLOBALS["l_import_files"]["sameName_nothing"] = "Ne pas importer le fichier";
$GLOBALS["l_import_files"]["sameName_headline"] = "En cas de<br>nom �gal?";
$GLOBALS["l_import_files"]["step1"] = "Import des fichiers local - �tape 1 sur 2";
$GLOBALS["l_import_files"]["step2"] = "Import des fichiers local - �tape 2 sur 2";
$GLOBALS["l_import_files"]["step3"] = "Import local files - Step 3 of 3"; // TRANSLATE
$GLOBALS["l_import_files"]["import_expl"] = "Avec un clic sur le bouton � cot� du saisi de texte vous pouvez choisir un fichier sur votre disque dur local. Apr�s la s�l�ction un autre champ de saisi appara�tra dans lequel vous pouvez choisir un autre fichier. Consid�rez que la taille par fichier ne doit pas d�passer %s � cause de restriction de PHP et MySQL!<br><br>Cliquez \"Avancer\", pour d�marrer l'import.";
$GLOBALS["l_import_files"]["import_expl_jupload"] = "With the click on the button you can select more then one file from your harddrive. Alternatively the files can be selected per 'Drag and Drop' from the file manager.  Please note that the maximum filesize of  %s is not to be exceeded because of restrictions by PHP and MySQL!<br><br>Click on \"Next\", to start the import.";

$GLOBALS["l_import_files"]["error"] = "Erreur en important!\\n\\nLes fichiers suivant ne pouvait pas �tre import�s:\\n%s";
$GLOBALS["l_import_files"]["finished"] = "L&rsquo;import a �t� termin� avec succ�s!";
$GLOBALS["l_import_files"]["import_file"] = "Import du fichier %s";

$GLOBALS["l_import_files"]["no_perms"] = "Erreur: non authoris�";
$GLOBALS["l_import_files"]["move_file_error"] = "Erreur: move_uploaded_file()";
$GLOBALS["l_import_files"]["read_file_error"] = "Erreur: fread()";
$GLOBALS["l_import_files"]["php_error"] = "Erreur: upload_max_filesize()";
$GLOBALS["l_import_files"]["same_name"] = "Erreur: Datei existiert";
$GLOBALS["l_import_files"]["save_error"] = "Erreur en enregistrant";
$GLOBALS["l_import_files"]["publish_error"] = "Erreur en publiant";

$GLOBALS["l_import_files"]["root_dir_1"] = "Vous avez choisi le r�pertoire racine du serveur web comme r�pertoire source. �tes-vous s�r, que vous voulez importer le contenu du r�pertoire racine compl�tement?";
$GLOBALS["l_import_files"]["root_dir_2"] = "Vous avez choisi le r�pertoire racine du serveur web comme r�pertoire cible. �tes-vous s�r, que vous voulez importer tous directement dans le r�pertoire racine?";
$GLOBALS["l_import_files"]["root_dir_3"] = "Vous avez choisi le r�pertoire racine du serveur web comme r�pertoire source et cible. �tes-vous s�r, que vous voulez reimportez tous le contenu du r�pertoire racine dans le r�pertoire racien?";

$GLOBALS["l_import_files"]["thumbnails"] = "Imagettes";
$GLOBALS["l_import_files"]["make_thumbs"] = "Cr�er des<br>Imagettes";
$GLOBALS["l_import_files"]["image_options_open"] = "Afficher les fonctions graphiques";
$GLOBALS["l_import_files"]["image_options_close"] = "Cacher les les fonctions graphiques";
$GLOBALS["l_import_files"]["add_description_nogdlib"] = "Pour que vous puisse profiter des fonctions des imagettes, il est n�c�ssaire que la GD Library soit install�e!";

$GLOBALS["l_import_files"]["noFiles"] = "No files exist in the specified source directory which correspond with the given import settings!"; // TRANSLATE
$GLOBALS["l_import_files"]["emptyDir"] = "The source directory is empty!"; // TRANSLATE

$GLOBALS["l_import_files"]["metadata"] = "Meta data"; // TRANSLATE
$GLOBALS["l_import_files"]["import_metadata"] = "Import meta data from file"; // TRANSLATE

?>