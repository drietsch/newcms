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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/messaging.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");

protect();

$messaging = new we_messaging($_SESSION["we_data"][$_REQUEST['we_transaction']]);
$messaging->set_login_data($_SESSION["user"]["ID"], $_SESSION["user"]["Username"]);
$messaging->init($_SESSION["we_data"][$_REQUEST['we_transaction']]);


?>
<html>
  <head>
    <title><?php echo $l_messaging['folder_settings']?></title>
      <script language="JavaScript" type="text/javascript">

<?php

	if (isset($_REQUEST['mcmd']) && $_REQUEST['mcmd'] == 'save_folder_settings') {
		if ($_REQUEST['mode'] == 'new') {
		    $res = $messaging->create_folder($_REQUEST['folder_name'], $_REQUEST['parent_folder'], $_REQUEST['foldertypes']);
		} elseif ($_REQUEST["mode"] == 'edit') {
		    $res = $messaging->modify_folder($_REQUEST['fid'], $_REQUEST['folder_name'], $_REQUEST['parent_folder']);
		}
		$ID = array_shift($res);
		if ($ID >= 0) {

		    $messaging->saveInSession($_SESSION["we_data"][$_REQUEST['we_transaction']]);
		    ?>
		    top.content.messaging_cmd.location = '<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_cmd.php?we_transaction=<?php echo $_REQUEST['we_transaction']?>&mcmd=save_folder_settings&name=<?php echo $_REQUEST['folder_name']?>&id=<?php echo $ID?>&mode=<?php echo $_REQUEST['mode']?>&parent_id=<?php echo $_REQUEST['parent_folder']?>&type=<?php echo $_REQUEST['foldertypes']?>';
		    top.content.we_cmd('messaging_start_view','','<?php echo isset($_REQUEST['table']) ? $_REQUEST['table'] : "" ?>');
		    </script>
		    </head>
		    <body></body>
		    </html>
		    <?php
		    exit;
		} else {
			print we_message_reporting::getShowMessageCall($res[0], WE_MESSAGE_ERROR);
		}
	    }
	?>

	function save() {
	    document.edit_folder.submit();
	}
		//-->
		</script>

<?php

protect();

print STYLESHEET;

$we_button = new we_button();
?>
<body class="weDialogBody" style="border-top: 1px solid black;">
<form name="edit_folder" action="<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_edit_folder.php" method="post">
<?php echo hidden('we_transaction', $_REQUEST['we_transaction']);
    echo hidden('mcmd', 'save_folder_settings');
    echo hidden('mode', $_REQUEST['mode']);

    if (isset($_REQUEST['fid'])) {

	echo hidden('fid', $_REQUEST['fid']);
	}
?>
<?php
    if ($_REQUEST["mode"] == 'new') {

	$heading = $l_messaging['new_folder'];
	$acc_html = html_select('foldertypes', 1, $messaging->get_wesel_folder_types(),"","top.content.setHot();");

    } elseif ($_REQUEST["mode"] == 'edit') {

	$heading = $l_messaging['change_folder_settings'];
	$finf = $messaging->get_folder_info($_REQUEST['fid']);
	$acc_html = html_select('foldertypes', 1, $messaging->get_wesel_folder_types(), $finf['ClassName'],"top.content.setHot();");
    }

    $n = isset($finf) ? $finf['Name'] : '';
    $orgn = $n;
    $fooArray = array(
    						"sent" => $GLOBALS["l_messaging"]["folder_sent"],
    						"messages" => $GLOBALS["l_messaging"]["folder_messages"],
    						"done" => $GLOBALS["l_messaging"]["folder_done"],
    						"task" => $GLOBALS["l_messaging"]["folder_todo"],
    						"rejected" => $GLOBALS["l_messaging"]["folder_rejected"],
   							"todo" => $GLOBALS["l_messaging"]["folder_todo"]
    					);
    if(isset($fooArray[strtolower($n)])){
    	$n = $fooArray[strtolower($n)];
    	$specialfolder = true;
    }else{
    	$specialfolder = false;
    }

    $input_tbl = '<table border="0" cellpadding="5" >
	<tr>
	  <td class="defaultfont">' . $l_messaging['folder_name'] . '</td>
	  <td class="defaultfont">' . ($specialfolder ? ($n.hidden("folder_name",$orgn))  : htmlTextInput('folder_name', 24, $n, 24, 'onchange="top.content.setHot();"')) . '</td>
	</tr>
	<tr>
	  <td class="defaultfont">' . $l_messaging['parent_folder'] . '</td>
	  <td>' . html_select('parent_folder', 1, $messaging->get_wesel_available_folders(), isset($finf) ? $finf['ParentID'] : '',"top.content.setHot();") . '</td>
	</tr>
	<tr>
	  <td class="defaultfont">' . $l_messaging['type'] . '</td>
	  <td>' . $acc_html  . '</td>
	</tr>
      </table>';

    $_btn_tbl = $we_button->position_yes_no_cancel(	$we_button->create_button("save", "javascript:save()"),
													"",
													$we_button->create_button("cancel", "javascript:top.content.we_cmd('messaging_start_view','', '" . (isset($_REQUEST["table"]) ? $_REQUEST["table"] : "") . "')")
										 	 )
	;
?>
<?php print htmlDialogLayout($input_tbl, $heading, $_btn_tbl,"100%","30","","none"); ?></td>
    </form>
  </body>
</html>