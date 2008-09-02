<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */


  include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
  include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_html_tools.inc.php");

  htmlTop();
?>
    <script language="JavaScript")>
	do_mark_messages = 0;
	last_entry_selected = -1;
	entries_selected = new Array();
    </script>

</head>
   <frameset rows="35,26,1,*" framespacing="0" border="0" frameborder="NO">
     <frame src="<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_search_frame.php?we_transaction=<?php echo $_REQUEST['we_transaction']?>" name="messaging_search" scrolling="no" noresize>
     <frame src="<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_fv_headers.php?we_transaction=<?php echo $_REQUEST['we_transaction']?>" name="messaging_fv_headers" scrolling="no" noresize>
     <frame src="<?php echo HTML_DIR?>msg_white_fr.html" noresize scrolling="no">
     <frame src="<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_mfv.php" name="msg_mfv" scrolling="no">
   </frameset>
<noframes>
 <body background="<?php print IMAGE_DIR ?>backgrounds/aquaBackground.gif" bgcolor="#bfbfbf" leftmargin=0 topmargin=0 marginheight=0 marginwidth=0>
 </body>
</noframes>
</html>
