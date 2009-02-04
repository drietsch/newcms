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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/messaging.inc.php");
include_once(WE_MESSAGING_MODULE_DIR . "we_messaging.inc.php");
include_once(WE_MESSAGING_MODULE_DIR . "msg_html_tools.inc.php");
protect();
htmlTop();

$messaging = new we_messaging($_SESSION["we_data"][$_REQUEST['we_transaction']]);
$messaging->set_login_data($_SESSION["user"]["ID"], $_SESSION["user"]["Username"]);
$messaging->init($_SESSION["we_data"][$_REQUEST['we_transaction']]);

print STYLESHEET;
?>
<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR; ?>windows.js"></script>
<script language="JavaScript" type="text/javascript"><!--

	function new_message(mode) {
	    if (mode == 're' && (top.content.messaging_main.messaging_right.msg_work.last_entry_selected == -1)) {
		return;
	    }

		new jsWindow("<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_newmessage.php?we_transaction=<?php echo $_REQUEST['we_transaction']?>&mode=" + mode, "messaging_new_message",-1,-1,670,530,true,false,true,false);
	}

	function copy_messages() {

	    if (top.content.messaging_main.messaging_right.msg_work.entries_selected && top.content.messaging_main.messaging_right.msg_work.entries_selected.length > 0) {
		top.content.messaging_cmd.location = "<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_cmd.php?we_transaction=<?php echo $_REQUEST['we_transaction']?>&mcmd=copy_msg&entrsel=" + top.content.messaging_main.messaging_right.msg_work.entries_selected.join(',');
	    }
	}

	function cut_messages() {

	    if (top.content.messaging_main.messaging_right.msg_work.entries_selected && top.content.messaging_main.messaging_right.msg_work.entries_selected.length > 0) {
		top.content.messaging_cmd.location = "<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_cmd.php?we_transaction=<?php echo $_REQUEST['we_transaction']?>&mcmd=cut_msg&entrsel=" + top.content.messaging_main.messaging_right.msg_work.entries_selected.join(',');
	    }
	}

	function paste_messages() {
		if (top.content.messaging_main.messaging_right.msg_work.entries_selected) {
	  		top.content.messaging_cmd.location = "<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_cmd.php?we_transaction=<?php echo $_REQUEST['we_transaction']?>&mcmd=paste_msg&entrsel=" + top.content.messaging_main.messaging_right.msg_work.entries_selected.join(',');
		}
	}

	function delete_messages() {
		if (top.content.messaging_main.messaging_right.msg_work.entries_selected && top.content.messaging_main.messaging_right.msg_work.entries_selected.length > 0) {
			c = confirm("<?php echo $l_messaging['q_rm_messages']?>");
			if (c == false) {
				return;
			}
			top.content.messaging_cmd.location = "<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_cmd.php?we_transaction=<?php echo $_REQUEST['we_transaction']?>&mcmd=delete_msg&entrsel=" + top.content.messaging_main.messaging_right.msg_work.entries_selected.join(',');
		}
	}

	function refresh() {
		top.content.update_messaging();
		top.content.update_msg_quick_view();
	}

	function launch_todo() {
		if (top.content.messaging_main.messaging_right.msg_work.entries_selected) {
	   	 top.content.messaging_cmd.location = '<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_cmd.php?mcmd=launch&mode=todo&we_transaction=<?php echo $_REQUEST['we_transaction']?>';
		}
	}

//-->
</script>
</head>

<?php
	$we_button = new we_button();
?>

<body background="<?php print IMAGE_DIR ?>backgrounds/iconbarBack.gif" marginwidth="0" topmargin="5" marginheight="5" leftmargin="0">
	<table border="0" cellpadding="8" cellspacing="0" width="100%">
		<tr>
			<td width="36">
				<?php echo $we_button->create_button("image:btn_messages_create", "javascript:new_message('new')", true); ?></td>
			<td width="36">
				<?php echo $we_button->create_button("image:btn_messages_reply", "javascript:new_message('re')", true); ?></td>
			<td width="36">
				</td>
			<td width="36">
				<?php echo $we_button->create_button("image:btn_messages_copy", "javascript:copy_messages()", true); ?></td>
			<td width="36">
				<?php echo $we_button->create_button("image:btn_messages_cut", "javascript:cut_messages()", true); ?></td>
			<td width="36">
				<?php echo $we_button->create_button("image:btn_messages_paste", "javascript:paste_messages()", true); ?></td>
			<td width="36">
				<?php echo $we_button->create_button("image:btn_messages_trash", "javascript:delete_messages()", true); ?></td>
			<td width="36">
				<?php echo $we_button->create_button("image:btn_messages_update", "javascript:refresh()", true); ?></td>
			<td align="right">
				<?php echo $we_button->create_button("image:btn_messages_tasks", "javascript:launch_todo();", true); ?></td>
		</tr>
	</table>
</body>

</html>