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

htmlTop();

print STYLESHEET;

?>
  </head>

<?php if ($GLOBALS["BROWSER"] == "NN6")	{ ?>
<frameset cols="*" framespacing="0" border="0" frameborder="NO">
	<frame src="<?php print WE_MESSAGING_MODULE_PATH ?>messaging_work.php?we_transaction=<?php echo $_REQUEST['we_transaction']?>" name="msg_work" scrolling="no" noresize>
</frameset>
<?php } else if($GLOBALS["BROWSER"] == "SAFARI") { ?>
<frameset cols="1,*" framespacing="0" border="0" frameborder="NO">
	<frame src="<?php print HTML_DIR ?>safariResize.html" name="bm_resize" scrolling="no" noresize>
	<frame src="<?php print WE_MESSAGING_MODULE_PATH ?>messaging_work.php?we_transaction=<?php echo $_REQUEST['we_transaction']?>" name="msg_work" scrolling="no" noresize>
</frameset>
<?php } else { ?>
<frameset cols="2,*" framespacing="0" border="0" frameborder="NO">
	<frame src="<?php print HTML_DIR ?>ieResize.html" name="bm_resize" scrolling="no" noresize>
	<frame src="<?php print WE_MESSAGING_MODULE_PATH ?>messaging_work.php?we_transaction=<?php echo $_REQUEST['we_transaction']?>" name="msg_work" scrolling="no" noresize>
</frameset>
<?php } ?>

  <body>
  </body>
</body>
