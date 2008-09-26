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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_html_tools.inc.php");
include_once(WE_MESSAGING_MODULE_DIR . "we_messaging.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");

$heading = 'ToDo Status-update ...';

$deadline = mktime($_REQUEST['td_deadline_hour'], $_REQUEST['td_deadline_minute'], 0, $_REQUEST['td_deadline_month'], $_REQUEST['td_deadline_day'], $_REQUEST['td_deadline_year']);
$arr = array('deadline' => $deadline);

$messaging = new we_messaging($_SESSION["we_data"][$_REQUEST['we_transaction']]);
$messaging->set_login_data($_SESSION["user"]["ID"], $_SESSION["user"]["Username"]);
$messaging->init($_SESSION["we_data"][$_REQUEST['we_transaction']]);


if ($_REQUEST['todo_status'] != $messaging->selected_message['hdrs']['status']) {
    $arr['todo_status'] = $_REQUEST['todo_status'];
}

if (!empty($_REQUEST['todo_comment'])) {
    $arr['todo_comment'] = $_REQUEST['todo_comment'];
}

$arr['todo_priority'] = $_REQUEST['todo_priority'];

$res = $messaging->used_msgobjs['we_todo']->update_status($arr, $messaging->selected_message['int_hdrs']);

$messaging->get_fc_data($messaging->Folder_ID, '', '', 0);

$messaging->saveInSession($_SESSION["we_data"][$_REQUEST['we_transaction']]);
?>

<html>
	<head>
		<title><?php echo $heading?></title>
		<?php print STYLESHEET; ?>
		<script language="JavaScript" type="text/javascript">
		if (opener && opener.top && opener.top.content) {
			top.opener.top.content.update_messaging();
			top.opener.top.content.update_msg_quick_view();
		}
		</script>
	</head>

	<body class="weDialogBody">
		<?php
			$tbl = '
				<table align="center" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td class="defaultfont" align="center">
							' . $res['msg'] . '</td>
					</tr>
				</table>';
			$we_button = new we_button();
			echo htmlDialogLayout($tbl, $heading, $we_button->create_button("ok", "javascript:top.window.close()"),"100%","30","","hidden");
		?>
	</body>

</html>