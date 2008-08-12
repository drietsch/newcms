<?php



class weBrowser {

	function weBrowser() {}


	function getDownloadLinkText() {

		$map = array(
			"de" => "Deutsch",
			"nl" => "Dutch",
			"fi" => "Finnish",
			"fr" => "French",
			"pl" => "Polish",
			"ru" => "Russian",
			"es" => "Spanish"
		);

		$tmp = explode("_",$_SERVER["HTTP_ACCEPT_LANGUAGE"]);
		$lang = (isset ($map[$tmp[0]]) && file_exists($_SERVER["DOCUMENT_ROOT"] . "webEdition/we/include/we_language/" . $map[$tmp[0]]))
						  ?  $map[$tmp[0]]  :  $GLOBALS["WE_LANGUAGE"];


		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/$lang/browser.inc.php");

		if (isset($_SERVER['HTTP_USER_AGENT'])) {

			$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
			if (strpos($ua,"safari") !== false) {
				$out = $GLOBALS["l_browser"]["save_link_as_SAFARI"];
			} else if (strpos($ua,"msie") !== false) {
				$out = $GLOBALS["l_browser"]["save_link_as_IE"];
			} else if (strpos($ua,"firefox") !== false) {
				$out = $GLOBALS["l_browser"]["save_link_as_FF"];
			} else if (strpos($ua,"seamonkey") !== false) {
				$out = $GLOBALS["l_browser"]["save_link_as_SM"];
			} else if (strpos($ua,"gecko") !== false) {
				$out = $GLOBALS["l_browser"]["save_link_as_SM"];
			} else {
				$out = $GLOBALS["l_browser"]["save_link_as_DEFAULT"];
			}
			return htmlspecialchars($out);
		}


	}

}

?>