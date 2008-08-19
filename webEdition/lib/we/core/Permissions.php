<?php

class we_core_Permissions
{
	static function hasPerm($perm) {
		$perm = strtoupper($perm);
		if(isset($_SESSION["perms"]["ADMINISTRATOR"]) && $_SESSION["perms"]["ADMINISTRATOR"]){
	        return true;
	    }
	    //we_util_Log::errorlog($perm);
		//we_util_Log::errorlog($_SESSION["perms"][$perm]);
	    //we_util_Log::errorlog($_SESSION["perms"]);
		return ((isset($_SESSION["perms"][$perm]) && $_SESSION["perms"][$perm]) || (!isset($_SESSION["perms"][$perm])));
	}
	
	static function protect() {
		
		$translate = we_core_Local::addTranslation('permissions.xml');
		
		if(!isset($_SESSION["user"]["Username"]) || $_SESSION["user"]["Username"] == "") {
			$page = new we_ui_layout_HTMLPage();
			$page->addJSFile('/webEdition/js/we_showMessage.js');
			
			$message = we_util_Strings::quoteForJSString($translate->_('You are not permitted to perform this action! Please login again.'), false);
		
			$messageCall = we_core_MessageReporting::getShowMessageCall(
				$message, 
				we_core_MessageReporting::kMessageNotice
			);
			
			$page->addInlineJS($messageCall . 'if (opener) {top.close();} else {location="/webEdition"}');
			print $page->getHTML();exit();
	}
}
	
	
}
