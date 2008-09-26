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
include_once(WE_MESSAGING_MODULE_DIR . "we_messaging.inc.php");
include_once(WE_MESSAGING_MODULE_DIR."messaging_format.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/messaging.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");

htmlTop('Messaging System - ' . $l_messaging['new_message']);


$messaging = new we_messaging($_SESSION["we_data"][$_REQUEST['we_transaction']]);
$messaging->set_login_data($_SESSION["user"]["ID"], $_SESSION["user"]["Username"]);
$messaging->init($_SESSION["we_data"][$_REQUEST['we_transaction']]);



print STYLESHEET;

$we_button = new we_button();
?>

<script language="JavaScript" type="text/javascript" src="<?php echo JS_DIR?>windows.js"></script>
<script language="JavaScript" type="text/javascript"><!--
	rcpt_sel = new Array();

	function update_rcpts() {
		var rcpt_str = "";

		for (i = 0; i < rcpt_sel.length; i++) {
			rcpt_str += rcpt_sel[i][2];
			if (i != rcpt_sel.length - 1) {
				rcpt_str += ", ";
			}
		}

		document.compose_form.mn_recipients.value = rcpt_str;
	}

	function selectRecipient() {
	    var rs = escape(document.compose_form.mn_recipients.value);

	    new jsWindow("<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_usel.php?we_transaction=<?php echo $_REQUEST['we_transaction']?>&rs=" + rs,"messaging_usel",-1,-1,530,420,true,false,true,false);
//	    opener.top.add_win(msg_usel);
	}

	function do_send() {
		rcpt_s = escape(document.compose_form.mn_recipients.value);
		document.compose_form.rcpts_string.value = rcpt_s;
		document.compose_form.submit();
	}

	function doUnload() {
		if(jsWindow_count) {
			for(i=0;i<jsWindow_count;i++) {
				eval("jsWindow"+i+"Object.close()");	
			}
		}
	}

//-->
</script>
</head>

<body class="weDialogBody" onLoad="document.compose_form.mn_body.focus()" onUnload="doUnload();">
<?php

if ($_REQUEST["mode"] == 're') {
	$compose = new we_format('re', $messaging->selected_message);
	$heading = $l_messaging['reply_message'];
} else {
	if(substr($_REQUEST["mode"],0,2) == 'u_') {
		$_u = str_replace(substr($_REQUEST["mode"],0,2),'',$_REQUEST["mode"]);
	}
	$compose = new we_format('new');
	$heading = $l_messaging['new_message'];
}

$compose->set_login_data($_SESSION["user"]["ID"], $_SESSION["user"]["Username"]);
?>
  <form action="<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_send_nm.php" name="compose_form" method="post">
    <?php echo hidden('we_transaction', $_REQUEST['we_transaction']);
	  echo hidden('rcpts_string', '');echo hidden('mode', $_REQUEST["mode"]);

$tbl = '<table align="center" cellpadding="6" width="100%">
      <tr><td class="defaultgray">' . $l_messaging['from']. ':</td><td class="defaultfont">' . $compose->get_from() . '</td></tr>
      <tr><td class="defaultgray"><a href="javascript:selectRecipient()">' . $l_messaging['recipients'] . ':</a></td><td>' . htmlTextInput('mn_recipients', 40, (!isset($_u)? $compose->get_recipient_line() : $_u)) . '</td></tr>
      <tr><td class="defaultgray">' . $l_messaging['subject'] . ':</td><td>' . htmlTextInput('mn_subject', 40, $compose->get_subject()) . '</td></tr>
      <tr><td colspan="2"><textarea cols="68" rows="15" name="mn_body" style="width:605px">' . $compose->get_msg_text() . '</textarea></td></tr>
    </table>';
	
	$_buttons = $we_button->position_yes_no_cancel(	$we_button->create_button("ok", "javascript:do_send()"),
	    											"",
	    											$we_button->create_button("cancel", "javascript:window.close()")
	    										);
	
    echo htmlDialogLayout($tbl, "<div style='padding:6px'>".$heading."</div>", $_buttons,"100%","24","","hidden");
    
		?>
	</form>
</body>
</html>