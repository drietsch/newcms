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

include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_classes/we_dirSelector.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_language/'.$GLOBALS['WE_LANGUAGE'].'/navigation.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_classes/html/'.'we_button.inc.php');

class we_navigationDirSelector extends we_dirSelector{

	var $fields = 'ID,ParentID,Text,Path,IsFolder,Icon,Charset';
	
	function we_navigationDirSelector($id,
								$JSIDName='',
								$JSTextName='',
								$JSCommand='',
								$order='',
								$we_editDirID='',
								$FolderText=''){
		
		$JSIDName = stripslashes($JSIDName);
		$JSTextName = stripslashes($JSTextName);

		$this->we_dirSelector($id,
								NAVIGATION_TABLE,
								$JSIDName,
								$JSTextName,
								$JSCommand,
								$order,
								'',
								$we_editDirID,
								$FolderText
								);
		$this->userCanMakeNewFolder = true;

	}


  	function printHeaderHeadlines(){
		print '			<table border="0" cellpadding="0" cellspacing="0" width="550">         
				<tr>
					<td>'.getPixel(25,14).'</td>             
					<td class="selector"colspan="2"><b><a href="#" onclick="javascript:top.orderIt(\'IsFolder DESC, Text\');">'.$GLOBALS['l_navigation']['name'].'</a></b></td> 
				</tr>
				<tr>  
					<td width="25">'.getPixel(25,1).'</td>								
					<td width="200">'.getPixel(200,1).'</td>								
					<td width="300">'.getPixel(300,1).'</td>
				</tr>  
			</table>
';

  	}

	function printFooterTable() {
		$we_button = new we_button();
		print '
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td colspan="5"><img src="'.IMAGE_DIR.'umr_h_small.gif" width="100%" height="2" border="0"></td>
				</tr>
				<tr>
					<td colspan="5">'.getPixel(5,5).'</td>
				</tr>';
		$cancel_button = $we_button->create_button('cancel', 'javascript:top.exit_close();');
		$yes_button = $we_button->create_button('ok', "javascript:press_ok_button();");
		$buttons = $we_button->position_yes_no_cancel(
												$yes_button,
												null,
												$cancel_button);
		print '
				<tr>
					<td></td>
					<td class="defaultfont">
						<b>'.$GLOBALS['l_navigation']['name'].'</b>
					</td>
					<td></td>
					<td class="defaultfont" align="left"><div id="showDiv" style="width:100%; height :100%; background-color: #dce6f2; border: #AAAAAA solid 1px;"></div><div style="display:none;">'.htmlTextInput('fname',24,$this->values['Text'],'','style="width:100%" readonly="readonly"').'</div>
					</td>
					<td></td>
				</tr>
				<tr>
					<td width="10">'.getPixel(10,5).'</td>
					<td width="70">'.getPixel(70,5).'</td>
					<td width="10">'.getPixel(10,5).'</td>
					<td>'.getPixel(5,5).'</td>
					<td width="10">'.getPixel(10,5).'</td>
				</tr>
			</table><table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td align="right">'.$buttons.'</td>
					<td width="10">'.getPixel(10,5).'</td>
				</tr>
			</table>';
	}


	function printHeaderTableExtraCols(){
		print '                <td width="10">'.getPixel(10,10).'</td><td width="40">
';                  
        $makefolderState = we_hasPerm("EDIT_NAVIGATION");
       	print '<script language="JavaScript">makefolderState='.$makefolderState.';</script>';
 		$we_button = new we_button();
		print $we_button->create_button("image:btn_new_dir", "javascript:if(makefolderState==1){top.drawNewFolder();}",true,-1,22,"","",$makefolderState ? false : true);
 		print '               </td>
';
	}

