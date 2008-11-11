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

$_dir = $_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/we_tags';

if (!file_exists($_dir)) {
	return "ERROR: Directory $_dir does not exixts!";
}

$d = dir($_dir);

$xml = '<?xml version="1.0" encoding="utf-8"?>' . "\n";
$xml .= "<tags>\n";

if ($d) {
	while (false !== ($entry = $d->read())) {
		if (substr($entry,0,7) == 'we_tag_') {
			$_dotPos = strpos($entry,'.');
			if ($_dotPos > 7) {
				$file = file_get_contents($_dir . "/" . $entry);
				$needsEndtag =  (strpos($file, "\$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true") !== false);
				$xml .= "\t". '<tag needsEndtag="'.($needsEndtag ? "true" : "false").'" name="' . substr($entry,7,$_dotPos-7) . '" />'."\n";
			}
		}
	}
	$d->close();
}
$xml .= "</tags>\n";

header('Content-Type: text/xml');
print $xml;
?>