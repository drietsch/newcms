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

$l_metadata["filesize"] = "File size"; // TRANSLATE
$l_metadata["supported_types"] = "Meta data formats"; // TRANSLATE
$l_metadata["none"] = "none"; // TRANSLATE
$l_metadata["filetype"] = "File type"; // TRANSLATE

/*****************************************************************************
 * METADATA FIELD MAPPING
 *****************************************************************************/

$l_metadata["headline"] = "Meta data fields"; // TRANSLATE
$l_metadata["tagname"] = "Field name"; // TRANSLATE
$l_metadata["type"] = "Type"; // TRANSLATE
$l_metadata["dummy"] = "dummy"; // TRANSLATE

$l_metadata["save"] = "Saving meta data fields, one moment ..."; // TRANSLATE
$l_metadata["save_wait"] = "Saving settings"; // TRANSLATE

$l_metadata["saved"] = "Meta data fields have been saved successfully."; // TRANSLATE
$l_metadata["saved_successfully"] = "Meta data fields saved"; // TRANSLATE

$l_metadata["properties"] = "Properties"; // TRANSLATE

$l_metadata["fields_hint"] = "Define additional fields for meta data. Attached data(Exit, IPTC) to the original file, may be migrated automatically during the import. Add one or more fields that are to be imported in the entry field &quot;import from&quot; in the format &quot;[type]/[fieldname]&quot;. Example: &quot;exif/copyright,iptc/copyright&quot;. Multiple fields may be entered separated by comma. The import will search all specified fields up to the first field filled with data."; // TRANSLATE
$l_metadata["import_from"] = "Import from"; // TRANSLATE
$l_metadata["fields"] = "Fields"; // TRANSLATE
$l_metadata['add'] = "add"; // TRANSLATE

/*****************************************************************************
 * UPLOAD
 *****************************************************************************/

$l_metadata["import_metadata_at_upload"] = "Import meta data from file"; // TRANSLATE

/*****************************************************************************
 * ERROR MESSAGES
 *****************************************************************************/

$l_metadata['error_meta_field_empty_msg'] = "The fieldname at line %s1 can not be empty!"; // TRANSLATE
$l_metadata['meta_field_wrong_chars_messsage'] = "The fieldname '%s1' is not valid! Valid characters are alpha-numeric, capital and small (a-z, A-Z, 0-9) and underscore."; // TRANSLATE
$l_metadata['meta_field_wrong_name_messsage'] = "The fieldname '%s1' is not valid! It is used internaly from webEdition! Following names are invalid and can not be used: %s2"; // TRANSLATE


/*****************************************************************************
 * INFO TAB
 *****************************************************************************/

$l_metadata['info_exif_data'] = "Exif data"; // TRANSLATE
$l_metadata['info_iptc_data'] = "IPTC data"; // TRANSLATE
$l_metadata['no_exif_data'] = "No Exif data available"; // TRANSLATE
$l_metadata['no_iptc_data'] = "No IPTC data available"; // TRANSLATE
$l_metadata['no_exif_installed'] = "The PHP Exif extension is not installed!"; // TRANSLATE
$l_metadata['no_metadata_supported'] = "webEdition does not support metadata formats for this kind of document."; // TRANSLATE

?>