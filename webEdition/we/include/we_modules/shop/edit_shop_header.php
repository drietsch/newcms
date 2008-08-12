<?php 

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//
// $Id: edit_shop_header.php,v 1.11 2007/07/17 07:18:14 andreas.frey Exp $


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/java_menu/weJavaMenu.inc.php");
if(defined("SHOP_TABLE")){
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/shop.inc.php");
}
include_once( $_SERVER['DOCUMENT_ROOT'] . "/webEdition/we/include/jsMessageConsole/messageConsole.inc.php" );

protect();

htmlTop();

print STYLESHEET;

//	Include javaMenu information for this module
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/java_menu/modules/module_menu_shop.inc.php");

	$port = defined("HTTP_PORT") ? HTTP_PORT : "";
	$protocol=getServerProtocol();
	$jmenu = new weJavaMenu($we_menu_shop,SERVER_NAME,"top.opener.top.load",$protocol,$port,350,30);

?>


	<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR; ?>images.js"></script>
	<script language="JavaScript" type="text/javascript">
        function menuaction(cmd){                
				top.opener.top.load.location.replace("/webEdition/we_lcmd.php?we_cmd[0]="+cmd);
	    }
	</script>
	</head>
	<body background="<?php print IMAGE_DIR ?>java_menu/background.gif" bgcolor="#bfbfbf" leftmargin=0 topmargin=0 marginheight=0 marginwidth=0>


<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td align=left valign=top>
					<?php $jmenu->printMenu(); ?>
				</td>
				<td align="right">
				<?php
					include_once( $_SERVER['DOCUMENT_ROOT'] . "/webEdition/we/include/jsMessageConsole/messageConsole.inc.php" );
					print createMessageConsole("moduleFrame");
				?>
				</td>
			</tr>
		</table> 
	</body>
</html>
