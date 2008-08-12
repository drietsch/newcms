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
$GLOBALS["l_import_files"]["destination_dir"] = "Kohdehakemisto";
$GLOBALS["l_import_files"]["file"] = "Tiedosto";
$GLOBALS["l_import_files"]["sameName_expl"] = "Jos samanniminen tiedosto on olemassa, webEdition?";
$GLOBALS["l_import_files"]["sameName_overwrite"] = "Korvaa samannimisen tiedoston";
$GLOBALS["l_import_files"]["sameName_rename"] = "Uudelleennime�� uuden tiedoston";
$GLOBALS["l_import_files"]["sameName_nothing"] = "Ei tuo tiedostoa";
$GLOBALS["l_import_files"]["sameName_headline"] = "Jos tiedosto<br>on olemassa?";
$GLOBALS["l_import_files"]["step1"] = "Tuo paikallisia tiedostoja - Vaihe 1 / 3";
$GLOBALS["l_import_files"]["step2"] = "Tuo paikallisia tiedostoja - Vaihe 2 / 3";
$GLOBALS["l_import_files"]["step3"] = "Tuo paikallisia tiedostoja - Vaihe 3 / 3";
$GLOBALS["l_import_files"]["import_expl"] = "Paina seuraava painiketta sy�tt�kent�ss� valitaksesi tiedoston kovalevylt�si. Valinnan j�lkeen ilmestyy uusi sy�tt�kentt� ja voit valita uuden tiedoston. Huomaa ett� tiedoston maksimikokoa %s ei voida ylitt�� johtuen PHP:n ja MySQL:n rajoituksesta!<br><br>Paina \"Seuraava\" -painiketta aloittaaksesi tuonnin.";
$GLOBALS["l_import_files"]["import_expl_jupload"] = "Painiketta painamalla voit valita useampia tiedostoja kovalevylt�si. Vaihtoehtoisesti voit valita tiedostoja 'raahaamalla' niit� koneesi tiedostojenhallinnasta.  Huomioi ett� PHP:n ja MySQL:n rajoittamaa tiedostojen maksimikokoa %s ei saa ylitt��!<br><br>Klikkaa \"Seuraava\", aloittaaksesi tuonnin.";

$GLOBALS["l_import_files"]["error"] = "Virhe tiedoston tuonnissa!\\n\\nSeuraavia tiedostoja ei voitu tuoda:\\n%s";
$GLOBALS["l_import_files"]["finished"] = "Tuonti onnistui!";
$GLOBALS["l_import_files"]["import_file"] = "Tuodaan tiedostoa %s";

$GLOBALS["l_import_files"]["no_perms"] = "Virhe: ei oikeuksia";
$GLOBALS["l_import_files"]["move_file_error"] = "Virhe: move_uploaded_file()";
$GLOBALS["l_import_files"]["read_file_error"] = "Virhe: fread()";
$GLOBALS["l_import_files"]["php_error"] = "Virhe: upload_max_filesize()";
$GLOBALS["l_import_files"]["same_name"] = "Virhe: file exists";
$GLOBALS["l_import_files"]["save_error"] = "Virhe tallennettaessa tiedostoa";
$GLOBALS["l_import_files"]["publish_error"] = "Virhe julkaistaessa tiedostoa";

$GLOBALS["l_import_files"]["root_dir_1"] = "M��ritit www-palvelimen juurihakemiston l�hdehakemistoksi. Oletko varma ett� haluat tuoda juurihakemiston sis�ll�n?";
$GLOBALS["l_import_files"]["root_dir_2"] = "M��ritit www-palvelimen juurihakemiston kohdehakemistoksi. Oletko varma ett� haluat tuoda suoraan juurihakemistoon?";
$GLOBALS["l_import_files"]["root_dir_3"] = "M��ritit www-palvelimen juurihakemiston sek� l�hde -ett� kohdehakemistoksi. Oletko varma ett� haluat tuoda juurihakemistoon?";

$GLOBALS["l_import_files"]["thumbnails"] = "Esikatselukuvat";
$GLOBALS["l_import_files"]["make_thumbs"] = "Luo<br>esikatselukivia";
$GLOBALS["l_import_files"]["image_options_open"] = "N�yt� kuvatoiminnot";
$GLOBALS["l_import_files"]["image_options_close"] = "Piilota kuvatoiminnot";
$GLOBALS["l_import_files"]["add_description_nogdlib"] = "GD -kirjasto pit�� olla asennettuna palvelimelle, jotta voit k�ytt�� kuvatoimintoja!";

$GLOBALS["l_import_files"]["noFiles"] = "L�hdehakemistossa ei ole tuontiehtojen mukaisia tiedostoja!";
$GLOBALS["l_import_files"]["emptyDir"] = "L�hdehakemisto on tyhj�!";

$GLOBALS["l_import_files"]["metadata"] = "Meta data"; // TRANSLATE
$GLOBALS["l_import_files"]["import_metadata"] = "Import meta data from file"; // TRANSLATE

?>