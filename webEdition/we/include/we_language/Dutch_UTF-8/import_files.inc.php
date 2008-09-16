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
 * Language file: import_files.inc.php
 * Provides language strings.
 * Language: Dutch
 */
$GLOBALS["l_import_files"]["destination_dir"] = "Doel directorie";
$GLOBALS["l_import_files"]["file"] = "Bestand";
$GLOBALS["l_import_files"]["sameName_expl"] = "Als de bestandsnaam al bestaat, wat wilt u dan dat webEdition doet?";
$GLOBALS["l_import_files"]["sameName_overwrite"] = "Overschrijf het bestaande bestand";
$GLOBALS["l_import_files"]["sameName_rename"] = "Hernoem het nieuwe bestand";
$GLOBALS["l_import_files"]["sameName_nothing"] = "Importeer het bestand niet";
$GLOBALS["l_import_files"]["sameName_headline"] = "Wat te doen<br>wanneer een bestand al bestaat?";
$GLOBALS["l_import_files"]["step1"] = "Importeer lokale bestanden - Stap 1 van 2";
$GLOBALS["l_import_files"]["step2"] = "Importeer lokale bestanden - Stap 2 van 2";
$GLOBALS["l_import_files"]["step3"] = "Importeer lokale bestanden - Stap 3 van 3";
$GLOBALS["l_import_files"]["import_expl"] = "Klik op de button naast het invoer veld om een bestand te selecteren vanaf uw harde schijf. Na de selectie verschijnt er een nieuw invoer veld en kunt u een nieuw bestand selecteren. Let er wel op dat de maximale bestandsgrootte van %s niet overschreden wordt vanwege restricties binnen PHP en MySQL!<br><br>Klik op \"Volgende\", om te beginnen met importeren.";
$GLOBALS["l_import_files"]["import_expl_jupload"] = "Met een druk op de knop kunt u meerdere bestanden selecteren vanaf uw harddisk. Daarnaast kunt u de bestanden verslepen vanaf uw desktop. Let er op dat de maximale bestandsgrootte van %s niet overschreden mag worden in verband met restricties binnen PHP en MySQL!<br><br>Klik op \"Volgende\", om te beginnen met importeren.";

$GLOBALS["l_import_files"]["error"] = "Er is een fout opgetreden tijdens het importeren!\\n\\nDe volgende bestanden konden niet geïmporteerd worden:\\n%s";
$GLOBALS["l_import_files"]["finished"] = "Het importeren is succesvol beïndigd!";
$GLOBALS["l_import_files"]["import_file"] = "Bezig met importeren van %s";

$GLOBALS["l_import_files"]["no_perms"] = "Foutmelding: geen toestemming";
$GLOBALS["l_import_files"]["move_file_error"] = "Foutmelding: verplaats_ge-uploade_bestand()";
$GLOBALS["l_import_files"]["read_file_error"] = "Foutmelding: flezen()";
$GLOBALS["l_import_files"]["php_error"] = "Foutmelding: upload_max_bestandsgrootte()";
$GLOBALS["l_import_files"]["same_name"] = "Foutmelding: bestand bestaat al";
$GLOBALS["l_import_files"]["save_error"] = "Fout tijdens bewaren";
$GLOBALS["l_import_files"]["publish_error"] = "Fout tijdens publiceren";

$GLOBALS["l_import_files"]["root_dir_1"] = "U heeft de hoofd directory van de web server gespecificeerd als de bron directory. Weet u zeker dat u alle content van de hoofd directory wilt importeren?";
$GLOBALS["l_import_files"]["root_dir_2"] = "U heeft de hoofd directory van de web server gespecificeerd als de doel directory. Weet u zeker dat u direct wilt importeren naar de hoofd directory?";
$GLOBALS["l_import_files"]["root_dir_3"] = "U heeft de hoofd directory van de web server gespecificeerd als de bron directory zowel als de doel directory. Weet u zeker dat u alle content van de hoofd directory wilt importeren naar de hoofd directory?";

$GLOBALS["l_import_files"]["thumbnails"] = "Thumbnails";
$GLOBALS["l_import_files"]["make_thumbs"] = "Maak<br>Thumbnails aan";
$GLOBALS["l_import_files"]["image_options_open"] = "Toon afbeeldings functies";
$GLOBALS["l_import_files"]["image_options_close"] = "Verberg afbeeldings functies";
$GLOBALS["l_import_files"]["add_description_nogdlib"] = "De GD Bibliotheek moet geïnstalleerd worden op uw server om de afbeeldings functies goed te laten functioneren.!";

$GLOBALS["l_import_files"]["noFiles"] = "Er bevinden zich geen bestanden in de opgegeven bron directory welke correspondeert met de opgegeven importeer instellingen!"; 
$GLOBALS["l_import_files"]["emptyDir"] = "De bron directory is leeg!";

$GLOBALS["l_import_files"]["metadata"] = "Meta data";
$GLOBALS["l_import_files"]["import_metadata"] = "Import meta data from file";

?>