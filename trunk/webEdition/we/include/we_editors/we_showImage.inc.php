<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_imageDocument.inc.php");

$we_doc=new we_imageDocument();
$we_doc->we_initSessDat($_SESSION["we_data"][$_REQUEST["we_cmd"][1]]);

header("Content-Type: ".$we_doc->getElement("type"));
$dataPath = $we_doc->getElement("data");
readfile($dataPath);

?>