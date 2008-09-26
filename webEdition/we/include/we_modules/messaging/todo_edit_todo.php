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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/messaging.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");

htmlTop($l_messaging['wintitle']);

$messaging = new we_messaging($_SESSION["we_data"][$_REQUEST['we_transaction']]);
$messaging->set_login_data($_SESSION["user"]["ID"], $_SESSION["user"]["Username"]);
$messaging->init($_SESSION["we_data"][$_REQUEST['we_transaction']]);

$mode = isset($_REQUEST["mode"]) ? $_REQUEST["mode"] : '';

print STYLESHEET;

?>

<script language="JavaScript" type="text/javascript" src="<?php echo JS_DIR?>windows.js"></script>
<script language="JavaScript" type="text/javascript">
	rcpt_sel = new Array();

	function update_rcpts() {
		var rcpt_str = rcpt_sel[0][2];
		document.compose_form.mn_recipients.value = rcpt_str;
	}

	function selectRecipient() {

	    var rs = escape(document.compose_form.mn_recipients.value);
	    
	    new jsWindow("<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_usel.php?we_transaction=<?php echo $_REQUEST['we_transaction']?>&maxsel=1&rs=" + rs,"messaging_usel",-1,-1,530,420,true,false,true,false);
	}

	function do_send() {
		<?php if ($mode != 'reject') { ?>
			rcpt_s = escape(document.compose_form.mn_recipients.value);
			document.compose_form.rcpts_string.value = rcpt_s;
		<?php } ?>
		document.compose_form.submit();
	}

	function doUnload() {
		if(jsWindow_count) {
			for(i=0;i<jsWindow_count;i++) {
				eval("jsWindow"+i+"Object.close()");
			}
		}
	}

</script>
</head>

<body class="weDialogBody" <?php echo ($mode == 'reject' ? '' : 'onLoad="document.compose_form.mn_subject.focus()"')?> onUnload="doUnload();">
	<?php
		if ($mode == 'forward') {
			$compose = new we_format('forward', $messaging->selected_message);
			$heading = $l_messaging['forward_todo'];
		}
		else if ($mode == 'reject') {
			$compose = new we_format('reject', $messaging->selected_message);
			$heading = $l_messaging['reject_todo'];
		}
		else {
			$compose = new we_format('new');
			$heading = $l_messaging['new_todo'];
		}
		$compose->set_login_data($_SESSION["user"]["ID"], $_SESSION["user"]["Username"]);
	?>
	<form action="<?php print WE_MESSAGING_MODULE_PATH; ?>todo_send_ntodo.php" name="compose_form" method="post">
		<?php
            echo hidden('we_transaction', $_REQUEST['we_transaction']);
	        echo hidden('rcpts_string', '');
	        echo hidden('mode', $mode);
	        
			if ($mode == 'reject') {
				$tbl =  '
					<table cellpadding="6">
					    <tr>
							<td class="defaultgray">
								' . $l_messaging['from'] . ':</td>
							<td class="defaultfont">
								' . $compose->get_from() . '</td>
						</tr>
						<tr>
							<td class="defaultgray">
								' . $l_messaging['reject_to'] . ':</a></td>
							<td class="defaultfont">
								' . $compose->get_recipient_line() . '</td>
						</tr>
						<tr>
							<td class="defaultgray">
								' . $l_messaging['subject'] . ':</td>
							<td class="defaultfont">
								' . $compose->get_subject() . '</td>
						</tr>
					</table>
					<table cellpadding="6">';
			} else {
				$tbl =  '
					<table cellpadding="6">
						<tr>
							<td class="defaultgray">
								' . $l_messaging['assigner'] . ':</td>
							<td class="defaultfont">
								' . $compose->get_from() . '</td>
						</tr>
						<tr>
							<td class="defaultgray">
								<a href="javascript:selectRecipient()">' . $l_messaging['recipient'] . ':</a></td>
							<td>
								' . htmlTextInput('mn_recipients', 40, ($mode == 'forward' ? '' : $_SESSION["user"]["Username"])) . '</td>
						</tr>
						<tr>
							<td class="defaultgray">
								' . $l_messaging['subject'] . ':</td>
							<td>
								' . htmlTextInput('mn_subject', 40, $compose->get_subject()) . '</td>
						</tr>
						<tr>
							<td class="defaultgray">
								' . $l_messaging['deadline'] . ':</td>
							<td>
								' . getDateInput2('td_deadline%s', $compose->get_deadline()) . '</td>
						</tr>
						<tr>
							<td class="defaultgray">' . $l_messaging['priority'] . ':</td>
							<td>' . html_select('mn_priority', 1, array(1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6, 7=>7, 8=>8, 9=>9, 10=>10)) . '</td>
						</tr>
					</table>
					<table cellpadding="6">';
			}
			if ($mode != 'new') {
				$tbl .= '
					<tr>
						<td class="defaultfont">' . $compose->get_msg_text() . '</td>
					</tr>
					<tr>
						<td class="defaultfont">' . $compose->get_todo_history() . '</td>
					</tr>';
			}
			$tbl .= '
					<tr>
						<td>
							<textarea cols="68" rows="10" name="mn_body" style="width:624px"></textarea></td>
					</tr>
				</table>';
  			$we_button = new we_button();
			$buttons = $we_button->position_yes_no_cancel(	$we_button->create_button("ok", "javascript:do_send()"),
    												"",
    												$we_button->create_button("cancel", "javascript:top.window.close()")
    											 );
			echo htmlDialogLayout($tbl, "<div style='padding:6px'>" . $heading . "</div>", $buttons,"100","24");
		?>
	</form>
</body>
</html>