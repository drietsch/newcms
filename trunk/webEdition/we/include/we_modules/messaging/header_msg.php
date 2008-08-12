<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");

?>

<html>
<head>
	<?php print STYLESHEET; ?>
	<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR ?>attachKeyListener.js"></script>
	<script language="JavaScript" type="text/javascript">
		
		function update(newmsg_count, newtodo_count) {
			var msgTD = document.getElementById("msgCount");
			var todoTD = document.getElementById("todoCount");
			msgTD.className = "middlefont" + ( (newmsg_count > 0) ? "red" : "" );
			todoTD.className = "middlefont" + ( (newtodo_count > 0) ? "red" : "" );
			msgTD.firstChild.innerHTML = newmsg_count;
			todoTD.firstChild.innerHTML = newtodo_count;
		}
		
	</script>
</head>
<body background="<?php print IMAGE_DIR ?>java_menu/background.gif" bgcolor="#bfbfbf" leftmargin="0" topmargin="0" marginheight="0" marginwidth="0">
<?php
    if (defined("MESSAGING_SYSTEM")) {
        include_once(WE_MESSAGING_MODULE_DIR . "we_messaging.inc.php");
        include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_html_tools.inc.php");
        $messaging = new we_messaging($_SESSION["we_data"]["we_transaction"]);
        $messaging->set_login_data($_SESSION["user"]["ID"], $_SESSION["user"]["Username"]);
        $messaging->add_msgobj('we_message', 1);
        $messaging->add_msgobj('we_todo', 1);
        $newmsg_count = $messaging->used_msgobjs['we_message']->get_newmsg_count();
        $newtodo_count = $messaging->used_msgobjs['we_todo']->get_newmsg_count();
        $msg_cmd = "javascript:top.we_cmd('messaging_start', 'message');";
        $todo_cmd = "javascript:top.we_cmd('messaging_start', 'todo');";
?>
<table border="0" cellpadding="0" cellspacing="0">
<?php echo '
<tr>
	<td>'.getPixel(25,2).'</td>
	<td colspan="2">'.getPixel(2,2).'</td>
</tr>
<tr>
	<td id="msgCount" align="right" class="middlefont' . ($newmsg_count ? 'red' : '') . '"><a style="text-decoration:none"  href="' . $msg_cmd . '">' . $newmsg_count . '</a></td>
	<td>' . getPixel(5, 1) . '</td>
	<td valign="bottom"><a href="' . $msg_cmd . '"><img src="'. IMAGE_DIR . 'modules/messaging/launch_messages.gif" border="0" width="16" height="12" alt=""></a></td>
</tr>
<tr>
	<td id="todoCount" align="right" class="middlefont' . ($newtodo_count ? 'red' : '') . '"><a style="text-decoration:none" href="' . $todo_cmd . '">' . $newtodo_count . '</a></td>
	<td>' . getPixel(5, 1) . '</td>
	<td valign="bottom"><a href="' . $todo_cmd . '"><img src="'. IMAGE_DIR . 'modules/messaging/launch_tasks.gif" border="0" width="16" height="12" alt=""></a></td>
</tr>'
?>
</table>
<script language="JavaScript" type="text/javascript">
if( top.weEditorFrameController && top.weEditorFrameController.getActiveDocumentReference() && top.weEditorFrameController.getActiveDocumentReference().quickstart && typeof(top.weEditorFrameController.getActiveDocumentReference().setMsgCount)=='function'&&typeof(top.weEditorFrameController.getActiveDocumentReference().setTaskCount)=='function'){
	top.weEditorFrameController.getActiveDocumentReference().setMsgCount(<?php print abs($newmsg_count); ?>);
	top.weEditorFrameController.getActiveDocumentReference().setTaskCount(<?php print abs($newtodo_count); ?>);
}
</script>

<?php } ?>

</body>

</html>