	function printFramesetJSFunctioWriteBody(){
		global $BROWSER;
		$htmltop = ereg_replace("[[:cntrl:]]","",trim(str_replace("'","\\'",getHtmlTop())));
		$htmltop = str_replace('script', "scr' + 'ipt", $htmltop);
?>

function writeBody(d){
	d.open();
	//d.writeln('<?php print $htmltop; ?>'); Geht nicht im IE
	d.writeln('<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head><title>webEdition (c) living-e AG</title><meta http-equiv="expires" content="0"><meta http-equiv="pragma" content="no-cache"><meta http-equiv="content-type" content="text/html; charset=ISO-8859-1"><meta http-equiv="imagetoolbar" content="no"><meta name="generator" content="webEdition Version 4.9.0.0">');
	d.writeln('<?php print STYLESHEET_SCRIPT;?>');
	d.writeln('</head>');
	d.writeln('<scr'+'ipt>');
	
	<?php print $this->getJS_attachKeyListener(); ?>
	
	//from we_showMessage.js
	d.writeln('var WE_MESSAGE_INFO = -1;');
	d.writeln('var WE_MESSAGE_FRONTEND = -2;');
	d.writeln('var WE_MESSAGE_NOTICE = 1;');
	d.writeln('var WE_MESSAGE_WARNING = 2;');
	d.writeln('var WE_MESSAGE_ERROR = 4;');
	d.writeln('function we_showMessage (message, prio, win) {');
	d.writeln('if (win.top.showMessage != null) {');
	d.writeln('win.top.showMessage(message, prio, win);');
	d.writeln('} else if (win.top.opener) {');
	d.writeln('if (win.top.opener.top.showMessage != null) {');
	d.writeln('win.top.opener.top.showMessage(message, prio, win);');
	d.writeln('} else if (win.top.opener.top.opener.top.showMessage != null) {');
	d.writeln('win.top.opener.top.opener.top.showMessage(message, prio, win);');
	d.writeln('} else if (win.top.opener.top.opener.top.opener.top.showMessage != null) {');
	d.writeln('win.top.opener.top.opener.top.showMessage(message, prio, win);');
	d.writeln('}');
	d.writeln('} else { // there is no webEdition window open, just show the alert');
	d.writeln('if (!win) {');
	d.writeln('win = window;');
	d.writeln('}');
	d.writeln('win.alert(message);');
	d.writeln('}');
	d.writeln('}');

	d.writeln('var ctrlpressed=false');
	d.writeln('var shiftpressed=false');
	d.writeln('var inputklick=false');
	d.writeln('var wasdblclick=false');
	d.writeln('var tout=null');
	d.writeln('document.onclick = weonclick;');
	d.writeln('function weonclick(e){');
	if(makeNewFolder ||  we_editDirID){
	d.writeln('if(!inputklick){');
	d.writeln('document.we_form.we_FolderText.value=escape(document.we_form.we_FolderText_tmp.value);document.we_form.submit();');
	d.writeln('}else{  ');
	d.writeln('inputklick=false;');
	d.writeln('}  ');
	}else{
	d.writeln('inputklick=false;');
	d.writeln('if(document.all){');
	d.writeln('if(event.ctrlKey || event.altKey){ ctrlpressed=true;}');
	d.writeln('if(event.shiftKey){ shiftpressed=true;}');
	d.writeln('}else{  ');
	d.writeln('if(e.altKey || e.metaKey || e.ctrlKey){ ctrlpressed=true;}');
	d.writeln('if(e.shiftKey){ shiftpressed=true;}');
	d.writeln('}');
<?php if($this->multiple): ?>
	d.writeln('if((self.shiftpressed==false) && (self.ctrlpressed==false)){top.unselectAllFiles();}');
<?php else: ?>
	d.writeln('top.unselectAllFiles();');
<?php endif ?>
	}
	d.writeln('}');
	d.writeln('</scr'+'ipt>');
	d.writeln('<body bgcolor="white" LINK="#000000" ALINK="#000000" VLINK="#000000" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0">');
	d.writeln('<form name="we_form" target="fscmd" action="<?php print $_SERVER["PHP_SELF"]; ?>">');
	if(top.we_editDirID){
		d.writeln('<input type="hidden" name="what" value="<?php print FS_DORENAMEFOLDER; ?>">');
		d.writeln('<input type="hidden" name="we_editDirID" value="'+top.we_editDirID+'">');
	}else{
		d.writeln('<input type="hidden" name="what" value="<?php print FS_CREATEFOLDER; ?>">');
	}
	d.writeln('<input type="hidden" name="order" value="'+top.order+'">');
	d.writeln('<input type="hidden" name="rootDirID" value="<?php print $this->rootDirID; ?>">');
	d.writeln('<input type="hidden" name="table" value="<?php print $this->table; ?>">');
	d.writeln('<input type="hidden" name="id" value="'+top.currentDir+'">');
	d.writeln('<table border="0" cellpadding="0" cellspacing="0" width="100%">');
	if(makeNewFolder){
		d.writeln('<tr style="background-color:#DFE9F5;">');
		d.writeln('<td align="center"><img src="<?php print ICON_DIR?>folder.gif" width="16" height="18" border="0"></td>');
		d.writeln('<td><input type="hidden" name="we_FolderText" value="<?php print $GLOBALS["l_navigation"]["newFolder"]?>"><input onMouseDown="self.inputklick=true" name="we_FolderText_tmp" type="text" value="<?php print $GLOBALS["l_navigation"]["newFolder"]?>"  class="wetextinput" onblur="this.className=\'wetextinput\';" onfocus="this.className=\'wetextinputselected\'" style="width:100%"></td>');
		d.writeln('</tr>');
	}
	for(i=0;i < entries.length; i++){
		var onclick = ' onClick="weonclick(<?php echo ($BROWSER=="IE"?"this":"event")?>);tout=setTimeout(\'if(top.wasdblclick==0){top.doClick('+entries[i].ID+',0);}else{top.wasdblclick=0;}\',300);return true"';
		var ondblclick = ' onDblClick="top.wasdblclick=1;clearTimeout(tout);top.doClick('+entries[i].ID+',1);return true;"';
		d.writeln('<tr id="line_'+entries[i].ID+'" style="' + ((entries[i].ID == top.currentID && (!makeNewFolder) )  ? 'background-color:#DFE9F5;' : '')+'cursor:pointer;'+((we_editDirID != entries[i].ID) ? '-moz-user-select: none;' : '' )+'"'+((we_editDirID || makeNewFolder) ? '' : onclick)+ (entries[i].isFolder ? ondblclick : '') + ' unselectable="on">');
		d.writeln('<td class="selector" width="25" align="center">');
		d.writeln('<img src="<?php print ICON_DIR; ?>'+entries[i].icon+'" width="16" height="18" border="0">');
		d.writeln('</td>');
		if(we_editDirID == entries[i].ID){
			d.writeln('<td class="selector">');
			d.writeln('<input type="hidden" name="we_FolderText" value="'+entries[i].text+'"><input onMouseDown="self.inputklick=true" name="we_FolderText_tmp" type="text" value="'+entries[i].text+'" class="wetextinput" onblur="this.className=\'wetextinput\';" onfocus="this.className=\'wetextinputselected\'" style="width:100%">');
		}else{
			d.writeln('<td class="selector" style="-moz-user-select: none;" unselectable="on">');
			//d.writeln(cutText(entries[i].text,24));
			d.writeln(entries[i].text);
		}
		d.writeln('</td>');
		d.writeln('</tr><tr><td colspan="3"><?php print getPixel(2,1); ?></td></tr>');
	}
	d.writeln('<tr>');
	d.writeln('<td width="25"><?php print getPixel(25,2)?></td>');
	d.writeln('<td><?php print getPixel(200,2)?></td>');								
	d.writeln('</tr>');
	d.writeln('</table></form>');
	if(makeNewFolder || top.we_editDirID){
		d.writeln('<scr'+'ipt language="JavaScript">document.we_form.we_FolderText_tmp.focus();document.we_form.we_FolderText_tmp.select();</scr'+'ipt>');
	}
	d.writeln('</body>');
	d.close();
}

<?php

	}
	
