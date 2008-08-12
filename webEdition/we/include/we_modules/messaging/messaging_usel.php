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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once(WE_MESSAGING_MODULE_DIR . "we_messaging.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/messaging.inc.php");

$messaging = new we_messaging($_SESSION["we_data"][$_REQUEST['we_transaction']]);
$messaging->set_login_data($_SESSION["user"]["ID"], $_SESSION["user"]["Username"]);
$messaging->init($_SESSION["we_data"][$_REQUEST['we_transaction']]);

$we_button = new we_button();
?>
<html>
  <head>
    <title><?php print $l_messaging['sel_rcpts']; ?></title>
  <script language="JavaScript" type="text/javascript" src="<?php print JS_DIR; ?>windows.js"></script>
  <script language="JavaScript" type="text/javascript" src="<?php print JS_DIR; ?>messaging_std.js"></script>
  <script language="JavaScript" type="text/javascript" src="<?php print JS_DIR; ?>we_showMessage.js"></script>
  <script language="JavaScript" type="text/javascript">
	<?php
	if (!empty($_REQUEST['mode']) && ($_REQUEST['mode'] == 'save_addrbook')) {
	    $addrbook = array();
	    $t_arr = array();
	    $addrbook_arr = $_REQUEST['addrbook_arr'];
	    if ($addrbook_arr != '')
		$t_arr = explode("\t", $addrbook_arr);
	    $i = 0;
	    foreach ($t_arr as $elem) {
			$addrbook[$i] = array();
			$entry = explode(',', $elem);
			foreach($entry as $val) {
			    $val = urldecode($val);
			    array_push($addrbook[$i], $val);
			}
			$i++;
	    }

	    if ( $messaging->save_addresses($addrbook) ) {
	    	print "function doOnLoad() {\n" . we_message_reporting::getShowMessageCall( $l_messaging['addr_book_saved'], WE_MESSAGE_NOTICE) . "\n}\n";

	    } else {
	    	print "function doOnLoad() {\n" . we_message_reporting::getShowMessageCall( $l_messaging['error_occured'], WE_MESSAGE_ERROR) . "\n}\n";

	    }
	 } else {

	 	print ' function doOnLoad() {
	// do nothing
}
';

	 }

	$addrbook_str = '';
	$t_arr = $messaging->get_addresses();

	if (!empty($t_arr)) {
	    foreach ($t_arr as $elem) {
		$addrbook_str .= 'new Array("' . $elem[0] . '","' . $elem[1] . '","' . $elem[2] . '"),';
	    }
	    $addrbook_str = substr($addrbook_str, 0, -1);
	}

	$rcpts_str = '';
	$rcpts = split(',', isset($_REQUEST["rs"]) ? $_REQUEST["rs"] : "");
	foreach ($rcpts as $rcpt) {
	    if (($uid = $messaging->get_userid($rcpt)) != -1) {
		$rcpts_str .= 'new Array("we_messaging","' . $uid . '","' . $rcpt . '"),';
	    }
	}
	$rcpts_str = substr($rcpts_str, 0, -1);
	?>

	delta_sel = new Array();
	addrbook_sel = new Array(<?php echo $addrbook_str?>);
	current_sel = new Array(<?php echo $rcpts_str?>);

	function init() {
	    var i;

	    for (i = 0; i < current_sel.length; i++) {
		opt = new Option(current_sel[i][2], current_sel[i][1], false, false);
		document.usel.usel_currentsel.options[document.usel.usel_currentsel.length] = opt;
	    }

	    for (i = 0; i < addrbook_sel.length; i++) {
		opt = new Option(addrbook_sel[i][2], addrbook_sel[i][1], false, false);
		document.usel.usel_addrbook.options[document.usel.usel_addrbook.length] = opt;
	    }
	}

	function browse_users_window() {
	    new jsWindow("<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_usel_browse_frameset.php?we_transaction=<?php echo $_REQUEST['we_transaction']?>","messaging_usel_browse",-1,-1,350,330,true,false,true,false);
	}

	function save_addrbook() {
	    var submit_str = "";
	    var i, j;

	    if (addrbook_sel.length > 0) {
			for (i = 0; i < addrbook_sel.length; i++) {
			    for (j = 0; j < addrbook_sel[i].length; j++) {
				submit_str += escape(addrbook_sel[i][j]) + ',';
			    }
			    submit_str = submit_str.substr(0, submit_str.length - 1);

			    submit_str += "\t";
			}

			submit_str = submit_str.substr(0, submit_str.length - 1);
	    }
	    document.addrbook_data.addrbook_arr.value = submit_str;
	    document.addrbook_data.submit();
	}

	function dump_entries(u_type) {
	    var i;
	    var new_arr = current_sel;
	    var pos;

	    for (i = 0; i < current_sel.length; i++) {
		if (current_sel[i][0] == u_type) {
		    pos = array_two_dim_search(current_sel[i][1], new_arr, 1);
		    val = document.usel.usel_currentsel.options[pos].value;
		    document.usel.usel_currentsel.options[pos] = null;
		    new_arr = array_rm_elem(new_arr, val, 1);
		}
	    }

	    current_sel = new_arr;
	}

	function delta_sel_add(user_type, delim) {
	    var i;
	    var opt;
	    var tarr;
	    <?php if (isset($_REQUEST['maxsel'])) {
/*		echo "if (current_sel.length < $maxsel) {
			var len = $maxsel - current_sel.length;
		      } else {
			return;
		      }\n";*/
	    } else {
		echo "var len=delta_sel.length\n";
	    }?>
	    var len = delta_sel.length;

	    dump_entries(user_type);

	    for (i = 0; i < len; i++) {
		tarr = delta_sel[i].split(delim);

		if (array_search(String(tarr[0]), current_sel) != -1) {
		    continue;
		}

		current_sel = current_sel.concat(new Array(new Array(user_type, String(tarr[0]), String(tarr[1]))));
		opt = new Option(tarr[1], tarr[0], false, false);
		document.usel.usel_currentsel.options[document.usel.usel_currentsel.length] = opt;
	    }
	}

	function rm_sel_user() {
	    var sel_elems = get_sel_elems(document.usel.usel_currentsel);
	    var i;
	    var pos = -1;
	    var val;

	    for (i = 0; i < sel_elems.length; i++) {
		pos = array_two_dim_search(sel_elems[i], current_sel, 1);
		val = document.usel.usel_currentsel.options[pos].value;
		document.usel.usel_currentsel.options[pos] = null;
		current_sel = array_rm_elem(current_sel, val, 1);
	    }
	}

	function rm_addrbook_entry() {
	    var sel_elems = get_sel_elems(document.usel.usel_addrbook);
	    var i;
	    var pos = -1;
	    var val;
	    for (i = 0; i < sel_elems.length; i++) {
		pos = array_two_dim_search(sel_elems[i], addrbook_sel, 1);
		val = document.usel.usel_addrbook.options[pos].value;
		document.usel.usel_addrbook.options[pos] = null;
		addrbook_sel = array_rm_elem(addrbook_sel, val, 1);
	    }
	}

	function add_toaddr() {
	    var sel_elems = get_sel_elems(document.usel.usel_currentsel);
	    var i;

	    for (i = 0; i < sel_elems.length; i++) {
		curr_offset = array_two_dim_search(String(sel_elems[i]), current_sel, 1);
		if (array_two_dim_search(String(sel_elems[i]), addrbook_sel, 1) != -1) {
		    continue;
		}

		addrbook_sel = addrbook_sel.concat(new Array(current_sel[curr_offset]));
		opt = new Option(current_sel[curr_offset][2], current_sel[curr_offset][1], false, false);
		document.usel.usel_addrbook.options[document.usel.usel_addrbook.length] = opt;
	    }
	}

	function add_addr2sel() {
	    var sel_elems = get_sel_elems(document.usel.usel_addrbook);
	    var i;
	    <?php if (isset($_REQUEST['maxsel'])) {
		echo "if (current_sel.length < " . $_REQUEST['maxsel'] . ") {
			var len = " . $_REQUEST['maxsel'] . " - current_sel.length;
		      } else {
			return;
		      }\n";
	    } else {
		echo "var len=sel_elems.length\n";
	    }?>

	    for (i = 0; i < len; i++) {
		addr_offset = array_two_dim_search(String(sel_elems[i]), addrbook_sel, 1);
		if (array_two_dim_search(String(sel_elems[i]), current_sel, 1) != -1) {
		    continue;
		}

		current_sel = current_sel.concat(new Array(addrbook_sel[addr_offset]));
		opt = new Option(addrbook_sel[addr_offset][2], addrbook_sel[addr_offset][1], false, false);
		document.usel.usel_currentsel.options[document.usel.usel_currentsel.length] = opt;
	    }
	}

	function ok() {
	    opener.rcpt_sel = current_sel;
	    opener.update_rcpts();
	    window.close();
	}

	function doUnload() {
	    if(jsWindow_count){
		    for(i=0;i<jsWindow_count;i++){
			    eval("jsWindow"+i+"Object.close()");
		    }
	    }
	}

    </script>
      <?php print STYLESHEET; ?>
    </head>
  <body class="weDialogBody" onload="doOnLoad()" onUnload="doUnload();">
    <form name="usel">
