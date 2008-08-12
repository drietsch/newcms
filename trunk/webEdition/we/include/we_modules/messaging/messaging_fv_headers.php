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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/messaging.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"].WE_MESSAGING_MODULE_PATH."msg_html_tools.inc.php");

?>
<html>
  <head>
    <script language="JavaScript" type="text/javascript"><!--
		function doSort(sortitem) {
		    entrstr = "";

			top.content.messaging_cmd.location = "<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_cmd.php?mcmd=show_folder_content&sort=" + sortitem + entrstr + "&we_transaction=<?php echo $we_transaction;?>";
		}
	//-->
    </script>
<?php
    print STYLESHEET;
?>
    <style type="text/css">
      .defaultfont a {color:black; text-decoration:none}
    </style>
  </head>
  <body  background="<?php print IMAGE_DIR; ?>backgrounds/header_with_black_line.gif"  marginwidth="7" marginheight="6" topmargin="6" leftmargin="7">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
      <tr>
	<?php if (!isset($_REQUEST["viewclass"]) || $_REQUEST["viewclass"] != "todo") { ?>
	    <td width="18"><?php pPixel(18, 1)?></td>
	    <td class="defaultfont" width="200"><a href="javascript:doSort('subject');"><b><?php echo $l_messaging['subject']?></b>&nbsp;<?php echo ( (isset($_REQUEST["si"]) && $_REQUEST["si"] == 'subject') ? sort_arrow("arrow_sortorder_" . $_REQUEST['so'], "") : getPixel(1, 1)) ?></a></td>
	    <td class="defaultfont" width="170"><a href="javascript:doSort('date');"><b><?php echo $l_messaging['date']?></b>&nbsp;<?php echo ((isset($_REQUEST["si"]) && $_REQUEST["si"] == 'date') ? sort_arrow("arrow_sortorder_" . $_REQUEST['so'], "") : getPixel(1, 1)) ?></a></td>
	    <td class="defaultfont" width="120"><a href="javascript:doSort('sender');"><b><?php echo $l_messaging['from']?></b>&nbsp;<?php echo ((isset($_REQUEST["si"]) && $_REQUEST["si"] == 'sender') ? sort_arrow("arrow_sortorder_" . $_REQUEST['so'], "") : getPixel(1, 1)) ?></a></td>
	    <td class="defaultfont" width="70"><a href="javascript:doSort('isread');"><b><?php echo $l_messaging['is_read']?></b>&nbsp;<?php echo ((isset($_REQUEST["si"]) && $_REQUEST["si"] == 'isread') ? sort_arrow("arrow_sortorder_" . $_REQUEST['so'], "") : getPixel(1, 1)) ?></a></td>
	<?php } else { ?>
	    <td width="18"><?php pPixel(18, 1)?></td>
	    <td class="defaultfont" width="200"><a href="javascript:doSort('subject');"><b><?php echo $l_messaging['subject']?></b>&nbsp;<?php echo ((isset($_REQUEST["si"]) && $_REQUEST["si"] == 'subject') ? sort_arrow("arrow_sortorder_" . $_REQUEST['so'], "") : getPixel(1, 1)) ?></a></td>
	    <td class="defaultfont" width="170"><a href="javascript:doSort('deadline');"><b><?php echo $l_messaging['deadline']?></b>&nbsp;<?php echo ((isset($_REQUEST["si"]) && $_REQUEST["si"] == 'deadline') ? sort_arrow("arrow_sortorder_" . $_REQUEST['so'], "") : getPixel(1, 1)) ?></a></td>
	    <td class="defaultfont" width="120"><a href="javascript:doSort('priority');"><b><?php echo $l_messaging['priority']?></b>&nbsp;<?php echo ((isset($_REQUEST["si"]) && $_REQUEST["si"] == 'priority') ? sort_arrow("arrow_sortorder_" . $_REQUEST['so'], "") : getPixel(1, 1)) ?></a></td>
	    <td class="defaultfont" width="70"><a href="javascript:doSort('status');"><b><?php echo $l_messaging['status']?></b>&nbsp;<?php echo ((isset($_REQUEST["si"]) && $_REQUEST["si"] == 'status') ? sort_arrow("arrow_sortorder_" . $_REQUEST['so'], "") : getPixel(1, 1)) ?></a></td>
	<?php } ?>
      </tr>
    </table>
  </body>
</html>
