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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_browser_check.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_browserDetect.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/date.inc.php");
include_once(WE_MESSAGING_MODULE_DIR . "we_messaging.inc.php");

htmlTop();

print STYLESHEET;

$browser = new we_browserDetect();
?>
 <script language="JavaScript" type="text/javascript" src="<?php print JS_DIR; ?>windows.js"></script>
 <script language="JavaScript" type="text/javascript" src="<?php print JS_DIR; ?>messaging_std.js"></script>
 <script language="JavaScript" type="text/javascript">
    NN4 = <?php echo $browser->getBrowser() == 'nn' && $browser->getBrowserVersion() < 5 ? 'true' : 'false'?>;
    check0_img = new Image();
    check1_img = new Image();
    check0_img.src = "<?php echo TREE_IMAGE_DIR?>check0.gif";
    check1_img.src = "<?php echo TREE_IMAGE_DIR?>check1.gif";
    read_img = new Image();
    read_img.src = "<?php echo IMAGE_DIR?>msg_read.gif";

    sel_color = "#006DB8";
    sel_text_color = "#ffffff";
    default_text_color = "#000000";
    default_color = "#ffffff";

    passed_dls = new Array();

    function showContent(id) {
		top.content.messaging_main.messaging_right.msg_work.msg_mfv.messaging_msg_view.location="<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_message_view.php?id=" + id + "&we_transaction=<?php echo $_REQUEST['we_transaction']?>";
    }

    function check(elem, groupSel) {
		var i, j;
	
		var id = parseInt(elem.match(/\d+/));
	
		if (top.content.multi_select == false) {
			
		    //de-select all selected entries
		    for (j = 0; j < parent.parent.entries_selected.length; j++) {
			    highlight_TR(parent.parent.entries_selected[j], default_color, default_text_color);
		    }
	
		    parent.parent.entries_selected = new Array();
		    doSelectMessage(id);
		} else {
			
		    if (array_search(id, parent.parent.entries_selected) != -1) {
				unSelectMessage(id);
		    } else {
				doSelectMessage(id);
		    }
		}
    }

    function doSelectMessage(id) {
		var i = 0;
		var highlight_color = sel_color;
		var highlight_text_color = sel_text_color;
	
		if (id == -1)
		    return;
	
		showContent(id);
	
		//IE Mac 5.01 doesnt support Array.push()
		if (parent.parent.entries_selected.length > 0) {
		    parent.parent.entries_selected = parent.parent.entries_selected.concat(new Array(String(id)));
		} else {
		    parent.parent.entries_selected = new Array(String(id));
		}
	
		parent.parent.last_entry_selected = id;
	
		if (typeof(document.images["read_" + id]) != "undefined") {
		    document.images["read_" + id].src = read_img.src;
		}
	    highlight_TR(id, sel_color, sel_text_color);
    }

    function highlight_TR(id, color, text_color) {
		var i;
	
		for (i = 0; i <= 3; i++) {
		    if (i == 0 || i == 2) {
			    if(document.getElementById("td_" + id + "_link_" + i)){
	                document.getElementById("td_" + id + "_link_" + i).style.color = text_color;
			    }
			    if(document.getElementById("td_" + id + "_" + i)){
	                document.getElementById("td_" + id + "_" + i).style.color = text_color;
			    }
		    } else {
			    if (i != 1 || (top.content.viewclass != "todo")) {
			        if(document.getElementById("td_" + id + "_" + i)){
			            document.getElementById("td_" + id + "_" + i).style.color = text_color;
			        }
			    }
		    }
		    if(document.getElementById("td_" + id + "_" + i)){
		        document.getElementById("td_" + id + "_" + i).style.backgroundColor = color;
		    }
		}
    }

    function unSelectMessage(id, unsel_all) {
		var index = -1;
		var arr1, arr2;
		var location;
	
		if (NN4 == false)
		    highlight_TR(id, default_color, default_text_color);
	
		parent.parent.entries_selected = array_rm_elem(parent.parent.entries_selected, id, -1);
		//document.images["img_" + id].src = check0_img.src;
	
		if (parent.parent.entries_selected.length == 0) {
		    top.content.messaging_main.messaging_right.msg_work.msg_mfv.messaging_msg_view.location = "<?php echo HTML_DIR?>white.html";
		} else {
		    showContent(parent.parent.entries_selected[parent.parent.entries_selected.length - 1]);
		}
    }

	function newMessage(username){
		new jsWindow('<?php echo WE_MESSAGING_MODULE_PATH; ?>messaging_newmessage.php?we_transaction=<?php echo $_SESSION["we_data"][$_REQUEST['we_transaction']]; ?>&mode=u_'+escape(username),'messaging_new_message',-1,-1,670,530,true,false,true,false);
	}
    
 </script>

