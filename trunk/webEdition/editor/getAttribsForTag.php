<?php

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");


$tagName = isset($_REQUEST['tagName']) ? $_REQUEST['tagName'] : "";
$_dir = $_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/we_tags';

$xml = '<?xml version="1.0" encoding="utf-8"?>' . "\n";
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