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

htmlTop($l_global["changePass"]);

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
			<form target="passwdload" action="<?php print WEBEDITION_DIR; ?>we_cmd.php" method="post">
				<?php
					$oldpass =  htmlTextInput("oldpasswd",20,"","32","","password",200);
					$newpass = htmlTextInput("newpasswd",20,"","32","","password",200);
					$newpass2 = htmlTextInput("newpasswd2",20,"","32","","password",200);

					$okbut     = $we_button->create_button("save", "javascript:document.forms[0].submit();");
					$cancelbut = $we_button->create_button("cancel", "javascript:top.close();");

					$content = '
						<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td class="defaultfont">
									' . $l_global["oldPass"] . '</td>
							</tr>
							<tr>
								<td>
									' . $oldpass . '</td>
							</tr>
							<tr>
								<td>
									' . getPixel(2,5) . '</td>
							</tr>
							<tr>
								<td class="defaultfont">
									' . $l_global["newPass"] . '</td>
							</tr>
							<tr>
								<td>
									' . $newpass . '</td>
							</tr>
							<tr>
								<td>
									' . getPixel(2,5) . '</td>
							</tr>
							<tr>
								<td class="defaultfont">
									' . $l_global["newPass2"] . '</td>
							</tr>
							<tr>
								<td>
									' . $newpass2 . '</td>
							</tr>
						</table>';


					$_buttons = $we_button->position_yes_no_cancel(	$okbut,
																	null,
																	$cancelbut);

					$frame = htmlDialogLayout($content, $l_global["changePass"], $_buttons);
					print $frame;
					print '	<input type="hidden" name="cmd" value="ok">
							<input type="hidden" name="we_cmd[0]" value="' . $_REQUEST["we_cmd"][0] . '">
							<input type="hidden" name="we_cmd[1]" value="load">';
				?>
			</form>
		</center>
<?php
} else if (isset($_REQUEST["we_cmd"][1]) && ($_REQUEST["we_cmd"][1] == "load")) {
	$oldpasswd = isset($_REQUEST["oldpasswd"]) ? $_REQUEST["oldpasswd"] : "";
	$newpasswd = isset($_REQUEST["newpasswd"]) ? $_REQUEST["newpasswd"] : "";
	$newpasswd2 = isset($_REQUEST["newpasswd2"]) ? $_REQUEST["newpasswd2"] : "";
?>
	<script language="JavaScript" type="text/javascript"><!--
	<?php
		if (isset($_REQUEST["cmd"]) && ($_REQUEST["cmd"] == "ok")) {
   			$passwd = f("SELECT passwd FROM " . USER_TABLE . " WHERE username='" . mysql_real_escape_string($_SESSION["user"]["Username"] ). "'", "passwd", $DB_WE);

			if (md5($oldpasswd.md5($_SESSION["user"]["Username"])) != $passwd) {
				print
					we_message_reporting::getShowMessageCall($l_global["pass_not_match"], WE_MESSAGE_ERROR) . '
					top.passwdcontent.document.forms[0].elements["oldpasswd"].focus();
					top.passwdcontent.document.forms[0].elements["oldpasswd"].select();';
			} else if (strlen($newpasswd) < 4) {
				print
					we_message_reporting::getShowMessageCall($l_global["pass_to_short"], WE_MESSAGE_ERROR) . '
					top.passwdcontent.document.forms[0].elements["newpasswd"].focus();
					top.passwdcontent.document.forms[0].elements["newpasswd"].select();';
			} else if ($newpasswd != $newpasswd2) {
				print
					we_message_reporting::getShowMessageCall($l_global["pass_not_confirmed"], WE_MESSAGE_ERROR) . '
					top.passwdcontent.document.forms[0].elements["newpasswd2"].focus();
					top.passwdcontent.document.forms[0].elements["newpasswd2"].select();';
			} else {
				
		 		$DB_WE->query("UPDATE " . USER_TABLE . " SET passwd='" . md5($newpasswd . md5($_SESSION["user"]["Username"])) . "', UseSalt=1 WHERE username='" . mysql_real_escape_string($_SESSION["user"]["Username"]) . "'");
				print
					we_message_reporting::getShowMessageCall($l_global["pass_changed"], WE_MESSAGE_NOTICE) .
					'top.close();';
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
		<?php
			print we_htmlElement::jsElement("", array("src" => JS_DIR . "keyListener.js")) .
				  we_htmlElement::jsElement("
					function saveOnKeyBoard() {
						window.frames[0].document.forms[0].submit();
						return true;
					}
					function closeOnEscape() {
						return true;
					
					}
				  ");
			
		?>
	</head>

	<frameset rows="*,0" framespacing="0" border="0" frameborder="NO">
		<frame src="<?php print WEBEDITION_DIR ?>we_cmd.php?we_cmd[0]=<?php print isset($_REQUEST["we_cmd"][0]) ? $_REQUEST["we_cmd"][0] : ""; ?>&we_cmd[1]=content" name="passwdcontent" noresize>
		<frame src="<?php print WEBEDITION_DIR ?>we_cmd.php?we_cmd[0]=<?php print isset($_REQUEST["we_cmd"][0]) ? $_REQUEST["we_cmd"][0] : ""; ?>&we_cmd[1]=load" name="passwdload" noresize>
	</frameset>

	<body>
<?php
}
?>
	</body>

</html>