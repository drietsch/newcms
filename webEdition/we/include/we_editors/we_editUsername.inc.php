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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/global.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");

protect();

htmlTop($l_global["changeUsername"]);

?>
<?php
if (isset($_REQUEST["we_cmd"][1]) && ($_REQUEST["we_cmd"][1] == "content")) {
?>
<?php
	print STYLESHEET;

	$we_button = new we_button();
?>
	<script language="JavaScript" type="text/javascript"><!--
		function add() {
			var p=document.forms[0].elements["we_category"];
		}

		self.focus();
	//-->
	</script>
	</head>

	<body class="weDialogBody" style="overflow:hidden;">
		<center>
			<form target="usernameload" action="<?php print WEBEDITION_DIR; ?>we_cmd.php" method="post">
				<?php
					$username =  htmlTextInput("username",20,$_SESSION["user"]["Username"],"32","readonly","text",200,"","","true");
					$new_username =  htmlTextInput("new_username",20,"","32","","text",200);
					$password = htmlTextInput("passwd",20,"","32","","password",200);

					$okbut     = $we_button->create_button("save", "javascript:document.forms[0].submit();");
					$cancelbut = $we_button->create_button("cancel", "javascript:top.close();");

					$content = '
						<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td class="defaultfont">
									' . $l_global["username"] . '</td>
							</tr>
							<tr>
								<td>
									' . $username . '</td>
							</tr>
							<tr>
								<td>
									' . getPixel(2,5) . '</td>
							</tr>
							<tr>
								<td class="defaultfont">
									' . $l_global["new_username"] . '</td>
							</tr>
							<tr>
								<td>
									' . $new_username . '</td>
							</tr>
							<tr>
								<td>
									' . getPixel(2,5) . '</td>
							</tr>
							<tr>
								<td class="defaultfont">
									' . $l_global["password"] . '</td>
							</tr>
							<tr>
								<td>
									' . $password . '</td>
							</tr>
						</table>';


					$_buttons = $we_button->position_yes_no_cancel(	$okbut,
																	null,
																	$cancelbut);

					$frame = htmlDialogLayout($content, $l_global["changeUsername"], $_buttons);
					print $frame;
					print '	<input type="hidden" name="cmd" value="ok">
							<input type="hidden" name="we_cmd[0]" value="' . $_REQUEST["we_cmd"][0] . '">
							<input type="hidden" name="we_cmd[1]" value="load">';
				?>
			</form>
		</center>
<?php
} else if (isset($_REQUEST["we_cmd"][1]) && ($_REQUEST["we_cmd"][1] == "load")) {
	$passwd = isset($_REQUEST["passwd"]) ? $_REQUEST["passwd"] : "";
	$new_username = isset($_REQUEST["new_username"]) ? $_REQUEST["new_username"] : "";
?>
	<script language="JavaScript" type="text/javascript"><!--
	<?php
		if (isset($_REQUEST["cmd"]) && ($_REQUEST["cmd"] == "ok")) {
   			$passwdcheck = f("SELECT passwd FROM " . USER_TABLE . " WHERE username='" . $_SESSION["user"]["Username"] . "'", "passwd", $DB_WE);

			if (md5($passwd) != $passwdcheck) {
				print
					we_message_reporting::getShowMessageCall($l_global["passwd_not_match"], WE_MESSAGE_ERROR) . '
					top.usernamecontent.document.forms[0].elements["passwd"].focus();
					top.usernamecontent.document.forms[0].elements["passwd"].select();';
			} else if (strlen($new_username) < 4) {
				print
					we_message_reporting::getShowMessageCall($l_global["username_to_short"], WE_MESSAGE_ERROR) . '
					top.usernamecontent.document.forms[0].elements["new_username"].focus();
					top.usernamecontent.document.forms[0].elements["new_username"].select();';
			} else {
				if(eregi("^[A-Za-z0-9._-]+$", $new_username)) {
		 		$DB_WE->query("UPDATE " . USER_TABLE . " set username='" . $new_username . "' WHERE passwd='" . md5($passwd) . "'");
				print
					we_message_reporting::getShowMessageCall($l_global["username_changed"], WE_MESSAGE_NOTICE) .
					'top.close();';
				} else {
				print
					we_message_reporting::getShowMessageCall($l_global["username_wrong_chars"], WE_MESSAGE_ERROR) . '
					top.usernamecontent.document.forms[0].elements["new_username"].focus();
					top.usernamecontent.document.forms[0].elements["new_username"].select();';
				}
			}
		}
	?>
	//-->
	</script>
	</head>

	<body>
<?php
} else {
?>
	</head>

	<frameset rows="*,0" framespacing="0" border="0" frameborder="NO">
		<frame src="<?php print WEBEDITION_DIR ?>we_cmd.php?we_cmd[0]=<?php print isset($_REQUEST["we_cmd"][0]) ? $_REQUEST["we_cmd"][0] : ""; ?>&we_cmd[1]=content" name="usernamecontent" noresize>
		<frame src="<?php print WEBEDITION_DIR ?>we_cmd.php?we_cmd[0]=<?php print isset($_REQUEST["we_cmd"][0]) ? $_REQUEST["we_cmd"][0] : ""; ?>&we_cmd[1]=load" name="usernameload" noresize>
	</frameset>

	<body>
<?php
}
?>
	</body>

</html>

