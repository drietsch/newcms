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
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/date.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/PEAR.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/Parser.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/RSS.php");

protect();

print htmlTop();
print 
		"<script type=\"text/javascript\">

function init() {
	parent.executeAjaxRequest('" . implode("', '", $_REQUEST["we_cmd"]) . "');
	
}


</script>";
print we_htmlElement::htmlBody(array(
	"onload" => "init()"
));
print "</html>";
?>