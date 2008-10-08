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
 * @package    webEdition_rpc
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */

class rpcGetCategoryCmd extends rpcCmd {
	
	function execute() {
		$resp = new rpcResponse();
		$_error = array();
		// check for necessory params
		if(!isset($_REQUEST['obj']) || $_REQUEST['obj']=="") {
			$_error[] = "Missing field obj";
		} 
		if(!isset($_REQUEST['cats']) || $_REQUEST['cats']=="") {
			$_error[] = "Missing field cats";
		} 
		if(isset($_REQUEST['part']) && $_REQUEST['part']=="table" && (!isset($_REQUEST['target']) || $_REQUEST['target']=="")) {
			$_error[] = "Missing target for table";
		} 
		
		if (count($_error) > 0) {
			$resp->setData("error",$_error);
		} else {
			$part = (isset($_REQUEST['part']) && $_REQUEST['part']!="") ? $_REQUEST['part'] : "rows";
			$target = (isset($_REQUEST['target']) && $_REQUEST['target']!="") ? $_REQUEST['target'] : $_REQUEST['obj']."CatTable";
			$catField = (isset($_REQUEST['catfield']) && $_REQUEST['catfield']!="") ? $_REQUEST['catfield'] : "";
			$categories = $this->getCategory($_REQUEST['obj'],$_REQUEST['cats'],$catField,$part);
			$categories = strtr($categories, array("\r" => "","\n"=>""));
			$resp->setData("elementsById",
				array($target => array("innerHTML" => addslashes($categories)))
			);
			
		}
		return $resp;
	}

	function getCategory($obj, $categories, $catField="", $as="table") {
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tools/MultiDirChooser2.inc.php");
		$cats = new MultiDirChooser2(410,$categories,"delete_".$obj."Cat","","","Icon,Path",CATEGORY_TABLE);
		$cats->setRowPrefix($obj);
		$cats->setCatField($catField);
		return $cats->getTableRows();
	}
}
?>