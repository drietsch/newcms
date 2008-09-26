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

function we_tag_newsletterUnsubscribeLink($attribs, $content){
	$foo = attributFehltError($attribs,"id","newsletterUnsubscribeLink");if($foo) return $foo;
	$id = we_getTagAttribute("id",$attribs);

	$db=new DB_WE();
	$settings=array();
	$db->query("SELECT * FROM ".NEWSLETTER_PREFS_TABLE);

	while ($db->next_record()) {
		$settings[$db->f("pref_name")]=$db->f("pref_value");
	}

	if(isset($settings["use_port"]) && $settings["use_port"]) $port = ":".$settings["use_port"];
	else $port = "";
	if(isset($settings["use_https_refer"]) && $settings["use_https_refer"]) $protocol="https://";
	else $protocol="http://";
	
	return $protocol.SERVER_NAME.$port.id_to_path($id,FILE_TABLE)."?we_unsubscribe_email__=###EMAIL###";
	
}

?>