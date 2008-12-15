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
  
  protect();

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
