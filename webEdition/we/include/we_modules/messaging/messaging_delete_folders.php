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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_live_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_delete_fn.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/alert.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/messaging.inc.php");
include_once(WE_MESSAGING_MODULE_DIR . "we_messaging.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");

protect();

htmlTop();

print STYLESHEET;

$we_button = new we_button();

$messaging = new we_messaging($_SESSION["we_data"][$_REQUEST['we_transaction']]);
$messaging->set_login_data($_SESSION["user"]["ID"], $_SESSION["user"]["Username"]);
$messaging->init($_SESSION["we_data"][$_REQUEST['we_transaction']]);

?>
<script language="JavaScript" type="text/javascript"><!--
	function we_submitForm(target,url) {
		var f = self.document.we_form;
		var sel = "";
		for(var i=1;i<=top.menuDaten.laenge;i++) {
			if(top.menuDaten[i].checked)
				sel += (top.menuDaten[i].name+",");
		}
		if(!sel) {
			top.toggleBusy(0);
			<?php print we_message_reporting::getShowMessageCall( $l_alert["nothing_to_delete"], WE_MESSAGE_ERROR ); ?>
			return;
		}
		sel = sel.substring(0,sel.length-1);
		f.sel.value = sel;
		f.target = target;
		f.action = url;
		f.method = "post";
		f.submit();
	}

	function do_delete() {
		document.we_form.folders.value = top.content.entries_selected.join(",");
		document.we_form.submit();
	}

	<?php
	if (isset($_REQUEST['mcmd']) && $_REQUEST['mcmd'] == 'delete_folders') {
		$folders = explode(',', $_REQUEST['folders']);

        if($folders[0] != ""){

		    $res = $messaging->delete_folders($folders);
		    $v = array_shift($res);
		    if ($v > 0) {

    		    $messaging->saveInSession($_SESSION["we_data"][$_REQUEST['we_transaction']]);
	    	    ?>
		        top.content.messaging_cmd.location = '<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_cmd.php?we_transaction=<?php echo $_REQUEST['we_transaction']?>&mcmd=delete_folders&folders=<?php echo join(',', $v)?>';
		        top.content.we_cmd('messaging_start_view','','<?php echo isset($_REQUEST['table']) ? $_REQUEST['table'] : '' ?>');
		        //-->
		        </script>
		        </head>
		        <body></body>
		        </html>
    		    <?php
		        exit;
		    } else {
    		    echo we_message_reporting::getShowMessageCall( $l_messaging['err_delete_folders'], WE_MESSAGE_ERROR );
		    }
		}
    }
	?>

//-->
</script>

<?php
$content = "<span class=\"defaultfont\">" . $l_messaging['deltext'] . "</span>";

$form = '<form name="we_form" method="post">' .
    hidden('we_transaction', $_REQUEST['we_transaction']) .
    hidden('folders','') .
    hidden('mcmd', 'delete_folders')
    .
    '</form>';

$_buttons = $we_button->position_yes_no_cancel(	$we_button->create_button("ok", "javascript:do_delete()"),
    											"",
    											$we_button->create_button("cancel","javascript:top.content.we_cmd('messaging_start_view')")
    								   			);
?>
</head>

<body bgcolor="white" marginwidth="10" marginheight="10" leftmargin="10" topmargin="10" background="/webEdition/images/msg_white_bg.gif">
<?php echo htmlMessageBox(400,120,$content,$l_messaging['rm_folders'], $_buttons)?>
<?php echo $form ?>
</body>

</html>