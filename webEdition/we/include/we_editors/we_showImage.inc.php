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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_imageDocument.inc.php");

$we_doc=new we_imageDocument();
$we_doc->we_initSessDat($_SESSION["we_data"][$_REQUEST["we_cmd"][1]]);

header("Content-Type: ".$we_doc->getElement("type"));
$dataPath = $we_doc->getElement("data");
readfile($dataPath);

?>