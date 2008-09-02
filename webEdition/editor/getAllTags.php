<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
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