</head>
<body leftmargin="7" topmargin="5" marginwidth="7" marginheight="5" bgcolor="#ffffff">
<?php
$messaging = new we_messaging($_SESSION["we_data"][$_REQUEST['we_transaction']]);
$messaging->set_login_data($_SESSION["user"]["ID"], $_SESSION["user"]["Username"]);
$messaging->init($_SESSION["we_data"][$_REQUEST['we_transaction']]);
	?><table width="99%" cellpadding="0" cellspacing="0" border="0"><?php

	$passed_dls = array();
/*
   	if (isset($_REQUEST["si"]) && $_REQUEST["si"] == 'sender') {
    		    $_db = new DB_WE();
    		    $_db->query('SELECT headerTo FROM '.MESSAGES_TABLE.' WHERE ID=' . $val['int_hdrs']['_ID']);
   				$_db->next_record();
				$_toUserId = $_db->f('headerTo');					
	    		$_showUser = '<a id="td_' .  $val['ID'] . '_link_2" href="javascript:newMessage(\'' . $_toUserId . '\')">' . $_toUserId . '</a>';
   	} else {
   		
   	}
*/
   	foreach($messaging->selected_set as $key => $val) {
	    echo '<tr onclick="check(\'' . $val['ID'] . '\')" style="cursor:pointer">
		<td id="td_' . $val['ID'] . '_cb" width="18" align="left" class="defaultfont"></td>';

	    if ($val['hdrs']['ClassName'] == 'we_todo') {
			if ($val['hdrs']['Deadline'] < time()) {
			    $dl_passed = 1;
			    $passed_dls[] = $val['ID'];
			} else {
			    $dl_passed = 0;
			}
	
			echo '<td id="td_' . $val['ID'] . '_0" width="200" align="left" class="defaultfont">' . $val['hdrs']['Subject'] . '</td>
			<td id="td_' . $val['ID'] . '_1" width="170" align="left" class="' . ($dl_passed == 0 ? 'defaultfont' : 'defaultfontred') . '">' . date($GLOBALS['l_global']['date_format'], $val['hdrs']['Deadline']) . '</td>
			<td id="td_' . $val['ID'] . '_2" width="140" align="left" class="defaultfont"><a id="td_' .  $val['ID'] . '_link_2" href="javascript:check(\'' . $val['ID'] . '\')">' . $val['hdrs']['Priority'] . '</a></td>
			<td id="td_' . $val['ID'] . '_3" width="40" align="left" class="defaultfont">' . $val['hdrs']['status'] . '%</td>
			</tr>';
	    } else {
			echo '
				<td id="td_' . $val['ID'] . '_0" width="200" align="left" class="defaultfont">' . $val['hdrs']['Subject'] . '</td>
				<td id="td_' . $val['ID'] . '_1" width="170" align="left" class="defaultfont">' . date($GLOBALS['l_global']['date_format'], $val['hdrs']['Date']) . '</td>
				<td id="td_' . $val['ID'] . '_2" width="140" align="left" class="defaultfont">' . $val['hdrs']['From'] . '</td>
				<td id="td_' . $val['ID'] . '_3" width="40" align="left" class="defaultfont"><img src="' . IMAGE_DIR . 'msg_' . ($val['hdrs']['seenStatus'] & MSG_STATUS_READ ? '' : 'un') . 'read.gif" border="0" width="16" height="18" name="read_' . $val['ID'] . '"></td>
			</tr>';
	    }

	    echo '<tr><td>' . getPixel(1, 3) . '</td><td>' . getPixel(1, 3) . '</td><td>' . getPixel(1, 3) . '</td><td>' . getPixel(1, 3) . '</td></tr>';
	}
	?></table><?php

?>
  <script language="JavaScript" type="text/javascript">
    var k;

    if (NN4 == false) {
	for (k = 0; k < parent.parent.entries_selected.length; k++) {
	    highlight_TR(parent.parent.entries_selected[k], sel_color, sel_text_color);
	}
    }

    if (parent.parent.entries_selected.length > 0)
	showContent(parent.parent.entries_selected[parent.parent.entries_selected.length -1]);

    <?php
	echo 'passed_dls = new Array(String(' . join('), String(', $passed_dls) . '));';
    ?>
  </script>
</body>
</html>
