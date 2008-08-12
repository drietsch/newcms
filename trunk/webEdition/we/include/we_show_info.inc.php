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

htmlTop();

print STYLESHEET . "\n";

?>
	</head>
	<body bgcolor="white" marginwidth="0" marginheight="0" leftmargin="0" topmargin="0" onBlur="self.close()" onClick="self.close()" onload="self.focus();">
		<center>
			<?php include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_templates/we_info.inc.php"); ?>
		</center>
	</body>
</html>
