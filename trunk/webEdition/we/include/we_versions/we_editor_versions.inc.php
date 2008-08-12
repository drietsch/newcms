<?php

// +---------------------------------------------------------+
// | webEdition
// +---------------------------------------------------------+
// | PHP version 5.1 or greater
// +---------------------------------------------------------+
// |Copyright (c) 2000 - 2008 living-e AG  
// +---------------------------------------------------------+

/**
* @author Thomas Kneip
* @copyright living-e AG
*/

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_versions/weVersionsView.class.inc.php");

protect();
  
htmlTop();

echo '<script language="JavaScript" type="text/javascript" src="'.JS_DIR.'windows.js"></script>';
echo '<script type="text/javascript" src="/webEdition/js/libs/yui/yahoo-min.js"></script>';
echo '<script type="text/javascript" src="/webEdition/js/libs/yui/event-min.js"></script>';
echo '<script type="text/javascript" src="/webEdition/js/libs/yui/connection-min.js"></script>';

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_editors/we_editor_script.inc.php");

$headCal = we_htmlElement::linkElement(array("rel"=>"stylesheet","type"=>"text/css","href"=>JS_DIR."jscalendar/skins/aqua/theme.css","title"=>"Aqua")).
		   we_htmlElement::jsElement("",array("src"=>JS_DIR."jscalendar/calendar.js")).
		   we_htmlElement::jsElement("",array("src"=>WEBEDITION_DIR."we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/calendar.js")).
		   we_htmlElement::jsElement("",array("src"=>JS_DIR."jscalendar/calendar-setup.js"));
	
echo $headCal;

$_view = new weVersionsView();

echo $_view->getJS();

print STYLESHEET;

echo '
<style type="text/css" media="screen"> 
#scrollContent {overflow: auto; }
#searchTable {display: block; }
#eintraege_pro_seite {display: inline;margin-right:10px; }
#anzahl {display: inline;margin-right:10px;  }
#eintraege {display: none; }
#print {display: inline;}
#zurueck {display: ;}
#weiter {display: ;}
#pageselect {display: inline;}
#bottom{display: inline;}
#beschreibung_print {display: none; }
.printShow{display: block; }
#deleteVersion{display: block; }
#deleteAllVersions{display: block; }
#label_deleteAllVersions{display: block; }
#deleteButton{display: block; }
#print{display: inline; }
</style>

<style type="text/css" media="print"> 
#scrollContent {overflow: visible; }
#searchTable {display: none; }
#eintraege_pro_seite {display: none; }
#anzahl {display: none; }
#eintraege {display: inline;margin-right:10px; }
#print {display: none;}
#zurueck {display: none;}
#weiter {display: none;}
#pageselect {display: none;}
#bottom{display: none;}
#beschreibung_print {display: block; }
.printShow{display: none; }
#deleteVersion{display: none; }
#deleteAllVersions{display: none; }
#label_deleteAllVersions{display: none; }
#deleteButton{display: none; }
#print{display: none; }
</style>
';

echo '</head>';

echo '<body class="weEditorBody" onUnload="doUnload()" onkeypress="javascript:if(event.keyCode==\'13\' || event.keyCode==\'3\') search(true);" onLoad="setTimeout(\'init();\',200)" onresize="sizeScrollContent();">';
echo '<form name="we_form" onSubmit="return false;" style="padding:0px;margin:0px;">';

$_parts = array();
$_parts[] = array("html"=>"<div id='searchTable'>".$_view->getBodyTop()."</div>");

$content = $_view->getVersionsOfDoc();
$headline = $_view->makeHeadLines();
$foundItems = count($content);

$_parts[] = array("html"=>"<div id='parametersTop'>".$_view->getParameterTop($foundItems)."</div>".$_view->tblList($content,$headline)."<div id='parametersBottom'>".$_view->getParameterBottom($foundItems)."</div>");

echo $_view->getHTMLforVersions($_parts);


echo '</form>';
echo '</body>';
echo '</html>';
?>