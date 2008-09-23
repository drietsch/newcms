
include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/lib/we/core/autoload.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_classes/we_dirSelector.inc.php');
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/tools.inc.php");

class we_<?php print $TOOLNAME; ?>DirSelector extends we_dirSelector{

	var $fields = 'ID,ParentID,Text,Path,IsFolder,ContentType';
	
	function we_<?php print $TOOLNAME; ?>DirSelector($id,
								$JSIDName='',
								$JSTextName='',
								$JSCommand='',
								$order='',
								$we_editDirID='',
								$FolderText=''){
		
		$JSIDName = stripslashes($JSIDName);
		$JSTextName = stripslashes($JSTextName);

		$this->we_dirSelector($id,
								<?php print (isset($TABLECONSTANT) && !empty($TABLECONSTANT)) ? $TABLECONSTANT : "''";?>,
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
					<td class="selector"colspan="2"><b><a href="#" onclick="javascript:top.orderIt(\'IsFolder DESC, Text\');">'.$GLOBALS['l_tools']['name'].'</a></b></td> 
				</tr>
				<tr>  
					<td width="25">'.getPixel(25,1).'</td>								
					<td width="200">'.getPixel(200,1).'</td>								
					<td width="300">'.getPixel(300,1).'</td>
				</tr>  
			</table>
';

  	}

	function printHeaderTableExtraCols(){
		print '<td></td>';
	}

	function printFramesetJSFunctioWriteBody(){
		global $BROWSER;
		$htmltop = ereg_replace("[[:cntrl:]]","",trim(str_replace("'","\\'",getHtmlTop())));
		$htmltop = str_replace('script', "scr' + 'ipt", $htmltop);
?>

function writeBody(d){
	d.open();
	//d.writeln('<?php print '<?php print $htmltop; ?>';?>'); Geht nicht im IE
	d.writeln('<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head><title>webEdition (c) living-e AG</title><meta http-equiv="expires" content="0"><meta http-equiv="pragma" content="no-cache"><meta http-equiv="content-type" content="text/html; charset=ISO-8859-1"><meta http-equiv="imagetoolbar" content="no"><meta name="generator" content="webEdition Version 4.9.0.0">');
	d.writeln('<?php print '<?php print STYLESHEET_SCRIPT;?>';?>');
	d.writeln('</head>');
	d.writeln('<scr'+'ipt>');
	
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
<?php print '<?php if($this->multiple): ?>';?>
	d.writeln('if((self.shiftpressed==false) && (self.ctrlpressed==false)){top.unselectAllFiles();}');
<?php print '<?php else: ?>';?>
	d.writeln('top.unselectAllFiles();');
<?php print '<?php endif ?>';?>
	}
	d.writeln('}');
	d.writeln('</scr'+'ipt>');
	d.writeln('<body bgcolor="white" LINK="#000000" ALINK="#000000" VLINK="#000000" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0">');
	d.writeln('<form name="we_form" target="fscmd" action="<?php print '<?php print $_SERVER["PHP_SELF"]; ?>';?>">');
	if(top.we_editDirID){
		d.writeln('<input type="hidden" name="what" value="<?php print '<?php print FS_DORENAMEFOLDER; ?>';?>">');
		d.writeln('<input type="hidden" name="we_editDirID" value="'+top.we_editDirID+'">');
	}else{
		d.writeln('<input type="hidden" name="what" value="<?php print '<?php print FS_CREATEFOLDER; ?>';?>">');
	}
	d.writeln('<input type="hidden" name="order" value="'+top.order+'">');
	d.writeln('<input type="hidden" name="rootDirID" value="<?php print '<?php print $this->rootDirID; ?>';?>">');
	d.writeln('<input type="hidden" name="table" value="<?php print '<?php print $this->table; ?>';?>">');
	d.writeln('<input type="hidden" name="id" value="'+top.currentDir+'">');
	d.writeln('<table border="0" cellpadding="0" cellspacing="0" width="100%">');
	if(makeNewFolder){
		d.writeln('<tr style="background-color:#DFE9F5;">');
		d.writeln('<td align="center"><img src="<?php print '<?php print WE_TOOLS_PATH;?>' . $TOOLNAME;?>/ui/themes/default/shared/icons/small/folder.gif" width="16" height="18" border="0"></td>');
		d.writeln('<td><input type="hidden" name="we_FolderText" value="<?php print '<?php print $GLOBALS["l_tools"]["newFolder"]?>';?>"><input onMouseDown="self.inputklick=true" name="we_FolderText_tmp" type="text" value="<?php print '<?php print $GLOBALS["l_tools"]["newFolder"]?>';?>"  class="wetextinput" onblur="this.className=\'wetextinput\';" onfocus="this.className=\'wetextinputselected\'" style="width:100%"></td>');
		d.writeln('</tr>');
	}
	for(i=0;i < entries.length; i++){
		var onclick = ' onClick="weonclick(<?php print '<?php echo ($BROWSER=="IE"?"this":"event")?>';?>);tout=setTimeout(\'if(top.wasdblclick==0){top.doClick('+entries[i].ID+',0);}else{top.wasdblclick=0;}\',300);return true"';
		var ondblclick = ' onDblClick="top.wasdblclick=1;clearTimeout(tout);top.doClick('+entries[i].ID+',1);return true;"';
		d.writeln('<tr id="line_'+entries[i].ID+'" style="' + ((entries[i].ID == top.currentID && (!makeNewFolder) )  ? 'background-color:#DFE9F5;' : '')+'cursor:pointer;'+((we_editDirID != entries[i].ID) ? '-moz-user-select: none;' : '' )+'"'+((we_editDirID || makeNewFolder) ? '' : onclick)+ (entries[i].isFolder ? ondblclick : '') + ' unselectable="on">');
		d.writeln('<td class="selector" width="25" align="center">');
		d.writeln('<img src="<?php print '<?php print WE_TOOLS_PATH;?>' . $TOOLNAME;?>/ui/themes/default/shared/icons/small/'+entries[i].icon+'" width="16" height="18" border="0">');
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
		d.writeln('</tr><tr><td colspan="3"><?php print '<?php print getPixel(2,1); ?>';?></td></tr>');
	}
	d.writeln('<tr>');
	d.writeln('<td width="25"><?php print '<?php print getPixel(25,2)?>';?></td>');
	d.writeln('<td><?php print '<?php print getPixel(200,2)?>';?></td>');								
	d.writeln('</tr>');
	d.writeln('</table></form>');
	if(makeNewFolder || top.we_editDirID){
		d.writeln('<scr'+'ipt language="JavaScript">document.we_form.we_FolderText_tmp.focus();document.we_form.we_FolderText_tmp.select();</scr'+'ipt>');
	}
	d.writeln('</body>');
	d.close();
}

<?php print '<?php';?>

	}
	
