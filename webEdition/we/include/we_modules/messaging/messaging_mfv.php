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
 <?php	if ($GLOBALS["BROWSER"] == "NN6"){ ?>
    <frameset rows="180,*" framespacing="0" border="1" frameborder="1">
       <frame src="<?php echo HTML_DIR?>white_inc.html" name="messaging_messages_overview" scrolling="auto">
       <frame src="<?php echo HTML_DIR?>white_inc.html" name="messaging_msg_view">
     </frameset>
 <?php	} else if ($GLOBALS["BROWSER"] == "SAFARI"){ ?>
     <frameset rows="180,1,*" framespacing="0" border="0" frameborder="0" id="msg_resize_frameset">
       <frame src="<?php echo HTML_DIR?>white_inc.html" name="messaging_messages_overview" scrolling="auto">
       <frame src="safariHResize.html" name="messaging_separator">
       <frame src="<?php echo HTML_DIR?>white_inc.html" name="messaging_msg_view" scrolling="auto">
     </frameset>

 <?php } else { ?>
    <frameset rows="180,*" framespacing="0" border="1" frameborder="0"">
       <frame src="<?php echo HTML_DIR?>white_inc.html" name="messaging_messages_overview" scrolling="auto" style="border-bottom:1px solid black"">
       <frame src="<?php echo HTML_DIR?>white_inc.html" name="messaging_msg_view">
     </frameset>
 <?php } ?>
 <body>
  </body>
</html>
