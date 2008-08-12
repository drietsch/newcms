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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/messaging.inc.php");

htmlTop();

print STYLESHEET;

$we_button = new we_button();
?>
    <script language="JavaScript" type="text/javascript" src="<?php echo JS_DIR?>windows.js"></script>
    <script language="JavaScript" type="text/javascript">
	function doSearch() {
		top.content.messaging_cmd.location = '<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_cmd.php?mcmd=search_messages&we_transaction=<?php echo $_REQUEST['we_transaction']?>&searchterm=' + document.we_messaging_search.messaging_search_keyword.value;
	}

	function launchAdvanced() {
		new jsWindow("<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_search_advanced.php?we_transaction=<?php echo $_REQUEST['we_transaction']?>","messaging_search_advanced",-1,-1,300,240,true,false,true,false);
	}

	function clearSearch() {
		document.we_messaging_search.messaging_search_keyword.value = "";
		doSearch();
	}
    </script>
  </head>
  <body marginwidth="10" marginheight="7" topmargin="7" leftmargin="7" background="/webEdition/images/msg_white_bg.gif">
    <nobr>
    <form name="we_messaging_search" action="<?php print WE_MESSAGING_MODULE_PATH ?>todo_search_frame.php" onSubmit="return doSearch()">
      <?php echo hidden('we_transaction', $_REQUEST['we_transaction']) ?>
      <table cellpadding="0" cellspacing="0" border="0">
	<tr>
	  <td class="defaultfont"><?php print $GLOBALS["l_messaging"]["search_todos"]; ?>:</td>
	<?php
	    echo '<td class="defaultfont">' . getPixel(10, 1) . htmlTextInput('messaging_search_keyword', 15, isset($_REQUEST['messaging_search_keyword']) ? $_REQUEST['messaging_search_keyword'] : '', 15) . '</td>';
	    echo '<td class="defaultfont">' . getPixel(10, 1) . '</td>';
	    print "<td>" . $we_button->create_button_table(array(	$we_button->create_button("search", "javascript:doSearch();"),
	    														$we_button->create_button("advanced", "javascript:launchAdvanced()"),
	    														$we_button->create_button("reset_search", "javascript:clearSearch()")),10)
				."</td>";
	?>
	  </tr>
	</table>
    </form>
    </nobr>
  </body>
</html>