<?php  $tbl = '  <table cellspacing="6">
      <tr><td class="defaultfont">' . $l_messaging['addr_book'] . '</td><td></td><td class="defaultfont">' . $l_messaging['selected'] . '</td></tr>
      <tr>
        <td rowspan="3"><select name="usel_addrbook" size="7" style="width:210px" multiple>
            </select>
        </td>
        <td valign="bottom">' . $we_button->create_button("image:btn_direction_left", "javascript:add_toaddr()") . '</td>
        <td rowspan="3"><select name="usel_currentsel" size="7" style="width:210px" multiple>
            </select>
        </td>
      </tr>
      <tr>
	<td>' . getPixel(22, 1) . '</td>
      </tr>
      <tr>
	<td valign="top">' . $we_button->create_button("image:btn_direction_right", "javascript:add_addr2sel()") . '</td>
      </tr>
      <tr>
	<td>' . $we_button->create_button("delete", "javascript:rm_addrbook_entry();") . '</td>
	<td></td>
	<td>' . $we_button->create_button("delete", "javascript:rm_sel_user();") . '</td>
      </tr>
      <tr>
	<td colspan="3">' . getPixel(1, 15) . '<td>
      </tr>
      <tr>
	<td>' . $we_button->create_button("save_address", "javascript:save_addrbook();") . '<td>
	<td colspan="2">' . $we_button->create_button("select_user", "javascript:browse_users_window();") . '<td>
      </tr>
    </table>';
    echo htmlDialogLayout($tbl, $l_messaging['sel_rcpts'],$we_button->position_yes_no_cancel($we_button->create_button("ok", "javascript:ok()"),  "", $we_button->create_button("cancel", "javascript:window.close();")));
?>
    </form>
    <form action="<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_usel.php" method="post" name="addrbook_data">
	<?php echo hidden('mode', 'save_addrbook');
	      echo hidden('we_transaction', $_REQUEST['we_transaction']);
	      echo hidden('addrbook_arr', '');
	?>
    </form>
    <script language="JavaScript" type="text/javascript">
	init();
    </script>
  </body>
</html>