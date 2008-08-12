<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) living-e AG                                            |
// +----------------------------------------------------------------------+
//

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/newsletter.inc.php");

function we_tag_ifFemale($attribs, $content){
	global $l_newsletter;
	if(isset($GLOBALS["we_editmode"]) && $GLOBALS["we_editmode"]) return true;
	if(isset($GLOBALS["WE_SALUTATION"]) && isset($GLOBALS["WE_FIRSTNAME"]) && isset($GLOBALS["WE_LASTNAME"]) && $GLOBALS["WE_SALUTATION"] && $GLOBALS["WE_FIRSTNAME"] && $GLOBALS["WE_LASTNAME"]){
		$femaleSalutation = f("SELECT pref_value FROM " . NEWSLETTER_PREFS_TABLE . " WHERE pref_name='female_salutation'","pref_value",$GLOBALS["DB_WE"]);
		if ($femaleSalutation == "") {
			$femaleSalutation = $l_newsletter["default"]["female"];
		}
		if($GLOBALS["WE_SALUTATION"] == $femaleSalutation) return true;
		else return false;
	}else{
		return false;
	}
}

?>