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

if(!$_SESSION["user"]["Username"])
	session_id;

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/contenttypes.inc.php");

protect();
htmltop();

$docroot = $_SERVER["DOCUMENT_ROOT"];
$docroot = str_replace("\\","/",(substr($docroot,-1) == "/") ? substr($docroot,0,strlen($docroot)-1) : $docroot);

$filter = (isset($_REQUEST["we_cmd"][2]) && $_REQUEST["we_cmd"][2] != "") ? $_REQUEST["we_cmd"][2] : "all_Types";
$currentDir = (  isset($_REQUEST["we_cmd"][3]) ? ($_REQUEST["we_cmd"][3] == "/") ? "" : ( is_dir($docroot.$_REQUEST["we_cmd"][3]) ? $_REQUEST["we_cmd"][3] : str_replace("\\","/",dirname($_REQUEST["we_cmd"][3])))  :  "");
if($filter != "folder"){
	$currentName = basename(isset($_REQUEST["we_cmd"][3]) ? $_REQUEST["we_cmd"][3] : "");
}else{
	$currentName = "";
}
if(!file_exists($docroot.$currentDir."/".$currentName)){
	$currentDir="";
	$currentName = "";
}
if($filter == "folder" || $filter == "filefolder"){
	$currentID = $docroot.$currentDir;
}else{
	$currentID = $docroot.$currentDir.(($currentDir != "") ? "/" : "").$currentName;
}

$currentID = str_replace("\\","/",$currentID);
$currentDir = str_replace("\\","/",$currentDir);

$rootDir = ((isset($_REQUEST["we_cmd"][5]) && $_REQUEST["we_cmd"][5] != "") ? $_REQUEST["we_cmd"][5] : "");

?>
<script language="JavaScript" type="text/javascript">
     var rootDir="<?php print $rootDir; ?>";
     var currentID="<?php print $currentID; ?>";
     var currentDir="<?php print str_replace($rootDir, "", $currentDir); ?>";
     var currentName="<?php print $currentName; ?>";
     var currentFilter="<?php print ereg_replace(" ","%20",isset($l_contentTypes[$filter]) ? $l_contentTypes[$filter] : ""); ?>";
     var filter = '<?php print $filter; ?>';
     var browseServer = <?php print isset($_REQUEST["we_cmd"][1]) ? "false" : "true"; ?>

     var currentType="<?php print ($filter == "folder") ? "folder" : ""; ?>";
     var sitepath="<?php print $docroot; ?>";
     var dirsel=1;
     var scrollToVal = 0;
     var allentries = new Array();

     function exit_close(){
<?php if( isset($_REQUEST["we_cmd"][1]) && $_REQUEST["we_cmd"][1] !="") :?>
     	var foo;
     	if(currentID){
     		if(currentID == sitepath) foo = "/";
     		else foo = currentID.substring(sitepath.length);
     	}else{
     		foo = "/";
     	}

      opener.<?php print $_REQUEST["we_cmd"][1]?>=foo;
      if(!!opener.postSelectorSelect) {
      	opener.postSelectorSelect('selectFile');
      }
      
<?php endif?>
<?php if(isset($_REQUEST["we_cmd"][4]) && $_REQUEST["we_cmd"][4]!="") :?>
	<?php print $_REQUEST["we_cmd"][4].";\n"; ?>
<?php endif?>
     close();
     }

     self.focus();
     
     function closeOnEscape() {
     	return true;
     	
     }
     
</script>
<script type="text/javascript" src="<?php print JS_DIR . "keyListener.js"; ?>"></script>
</head>

<frameset rows="73,*,<?php print ( (isset($_REQUEST["we_cmd"][2]) && $_REQUEST["we_cmd"][2] ) ? 60 : 90); ?>,0" border="0" onload="top.fscmd.selectDir()">
  <frame src="we_sselector_header.php?ret=<?php print ( (isset($_REQUEST["we_cmd"][1]) && $_REQUEST["we_cmd"][1]) ? 1 : 0); ?>&filter=<?php print $filter; ?>&currentDir=<?php print $currentDir; ?>" name="fsheader" noresize scrolling="no">
  <frame src="<?php print HTML_DIR;?>white.html" name="fsbody" noresize scrolling="auto">
  <frame  src="we_sselector_footer.php?ret=<?php print ( (isset($_REQUEST["we_cmd"][1]) && $_REQUEST["we_cmd"][1])  ? 1 : 0); ?>&filter=<?php print $filter; ?>&currentName=<?php print $currentName; ?>" name="fsfooter" noresize scrolling="no">
  <frame src="we_sselector_cmd.php?ret=<?php print ( (isset($_REQUEST["we_cmd"][1]) && $_REQUEST["we_cmd"][1]) ? 1 : 0); ?>&filter=<?php print $filter; ?>&currentName=<?php print $currentName; ?>" name="fscmd" noresize scrolling="no">
</frameset>
<body>
</body>
</html>
