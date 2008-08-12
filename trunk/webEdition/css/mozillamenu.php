<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//

if(!isset($_SESSION)) @session_start();
header("Content-Type: text/css");
$show_stylesheet = true;

// Activate the webEdition error handler
   include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/we_error_handler.inc.php");
   we_error_handler();

if (isset($_SESSION["prefs"]["Language"]) && $_SESSION["prefs"]["Language"] != "") {
	$GLOBALS["WE_LANGUAGE"] = $_SESSION["prefs"]["Language"];
} else {
	$GLOBALS["WE_LANGUAGE"] = WE_LANGUAGE;
}
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/css/css.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_browser_check.inc.php");
?>
window,
hbox {
  font-family: <?php print $l_css["font_family"]; ?>;
  font-size: 12px;
  border:0px;
}

menupopup {
  background-image: url(/webEdition/images/backgrounds/aquaBackground.gif);
  font-family: <?php print $l_css["font_family"]; ?>;
  font-size: 12px;

}
.menu-right {
  margin: 0px 0px 0px 6px;
  width: 0px;
  list-style-image: url("/webEdition/images/java_menu/menu-arrow.gif");
}
.menu-right[disabled="true"],
.menu-right[_moz-menuactive="true"][disabled="true"] {
  list-style-image: url("/webEdition/images/java_menu/menu-arrow-dis.gif");
}

.menu-right[_moz-menuactive="true"] {
  list-style-image: url("/webEdition/images/java_menu/menu-arrow-hov.gif");
}

menu,menuitem {
   font-weight: normal;
  color: black;
  font-family: <?php print $l_css["font_family"]; ?>;
  font-size: 12px;
}

menu[disabled="true"],
menuitem[disabled="true"],
menu[_moz-menuactive="true"][disabled="true"],
menuitem[_moz-menuactive="true"][disabled="true"] {
  background-color: transparent !important;
  color: GrayText !important;
}

menu[_moz-menuactive="true"],menuitem[_moz-menuactive="true"] {
  background: #3063B0;
  color: white;
  font-family: <?php print $l_css["font_family"]; ?>;
  font-size: 12px;
}

toolbar {
  border: 0px;
  background-image: url(/webEdition/images/backgrounds/aquaBackground.gif);
  background: transparent;
  color: #000000;
}


toolbarbutton {
  padding: 2px 8px 2px 5px ! important;
  font-weight: bold ! important;
  color: black ! important;
  border: solid 1px transparent ! important;
  font-family: <?php print $l_css["font_family"]; ?>  ! important;
  font-size: 12px ! important;
}

toolbarbutton:hover{
  padding: 2px 8px 2px 5px ! important;
  border-left: #cccccc 1px solid ! important;
  border-top: #cccccc 1px solid ! important;
  border-right: #000000 1px solid ! important;
  border-bottom: #000000 1px solid ! important;

}

toolbarseparator {
  border: 0px ! important;
  width: 0px ! important;
}

.toolbarbutton-menu-dropmarker {
  display: none ! important;
}

.toolbarbutton-menu-dropmarker[disabled="true"] {
  display: none ! important;
}
