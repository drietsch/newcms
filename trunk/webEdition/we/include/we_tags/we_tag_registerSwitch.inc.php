<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) living-e AG                   |
// +----------------------------------------------------------------------+
//

function we_tag_registerSwitch($attribs,$content) {
	
	if ($GLOBALS["we_editmode"]) {
		
		include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/customer.inc.php");
		
		return '
			<table border="0" cellpadding="4" cellspacing="0" bgcolor="silver">
				<tr>
					<td>
						<font face="verdana" size="2">
							<b>' . $l_customer["view"] . ':</b>&nbsp;</font></td>
					<td>
						<input id="set_registered" type="radio" name="we_set_registeredUser" value="1" onClick="top.we_cmd(\'reload_editpage\');"'.((isset($_SESSION["we_set_registered"]) && $_SESSION["we_set_registered"]) ? " checked" : "").'></td>
					<td>
						<font face="verdana" size="2">
							&nbsp;<label for="set_registered">' . $l_customer["registered_user"] . '</label>&nbsp;&nbsp;&nbsp;<font></td>
					<td>
						<input id="set_unregistered" type="radio" name="we_set_registeredUser" value="0" onClick="top.we_cmd(\'reload_editpage\');"'.((!isset($_SESSION["we_set_registered"]) || !$_SESSION["we_set_registered"]) ? " checked" : "").'></td>
					<td>
						<font face="verdana" size="2">
							&nbsp;<label for="set_unregistered">' . $l_customer["unregistered_user"] . '</label></font></td>
				</tr>
			</table>';
	} else {
		return "";
	}
}
?>