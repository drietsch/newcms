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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once(WE_MESSAGING_MODULE_DIR . "we_messaging.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/messaging.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");

if(is_array($_SESSION["we_data"][$_REQUEST['we_transaction']])) {

	$messaging = new we_messaging($_SESSION["user"]["ID"]);
	$messaging = new we_messaging($_SESSION["we_data"][$_REQUEST['we_transaction']]);
	$messaging->set_login_data($_SESSION["user"]["ID"], $_SESSION["user"]["Username"]);
	$messaging->init($_SESSION["we_data"][$_REQUEST['we_transaction']]);
	
	$arr = array('rcpts_string' => $_REQUEST['rcpts_string'], 'subject' => $_REQUEST['mn_subject'], 'body' => $_REQUEST['mn_body']);
	
	$res = $messaging->send($arr);
} else {
	include_once(WE_MESSAGING_MODULE_DIR."messaging_interfaces.inc.php");
	$errs = array();
	$rcpts = array(urldecode($_REQUEST['rcpts_string'])); /* user names */
	$res = msg_new_message($rcpts,$_REQUEST['mn_subject'],$_REQUEST['mn_body'],$errs);
}
?>
<html>
	<head>
		<title><?php echo $l_messaging['message_send']?></title>
		<?php
			print STYLESHEET;

			$we_button = new we_button();
		?>
		<?php
		
		    if(!empty($res['ok'])){
		    if(substr($_REQUEST["mode"],0,2) != 'u_') {
		    echo "
        <script language=\"javascript\">
        	if (opener && opener.top && opener.top.content) {
			    opener.top.content.update_messaging();
			    opener.top.content.update_msg_quick_view();
        	}
		    </script>
		    ";		    
		    } else {
          echo "
          <script language=\"javascript\">
          	if (opener && opener.top && opener.top.content) {
		    	  opener.top.content.update_msg_quick_view();
          	}	  
		    </script>
		      ";
		    }  
		    }
		?>
	</head>

	<body class="weDialogBody">
		<?php
			$tbl = '
				<table align="center" cellpadding="7" cellspacing="3" width="100%">
					' . (empty($res['ok']) ? '' : '
					<tr>
						<td class="defaultfont" valign="top">
							' . $l_messaging['s_sent_to'] . ':</td>
						<td class="defaultfont">
							<ul>
								<li>
									' . join("</li>\n<li>", $res['ok']) . '</li></ul></td>
					</tr>
					') . (empty($res['failed']) ? '' : '
						<tr>
							<td class="defaultfont" valign="top">
								' . $l_messaging['n_sent_to'] . ':</td>
							<td class="defaultfont">
								<ul>
									<li>
										' . join("</li>\n<li>", $res['failed']) . '</li></ul></td>
						</tr>
					') . (empty($res['err']) ? '' : '
						<tr>
							<td class="defaultfont" valign="top">
								' . $l_messaging['occured_errs'] . ':</td>
							<td class="defaultfont">
								<ul>
									<li>
										' . join("</li>\n<li>", $res['err']) . '</li></ul></td>
						</tr>') . '
				</table>';
			echo htmlDialogLayout($tbl, $l_messaging['message_send'] . '...',$we_button->create_button("ok", "javascript:window.close()"),"100%","20","","hidden");
		?>
	</body>

</html>