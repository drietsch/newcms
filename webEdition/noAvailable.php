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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/help.inc.php");

htmlTop();

$we_button = new we_button();

print STYLESHEET;

$content='<table cellpadding="0" cellspacing="0" border="0">
        <tr><td class="defaultfont">'.$l_help["help_not_available_text"].'</td></tr>
        <tr><td class="defaultfont">'.$l_help["help_not_available_again"].'</td></tr>
    </table>';

?>
</head>
<body class="weDialogBody">
 <?php print htmlDialogLayout($content,$l_help["help_not_available_title"],$we_button->create_button("close", "javascript:self.close();")); ?>
</body>
</html>

