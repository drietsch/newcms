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
	$l_cockpit["users_online"], ' ([[span id="num_users"]]' . $UO->getNumUsers() . "[[/span]])"
);

?>
