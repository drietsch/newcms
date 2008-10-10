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

protect();

$messaging = new we_messaging($_SESSION["we_data"][$_REQUEST['we_transaction']]);
$messaging->set_login_data($_SESSION["user"]["ID"], $_SESSION["user"]["Username"]);
$messaging->init($_SESSION["we_data"][$_REQUEST['we_transaction']]);

if(isset($_REQUEST['td_deadline_hour'])){
    $deadline = mktime($_REQUEST['td_deadline_hour'], $_REQUEST['td_deadline_minute'], 0, $_REQUEST['td_deadline_month'], $_REQUEST['td_deadline_day'], $_REQUEST['td_deadline_year']);
}

if ($_REQUEST["mode"] == 'forward') {
    $arr = array('rcpts_string' => $_REQUEST['rcpts_string'], 'deadline' => $deadline, 'body' => $_REQUEST['mn_body']);
    $res = $messaging->forward($arr);
    $heading = $l_messaging['forwarding_todo'];
    $action = $l_messaging['forwarded_to'];
    $s_action = $l_messaging['todo_s_forwarded'];
    $n_action = $l_messaging['todo_n_forwarded'];
} elseif ($_REQUEST["mode"] == 'reject') {
    $arr = array('body' => $_REQUEST['mn_body']);
    $res = $messaging->reject($arr);
    $heading = $l_messaging['rejecting_todo'];
    $action = $l_messaging['rejected_to'];
    $s_action = $l_messaging['todo_s_rejected'];
    $n_action = $l_messaging['todo_n_rejected'];
} else {
    $arr = array('rcpts_string' => $_REQUEST['rcpts_string'], 'subject' => $_REQUEST['mn_subject'], 'body' => $_REQUEST['mn_body'], 'deadline' => $deadline, 'status' => 0, 'priority' => $_REQUEST['mn_priority']);
    $res = $messaging->send($arr, "we_todo");
    $heading = $l_messaging['creating_todo'];
    $s_action = $l_messaging['todo_s_created'];
    $n_action = $l_messaging['todo_n_created'];


}
?>
<html>
    <head>
        <title><?php echo $heading ?></title>
        <?php print STYLESHEET; ?>
        <script language="JavaScript" type="text/javascript">
        <!--
        top.opener.top.content.messaging_cmd.location = "<?php print WE_MESSAGING_MODULE_PATH . 'messaging_cmd.php?mcmd=refresh_mwork&we_transaction=' . $_REQUEST['we_transaction']?>";
        //-->
        </script>
		<?php
        if(!empty($res['ok'])){
		    echo "
        <script language=\"javascript\">
        if (opener && opener.top && opener.top.content) {
		    top.opener.top.content.update_messaging();
		    top.opener.top.content.update_msg_quick_view();
        }
		</script>
		    ";
		    }
		?>
    </head>

    <body class="weDialogBody">
    <?php
    $tbl = '<table align="center" cellpadding="7" cellspacing="3">
		    <tr>
		      <td class="defaultfont" valign="top">' . $s_action . ':</td>
		      <td class="defaultfont"><ul><li>' . (empty($res['ok']) ? $l_messaging['nobody'] : join("</li>\n<li>", $res['ok'])) . '</li></ul></td>
		    </tr>
		    ' . (empty($res['failed']) ? '' : '<tr>
		        <td class="defaultfont" valign="top">' . $n_action . ':</td>
		        <td class="defaultfont"><ul><li>' . join("</li>\n<li>", $res['failed']) . '</li></ul></td>
		    </tr>') .
		    (empty($res['err']) ? '' : '<tr>
		        <td class="defaultfont" valign="top">' . $l_messaging['occured_errs'] . ':</td>
		        <td class="defaultfont"><ul><li>' . join("</li>\n<li>", $res['err']) . '</li></ul></td>
		    </tr>') . '
	    </table>
	';
	$we_button = new we_button();
	echo htmlDialogLayout($tbl, $heading, $we_button->create_button("ok", "javascript:top.window.close()"),"100%","30","","hidden");
    ?>
    </body>
</html>