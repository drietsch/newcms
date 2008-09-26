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
include_once(WE_MESSAGING_MODULE_DIR . "we_messaging.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_html_tools.inc.php");

htmlTop();
protect();

function print_fc_html($blank = true) {
	global $messaging;
?>
	<script language="JavaScript" type="text/javascript">
	<!--
		top.content.update_msg_quick_view();
		top.content.messaging_main.messaging_right.msg_work.entries_selected = new Array(<?php echo $messaging->get_ids_selected()?>);
		top.content.messaging_main.messaging_right.msg_work.messaging_fv_headers.location="<?php echo $messaging->url(WE_MESSAGING_MODULE_PATH.'messaging_fv_headers.php') . '?si=' . $messaging->get_sortitem() . '&so=' . $messaging->get_sortorder();?>&viewclass=" + top.content.viewclass;
		if (top.content.messaging_main.messaging_right.msg_work.msg_mfv.messaging_messages_overview) {
			top.content.messaging_main.messaging_right.msg_work.msg_mfv.messaging_messages_overview.location="<?php echo $messaging->url(WE_MESSAGING_MODULE_PATH. 'messaging_show_folder_content.php');?>";
		}


		<?php
			if ($blank) {
				echo 'top.content.messaging_main.messaging_right.msg_work.msg_mfv.messaging_msg_view.location="' .  HTML_DIR . 'white.html";';
			}
		?>
	//-->
	</script>
<?php
}

function refresh_work($blank = false) {
	global $messaging;

	if (isset($_REQUEST["entrsel"]) && $_REQUEST["entrsel"] != '')

	    $messaging->set_ids_selected($_REQUEST["entrsel"]);

	$messaging->get_fc_data($messaging->Folder_ID, '', '', 0);
	print_fc_html($blank);
	update_treeview();
}

function get_folder_content($id, $sort = '', $entrsel = '', $searchterm = '', $usecache = 1) {

	global $messaging;

	if ($entrsel != '')
		$messaging->set_ids_selected($entrsel);

	if ($id != $messaging->Folder_ID) {
		$messaging->reset_ids_selected();
?>
	<script language="JavaScript" type="text/javascript">
	<!--
		top.content.messaging_main.messaging_right.msg_work.last_entry_selected = -1;
	//-->
	</script>
<?php
	}
	$messaging->get_fc_data(isset($id) ? $id : '', empty($sort) ? '' : $sort, $searchterm, $usecache);

	$messaging->saveInSession($_SESSION["we_data"][$_REQUEST['we_transaction']]);
}

function update_treeview() {
	global $messaging;
	echo '<script language="JavaScript" type="text/javascript">
	<!--' . "\n";

	foreach ($messaging->available_folders as $f) {

	echo 'top.content.updateEntry(' . $f['ID'] . ', ' . $f['ParentID'] . ', "' . $f['Name'] . ' - (' . $messaging->get_message_count($f['ID'], '') . ')", -1, 1);' . "\n";
	}
	echo "top.content.drawEintraege();\n//--></script>";
}

if(!isset($_REQUEST["we_transaction"])){
    $_REQUEST["we_transaction"] = $we_transaction;
}

$messaging = new we_messaging($_SESSION["we_data"][$_REQUEST["we_transaction"]]);
$messaging->set_login_data($_SESSION["user"]["ID"], $_SESSION["user"]["Username"]);


$messaging->init($_SESSION["we_data"][$_REQUEST["we_transaction"]]);

if(!isset($_REQUEST["mcmd"])){
    $_REQUEST["mcmd"] = "goToDefaultCase";
}


