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

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/newsletter.inc.php");

function we_tag_ifFemale($attribs, $content){
	global $l_newsletter;
	if(isset($GLOBALS["we_editmode"]) && $GLOBALS["we_editmode"]) return true;
	if(isset($GLOBALS["WE_SALUTATION"]) && $GLOBALS["WE_SALUTATION"]){
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