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

$splitMdc = explode(';', $aProps[3]);
$oTblCont = new we_htmlTable(array(
	"border" => "0", "cellpadding" => "0", "cellspacing" => "0"
), 1, 1);
$oTblCont->setCol(
		0, 
		0, 
		null, 
		we_htmlElement::htmlDiv(
				array(
					
						"id" => "m_" . $iCurrId . "_inline", 
						"style" => "width:" . $iWidth . "px;height:" . ($aPrefs[$aProps[0]]["height"] - 25) . "px;overflow:auto;"
				), 
				$mdc));
$aLang = array(
	
		($splitMdc[0] != "") ? base64_decode($splitMdc[0]) : (!$splitMdc[1][1] ? $l_cockpit["my_documents"] : $l_cockpit["my_objects"]), 
		""
);

?>
