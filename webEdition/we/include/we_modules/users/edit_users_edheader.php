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
include_once(WE_USERS_MODULE_DIR . "we_users.inc.php");

protect();

htmlTop();

print STYLESHEET;

$user_object=new we_user();
$user_object->setState($_SESSION["user_session_data"]);

?>
	</head>

	<body bgcolor="white" background="<?php print IMAGE_DIR; ?>backgrounds/header_with_black_line.gif" marginwidth="0" marginheight="0" leftmargin="0" topmargin="0" onload="setFrameSize()" onresize="setFrameSize()">
		<?php print $user_object->formHeader((isset($_REQUEST['tab'])?$_REQUEST['tab']:0)); ?>
	</body>

</html>