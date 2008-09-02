<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/permissionhandler/permissionhandler.class.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/java_menu/weJavaMenu.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/javaMenu/javaMenu.inc.php");

protect();
htmlTop();

print STYLESHEET;

//	width of java-/XUL-Menu
$_menu_width = 360;
$port = defined("HTTP_PORT") ? HTTP_PORT : "";

// all available elements
$jmenu = null;
$navigationButtons = array();

if ( !isset($_REQUEST["SEEM_edit_include"]) ) { // there is only a menu when not in seem_edit_include!


	if( // menu for normalmode
		isset($_SESSION["we_mode"]) && $_SESSION["we_mode"] == "normal" ){

		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/java_menu/"."we_menu.inc.php");
		ksort ($we_menu);
	    $jmenu = new weJavaMenu($we_menu,SERVER_NAME,"top.load",getServerProtocol(),$port,$_menu_width,30);


	} else { // menu for seemode

		if(permissionhandler::isUserAllowedForAction("header", "with_java")){

			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/java_menu/"."we_menu_seem.inc.php");
	    	ksort ($we_menu);
	    	$jmenu = new weJavaMenu($we_menu,SERVER_NAME,"top.load",getServerProtocol(),$port,$_menu_width,30);

		} else {
			//  no menu in this case !
			$navigationButtons[] = array(
				"onclick" => "top.we_cmd('dologout');",
				"imagepath" => "/navigation/close.gif",
				"text" => $l_javaMenu["close"]
			);
		}
	}
	$navigationButtons = array_merge($navigationButtons, array(
			array("onclick" => "top.we_cmd('start_multi_editor');", "imagepath" => "/navigation/home.gif", "text" => $l_javaMenu["home"]),
			array("onclick" => "top.weNavigationHistory.navigateReload();", "imagepath" => "/navigation/reload.gif", "text" => $l_javaMenu["reload"]),
			array("onclick" => "top.weNavigationHistory.navigateBack();", "imagepath" => "/navigation/back.gif", "text" => $l_javaMenu["back"]),
			array("onclick" => "top.weNavigationHistory.navigateNext();", "imagepath" => "/navigation/next.gif", "text" => $l_javaMenu["next"]),

		)
	);
}

?>
		<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR; ?>images.js"></script>
		<script src="<?php print JS_DIR; ?>weSidebar.php" language="JavaScript" type="text/javascript"></script>
		<script language="JavaScript" type="text/javascript">
			// initialize siebar in webedition.php
			top.weSidebar = weSidebar;

			preload("busy_icon","<?php print IMAGE_DIR; ?>logo-busy.gif");
			preload("empty_icon","<?php print IMAGE_DIR; ?>pixel.gif");
			function toggleBusy(foo){
				if(!document.images["busy"]){
					setTimeout("toggleBusy("+foo+")",200);
				}else{
					changeImage(null,"busy",(foo ? "busy_icon" : "empty_icon"));
				}
			}

			var appletTrys = 0;
			function checkApplet() {
				<?php

					if ( ($GLOBALS["BROWSER"] != "NN6")  && ( !(isset($_REQUEST["showAltMenu"]) && $_REQUEST["showAltMenu"]) ) ) { ?>

				try {
					if(!document.weJavaMenuApplet.getBgImage) {
						checkAndLoadAltMenu();
					}
				} catch (e) {
					checkAndLoadAltMenu();
				}
				appletTrys += 1;
				<?php } ?>
			}

			function checkAndLoadAltMenu() {
				if (appletTrys < 3) {
					setTimeout("checkApplet()",500);
				} else {
					document.location = "headermenu.php?showAltMenu=true";
				}
			}
		</script>
	</head>
<body background="<?php print IMAGE_DIR ?>java_menu/background.gif" bgcolor="#bfbfbf" leftmargin="0" topmargin="0" marginheight="0" marginwidth="0"<?php if($GLOBALS["SYSTEM"]=="WIN"): ?> onload="if(top.makefocus != null){top.focusise();}"<?php endif ?>>
<table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
<tr>
<?php
if ($jmenu) {
	print "
	<td align=\"left\" valign=\"top\" width=\"$_menu_width\">
		" . $jmenu->getCode() . "
	</td>
";
}

if ($amount = sizeof($navigationButtons)) {

	print '
	<td>
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td>' . getPixel(1, 1) . '</td>
		</tr>
		<tr>
			<td>' . getPixel(2, 1) . '</td>';

	for ($i=0; $i<$amount; $i++) {
		print "
		<td>
			<div class=\"navigation_normal\" onclick=\"{$navigationButtons[$i]["onclick"]}\" onmouseover=\"this.className='navigation_hover'\" onmouseout=\"this.className='navigation_normal'\"><img border=\"0\" hspace=\"2\" src=\"" . IMAGE_DIR . "{$navigationButtons[$i]["imagepath"]}\" width=\"17\" height=\"18\" alt=\"{$navigationButtons[$i]["text"]}\" title=\"{$navigationButtons[$i]["text"]}\"></div>
		</td>";
	}
	print "
		</tr>
		</table>
	</td>";
}
?>
	<td align="right" valign="middle">
		<table border="0" cellpadding="0" cellspacing="0">
		<tr valign="middle">
			<td>
				<?php
					include_once( $_SERVER['DOCUMENT_ROOT'] . "/webEdition/we/include/jsMessageConsole/messageConsole.inc.php" );
					print createMessageConsole("mainWindow");
				?>
			</td>
			<td valign="middle">
				<img src="<?php print IMAGE_DIR ?>pixel.gif" name="busy" width="20" height="19">
			</td>
			<td>
				<img src="<?php print IMAGE_DIR ?>pixel.gif" width="10" height="19">
			</td>
			<td valign="bottom">
				<img src="<?php print IMAGE_DIR ?>webedition.gif" width="78" height="25">
			</td>
			<td>
				<img src="<?php print IMAGE_DIR ?>pixel.gif" width="5" height="19">
			</td>
		</tr>
	</table>
	</td>
</tr>
</table>
</body>
</html>