	function printFramesetJSFunctionQueryString(){
?>

function queryString(what,id,o,we_editDirID){
	if(!o) o=top.order;
	if(!we_editDirID) we_editDirID="";
	return '<?php print $_SERVER["PHP_SELF"]; ?>?what='+what+'&rootDirID=<?php print $this->rootDirID; ?><?php if(isset($this->open_doc)){print "&open_doc=".$this->open_doc;} ?>&table=<?php print $this->table; ?>&id='+id+(o ? ("&order="+o) : "")+(we_editDirID ? ("&we_editDirID="+we_editDirID) : "");
}

<?php

	}

	function printFramesetJSFunctionEntry(){
?>

function entry(ID,icon,text,isFolder,path){
	this.ID=ID;
	this.icon=icon;
	this.text=text;
	this.isFolder=isFolder;
	this.path=path;
}

<?php

	}

	function printFramesetJSFunctionAddEntry(){
?>

function addEntry(ID,icon,text,isFolder,path){
	entries[entries.length] = new entry(ID,icon,text,isFolder,path);
}

<?php

	}

	function printFramesetJSFunctionAddEntries(){
		while($this->next_record()){			
			$_text = $this->f('Text');
			$_charset = $this->f('Charset');
			if(function_exists('mb_convert_encoding') && !empty($_charset)) {
				$_text = mb_convert_encoding($this->f('Text'), 'HTML-ENTITIES', $_charset);				
			}
			print 'addEntry('.$this->f('ID').',"'.$this->f('Icon').'","'.$_text.'",'.$this->f('IsFolder').',"'.$this->f('Path').'");'."\n";
		}
	}