switch($_REQUEST["mcmd"]) {
    case 'search_messages':
    case 'show_folder_content':
	get_folder_content(isset($_REQUEST['id']) ? $_REQUEST['id'] : "", isset($_REQUEST['sort']) ? $_REQUEST['sort'] : "" , isset($_REQUEST['entrsel']) ? $_REQUEST['entrsel'] : "", isset($_REQUEST['searchterm']) ? $_REQUEST['searchterm'] : "", 1);
	print_fc_html();
	update_treeview();
	break;
    case 'launch':
	if ($_REQUEST['mode'] == 'todo') {
	    $f = $messaging->get_inbox_folder('we_todo');
	} elseif ($_REQUEST['mode'] == 'message') {
	    $f = $messaging->get_inbox_folder('we_message');
	} else {
	    break;
	}

	get_folder_content($f['ID'], '', '', '', 0);
	print_fc_html();
	update_treeview();
	?><script language="JavaScript" type="text/javascript">
	  <!--
		if (top.content.viewclass != '<?php echo $_REQUEST['mode']?>') {
		    top.content.set_frames('<?php echo $_REQUEST['mode']?>');
		}
      //-->
	  </script>
	<?php
	break;
    case 'refresh_mwork':
	refresh_work(true);
	/* FALLTHROUGH */
    case 'show_message':
	if (isset($id)) {
	    ?>
		<script language="JavaScript" type="text/javascript">
		<!--
		    top.content.messaging_main.messaging_right.msg_work.msg_mfv.messaging_msg_view.location="<?php print WE_MESSAGING_MODULE_PATH . "messaging_message_view.php?we_transaction=" . $_REQUEST['we_transaction'] . "&id=$id"?>";
		//-->
		</script>
	    <?php
	}
	$messaging->saveInSession($_SESSION["we_data"][$_REQUEST["we_transaction"]]);
	break;
    case 'new_message':
	?>

	<script language="JavaScript" type="text/javascript" src="<?php echo JS_DIR?>windows.js"></script>
	<script language="JavaScript" type="text/javascript">
	<!--
	    new jsWindow("<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_newmessage.php?we_transaction=<?php echo $_REQUEST['we_transaction']?>&mode=<?php echo $_REQUEST['mode']?>", "messaging_new_message",-1,-1,670,530,true,false,true,false);
    //-->
	</script>
<?php
		break;
	case 'new_todo':
?>
	<script language="JavaScript" type="text/javascript" src="<?php echo JS_DIR?>windows.js"></script>
	<script language="JavaScript" type="text/javascript">
	<!--
	    new jsWindow("<?php print WE_MESSAGING_MODULE_PATH; ?>todo_edit_todo.php?we_transaction=<?php echo $_REQUEST['we_transaction']?>&mode=new", "messaging_new_todo",-1,-1,690,520,true,false,true,false);
    //-->
	</script>
<?php
		break;
	case 'forward_todo':
?>
	<script language="JavaScript" type="text/javascript" src="<?php echo JS_DIR?>windows.js"></script>
	<script language="JavaScript" type="text/javascript">
	<!--
	    new jsWindow("<?php print WE_MESSAGING_MODULE_PATH; ?>todo_edit_todo.php?we_transaction=<?php echo $_REQUEST['we_transaction']?>&mode=forward", "messaging_new_todo",-1,-1,690,600,true,false,true,false);
    //-->
	</script>
<?php
		break;
	case 'rej_todo':
?>
	<script language="JavaScript" type="text/javascript" src="<?php echo JS_DIR?>windows.js"></script>

	<script language="JavaScript" type="text/javascript">
	<!--
	    new jsWindow("<?php print WE_MESSAGING_MODULE_PATH; ?>todo_edit_todo.php?we_transaction=<?php echo $_REQUEST['we_transaction']?>&mode=reject", "messaging_new_todo",-1,-1,690,600,true,false,true,false);
    //-->
	</script>
<?php
		break;
	case 'reset_right_view':
?>
	<script language="JavaScript" type="text/javascript">
	<!--
		top.content.messaging_main.messaging_right.msg_work.entries_selected = new Array();
		top.content.messaging_main.messaging_right.msg_work.msg_mfv.messaging_messages_overview.location="<?php echo $messaging->url(WE_MESSAGING_MODULE_PATH . 'messaging_show_folder_content.php');?>";
		top.content.messaging_main.messaging_right.msg_work.msg_mfv.messaging_msg_view.location="<?php echo HTML_DIR?>white.html";
	//-->
	</script>
	<?php
	break;
    case 'update_todo':
	if (!empty($messaging->selected_message)) {
	    ?>
	    <script language="JavaScript" type="text/javascript" src="<?php echo JS_DIR?>windows.js"></script>
	    <script language="JavaScript" type="text/javascript">
	    <!--
		new jsWindow("<?php print WE_MESSAGING_MODULE_PATH; ?>todo_update_todo.php?we_transaction=<?php echo $_REQUEST['we_transaction']?>&mode=reject", "messaging_new_todo",-1,-1,690,600,true,false,true,false);
		//-->
	    </script>
	    <?php
	}
	break;
    case 'todo_markdone':
	    $arr = array('todo_status' => '100');
	    $messaging->used_msgobjs['we_todo']->update_status($arr, $messaging->selected_message['int_hdrs']);
    	refresh_work(true);
	    $messaging->saveInSession($_SESSION["we_data"][$_REQUEST['we_transaction']]);
	    break;
    case 'copy_msg':
    	$messaging->set_clipboard($_REQUEST['entrsel'], 'copy');
    	$messaging->saveInSession($_SESSION["we_data"][$_REQUEST['we_transaction']]);
    	break;
    case 'cut_msg':
    	$messaging->set_clipboard($_REQUEST['entrsel'], 'cut');
    	$messaging->saveInSession($_SESSION["we_data"][$_REQUEST['we_transaction']]);
    	break;
    case 'paste_msg':
    	$errs = array();
    	$messaging->clipboard_paste($errs);
    	$messaging->reset_ids_selected();
    	$messaging->get_fc_data($messaging->Folder_ID, '', '', 0);

    	$messaging->saveInSession($_SESSION["we_data"][$_REQUEST['we_transaction']]);
	?>
	    <script language="JavaScript" type="text/javascript">

		top.content.messaging_main.messaging_right.msg_work.entries_selected = new Array();
		top.content.messaging_main.messaging_right.msg_work.messaging_fv_headers.location="<?php echo $messaging->url(WE_MESSAGING_MODULE_PATH.'messaging_fv_headers.php') . '&si=' . $messaging->get_sortitem() . '&so=' . $messaging->get_sortorder();?>&viewclass=" + top.content.viewclass;
		top.content.messaging_main.messaging_right.msg_work.msg_mfv.messaging_messages_overview.location="<?php echo $messaging->url(WE_MESSAGING_MODULE_PATH . 'messaging_show_folder_content.php');?>";
		top.content.messaging_main.messaging_right.msg_work.msg_mfv.messaging_msg_view.location="<?php echo HTML_DIR?>white.html";

		<?php
			$aid =  $messaging->Folder_ID;
			$idx = array_ksearch('ID', $aid, $messaging->available_folders);
			if ($idx > -1) {

		?>

			aid = <?php echo $aid?>;
			top.content.updateEntry(aid, -1, "<?php echo $messaging->available_folders[$idx]['Name'] . ' - (' . $messaging->get_message_count($aid, '') . ')';?>", -1, 1);
		<?php } ?>

	    </script>
	<?php
    	update_treeview();
    	break;
    case 'delete_msg':
	    $messaging->set_ids_selected($_REQUEST['entrsel']);
	    $messaging->delete_items();
	    $messaging->reset_ids_selected();
	    $messaging->get_fc_data(isset($_REQUEST['id']) ? $_REQUEST['id'] : '',     empty($_REQUEST['sort']) ? '' : $_REQUEST['sort'], isset($_REQUEST['searchterm']) ? $_REQUEST['searchterm'] : '', 1);

    	$messaging->saveInSession($_SESSION["we_data"][$_REQUEST['we_transaction']]);
	?>
	    <script language="JavaScript" type="text/javascript">
	<!--
		top.content.messaging_main.messaging_right.msg_work.entries_selected = new Array();
		top.content.messaging_main.messaging_right.msg_work.messaging_fv_headers.location="<?php echo $messaging->url(WE_MESSAGING_MODULE_PATH.'messaging_fv_headers.php') . '&si=' . $messaging->get_sortitem() . '&so=' . $messaging->get_sortorder();?>&viewclass" + top.content.viewclass;
		top.content.messaging_main.messaging_right.msg_work.msg_mfv.messaging_messages_overview.location="<?php echo $messaging->url(WE_MESSAGING_MODULE_PATH . 'messaging_show_folder_content.php');?>";
		top.content.messaging_main.messaging_right.msg_work.msg_mfv.messaging_msg_view.location="<?php echo HTML_DIR?>white.html";
		<?php $aid =  $messaging->Folder_ID;?>

		aid = <?php echo $aid?>;
		top.content.updateEntry(aid, -1, "<?php echo $messaging->available_folders[array_ksearch('ID', $aid, $messaging->available_folders)]['Name'] . ' - (' . $messaging->get_message_count($aid, '') . ')';?>", -1, 1);
		//-->
	    </script>
	<?php
	    break;
    case 'update_treeview':
	    update_treeview();
	    break;
    case 'update_msgs':
    	update_treeview();
    	$blank = false;
    	/* FALLTHROUGH */
    case 'update_fcview':
    	$id = $messaging->Folder_ID;
    	$blank = isset($blank) ? $blank : true;
    	if (($messaging->cont_from_folder != 1) && ($id != -1)) {
	        if (isset($_REQUEST['entrsel']) && $_REQUEST['entrsel'] != '')
		        $messaging->set_ids_selected($_REQUEST['entrsel']);

    	        $messaging->get_fc_data($id, empty($_REQUEST['sort']) ? '' : $_REQUEST['sort'], '', 0);

	            $messaging->saveInSession($_SESSION["we_data"][$_REQUEST['we_transaction']]);
	            print_fc_html($blank);
	    }
	    break;
    case 'edit_folder':
	    if ($_REQUEST['mode'] == 'new' || ($_REQUEST['mode'] == 'edit')) {
    	    ?>
	        <script language="JavaScript" type="text/javascript">
	        <!--
		top.content.messaging_main.messaging_right.msg_work.location = "<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_edit_folder.php?we_transaction=<?php echo $_REQUEST['we_transaction']?>&mode=<?php echo $_REQUEST['mode']?>&fid=<?php echo (isset($_REQUEST['fid']) ? $_REQUEST['fid'] : -1) ?>";
		//-->
	    </script>
	    <?php
	    }
    	break;
    case 'save_folder_settings':
	if (isset($_REQUEST['id'])) {
	    $mcount = $_REQUEST['mode'] == 'new' ? 0 : $messaging->get_message_count($_REQUEST['id'], '');
	    if ($_REQUEST["mode"] == 'new') {
		?>
		<script language="JavaScript" type="text/javascript">
		<!--
		    top.content.folder_added(<?php echo $_REQUEST['parent_id']?>);
		    top.content.menuDaten.add(new top.content.urlEntry('<?php echo ($_REQUEST['type'] == 'we_todo' ? 'todo_folder' : 'msg_folder')?>.gif', '<?php echo $_REQUEST['id']?>', '<?php echo $_REQUEST['parent_id']?>', '<?php echo $_REQUEST['name'] . ' - (0)'?>', 'leaf_Folder', '<?php print MESSAGES_TABLE; ?>', '<?php echo ($_REQUEST['type'] == 'we_todo' ? 'todo_folder' : 'msg_folder')?>'));
		    <?php print we_message_reporting::getShowMessageCall( $l_messaging['folder_created'], WE_MESSAGE_NOTICE ); ?>
		    top.content.drawEintraege();
		//-->
		</script>
		<?php
	    } else {
		?>
		<script language="JavaScript" type="text/javascript">
		<!--

		top.content.menuDaten.clear();
		<?php

		$entries=array();

		print "top.content.startloc=0;\n";
		print "top.content.menuDaten.add(new top.content.self.rootEntry('0','root','root'));\n";
		foreach ($messaging->available_folders as $folder)
		    if (($sf_cnt = $messaging->get_subfolder_count($folder['ID'], '')) >= 0) {
			    print "  top.content.menuDaten.add(new top.content.dirEntry('" . ($folder['ClassName'] == 'we_todo' ? 'todo_folder' : 'msg_folder') . ".gif','" . $folder['ID']."','" . $folder['ParentID'] . "','" . $folder['Name'] . ' - (' . $messaging->get_message_count($folder['ID'], '') . ")',false,'parent_Folder','".MESSAGES_TABLE."', " . $sf_cnt . ", '" . ($folder['ClassName'] == 'we_todo' ? 'todo_folder' : 'msg_folder') . "') );\n";
		    } else {
			    print "  top.content.menuDaten.add(new top.content.urlEntry('" . ($folder['ClassName'] == 'we_todo' ? 'todo_folder' : 'msg_folder') . ".gif','" . $folder['ID'] . "','" . $folder['ParentID'] . "','" . $folder['Name'] . ' - (' . $messaging->get_message_count($folder['ID'], '') . ")','leaf_Folder','".MESSAGES_TABLE."', '" . ($folder['ClassName'] == 'we_todo' ? 'todo_folder' : 'msg_folder') . "'));\n";
		    }

		$messaging->saveInSession($_SESSION["we_data"][$_REQUEST['we_transaction']]);
		?>
		top.content.drawEintraege();
        //-->
		</script>
		<?php
	    }
	}
    	break;
    case 'delete_folders':
    	if (!empty($_REQUEST['folders'])) {
	        $folders = explode(',', $_REQUEST['folders']);

    	    ?>
	        <script language="JavaScript" type="text/javascript">
	        <!--

		    top.content.delete_menu_entries(new Array(String(<?php echo join('), String(', $folders)?>)));
		    top.content.folders_removed(new Array(String(<?php echo join('), String(', $folders)?>)));
    		top.content.drawEintraege();
            //-->
	    </script>
	    <?php
	    }
	    break;
    case 'edit_settings':
        ?>
   	    <script language="JavaScript" type="text/javascript" src="<?php echo JS_DIR?>windows.js"></script>
        <script language="JavaScript" type="text/javascript">
        <!--
	    new jsWindow("<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_settings.php?we_transaction=<?php echo    $_REQUEST['we_transaction']?>&mode=<?php echo $_REQUEST['mode']?>", "messaging_settings",-1,-   1,280,200,true,false,true,false);
	    //-->
        </script>
        <?php
        break;
    case 'save_settings':
    	if ($ui) {
	        if ($messaging->save_settings(array('update_interval' => $ui))) {
		    ?>
		    <script language="JavaScript" type="text/javascript" src="<?php echo JS_DIR?>messaging_std.js"></script>
		    <script language="JavaScript" type="text/javascript">
    		<!--
    			<?php print we_message_reporting::getShowMessageCall( $l_messaging['saved'], WE_MESSAGE_NOTICE ); ?>
		        close_win("messaging_settings");
		    //-->
		    </script>
		    <?php
	        }
	    }
	    break;
    case 'messaging_close':
	    ?>
	    <script language="JavaScript" type="text/javascript">
	    <!--
    	    top.close();
    	//-->
    	</script>
	    <?php
	    break;
    default:
    	echo 'mcmd=' . $_REQUEST['mcmd'] . '<br>';
}
?>
</head>

<body>
</body>

</html>