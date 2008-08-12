<?php
// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


//  Diese we_cmds kommen nicht aus REQUEST !!!! werden verwendet in: we_showDocument
$_REQUEST["we_cmd"][1] = $ID;
$_REQUEST["we_cmd"][3] = 1;
$_REQUEST["we_cmd"][4] = 0;
$_REQUEST["we_cmd"][5] = 1;
$FROM_WE_SHOW_DOC = true;
include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_showDocument.inc.php");
?>