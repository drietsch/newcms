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
     <frameset rows="10,5,*" framespacing="0" border="0" frameborder="NO">
       <frame src="<?php echo HTML_DIR?>aqua_nb.html" scrolling="no" noresize>
       <frame src="<?php print HTML_DIR?>msg_white_fr.html" noresize scrolling="no">
       <frame src="<?php print HTML_DIR?>white_inc.html" name="messaging_msg_view" noresize>
     </frameset>
  <body>
  </body>
</html>
