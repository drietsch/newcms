<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/inlcude/we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/inlcude/we_language/".$GLOBALS["WE_LANGUAGE"]."/global.inc.php");

?>

<html>
	<head>
		<title></title>
		<?php print STYLESHEET; ?>
	</head>

	<body>
		<span class="defaultfont">
			<?php print $l_global["load_menu_info"]; ?>
		</span>
	</body>

</html>