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


include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_modules/navi_language.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_classes/we_tabs.class.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_classes/tools/weToolLookup.class.php');
protect();
htmltop();

$we_tabs = new we_tabs();

$name = array();

$_menuItems = weToolLookup::getAllTools(true, true);

include(weToolLookup::getLanguageInclude('weSearch'));
include(weToolLookup::getLanguageInclude('toolfactory'));
include(weToolLookup::getLanguageInclude('navigation'));

foreach ($_menuItems as $_menuItem) {
	$text = $_menuItem["text"];

	if ($_menuItem["name"]=="weSearch") {
		$text = $l_weSearch["weSearch"];
	}
	else if ($_menuItem["name"]=="navigation") {
		$text = $l_navigation["navigation"];
	}
	if($_REQUEST["tool"]=="weSearch") {
		$we_tabs->heightPlus=-30;
	}
	else if($_REQUEST["tool"]=="navigation") {
		$we_tabs->heightPlus=-30;
	}
	else  {
		if($text != $l_weSearch["weSearch"] && $text != $l_navigation["navigation"]) {
			if(we_hasPerm($_menuItem['startpermission'])) {
				$we_tabs->addTab(new we_tab("#", $text, ( isset($_REQUEST['tool']) && $_REQUEST['tool'] == $_menuItem["name"] ? "TAB_ACTIVE" : "TAB_NORMAL" ) ,"openTool('" . $_menuItem["name"] . "');",array("id" => $_menuItem["name"])));
			}
		}
	}
}


$we_tabs->onResize('navi');
$tab_header = $we_tabs->getHeader('_tools', 1);
$tab_js = $we_tabs->getJS();

print $tab_header;
?>
<script language="JavaScript" type="text/javascript">
var current = "<?php echo $_REQUEST["tool"];?>";
function openTool(tool) {
	if(top.content.hot =="1") {
		if(confirm("<?php print $l_alert['discard_changed_data']?>")) {
			top.content.hot = "0";
			current = tool;
			top.content.location.replace('tools_content.php?tool=' + tool);
		} else {
			top.navi.setActiveTab(current);
		}
	} else {
		top.content.hot = "0";
		current = tool;
		top.content.location.replace('tools_content.php?tool=' + tool);
		
	}
	
}
</script>
</head>
<body bgcolor="white" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" background="<?php print IMAGE_DIR; ?>backgrounds/header.gif" link="black" alink="#1559b0" vlink="black" onload="setFrameSize()" onresize="setFrameSize()">
<div id="main" ><?php echo $we_tabs->getHTML(); ?></div>
<?php
//	print $tab_js;
	if (isset($_REQUEST["tab"])) {
		//print we_htmlElement::jsElement("tabCtrl.setActiveTab(".$_REQUEST["tab"].");");
	}
?>
</body>
</html>
