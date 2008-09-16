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
 * Language file: metadata.inc.php
 * Provides language strings.
 * Language: English
 */

/*****************************************************************************
 * DOCUMENT TAB
 *****************************************************************************/

$l_metadata["filesize"] = "File size";
$l_metadata["supported_types"] = "Meta data formats";
$l_metadata["none"] = "none";
$l_metadata["filetype"] = "File type";

/*****************************************************************************
 * METADATA FIELD MAPPING
 *****************************************************************************/

$l_metadata["headline"] = "Meta data fields";
$l_metadata["tagname"] = "Field name";
$l_metadata["type"] = "Type";
$l_metadata["dummy"] = "dummy";

$l_metadata["save"] = "Saving meta data fields, one moment ...";
$l_metadata["save_wait"] = "Saving settings";

$l_metadata["saved"] = "Meta data fields have been saved successfully.";
$l_metadata["saved_successfully"] = "Meta data fields saved";

$l_metadata["properties"] = "Properties";

$l_metadata["fields_hint"] = "Define additional fields for meta data. Attached data(Exit, IPTC) to the original file, may be migrated automatically during the import. Add one or more fields that are to be imported in the entry field &quot;import from&quot; in the format &quot;[type]/[fieldname]&quot;. Example: &quot;exif/copyright,iptc/copyright&quot;. Multiple fields may be entered separated by comma. The import will search all specified fields up to the first field filled with data.";
$l_metadata["import_from"] = "Import from";
$l_metadata["fields"] = "Fields";
$l_metadata['add'] = "add";

/*****************************************************************************
 * UPLOAD
 *****************************************************************************/

$l_metadata["import_metadata_at_upload"] = "Import meta data from file";

/*****************************************************************************
 * ERROR MESSAGES
 *****************************************************************************/

$l_metadata['error_meta_field_empty_msg'] = "The fieldname at line %s1 can not be empty!";
$l_metadata['meta_field_wrong_chars_messsage'] = "The fieldname '%s1' is not valid! Valid characters are alpha-numeric, capital and small (a-z, A-Z, 0-9) and underscore.";
$l_metadata['meta_field_wrong_name_messsage'] = "The fieldname '%s1' is not valid! It is used internaly from webEdition! Following names are invalid and can not be used: %s2";


/*****************************************************************************
 * INFO TAB
 *****************************************************************************/

$l_metadata['info_exif_data'] = "Exif data";
$l_metadata['info_iptc_data'] = "IPTC data";
$l_metadata['no_exif_data'] = "No Exif data available";
$l_metadata['no_iptc_data'] = "No IPTC data available";
$l_metadata['no_exif_installed'] = "The PHP Exif extension is not installed!";
$l_metadata['no_metadata_supported'] = "webEdition does not support metadata formats for this kind of document.";

?>