<?php

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