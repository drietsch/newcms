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
include_once(WE_MESSAGING_MODULE_DIR . "we_messaging.inc.php");
include_once(WE_MESSAGING_MODULE_DIR."messaging_format.inc.php");
include_once(WE_MESSAGING_MODULE_DIR . "msg_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/messaging.inc.php");
include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");

$messaging = new we_messaging($_SESSION["we_data"][$_REQUEST['we_transaction']]);
$messaging->set_login_data($_SESSION["user"]["ID"], $_SESSION["user"]["Username"]);
$messaging->init($_SESSION["we_data"][$_REQUEST['we_transaction']]);
$messaging->get_mv_data($_REQUEST["id"]);
$messaging->saveInSession($_SESSION["we_data"][$_REQUEST['we_transaction']]);

if(sizeof($messaging->selected_message) == 0){
    exit;
}

$format = new we_format('view', $messaging->selected_message);
$format->set_login_data($_SESSION["user"]["ID"], $_SESSION["user"]["Username"]);

htmlTop();

protect();

print STYLESHEET;

$parts = array();

?>
    <style>
	.quote_lvl_0 {}
	.quote_lvl_1 {color:#ff0000}
	.quote_lvl_2 {color:#00ff00}
	.quote_lvl_3 {color:#0000ff}
    </style>
    <script language="JavaScript" type="text/javascript">
	function todo_markdone() {
	    top.content.messaging_cmd.location = '<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_cmd.php?mcmd=todo_markdone&we_transaction=<?php echo $_REQUEST['we_transaction']?>';
	}
    </script>
  </head>
  <body class="weDialogBody">

<?php
if (isset($messaging->selected_message['hdrs']['ClassName']) && $messaging->selected_message['hdrs']['ClassName'] == 'we_todo') {	//	TODO

	array_push($parts,array(	"headline" => $l_messaging['subject'],
								"html"     => "<b>" . $format->get_subject() . "</b>",
								"noline"   => 1,
								"space"    => 140
							)
				);

	array_push($parts,array(	"headline" => $l_messaging['deadline'],
								"html"     => $format->get_deadline(),
								"noline"   => 1,
								"space"    => 140
							)
				);

	$we_button = new we_button();

	$html = '<table border="0" cellpadding="0" cellspacing="0"><tr><td class="defaultfont">'. $messaging->selected_message['hdrs']['status'].'%</td><td>'.getPixel(20,2).
				(($messaging->selected_message['hdrs']['status'] < 100) ? '<td>'.$we_button->create_button(
								"percent100",
								"javascript:todo_markdone()").'</td>' : '') . '</tr></table>';


	array_push($parts,array(	"headline" => $l_messaging['status'],
								"html"     => $html,
								"noline"   => 1,
								"space"    => 140
							)
				);

	array_push($parts,array(	"headline" => $l_messaging['created_by'],
								"html"     => $format->get_from(),
								"noline"   => 1,
								"space"    => 140
							)
				);

	array_push($parts,array(	"headline" => $l_messaging['assigned_by'],
								"html"     => $format->get_assigner(),
								"noline"   => 1,
								"space"    => 140
							)
				);

	array_push($parts,array(	"headline" => $l_messaging['creation_date'],
								"html"     => $format->get_date(),
								"space"    => 140
							)
				);

	array_push($parts,array("headline" => "",
							"html"     => $format->get_msg_text(),
							"space"    => 0
							)
				);

	if (isset($messaging->selected_message['hdrs']['ClassName']) && $messaging->selected_message['hdrs']['ClassName'] == 'we_todo' && ($h = $format->get_todo_history())) {
	    array_push($parts,array("headline" => "",
							"html"     => $format->get_todo_history(),
							"noline"   => 1,
							"space"    => 0
							)
				);

	}

} else {	//	Message

	array_push($parts,array(	"headline" => $l_messaging['subject'],
								"html"     => "<b>" . $format->get_subject() . "</b>",
								"noline"   => 1,
								"space"    => 80
							)
				);

	array_push($parts,array("headline" => $l_messaging['from'],
							"html"     => $format->get_from(),
							"noline"   => 1,
							"space"    => 80
							)
				);
	array_push($parts,array("headline" => $l_messaging['date'],
							"html"     => $format->get_date(),
							"noline"   => (empty($messaging->selected_message['hdrs']['To']) ? null : 1),
							"space"    => 80
							)
				);
	if(!empty($messaging->selected_message['hdrs']['To'])){
		array_push($parts,array("headline" => $l_messaging['recipients'],
								"html"     => $messaging->selected_message['hdrs']['To'],
								"space"    => 80
								)
				);
	}

	array_push($parts,array("headline" => "",
							"html"     => $format->get_msg_text(),
							"noline"   => 1,
							"space"    => 0
							)
				);
}

print we_multiIconBox::getJS();
print we_multiIconBox::getHTML(	"weMessageView",
							"100%",
							$parts,
							30,
							"",
							-1,
							"",
							"",
							false,
							(isset($messaging->selected_message['hdrs']['ClassName']) && $messaging->selected_message['hdrs']['ClassName'] == 'we_todo' ? $l_messaging["type_todo"] : $l_messaging["type_message"]));

?>
  </body>
</html>
