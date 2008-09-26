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

function getPLogChart($vals)
{
	global $_pLogUrl, $l_cockpit;
	$_chart = new we_htmlTable(
			array(
				
					"width" => "100%", 
					"border" => "0", 
					"cellpadding" => "0", 
					"cellspacing" => "0", 
					"class" => "finelinebox"
			), 
			count($vals) + 1, 
			4);
	$_chart->setCol(
			0, 
			0, 
			array(
				"height" => 16, "colspan" => 3, "class" => "tablehead"
			), 
			getPixel(2, 5) . we_htmlElement::htmlImg(
					array(
						"src" => IMAGE_DIR . "pd/bullet_circle.gif", "class" => "bulletCircle"
					)) . getPixel(2, 5) . $l_cockpit[$vals[0]]);
	$_chart->setCol(1, 0, array(
		"colspan" => 3
	), we_htmlElement::htmlImg(array(
		"src" => IMAGE_DIR . "pd/blackdot.gif", "width" => "100%", "height" => 1
	)));
	for ($i = 2; $i < count($vals) + 1; $i++) {
		$_chart->setCol($i, 0, array(
			"width" => "53%", "height" => 19, "class" => "boxbg"
		), getPixel(3, 5) . $l_cockpit[$vals[$i - 1]]);
		$_chart->setCol($i, 1, array(
			"width" => "2%", "height" => 19, "class" => "boxbg"
		), ":");
		$_chart->setCol($i, 2, array(
			"width" => "45%", "height" => 19, "class" => "resbg"
		), showme($vals[$i - 1], $_pLogUrl));
	}
	return $_chart;
}

function getPLogGraph($gf)
{
	
	global $_pLogUrl, $_url, $l_cockpit;
	$_graph = new we_htmlTable(
			array(
				
					"width" => "100%", 
					"border" => "0", 
					"cellpadding" => "0", 
					"cellspacing" => "0", 
					"class" => "finelinebox"
			), 
			1, 
			1);
	$_gfDat = showme($gf, $_pLogUrl);
	$_graph->setCol(
			0, 
			0, 
			array(
				"colspan" => 3, "align" => "center", "style" => "background-color:#efefef;"
			), 
			we_htmlElement::htmlImg(
					array(
						
							"src" => $_url . "vertical-bar-graph.php?data=" . $_url . "data.php%3Fdta=" . urlencode(
									serialize($_gfDat)) . "&config=" . $_url . "config_" . $gf . ".php%3Fgfh=" . base64_encode(
									$l_cockpit[$gf])
					)));
	return $_graph;
}

?>