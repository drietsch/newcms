<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   we
 * @package    we_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
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

if($id){
	$url = weBanner::getBannerURL($id);
	if(!$nocount){
		$db->query("INSERT INTO ".BANNER_CLICKS_TABLE." (ID,Timestamp,IP,Referer,DID,Page) VALUES($id,".time().",'".$_SERVER["REMOTE_ADDR"]."','".($referer ? $referer : (isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] :  ""))."','".$did."','".$page."')");
		$db->query("UPDATE ".BANNER_TABLE." SET clicks=clicks+1 WHERE ID='$id'");
	}
	header("Location: $url");
}
?>