	function printCmdAddEntriesHTML(){
		$this->query();
		while($this->next_record()){
			$_text = $this->f('Text');
			$_charset = $this->f('Charset');
			if(function_exists('mb_convert_encoding') && !empty($_charset)) {
				$_text = mb_convert_encoding($this->f('Text'), 'HTML-ENTITIES', $_charset);				
			}
			print 'top.addEntry('.$this->f('ID').',"'.$this->f('Icon').'","'.$_text.'",'.$this->f('IsFolder').',"'.$this->f('Path').'");'."\n";
		}
  	}
  	
	function printCreateFolderHTML(){
		htmlTop();		
protect();								

		print '<script>
top.clearEntries();
';
		$this->FolderText = rawurldecode($this->FolderText);
		$txt = '';
		if(isset($_REQUEST['we_FolderText_tmp'])){
			$txt = rawurldecode($_REQUEST['we_FolderText_tmp']);
		}
		if($txt==''){
			print we_message_reporting::getShowMessageCall($l_navigation['wrongtext'], WE_MESSAGE_ERROR);
		}else{
			include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/'.'we_classes/we_folder.inc.php');
			include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_tools/navigation/class/weNavigation.class.php');
			$folder= new we_folder();
			$folder->we_new();
			$folder->setParentID($this->dir);
			$folder->Table=$this->table;
			$folder->Icon='folder.gif';
			$folder->Text=$txt;
			$folder->Path=$folder->getPath();
			$this->db->query("SELECT ID FROM ".$this->table." WHERE Path='".$folder->Path."'");
			if($this->db->next_record()){
				print we_message_reporting::getShowMessageCall($GLOBALS['l_navigation']['folder_path_exists'], WE_MESSAGE_ERROR);
			}else{
				if(weNavigation::filenameNotValid($folder->Text)){
					print we_message_reporting::getShowMessageCall($GLOBALS['l_navigation']['wrongtext'], WE_MESSAGE_ERROR);
		         }else{
					$folder->we_save();
		         	print 'var ref;		         	
if(top.opener.top.makeNewEntry){		   
	ref = top.opener.top;
	ref.makeNewEntry("folder.gif",'.$folder->ID.',"'.$folder->ParentID.'","'.$txt.'",1,"folder","'.$this->table.'",0,0);
}
';
if($this->canSelectDir){
					print 'top.currentPath = "'.$folder->Path.'";
top.currentID = "'.$folder->ID.'";
top.fsfooter.document.we_form.fname.value = "'.$folder->Text.'";
';
}
				}                    

			}
		}           


		$this->printCmdAddEntriesHTML();
		$this->printCMDWriteAndFillSelectorHTML();

print 'top.makeNewFolder = 0;
top.selectFile(top.currentID);
</script>
';
		print '</head><body></body></html>';
	}

