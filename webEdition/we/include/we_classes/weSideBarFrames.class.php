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

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/SEEM/we_SEEM.class.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/sidebar.inc.php");

class weSideBarFrames {
	
	var $_frameset = "";
	
	function weSideBar() {
		
		$_frameset = WEBEDITION_DIR . "we/includes/sidebar.php";
		
	}
	

	function getHTML($what){
		
		switch($what) {
				
			case 'header':
				print $this->getHTMLHeader();
				break;
				
			case 'content':
				print $this->getHTMLContent();
				break;
				
			case 'footer':
				print $this->getHTMLFooter();
				break;
			
			case 'frameset':
			default:
				print $this->getHTMLFrameset();
				break;
				
		}
		
	}
	
	
	function getHTMLFrameset() {
?>
</head>

<frameset rows="22,*,40" framespacing="0" border="1" frameborder="NO">
	<frame src="<?php print $this->_frameset; ?>?pnt=header" name="weSidebarHeader" scrolling="no" noresize>
	<frame src="<?php print $this->_frameset; ?>?pnt=content" name="weSidebarContent" scrolling="auto" noresize>
	<frame src="<?php print $this->_frameset; ?>?pnt=footer" name="weSidebarFooter" scrolling="no" noresize>
</frameset>
		
<body bgcolor="#bfbfbf" leftmargin="0" topmargin="0" marginheight="0" marginwidth="0">
</body>

</html>
		<?php
	}

	
	function getHTMLHeader(){
?>
<style type="text/css">
body {
	margin			: 0px;
	padding			: 0px;
	border			: 0px;
	border-top		: 1px solid #000000;
	font-family		: Verdana, Arial, sans-serif;
	font-size		: 10px;
	color			: #000000;
	background-color: silver;
	background-image: url('<?php echo IMAGE_DIR; ?>/backgrounds/multitabBG.gif');
}
#Headline {
	padding-left	: 5px;
	line-height		: 20px;
	vertical-align	: middle;
	float			: left;
	width			: 80%;
}
#CloseButton {
	padding-top		: 3px;
	padding-right	: 4px;
	float			: right;
}
</style>
</head>
<body>
<div id="Headline">
	<?php echo $GLOBALS['l_sidebar']['headline']; ?>
</div>
<div id="CloseButton">
	<img src="<?php echo IMAGE_DIR; ?>/multiTabs/close.gif" border="0" vspace="0" hspace="0" onclick="top.weSidebar.close();" onmouseover="this.src='<?php echo IMAGE_DIR; ?>/multiTabs/closeOver.gif'" onmouseout="this.src='<?php echo IMAGE_DIR; ?>/multiTabs/close.gif'" />
</div>

</body>

</html>
<?php
	}

	
	function getHTMLFooter(){
?>
</head>
<body bgcolor="#f0f0f0"  background="/webEdition/images/edit/editfooterback.gif" marginwidth="0" marginheight="10" leftmargin="0" topmargin="10">
</body>

</html>
<?php
	}

	
	function getHTMLContent() {
		
		$file = isset($_REQUEST['we_cmd'][1]) ? $_REQUEST['we_cmd'][1] : "";
		define("WE_SIDEBAR", true);
		
		if(eregi("^http://", $file) || eregi("^https://", $file)) {
			header("Location: " . $file);
			exit();
			
		}
		
		if(!eregi("^/", $file)) {
			$file = id_to_path($file, FILE_TABLE);
			
		}
		
		if(!file_exists($_SERVER['DOCUMENT_ROOT'] . $file) || !is_file($_SERVER['DOCUMENT_ROOT'] . $file)) {
			if(defined("SIDEBAR_DEFAULT_DOCUMENT")) {
				$file = id_to_path(SIDEBAR_DEFAULT_DOCUMENT, FILE_TABLE);
			}
			if($file == "" || eregi("/$", $file) || $file == "default") {
				$file = WEBEDITION_DIR . "sidebar/default.php";
				
			}
			
		}
		
		ob_start();
		include($_SERVER['DOCUMENT_ROOT'] . $file);
		
		$SrcCode = ob_get_contents();
		ob_end_clean();
		
        $SrcCode = we_SEEM::parseDocument($SrcCode);
		echo $SrcCode;
		
		exit();
		
	}
	
	
}



?>