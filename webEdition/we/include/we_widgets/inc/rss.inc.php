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

list($_rssUri, $_rssCont, $_rssNumItems, $_rssTb, $_rssTitle) = explode(',', $aProps[3]);

//$_iFrmRssAtts['src'] = WEBEDITION_DIR.'we/include/we_widgets/mod/rss.inc.php'.
//	'?we_cmd[0]='.rawurlencode(base64_decode($_rssUri)).
//	'&amp;we_cmd[1]='.$_rssCont.
//	'&amp;we_cmd[2]='.$_rssNumItems.
//	'&amp;we_cmd[3]='.$_rssTb.
//	'&amp;we_cmd[4]='.$_rssTitle.
//	'&amp;we_cmd[5]=m_'.$iCurrId;


list($bTbLabel, $bTbTitel, $bTbDesc, $bTbLink, $bTbPubDate, $bTbCopyright) = $_rssTb;
$aLabelPrefix = array();
if ($bTbLabel)
	$aLabelPrefix[] = $l_cockpit['rss_feed'];
if ($bTbTitel && $_rssTitle) {
	$_feed = (isset($aTrf)) ? $aTrf : $aTopRssFeeds;
	foreach ($_feed as $iRssFeedIndex => $aFeed) {
		if ($_rssUri == $aFeed[1]) {
			$aLabelPrefix[] = base64_decode($aFeed[0]);
			break;
		}
	}
}
$sTbPrefix = implode(' - ', $aLabelPrefix);
$aLang = array(
	$sTbPrefix, ''
);

$_iFrmRss = "
<script type=\"text/javascript\">

if ( window.addEventListener ) { // moz
	window.addEventListener(
		\"load\",
		function() {
			top.cockpitFrame.executeAjaxRequest('" . base64_decode(
		$_rssUri) . "', '" . $_rssCont . "', '" . $_rssNumItems . "', '" . $_rssTb . "', '" . $sTbPrefix . "', '" . 'm_' . $iCurrId . "');
		},
		true
	);
	
} else if ( window.attachEvent ) { // IE
	window.attachEvent( \"onload\", function(){
			top.cockpitFrame.executeAjaxRequest('" . base64_decode(
		$_rssUri) . "', '" . $_rssCont . "', '" . $_rssNumItems . "', '" . $_rssTb . "', '" . $sTbPrefix . "', '" . 'm_' . $iCurrId . "');
		}
	);
}

</script>
<div class=\"rssDiv\" id=\"m_" . $iCurrId . "_inline\" style=\"width: " . $iWidth . ";height:287 ! important; overflow: auto;\"></div>
";

$oTblCont = new we_htmlTable(array(
	"cellpadding" => "0", "cellspacing" => "0", "border" => "0"
), 1, 1);
$oTblCont->setCol(0, 0, null, $_iFrmRss);

?>