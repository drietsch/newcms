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
 * Language: English
 */
$GLOBALS["l_import_files"]["destination_dir"] = "Kohdehakemisto";
$GLOBALS["l_import_files"]["file"] = "Tiedosto";
$GLOBALS["l_import_files"]["sameName_expl"] = "Jos samanniminen tiedosto on olemassa, webEdition?";
$GLOBALS["l_import_files"]["sameName_overwrite"] = "Korvaa samannimisen tiedoston";
$GLOBALS["l_import_files"]["sameName_rename"] = "Uudelleennimeää uuden tiedoston";
$GLOBALS["l_import_files"]["sameName_nothing"] = "Ei tuo tiedostoa";
$GLOBALS["l_import_files"]["sameName_headline"] = "Jos tiedosto<br>on olemassa?";
$GLOBALS["l_import_files"]["step1"] = "Tuo paikallisia tiedostoja - Vaihe 1 / 3";
$GLOBALS["l_import_files"]["step2"] = "Tuo paikallisia tiedostoja - Vaihe 2 / 3";
$GLOBALS["l_import_files"]["step3"] = "Tuo paikallisia tiedostoja - Vaihe 3 / 3";
$GLOBALS["l_import_files"]["import_expl"] = "Paina seuraava painiketta syöttökentässä valitaksesi tiedoston kovalevyltäsi. Valinnan jälkeen ilmestyy uusi syöttökenttä ja voit valita uuden tiedoston. Huomaa että tiedoston maksimikokoa %s ei voida ylittää johtuen PHP:n ja MySQL:n rajoituksesta!<br><br>Paina \"Seuraava\" -painiketta aloittaaksesi tuonnin.";
$GLOBALS["l_import_files"]["import_expl_jupload"] = "Painiketta painamalla voit valita useampia tiedostoja kovalevyltäsi. Vaihtoehtoisesti voit valita tiedostoja 'raahaamalla' niitä koneesi tiedostojenhallinnasta.  Huomioi että PHP:n ja MySQL:n rajoittamaa tiedostojen maksimikokoa %s ei saa ylittää!<br><br>Klikkaa \"Seuraava\", aloittaaksesi tuonnin.";

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

$GLOBALS["l_import_files"]["root_dir_1"] = "Määritit www-palvelimen juurihakemiston lähdehakemistoksi. Oletko varma että haluat tuoda juurihakemiston sisällön?";
$GLOBALS["l_import_files"]["root_dir_2"] = "Määritit www-palvelimen juurihakemiston kohdehakemistoksi. Oletko varma että haluat tuoda suoraan juurihakemistoon?";
$GLOBALS["l_import_files"]["root_dir_3"] = "Määritit www-palvelimen juurihakemiston sekä lähde -että kohdehakemistoksi. Oletko varma että haluat tuoda juurihakemistoon?";

$GLOBALS["l_import_files"]["thumbnails"] = "Esikatselukuvat";
$GLOBALS["l_import_files"]["make_thumbs"] = "Luo<br>esikatselukivia";
$GLOBALS["l_import_files"]["image_options_open"] = "Näytä kuvatoiminnot";
$GLOBALS["l_import_files"]["image_options_close"] = "Piilota kuvatoiminnot";
$GLOBALS["l_import_files"]["add_description_nogdlib"] = "GD -kirjasto pitää olla asennettuna palvelimelle, jotta voit käyttää kuvatoimintoja!";

$GLOBALS["l_import_files"]["noFiles"] = "Lähdehakemistossa ei ole tuontiehtojen mukaisia tiedostoja!";
$GLOBALS["l_import_files"]["emptyDir"] = "Lähdehakemisto on tyhjä!";

$GLOBALS["l_import_files"]["metadata"] = "Meta data"; // TRANSLATE
$GLOBALS["l_import_files"]["import_metadata"] = "Import meta data from file"; // TRANSLATE

?>