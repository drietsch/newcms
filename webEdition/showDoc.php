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


//  Diese we_cmds kommen nicht aus REQUEST !!!! werden verwendet in: we_showDocument
$_REQUEST["we_cmd"][1] = $ID;
$_REQUEST["we_cmd"][3] = 1;
$_REQUEST["we_cmd"][4] = 0;
$_REQUEST["we_cmd"][5] = 1;
$FROM_WE_SHOW_DOC = true;
include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_showDocument.inc.php");
?>