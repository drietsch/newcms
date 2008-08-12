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
$GLOBALS["l_import_files"]["destination_dir"] = "Répertoire cible";
$GLOBALS["l_import_files"]["file"] = "Fichier";
$GLOBALS["l_import_files"]["sameName_expl"] = "Définissez le comportement de webEdition, s'il exitste un fichier avec le même nom.";
$GLOBALS["l_import_files"]["sameName_overwrite"] = "Éffacer le fichier existant";
$GLOBALS["l_import_files"]["sameName_rename"] = "Renommer le nouveau fichier";
$GLOBALS["l_import_files"]["sameName_nothing"] = "Ne pas importer le fichier";
$GLOBALS["l_import_files"]["sameName_headline"] = "En cas de<br>nom égal?";
$GLOBALS["l_import_files"]["step1"] = "Import des fichiers local - étape 1 sur 2";
$GLOBALS["l_import_files"]["step2"] = "Import des fichiers local - étape 2 sur 2";
$GLOBALS["l_import_files"]["step3"] = "Import local files - Step 3 of 3"; // TRANSLATE
$GLOBALS["l_import_files"]["import_expl"] = "Avec un clic sur le bouton à coté du saisi de texte vous pouvez choisir un fichier sur votre disque dur local. Après la séléction un autre champ de saisi apparaîtra dans lequel vous pouvez choisir un autre fichier. Considérez que la taille par fichier ne doit pas dépasser %s à cause de restriction de PHP et MySQL!<br><br>Cliquez \"Avancer\", pour démarrer l'import.";
$GLOBALS["l_import_files"]["import_expl_jupload"] = "With the click on the button you can select more then one file from your harddrive. Alternatively the files can be selected per 'Drag and Drop' from the file manager.  Please note that the maximum filesize of  %s is not to be exceeded because of restrictions by PHP and MySQL!<br><br>Click on \"Next\", to start the import.";

$GLOBALS["l_import_files"]["error"] = "Erreur en important!\\n\\nLes fichiers suivant ne pouvait pas être importés:\\n%s";
$GLOBALS["l_import_files"]["finished"] = "L&rsquo;import a été terminé avec succès!";
$GLOBALS["l_import_files"]["import_file"] = "Import du fichier %s";

$GLOBALS["l_import_files"]["no_perms"] = "Erreur: non authorisé";
$GLOBALS["l_import_files"]["move_file_error"] = "Erreur: move_uploaded_file()";
$GLOBALS["l_import_files"]["read_file_error"] = "Erreur: fread()";
$GLOBALS["l_import_files"]["php_error"] = "Erreur: upload_max_filesize()";
$GLOBALS["l_import_files"]["same_name"] = "Erreur: Datei existiert";
$GLOBALS["l_import_files"]["save_error"] = "Erreur en enregistrant";
$GLOBALS["l_import_files"]["publish_error"] = "Erreur en publiant";

$GLOBALS["l_import_files"]["root_dir_1"] = "Vous avez choisi le répertoire racine du serveur web comme répertoire source. Êtes-vous sûr, que vous voulez importer le contenu du répertoire racine complètement?";
$GLOBALS["l_import_files"]["root_dir_2"] = "Vous avez choisi le répertoire racine du serveur web comme répertoire cible. Êtes-vous sûr, que vous voulez importer tous directement dans le répertoire racine?";
$GLOBALS["l_import_files"]["root_dir_3"] = "Vous avez choisi le répertoire racine du serveur web comme répertoire source et cible. Êtes-vous sûr, que vous voulez reimportez tous le contenu du répertoire racine dans le répertoire racien?";

$GLOBALS["l_import_files"]["thumbnails"] = "Imagettes";
$GLOBALS["l_import_files"]["make_thumbs"] = "Créer des<br>Imagettes";
$GLOBALS["l_import_files"]["image_options_open"] = "Afficher les fonctions graphiques";
$GLOBALS["l_import_files"]["image_options_close"] = "Cacher les les fonctions graphiques";
$GLOBALS["l_import_files"]["add_description_nogdlib"] = "Pour que vous puisse profiter des fonctions des imagettes, il est nécéssaire que la GD Library soit installée!";

$GLOBALS["l_import_files"]["noFiles"] = "No files exist in the specified source directory which correspond with the given import settings!"; // TRANSLATE
$GLOBALS["l_import_files"]["emptyDir"] = "The source directory is empty!"; // TRANSLATE

$GLOBALS["l_import_files"]["metadata"] = "Meta data"; // TRANSLATE
$GLOBALS["l_import_files"]["import_metadata"] = "Import meta data from file"; // TRANSLATE

?>