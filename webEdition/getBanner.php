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

$id = isset($_GET["id"]) ? $_GET["id"] : 0;
$bid = isset($_GET["bid"]) ? $_GET["bid"] : 0;
$did = isset($_GET["did"]) ? $_GET["did"] : 0;
$paths = isset($_GET["paths"]) ? $_GET["paths"] : "";
$target = isset($_GET["target"]) ? $_GET["target"] : "";
$height = isset($_GET["height"]) ? $_GET["height"] : 0;
$width = isset($_GET["width"]) ? $_GET["width"] : 0;
$bannerclick = isset($_GET["bannerclick"]) ? $_GET["bannerclick"] : "/webEdition/bannerclick.php";
$referer = isset($_GET["referer"]) ? $_GET["referer"] : "";
$type = isset($_GET["type"]) ? $_GET["type"] : "";
$cats = isset($_GET["cats"]) ? $_GET["cats"] : "";
$dt = isset($_GET["dt"]) ? $_GET["dt"] : "";
$link = isset($_GET["link"]) ? $_GET["link"] : 1;
$pixel = isset($_GET["link"]) ? $_GET["link"] : 0;
$bannername = isset($_GET["bannername"]) ? $_GET["bannername"] : "";
$page = isset($_GET["page"]) ? $_GET["page"] : "";
$nocount = isset($_GET["nocount"]) ? $_GET["nocount"] : false;
$xml = (isset($_GET["xml"]) && $_GET["xml"]) ? true : false;
$c = isset($_GET["c"]) ? $_GET["c"] : 0;

if($type && $type != "pixel"){
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/banner/weBanner.php");
	$port = (defined("HTTP_PORT")) ? (":".HTTP_PORT) : "";
	$prot = getServerProtocol();
	$code = weBanner::getBannerCode($did,$paths,$target,$width,$height,$dt,$cats,$bannername,$link,$referer,$bannerclick,$prot."://".SERVER_NAME.$port.$_SERVER["PHP_SELF"],$type, $page, $nocount, $xml);
}
if($type=="js"){

	$code = str_replace("\r\n","\n",$code);
	$code = str_replace("\r","\n",$code);
	$code = str_replace("'","\\'",$code);
	$jsarr = explode("\n",$code);


	header("Content-type: application/x-javascript");

	foreach($jsarr as $line){
		print "document.writeln('".$line."');\n";
	}
}else if($type=="iframe"){
	print $code;
}else{
	if(!$id){
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/banner/weBanner.php");
		$bannerData = weBanner::getBannerData($did,$paths,$dt,$cats,$bannername);
		$id = $bannerData["ID"];
		$bid = $bannerData["bannerID"];
	}else{
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_defines.inc.php");
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/banner/we_conf_banner.inc.php");
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/conf/we_conf.inc.php");
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_db.inc.php");
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_db_tools.inc.php");
	}
	if(!$bid){
		$id=f("SELECT pref_value FROM ".BANNER_PREFS_TABLE." WHERE pref_name='DefaultBannerID'","pref_value",$DB_WE);
		$bid=f("SELECT bannerID FROM ".BANNER_TABLE." WHERE ID=".abs($id),"bannerID",$DB_WE);

	}

	$bannerpath = f("SELECT Path FROM ".FILE_TABLE." WHERE ID=".abs($bid),"Path",$DB_WE);

	if(($type=="pixel" || (!$nocount) && $id && $c)){
		$DB_WE->query("INSERT INTO ".BANNER_VIEWS_TABLE." (ID,Timestamp,IP,Referer,DID,Page) VALUES(".abs($id).",".time().",'".addslashes($_SERVER["REMOTE_ADDR"])."','".addslashes($referer ? $referer : (isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] :  ""))."',".abs($did).",'".addslashes($page)."')");
		$DB_WE->query("UPDATE ".BANNER_TABLE." SET views=views+1 WHERE ID=".abs($id));
		setcookie("webid_$bannername",abs($id));
	}

	if($bannerpath){
		//header("Location: $bannerpath");exit();

		if($c){
			$ext = ereg_replace('.*\.(.+)$','\1',$bannerpath);
			switch($ext){
				case "jpg":
				case "jpeg":
					$contenttype = "image/jpeg";
					break;
				case "png":
					$contenttype = "image/png";
					break;
				default:
					$contenttype = "image/gif";
			}


			header("Cache-Control: no-cache");
			header("Pragma: no-cache");
			header("Expires: -1");
			header("Content-disposition: filename=".basename($bannerpath));
			header("Content-Type: $contenttype");

			readfile($_SERVER["DOCUMENT_ROOT"].$bannerpath);
		}else{
			header("Location: $bannerpath");exit();
		}

	}else{
		header 	 ("Content-type: image/gif");
		print chr(0x47).chr(0x49).chr(0x46).chr(0x38).chr(0x39).chr(0x61).chr(0x01).chr(0x00).
			chr(0x01).chr(0x00).chr(0x80).chr(0x00).chr(0x00).chr(0x04).chr(0x02).chr(0x04).
			chr(0x00).chr(0x00).chr(0x00).chr(0x21).chr(0xF9).chr(0x04).chr(0x01).chr(0x00).
			chr(0x00).chr(0x00).chr(0x00).chr(0x2C).chr(0x00).chr(0x00).chr(0x00).chr(0x00).
			chr(0x01).chr(0x00).chr(0x01).chr(0x00).chr(0x00).chr(0x02).chr(0x02).chr(0x44).
			chr(0x01).chr(0x00).chr(0x3B);
	}


}

?>