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

list($pad_header_enc, $pad_csv) = explode(',', $aProps[3]);

$_iFrmPadAtts['src'] = WEBEDITION_DIR . 'we/include/we_widgets/mod/pad.inc.php' . '?we_cmd[0]=' . $pad_csv . '&amp;we_cmd[1]=' . '&amp;we_cmd[2]=home' . '&amp;we_cmd[3]=' . $aProps[1] . '&amp;we_cmd[4]=' . rawurlencode(
		$pad_header_enc) . '&amp;we_cmd[5]=' . $iCurrId . '&amp;we_cmd[6]=' . $aProps[1] . '&amp;we_cmd[7]=home';
$_iFrmPadAtts['id'] = 'm_' . $iCurrId . '_inline';
$_iFrmPadAtts['style'] = 'width:' . $iWidth . 'px;height:287px';
$_iFrmPadAtts['scrolling'] = 'no';
$_iFrmPadAtts['marginheight'] = '0';
$_iFrmPadAtts['marginwidth'] = '0';
$_iFrmPadAtts['frameborder'] = '0';

$_iFrmPad = str_replace('>', ' allowtransparency="true">', getHtmlTag('iframe', $_iFrmPadAtts, '', true));

$oTblCont = new we_htmlTable(array(
	"cellpadding" => "0", "cellspacing" => "0", "border" => "0"
), 1, 1);
$oTblCont->setCol(0, 0, null, $_iFrmPad);
$aLang = array(
	$l_cockpit['notes'] . " - " . base64_decode($pad_header_enc), ""
);

?>
