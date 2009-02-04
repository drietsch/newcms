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


########################################### tableStart ###########################################################
### String tableStart(int $width, int $cellpadding, int $cellspacing, int $border, [String $bgcolor, $bgimage])
### Erzeugt das <table ... > - Tag

function tableStart($width,$cellpadding,$cellspacing,$border,$bgcolor="",$bgimage=""){
	return '<table cellpadding="'.$cellpadding.'" cellspacing="'.$cellspacing.'"'.($width ? ' width="'.$width.'"' : '').' border="'.$border.'"'.($bgcolor ? ' bgcolor=""' : '').($bgimage ? ' background="'.$bgimage.'"' : '').">\n";
}


########################################### tableRow ###########################################################
### String tableRow(String $align,String $valign,String $class,$c1,...,$c10.)
### Erzeugt eine Tabellen-Zeile mit sovielen Zellen, wie Variablen nach $class angegeben sind (max 10)

function tableRow($align,$valign,$class,$c1,$c2="",$c3="",$c4="",$c5="",$c6="",$c7="",$c8="",$c9="",$c10=""){
	return "<tr align=\"$align\" valign=\"$valign\"><td class=\"$class\">$c1</td>".($c2 ? "<td class=\"$class\">$c2</td>" : "").($c3 ? "<td class=\"$class\">$c3</td>" : "").($c4 ? "<td class=\"$class\">$c4</td>" : "").($c5 ? "<td class=\"$class\">$c5</td>" : "").($c6 ? "<td class=\"$class\">$c6</td>" : "").($c7 ? "<td class=\"$class\">$c7</td>" : "").($c8 ? "<td class=\"$class\">$c8</td>" : "").($c9 ? "<td class=\"$class\">$c9</td>" : "").($c10 ? "<td class=\"$class\">$c10</td>" : "")."</tr>\n";
}


########################################### tableEnd ###########################################################
### String tableEnd()
### Erzeugt das </table> - Tag

function tableEnd(){
	return "</table>\n";
}
?>
