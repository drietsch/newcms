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

$oTblCont = new we_htmlTable(
		array(
			
				"id" => "m_" . $iCurrId . "_inline", 
				"style" => "width:" . $iWidth . "px;", 
				"cellpadding" => "0", 
				"cellspacing" => "0", 
				"border" => "0"
		), 
		1, 
		1);
$oTblCont->setCol(0, 0, null, $inline);
$aLang = array(
	$l_cockpit["users_online"], ' (' . $UO->getNumUsers() . ")"
);

?>
