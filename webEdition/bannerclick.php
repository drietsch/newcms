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

define("NO_SESS",1);

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once(WE_BANNER_MODULE_DIR."weBanner.php");

$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : 0;
$did = isset($_REQUEST["did"]) ? $_REQUEST["did"] : 0;
$page = isset($_REQUEST["page"]) ? $_REQUEST["page"] : 0;
$referer = isset($_REQUEST["referer"]) ? $_REQUEST["referer"] : 0;
$nocount = isset($_REQUEST["nocount"]) ? $_REQUEST["nocount"] : "";
$db = new DB_WE();

if(!$id){
	$bannername = $_REQUEST["bannername"];

	if($bannername && isset($_COOKIE["webid_".$bannername])){
		$id = $_COOKIE["webid_".$bannername];
	}
	if(!$id){
		$id = f("SELECT pref_value FROM ".BANNER_PREFS_TABLE." WHERE pref_name='DefaultBannerID'","pref_value",$db);
	}
}

if($id && is_numeric($id) && $did>0){
	$url = weBanner::getBannerURL($id);
	if(!$nocount){
		$db->query("INSERT INTO ".BANNER_CLICKS_TABLE." (ID,Timestamp,IP,Referer,DID,Page) VALUES(".abs($id).",".time().",'".mysql_real_escape_string($_SERVER["REMOTE_ADDR"])."','".($referer ? mysql_real_escape_string($referer) : (isset($_SERVER["HTTP_REFERER"]) ? mysql_real_escape_string($_SERVER["HTTP_REFERER"]) :  ""))."','".abs($did)."','".mysql_real_escape_string($page)."')");
		$db->query("UPDATE ".BANNER_TABLE." SET clicks=clicks+1 WHERE ID='".abs($id)."'");
	}
	header("Location: $url");
}
?>
