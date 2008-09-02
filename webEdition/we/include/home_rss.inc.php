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

include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/cockpit.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/PEAR.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/Parser.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/RSS.php");

htmlTop();
print STYLESHEET;
print 
		'<style type="text/css">div#rss,div#rss *{color:black;font-size:' . (($SYSTEM == "MAC") ? "10px" : (($SYSTEM == "X11") ? "12px" : "11px")) . ';font-family:' . $l_css["font_family"] . ';}</style>';
print '</head><body bgcolor="#F1F5FF">';

$rss = & new XML_RSS($_SESSION["prefs"]["cockpit_rss_feed_url"], $_language["charset"]);
$rss->parse();
$rss_out = '<div id="rss">';
foreach ($rss->getItems() as $item) {
	$rss_out .= "<b>" . $item['title'] . "</b><p>" . $item['description'] . " ";
	if (isset($item['link']) && !empty($item['link']))
		$rss_out .= "<a href=\"" . $item['link'] . "\" target=\"_blank\">" . $l_cockpit['more'] . "</a>";
	$rss_out .= "</p>\n";
	$rss_out .= getPixel(1, 10) . "<br>";
}
$rss_out .= '</div>';
print $rss_out;
print '</body></html>';

?>
