<?php

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_installed_modules.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_active_integrated_modules.inc.php");

class weModuleInfo {

	function _orderModules($a, $b){
    	return (strcmp($a["text"],$b["text"]));

	}

	/**
	 * Orders a hash array of the scheme of we_available_modules
	 *
	 * @param hash $array
	 */
	function orderModuleArray(&$array) {
		uasort($array, array("weModuleInfo","_orderModules"));

	}

	/**
	 * returns hash with all buyable modules
	 *
	 * @return hash
	 */
	function getNoneIntegratedModules() {
		global $_we_available_modules;

		$retArr = array();

		foreach ($_we_available_modules as $key => $modInfo) {
			if ($modInfo["integrated"] == false) {
				$retArr[$key] = $modInfo;
			}
		}
		
		return $retArr;
	}

	/**
	 * @param string $mKey
	 * @return boolean
	 */
	function isModuleInstalled($mKey) {

		global $_we_installed_modules;

		if (in_array($mKey, $_we_installed_modules) || $mKey == "editor") {
			return true;
		}

		return false;
	}

	/**
	 * returns hash of all integrated modules
	 * @return hash
	 */
	function getIntegratedModules($active=null) {

		global $_we_available_modules, $_we_active_integrated_modules;

		$retArr = array();

		foreach ($_we_available_modules as $key => $modInfo) {
			if ($modInfo["integrated"] == true) {

				if ($active === null) {
					$retArr[$key] = $modInfo;

				} else if ( in_array($key, $_we_active_integrated_modules) == $active ) {
					$retArr[$key] = $modInfo;
				}
			}
		}

		return $retArr;
	}

	/**
	 * returns whether a module is in the menu or not
	 * @param string $modulekey
	 * @return boolean
	 */
	function showModuleInMenu($modulekey) {
		global $_we_available_modules;
		/*
		if ($_we_available_modules[$modulekey]["integrated"]) {
			return true;

		} else {
		*/
			// show a module, if
			// - it is active
			// - if it is in module window

			if ( $_we_available_modules[$modulekey]["inModuleMenu"] && in_array($modulekey, $GLOBALS["_we_active_modules"]) ) {
				return true;
			}

		//}

		return false;
	}

	function isActiv($modul) {
		global $_we_active_integrated_modules;
		return in_array($modul,$_we_active_integrated_modules);
	}
}
?>