	function query(){
		$ws_query = getWsQueryForSelector(NAVIGATION_TABLE);
		$this->db->query("SELECT ".$this->fields.", abs(text) as Nr, (text REGEXP '^[0-9]') as isNr FROM ".
		$this->table.
		" WHERE IsFolder=1 AND ParentID='".$this->dir."' ". 
		$ws_query .
		" ORDER BY Ordn, isNr DESC,Nr,Text;");
	}

	function printDoRenameFolderHTML(){
		htmlTop();		
		protect();

		print '<script>
top.clearEntries();
';
		$this->FolderText = rawurldecode($this->FolderText);
		$txt = $this->FolderText;
		if($txt==''){
			print we_message_reporting::getShowMessageCall($GLOBALS['l_navigation']['folder_empty'], WE_MESSAGE_ERROR);
		}else{
			include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_classes/we_folder.inc.php');
			$folder= new we_folder();
			$folder->initByID($this->we_editDirID,$this->table);
			$folder->Text=$txt;
			$folder->Filename=$txt;
			$folder->Path=$folder->getPath();
			$this->db->query("SELECT ID,Text FROM ".$this->table." WHERE Path='".$folder->Path."' AND ID != '".$this->we_editDirID."'");
			if($this->db->next_record()){
				$we_responseText = sprintf($GLOBALS["l_navigation"]["folder_exists"],$folder->Path);
				print we_message_reporting::getShowMessageCall($we_responseText, WE_MESSAGE_ERROR);
			}else{
				if(ereg('[%/\\"\']',$folder->Text)){
					$we_responseText = $GLOBALS["l_navigation"]["wrongtext"];
					print we_message_reporting::getShowMessageCall($we_responseText, WE_MESSAGE_ERROR);
				}else{
					if(f("SELECT Text FROM ".$this->table." WHERE ID='".$this->we_editDirID."'","Text",$this->db) != $txt){
						$folder->we_save();
						print 'var ref;
if(top.opener.top.updateEntry){
	ref = top.opener.top;
	ref.updateEntry('.$folder->ID.',"'.$txt.'","'.$folder->ParentID.'",1,0);
}
';
						if($this->canSelectDir){
							print 'top.currentPath = "'.$folder->Path.'";
top.currentID = "'.$folder->ID.'";
top.fsfooter.document.we_form.fname.value = "'.$folder->Text.'";
';
						}
					}
				}
				
			}
		}
		
		
		$this->printCmdAddEntriesHTML();
		$this->printCMDWriteAndFillSelectorHTML();
		
		print 'top.makeNewFolder = 0;
top.selectFile(top.currentID);
</script>
';
		print '</head><body></body></html>';
	}
	
	

	function printFramesetSelectFileHTML(){
?>

function selectFile(id){
	if(id){
		e = getEntry(id);
		if( top.fsfooter.document.we_form.fname.value != e.text &&
			top.fsfooter.document.we_form.fname.value.indexOf(e.text+",") == -1 &&
			top.fsfooter.document.we_form.fname.value.indexOf(","+e.text+",") == -1 &&
			top.fsfooter.document.we_form.fname.value.indexOf(","+e.text+",") == -1 ){
			
			top.fsfooter.document.we_form.fname.value =  top.fsfooter.document.we_form.fname.value ?
																(top.fsfooter.document.we_form.fname.value + "," + e.text) :
																e.text;
																
			var show = top.fsfooter.document.getElementById("showDiv");
			if(show){
				show.innerHTML = top.fsfooter.document.we_form.fname.value;
			}
																
		}
		if(top.fsbody.document.getElementById("line_"+id)) top.fsbody.document.getElementById("line_"+id).style.backgroundColor="#DFE9F5";
		currentPath = e.path;
		currentID = id;

		we_editDirID = 0;
	}else{
		top.fsfooter.document.we_form.fname.value = "";
		currentPath = "";
		we_editDirID = 0;
	}
}

<?php
	}	
	
	
}



?>