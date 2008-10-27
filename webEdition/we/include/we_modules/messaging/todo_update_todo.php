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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
include_once(WE_MESSAGING_MODULE_DIR . "we_messaging.inc.php");
include_once(WE_MESSAGING_MODULE_DIR."messaging_format.inc.php");
include_once(WE_MESSAGING_MODULE_DIR . "msg_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/messaging.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");

protect();

htmlTop($l_messaging['wintitle'].' - Update Status');

$messaging = new we_messaging($_SESSION["we_data"][$_REQUEST['we_transaction']]);

$messaging->set_login_data($_SESSION["user"]["ID"], $_SESSION["user"]["Username"]);

$messaging->init($_SESSION["we_data"][$_REQUEST['we_transaction']]);

print STYLESHEET;

?>
    <script language="JavaScript" type="text/javascript">
	function do_confirm() {
	    document.update_todo_form.submit();
	}

	function doUnload() {
	    if(top.jsWindow_count){
		    for(i=0;i<top.jsWindow_count;i++){
			    eval("jsWindow"+i+"Object.close()");
		    }
	    }
	}
    </script>
  </head>
  <body class="weDialogBody"  onUnload="doUnload();">
<?php
$heading = $l_messaging['todo_status_update'];
$compose = new we_format('update', $messaging->selected_message);
$compose->set_login_data($_SESSION["user"]["ID"], $_SESSION["user"]["Username"]);

?>
    <form action="<?php print WE_MESSAGING_MODULE_PATH; ?>todo_update.php" name="update_todo_form" method="post">
<?php
	echo hidden('we_transaction', $_REQUEST['we_transaction']);
	echo hidden('rcpts_string', '');
	echo hidden('mode', $_REQUEST['mode']);

    $parts = array();
	array_push	($parts, array(	"headline" => $l_messaging['assigner'],
								"html"     => $compose->get_from(),
								"space"    => 120,
								"noline"   => 1
								)
				);
	array_push	($parts, array(	"headline" => $l_messaging['subject'],
								"html"     => $compose->get_subject(),
								"space"    => 120,
								"noline"   => 1
								)
				);
	array_push	($parts, array(	"headline" => $l_messaging['deadline'],
								"html"     => getDateInput2('td_deadline%s', $compose->get_deadline()),
								"space"    => 120,
								"noline"   => 1
								)
				);
	array_push	($parts, array(	"headline" => $l_messaging['status'],
								"html"     => htmlTextInput('todo_status', 4, $messaging->selected_message['hdrs']['status']) . ' %',
								"space"    => 120,
								"noline"   => 1
								)
				);
	array_push	($parts, array(	"headline" => $l_messaging['priority'],
								"html"     => html_select('todo_priority', 1, array(1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6, 7=>7, 8=>8, 9=>9, 10=>10), $compose->get_priority()),
								"space"    => 120,
								)
				);

	//	message
	array_push	($parts, array(	"headline" => "",
								"html"     => $compose->get_msg_text(),
								"space"    => 0,
								"noline"   => 1
								)
				);
	array_push	($parts, array(	"headline" => "",
								"html"     => $compose->get_todo_history(),
								"space"    => 0,
								)
				);

	array_push	($parts, array(	"headline" => $l_messaging['comment'],
								"html"     => '<textarea cols="40" rows="8" name="todo_comment"></textarea>',
								"space"    => 120,
								)
				);

	$we_button = new we_button();

	$buttons = $we_button->position_yes_no_cancel(	$we_button->create_button("ok", "javascript:do_confirm();"),
    												"",
    												$we_button->create_button("cancel", "javascript:top.window.close()")
    											);
    print we_multiIconBox::getHTML("todoStatusUpdate", "100%", $parts, 30, $buttons, -1, "", "", false, $heading);
?>
    </form>
  </body>
</html>