	function printFramesetJSFunctionQueryString(){
?>

function queryString(what,id,o,we_editDirID){
	if(!o) o=top.order;
	if(!we_editDirID) we_editDirID="";
	return '<?php print '<?php print $_SERVER["PHP_SELF"]; ?>';?>?what='+what+'&rootDirID=<?php print '<?php print $this->rootDirID; ?><?php if(isset($this->open_doc)){print "&open_doc=".$this->open_doc;} ?>';?>&table=<?php print '<?php print $this->table; ?>';?>&id='+id+(o ? ("&order="+o) : "")+(we_editDirID ? ("&we_editDirID="+we_editDirID) : "");
}

<?php print '<?php';?>

	}

	function printFramesetJSFunctionEntry(){
<?php print '?>';?>

function entry(ID,icon,text,isFolder,path){
	this.ID=ID;
	this.icon=icon;
	this.text=text;
	this.isFolder=isFolder;
	this.path=path;
}

<?php print '<?php';?>

	}

	function printFramesetJSFunctionAddEntry(){
?>

function addEntry(ID,icon,text,isFolder,path){
	entries[entries.length] = new entry(ID,icon,text,isFolder,path);
}

<?php print '<?php';?>

	}

	function printFramesetJSFunctionAddEntries(){
		while($this->next_record()){			
			$_text = $this->f('Text');
			$_charset = $this->f('Charset');

			print 'addEntry('.$this->f('ID').',"'.we_ui_layout_Image::getIconClass($this->f('ContentType')).'.gif","'.$_text.'",'.$this->f('IsFolder').',"'.$this->f('Path').'");'."\n";
		}
	}

