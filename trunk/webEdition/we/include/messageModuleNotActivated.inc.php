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

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"] . "/moduleActivation.inc.php");

htmlTop();
print STYLESHEET;

$content = '
<table border="0" cellpadding="7" width="100%" class="defaultfont">
<tr>
	<td colspan="2"><strong>' . sprintf($l_moduleActivation["headline"], $_moduleName) . '</strong></td>
</tr>
<tr>
	<td valign="top">
		<img src="'.IMAGE_DIR."alert.gif".'">
	</td>
	<td class="defaultfont">
		' . $l_moduleActivation["content"] . '
	</td>
</tr>
</table>';
?>
</head>

<body bgcolor="#ffffff" background="<?php print IMAGE_DIR ?>backgrounds/aquaBackground.gif"  onload="self.focus();" onBlur="setTimeout('self.close()',500);">
<?php print $content ?>
</body>
</html>