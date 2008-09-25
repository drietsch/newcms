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
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");


$tagName = isset($_REQUEST['tagName']) ? $_REQUEST['tagName'] : "";

// Remove . / \ because of security reasons
$tagName = str_replace('.','',$tagName);
$tagName = str_replace('/','',$tagName);
$tagName = str_replace('\\','',$tagName);

$_dir = $_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/we_tags';

$xml = '<?xml version="1.0" encoding="utf-8"?'.'>' . "\n";
$xml .= "<attributes>\n";

if ($tagName) {
	$GLOBALS['weTagWizard']['attribute'] = array();
	$_filename = $_dir . "/we_tag_" . $tagName . ".inc.php";
	if (file_exists($_filename)) {
		include($_filename);
		foreach ($GLOBALS['weTagWizard']['attribute'] as $name => $dummy) {
			$parts = explode("_", $name);
			array_shift($parts);
			$xml .= "\t". '<attribute name="' . implode("_", $parts) . '" />'."\n";
		}
	}
}


$xml .= "</attributes>\n";

header('Content-Type: text/xml');
print $xml;
?>