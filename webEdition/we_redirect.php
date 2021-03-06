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


include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");

$row = getHash("SELECT Path,IsDynamic FROM ".FILE_TABLE." WHERE ID=" . abs($_REQUEST["id"]),$DB_WE);
$port = (defined("HTTP_PORT")) ? (":".HTTP_PORT) : "";

srand ((double)microtime()*1000000);
$randval = rand();

$prot = getServerProtocol();
$preurl = (isset($_SERVER["HTTP_HOST"]) && $_SERVER["HTTP_HOST"]) ? "$prot://".$_SERVER["HTTP_HOST"] : "";

$DB_WE->query("SELECT Published FROM ".FILE_TABLE." WHERE ID=" . abs($_REQUEST["id"]));
if($DB_WE->next_record()){
	if($DB_WE->f("Published")){
		header("Location: ".$preurl.$row["Path"]."?r=$randval");
		exit;
	}
}
header("Location: ".$preurl.WEBEDITION_DIR."notPublished.php");


?>