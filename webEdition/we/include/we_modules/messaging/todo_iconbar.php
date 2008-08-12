<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/messaging.inc.php");
include_once(WE_MESSAGING_MODULE_DIR . "we_messaging.inc.php");
include_once(WE_MESSAGING_MODULE_DIR . "msg_html_tools.inc.php");

htmlTop();

$messaging = new we_messaging($_SESSION["we_data"][$_REQUEST['we_transaction']]);
$messaging->set_login_data($_SESSION["user"]["ID"], $_SESSION["user"]["Username"]);
$messaging->init($_SESSION["we_data"][$_REQUEST['we_transaction']]);

print STYLESHEET;

?>
<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR; ?>windows.js"></script>
<script language="JavaScript" type="text/javascript">

	function new_todo() {
	    new jsWindow("<?php print WE_MESSAGING_MODULE_PATH; ?>todo_edit_todo.php?we_transaction=<?php echo $_REQUEST['we_transaction']?>&mode=new", "messaging_new_todo",-1,-1,690,520,true,false,true,false);
	}

	function forward_todo() {
	    if (top.content.messaging_main.messaging_right.msg_work.entries_selected && top.content.messaging_main.messaging_right.msg_work.entries_selected.length > 0) {
		new jsWindow("<?php print WE_MESSAGING_MODULE_PATH; ?>todo_edit_todo.php?we_transaction=<?php echo $_REQUEST['we_transaction']?>&mode=forward", "messaging_new_todo",-1,-1,705,600,true,true,true,false);
	    }
	}

	function reject_todo() {
	    if (top.content.messaging_main.messaging_right.msg_work.entries_selected && top.content.messaging_main.messaging_right.msg_work.entries_selected.length > 0) {
		new jsWindow("<?php print WE_MESSAGING_MODULE_PATH; ?>todo_edit_todo.php?we_transaction=<?php echo $_REQUEST['we_transaction']?>&mode=reject", "messaging_new_todo",-1,-1,690,600,true,false,true,false);
	    }
	}

	function update_todo() {
	    if (top.content.messaging_main.messaging_right.msg_work.entries_selected && top.content.messaging_main.messaging_right.msg_work.entries_selected.length > 0) {
		new jsWindow("<?php print WE_MESSAGING_MODULE_PATH; ?>todo_update_todo.php?we_transaction=<?php echo $_REQUEST['we_transaction']?>&mode=reject", "messaging_new_todo",-1,-1,705,600,true,true,true,false);
	    }
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
			c = confirm("<?php echo $l_messaging['q_rm_todos']?>");
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

	function launch_msg() {
		if (top.content.messaging_main.messaging_right.msg_work.entries_selected) {
	    	top.content.messaging_cmd.location = '<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_cmd.php?mcmd=launch&mode=message&we_transaction=<?php echo $_REQUEST['we_transaction']?>';
		}
	}

</script>
</head>

<?php
	$we_button = new we_button();
?>

<body background="<?php print IMAGE_DIR ?>backgrounds/iconbarBack.gif" marginwidth="0" topmargin="5" marginheight="5" leftmargin="0">
	<table border="0" cellpadding="8" cellspacing="0" width="100%">
		<tr>
			<td width="36">
				<?php echo $we_button->create_button("image:btn_task_create", "javascript:new_todo()", true); ?></td>
			<td width="36">
				<?php echo $we_button->create_button("image:btn_task_forward", "javascript:forward_todo()", true); ?></td>
			<td width="36">
				<?php echo $we_button->create_button("image:btn_task_reject", "javascript:reject_todo()", true); ?></td>
			<td width="36">
				<?php echo $we_button->create_button("image:btn_task_status", "javascript:update_todo()", true); ?></td>
			<td width="36">
				</td>
			<td width="36">
				<?php echo $we_button->create_button("image:btn_task_copy", "javascript:copy_messages()", true); ?></td>
			<td width="36">
				<?php echo $we_button->create_button("image:btn_task_cut", "javascript:cut_messages()", true); ?></td>
			<td width="36">
				<?php echo $we_button->create_button("image:btn_task_paste", "javascript:paste_messages()", true); ?></td>
			<td width="36">
				<?php echo $we_button->create_button("image:btn_task_trash", "javascript:delete_messages()", true); ?></td>
			<td width="36">
				<?php echo $we_button->create_button("image:btn_task_update", "javascript:refresh()", true); ?></td>
			<td align="right">
				<?php echo $we_button->create_button("image:btn_task_messages", "javascript:launch_msg()", true); ?></td>
		</tr>
	</table>
</body>

</html>