<?php

/**
 * webEdition CMS
 *
 * This source is part of webEdition CMS. webEdition CMS is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package    webEdition_language
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */


/**
 * Language file: metadata.inc.php
 * Provides language strings.
 * Language: English
 */

/*****************************************************************************
 * DOCUMENT TAB
 *****************************************************************************/

$l_metadata["filesize"] = "Bestandsgrootte";
$l_metadata["supported_types"] = "Meta gegevens formaten";
$l_metadata["none"] = "geen";
$l_metadata["filetype"] = "Bestandstype";

/*****************************************************************************
 * METADATA FIELD MAPPING
 *****************************************************************************/

$l_metadata["headline"] = "Meta gegevens velden";
$l_metadata["tagname"] = "Veld naam";
$l_metadata["type"] = "Type"; // TRANSLATE
$l_metadata["dummy"] = "dummy"; // TRANSLATE

$l_metadata["save"] = "Bezig met bewaren van meta gegevens velden, een ogenblik geduld ...";
$l_metadata["save_wait"] = "Instellingen bewaren";

$l_metadata["saved"] = "De meta gegevens velden zijn succesvol bewaard.";
$l_metadata["saved_successfully"] = "Meta gegevens velden bewaard";

$l_metadata["properties"] = "Eigenschappen";

$l_metadata["fields_hint"] = "Defineer extra velden voor meta gegevens. Toegevoegde gegevens(Exit, IPTC) aan het originele bestand, kunnen automatisch inbegrepen worden tijdens het importeren. Voeg één of meerdere velden toe die geïmporteerd moeten worden in het invoer veld &quot;importeer vanuit&quot; in het formaat &quot;[type]/[fieldname]&quot;. Bijvoorbeeld: &quot;exif/copyright,iptc/copyright&quot;. Er kunnen meerdere ingevoerd worden, gescheiden door een komma. Tijdens het importeren worden alle gespecificeerde velden doorzocht.";
$l_metadata["import_from"] = "Importeer uit";
$l_metadata["fields"] = "Velden";
$l_metadata['add'] = "voeg toe";

/*****************************************************************************
 * UPLOAD
 *****************************************************************************/

$l_metadata["import_metadata_at_upload"] = "Importeer metagegevens uit bestand";

/*****************************************************************************
 * ERROR MESSAGES
 *****************************************************************************/

$l_metadata['error_meta_field_empty_msg'] = "De veldnaam op regel %s1 mag niet leeg zijn!";
$l_metadata['meta_field_wrong_chars_messsage'] = "De veldnaam '%s1' is niet geldig! Geldige karakters zijn alfa-numeriek, hoofd- en kleine letters (a-z, A-Z, 0-9) en underscore.";
$l_metadata['meta_field_wrong_name_messsage'] = "De veldnaam '%s1' is niet geldig! Deze naam wordt intern gebruikt in webEdition! De volgende namen zijn niet geldig en kunnen niet gebruikt worden: %s2";


/*****************************************************************************
 * INFO TAB
 *****************************************************************************/

$l_metadata['info_exif_data'] = "Exif gegevens";
$l_metadata['info_iptc_data'] = "IPTC gegevens";
$l_metadata['no_exif_data'] = "Geen Exif gegevens beschikbaar";
$l_metadata['no_iptc_data'] = "Geen IPTC gegevens available";
$l_metadata['no_exif_installed'] = "De PHP Exif extensie is niet geïnstalleerd!";
$l_metadata['no_metadata_supported'] = "webEdition ondersteunt geen metagegevens formaten voor dit type document.";

?>