	function printCmdAddEntriesHTML(){
		$this->query();
		while($this->next_record()){
			$_text = $this->f('Text');
			$_charset = $this->f('Charset');

			print 'top.addEntry('.$this->f('ID').',"'.we_ui_layout_Image::getIconClass($this->f('ContentType')).'.gif","'.$_text.'",'.$this->f('IsFolder').',"'.$this->f('Path').'");'."\n";
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
			print we_message_reporting::getShowMessageCall($GLOBALS['l_tools']['wrongtext'], WE_MESSAGE_ERROR);
		}else{
			include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/'.'we_classes/we_folder.inc.php');
			//include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/apps/<?php print $TOOLNAME; ?>/class/<?php print $CLASSNAME; ?>.class.php');
			$folder= new we_folder();
			$folder->we_new();
			$folder->setParentID($this->dir);
			$folder->Table=$this->table;
			$folder->Icon='folder.gif';
			$folder->Text=$txt;
			$folder->Path=$folder->getPath();
			$this->db->query("SELECT ID FROM ".$this->table." WHERE Path='".$folder->Path."'");
			if($this->db->next_record()){
				print we_message_reporting::getShowMessageCall($GLOBALS['l_tools']['folder_path_exists'], WE_MESSAGE_ERROR);
			}else{
				if(<?php print $CLASSNAME; ?>::filenameNotValid($folder->Text)){
					print we_message_reporting::getShowMessageCall($GLOBALS['l_tools']['wrongtext'], WE_MESSAGE_ERROR);
		         }else{
					$folder->we_save();
		         	print 'var ref = top.opener.top.content;
if(ref.makeNewEntry){		   
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
		$ws_query = getWsQueryForSelector(<?php print $TABLECONSTANT; ?>);
		$this->db->query("SELECT ".$this->fields.", abs(text) as Nr, (text REGEXP '^[0-9]') as isNr FROM ".
		$this->table.
		" WHERE IsFolder=1 AND ParentID='".$this->dir."' ". 
		$ws_query .
		" ORDER BY isNr DESC,Nr,Text;");
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
			print we_message_reporting::getShowMessageCall($GLOBALS['l_<?php print $TOOLNAME; ?>']['folder_empty'], WE_MESSAGE_ERROR);
		}else{
			include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_classes/we_folder.inc.php');
			$folder= new we_folder();
			$folder->initByID($this->we_editDirID,$this->table);
			$folder->Text=$txt;
			$folder->Filename=$txt;
			$folder->Path=$folder->getPath();
			$this->db->query("SELECT ID,Text FROM ".$this->table." WHERE Path='".$folder->Path."' AND ID != '".$this->we_editDirID."'");
			if($this->db->next_record()){
				$we_responseText = sprintf($GLOBALS["l_<?php print $TOOLNAME; ?>"]["folder_exists"],$folder->Path);
				print we_message_reporting::getShowMessageCall($we_responseText, WE_MESSAGE_ERROR);
			}else{
				if(ereg('[%/\\"\']',$folder->Text)){
					$we_responseText = $GLOBALS["l_<?php print $TOOLNAME; ?>"]["wrongtext"];
					print we_message_reporting::getShowMessageCall($we_responseText, WE_MESSAGE_ERROR);
				}else{
					if(f("SELECT Text FROM ".$this->table." WHERE ID='".$this->we_editDirID."'","Text",$this->db) != $txt){
						$folder->we_save();
						print 'var ref = top.opener.top.content;
if(ref.updateEntry){
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

<?php print '<?php';?>
	}	
	
	
<?php print '}';?>