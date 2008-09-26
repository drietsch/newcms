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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/messaging.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");

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
		top.content.messaging_cmd.location = '<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_cmd.php?mcmd=launch&we_transaction=<?php echo $we_transaction?>&mode=' + top.content.viewclass;
	}
    </script>
  </head>
  <body marginwidth="10" marginheight="7" topmargin="7" leftmargin="7" background="/webEdition/images/msg_white_bg.gif">
    <nobr>
    <form name="we_messaging_search" action="<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_search_frame.php" onSubmit="return doSearch()">
      <?php echo hidden('we_transaction', $_REQUEST['we_transaction'])?>

      <table cellpadding="0" cellspacing="0" border="0">
	<tr>
	  <td class="defaultfont"><?php echo $l_messaging['search_messages']?>:</td>
	  <td width="10"></td>
	<?php
	    echo '<td class="defaultfont">' .
	    $we_button->create_button_table(array(	htmlTextInput('messaging_search_keyword', 15, isset($_REQUEST['messaging_search_keyword']) ? $_REQUEST['messaging_search_keyword'] : '', 15),
	    										$we_button->create_button("search", "javascript:doSearch();"),
	    										$we_button->create_button("advanced", "javascript:launchAdvanced()", true),
	    										$we_button->create_button("reset_search", "javascript:clearSearch();")), 10)
		. '</td>';
	?>
	  </tr>
	</table>
    </form>
    </nobr>
  </body>
</html>
