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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_multiSelector.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/banner.inc.php");

define("FS_SETDIR",5);

class we_bannerSelector extends we_multiSelector{

	var $fields = "ID,ParentID,Text,Path,IsFolder,Icon";
	
	function we_bannerSelector($id,
								$JSIDName="",
								$JSTextName="",
								$JSCommand="",
								$order=""){
		
		$this->we_multiSelector($id,
								BANNER_TABLE,
								$JSIDName,
								$JSTextName,
								$JSCommand,
								$order);


	}

	function printFramesetJSDoClickFn(){
?>
function doClick(id,ct){
	if(ct==1){
		if(wasdblclick){
			setDir(id);
			setTimeout('wasdblclick=0;',400);
		}
	}else{
		e=top.getEntry(id);
		if(e.isFolder){
			if(top.currentID == id){
				top.RenameFolder(id);
			}
		}else{
			selectFile(id);
		}
	}
}
<?php
	}


  	function printHeaderHeadlines(){
		print '			<table border="0" cellpadding="0" cellspacing="0" width="550">         
				<tr>
					<td>'.getPixel(25,14).'</td>             
					<td class="selector"colspan="2"><b><a href="#" onclick="javascript:top.orderIt(\'IsFolder DESC, Text\');">'.$GLOBALS["l_banner"]["name"].'</a></b></td> 
				</tr>
				<tr>  
					<td width="25">'.getPixel(25,1).'</td>								
					<td width="200">'.getPixel(200,1).'</td>								
					<td width="300">'.getPixel(300,1).'</td>
				</tr>  
			</table>
';

  	}



	
	function printFramesetJSsetDir(){
?>
function setDir(id){
	top.fscmd.location.replace(top.queryString(<?php print FS_SETDIR; ?>,id));
}


<?php
	}


	function printSetDirHTML(){
		print '<script>
top.clearEntries();
';
		$this->printCmdAddEntriesHTML();
		$this->printCMDWriteAndFillSelectorHTML();

if(abs($this->dir)==0){
	print 'top.fsheader.disableRootDirButs();
';
}else{
	print 'top.fsheader.enableRootDirButs();
';
}
print 'top.currentDir = "'.$this->dir.'";
top.parentID = "'.$this->values["ParentID"].'";
</script>
';
		$GLOBALS["we_fs_lastDir"][$this->table] = $this->dir;
	}

	function printHTML($what=FS_FRAMESET){
		switch($what){
			case FS_HEADER:
			$this->printHeaderHTML();
			break;
			case FS_FOOTER:
			$this->printFooterHTML();
			break;
			case FS_BODY:
			$this->printBodyHTML();
			break;
			case FS_CMD:
			$this->printCmdHTML();
			break;
			case FS_SETDIR:
			$this->printSetDirHTML();
			break;
			case FS_FRAMESET:
			default:
			$this->printFramesetHTML();
		}
	}
}

?>