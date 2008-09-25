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


include_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we.inc.php");

protect ();

htmlTop ();

include_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_doclist/doclistView.class.inc.php");

echo '<script language="JavaScript" type="text/javascript" src="' . JS_DIR . 'windows.js"></script>';
echo '<script type="text/javascript" src="/webEdition/js/libs/yui/yahoo-min.js"></script>';
echo '<script type="text/javascript" src="/webEdition/js/libs/yui/event-min.js"></script>';
echo '<script type="text/javascript" src="/webEdition/js/libs/yui/connection-min.js"></script>';

include_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we_editors/we_editor_script.inc.php");

$headCal = we_htmlElement::linkElement ( array ("rel" => "stylesheet", "type" => "text/css", "href" => JS_DIR . "jscalendar/skins/aqua/theme.css", "title" => "Aqua" ) ) . we_htmlElement::jsElement ( "", array ("src" => JS_DIR . "jscalendar/calendar.js" ) ) . we_htmlElement::jsElement ( "", array ("src" => WEBEDITION_DIR . "we/include/we_language/" . $GLOBALS ["WE_LANGUAGE"] . "/calendar.js" ) ) . we_htmlElement::jsElement ( "", array ("src" => JS_DIR . "jscalendar/calendar-setup.js" ) );

echo $headCal;

$_view = new doclistView ( );

echo $_view->getSearchJS ();

print STYLESHEET;

echo '</head>

<body class="weEditorBody" onUnload="doUnload()" onkeypress="javascript:if(event.keyCode==\'13\' || event.keyCode==\'3\') search(true);" onLoad="setTimeout(\'init();\',200)" onresize="sizeScrollContent();">';

echo '<div id="mouseOverDivs_doclist"></div>';

echo '<form name="we_form" onSubmit="return false;" style="padding:0px;margin:0px;">';

$_parts = array ( );
$_parts [] = array ("html" => $_view->getSearchDialog () );
$content = $_view->searchProperties ();
$headline = $_view->makeHeadLines ();
$foundItems = (isset($_SESSION['weSearch']['foundItems'])) ? $_SESSION['weSearch']['foundItems'] : 0;
$_parts [] = array ("html" => "<div id='parametersTop'>" . $_view->getSearchParameterTop ( $foundItems ) . "</div>" . searchtoolView::tblList ( $content, $headline, "doclist" ) . "<div id='parametersBottom'>" . $_view->getSearchParameterBottom ( $foundItems ) . "</div>" );

echo $_view->getHTMLforDoclist ( $_parts );

echo '
</form>
</body>
</html>';
?>