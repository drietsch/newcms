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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_fileselector.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/we_editor.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/fileselector.inc.php");

class we_multiSelector extends we_fileselector {

	var $fields = "ID,ParentID,Text,Path,IsFolder,Icon";

	var $multiple = true;

	function we_multiSelector($id,
								$table=FILE_TABLE,
								$JSIDName="",
								$JSTextName="",
								$JSCommand="",
								$order="",
								$sessionID="",
								$rootDirID=0,
								$multiple=true,
								$filter=""){

		$this->we_fileselector($id,
								$table,
								$JSIDName,
								$JSTextName,
								$JSCommand,
								$order,
								$sessionID,
								$rootDirID,
								$filter);


		$this->rootDirID	= $rootDirID;
		$this->multiple	= $multiple;
	}


	function printFramesetJSFunctions(){
		parent::printFramesetJSFunctions();
?>

var allIDs ="";
var allPaths ="";
var allTexts ="";
var allIsFolder ="";

function fillIDs() {
	allIDs =",";
	allPaths =",";
	allTexts =",";
	allIsFolder =",";

	for	(var i=0;i < entries.length; i++) {
		if (isFileSelected(entries[i].ID)) {
			allIDs += (entries[i].ID + ",");
			allPaths += (entries[i].path + ",");
			allTexts += (entries[i].text + ",");
			allIsFolder += (entries[i].isFolder + ",");
		}
	}
	if(currentID != ""){
		if(allIDs.indexOf(","+currentID+",") == -1){
			allIDs += (currentID + ",");
		}
	}
	if(currentPath != ""){
		if(allPaths.indexOf(","+currentPath+",") == -1){
			allPaths += (currentPath + ",");
			allTexts += (we_makeTextFromPath(currentPath) + ",");
		}
	}

	if (allIDs == ",") {
		allIDs = "";
	}
	if (allPaths == ",") {
		allPaths = "";
	}
	if (allTexts == ",") {
		allTexts = "";
	}

	if (allIsFolder == ",") {
		allIsFolder = "";
	}



}

function we_makeTextFromPath(path){
	position =  path.lastIndexOf("/");
	if(position > -1 &&  position < path.length){
		return path.substring(position+1);
	}else{
		return "";
	}
}

<?php

	}

	function printFramesetJSFunctioWriteBody(){
		global $BROWSER;
		$htmltop = ereg_replace("[[:cntrl:]]","",trim(str_replace("'","\\'",getHtmlTop())));
		$htmltop = str_replace('script', "scr' + 'ipt", $htmltop);
		$htmltop = str_replace('Script', "Scr' + 'ipt", $htmltop);
?>

function writeBody(d){
	d.open();
	//d.writeln('<?php print $htmltop; ?>'); Geht nicht im IE
	d.writeln('<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head><title>webEdition (c) living-e AG</title><meta http-equiv="expires" content="0"><meta http-equiv="pragma" content="no-cache"><meta http-equiv="content-type" content="text/html; charset=ISO-8859-1"><meta http-equiv="imagetoolbar" content="no"><meta name="generator" content="webEdition Version 4.9.0.0">');
	d.writeln('<?php print STYLESHEET_SCRIPT; ?>');
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
	d.writeln('var wasdblclick=false');
	d.writeln('var tout=null');
	d.writeln('document.onclick = weonclick;');
	d.writeln('function weonclick(e){');
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
	d.writeln('}');
	d.writeln('</scr'+'ipt>');
	d.writeln('<body bgcolor="white" LINK="#000000" ALINK="#000000" VLINK="#000000" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0">');
	d.writeln('<table border="0" cellpadding="0" cellspacing="0" width="100%">');
	for(i=0;i < entries.length; i++){
		var onclick = ' onClick="weonclick(<?php echo ($BROWSER=="IE"?"this":"event")?>);tout=setTimeout(\'if(top.wasdblclick==0){top.doClick('+entries[i].ID+',0);}else{top.wasdblclick=0;}\',300);return true;"';
		var ondblclick = ' onDblClick="top.wasdblclick=1;clearTimeout(tout);top.doClick('+entries[i].ID+',1);return true;"';
		d.writeln('<tr' + ((entries[i].ID == top.currentID)  ? ' style="background-color:#DFE9F5;cursor:pointer;-moz-user-select: none;"' : '') + ' id="line_'+entries[i].ID+'" style="cursor:pointer;-moz-user-select: none;"'+onclick+ (entries[i].isFolder ? ondblclick : '') + ' unselectable="on">');
		d.writeln('<td class="selector" width="25" align="center">');
		d.writeln('<img src="<?php print ICON_DIR; ?>'+entries[i].icon+'" width="16" height="18" border="0">');
		d.writeln('</td>');
		d.writeln('<td class="selector" unselectable="on" title="'+entries[i].text+'">');
		d.writeln(cutText(entries[i].text,80));
		d.writeln('</td>');
		d.writeln('</tr><tr><td colspan="2"><?php print getPixel(2,1); ?></td></tr>');
	}
	d.writeln('<tr>');
	d.writeln('<td width="25"><?php print getPixel(25,2)?></td>');
	d.writeln('<td><?php print getPixel(150,2)?></td>');
	d.writeln('</tr>');
	d.writeln('</table>');
	d.writeln('</body>');
	d.close();
}

<?php
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
<?php if($this->multiple): ?>
		if(fsbody.shiftpressed){
			var oldid = currentID;
			var currendPos = getPositionByID(id);
			var firstSelected = getFirstSelected();

			if(currendPos > firstSelected){
				selectFilesFrom(firstSelected,currendPos);
			}else if(currendPos < firstSelected){
				selectFilesFrom(currendPos,firstSelected);
			}else{
				selectFile(id);
			}
			currentID = oldid;

		}else if(!fsbody.ctrlpressed){

<?php endif ?>

			selectFile(id);

<?php if($this->multiple): ?>

		}else{
			if (isFileSelected(id)) {
				unselectFile(id);
			}else{
				selectFile(id);
			}
		}

<?php endif ?>

	}
	if(fsbody.ctrlpressed){
		fsbody.ctrlpressed = 0;
	}
	if(fsbody.shiftpressed){
		fsbody.shiftpressed = 0;
	}
}
<?php
	}


	function printFramesetUnselectFileHTML(){
?>

function unselectFile(id){
	e = getEntry(id);
	top.fsbody.document.getElementById("line_"+id).style.backgroundColor="white";

	var foo = top.fsfooter.document.we_form.fname.value.split(/,/);

	for (var i=0; i < foo.length; i++) {
		if (foo[i] == e.text) {
			foo[i] = "";
			break;
		}
	}
	var str = "";
	for (var i=0; i < foo.length; i++) {
		if(foo[i]){
			str += foo[i]+",";
		}
	}
	str = str.replace(/(.*),$/,"$1");
	top.fsfooter.document.we_form.fname.value = str;
}

<?php

	}

	function printFramesetSelectFilesFromHTML(){
?>

function selectFilesFrom(from,to){
	unselectAllFiles();
	for	(var i=from;i <= to; i++){
		selectFile(entries[i].ID);
	}
}

<?php

	}

	function printFramesetGetFirstSelectedHTML(){
?>

function getFirstSelected(){
	for	(var i=0;i < entries.length; i++){
		if(top.fsbody.document.getElementById("line_"+entries[i].ID).style.backgroundColor!="white"){
			return i;
		}
	}
	return -1;
}

<?php

	}

		function printFramesetGetPositionByIDHTML(){
?>

function getPositionByID(id){
	for	(var i=0;i < entries.length; i++){
		if(entries[i].ID == id){
			return i;
		}
	}
	return -1;
}

<?php

	}

	function printFramesetIsFileSelectedHTML(){
?>

function isFileSelected(id){
	return (top.fsbody.document.getElementById("line_"+id).style.backgroundColor && (top.fsbody.document.getElementById("line_"+id).style.backgroundColor!="white"));
}

<?php

	}

	function printFramesetUnselectAllFilesHTML(){
?>

function unselectAllFiles(){
	for	(var i=0;i < entries.length; i++){
		if(elem = top.fsbody.document.getElementById("line_"+entries[i].ID))
			elem.style.backgroundColor="white";
	}
	top.fsfooter.document.we_form.fname.value = "";
}

<?php

	}

	function printFramesetSelectFileHTML(){
?>

function selectFile(id){
	if(id){
		e = getEntry(id);

		if(
			top.fsfooter.document.we_form.fname.value != e.text &&
			top.fsfooter.document.we_form.fname.value.indexOf(e.text+",") == -1 &&
			top.fsfooter.document.we_form.fname.value.indexOf(","+e.text+",") == -1 &&
			top.fsfooter.document.we_form.fname.value.indexOf(","+e.text+",") == -1 ){

			top.fsfooter.document.we_form.fname.value =  top.fsfooter.document.we_form.fname.value ?
																(top.fsfooter.document.we_form.fname.value + "," + e.text) :
																e.text;
		}
		top.fsbody.document.getElementById("line_"+id).style.backgroundColor="#DFE9F5";
		currentPath = e.path;
		currentID = id;
	}else{
		top.fsfooter.document.we_form.fname.value = "";
		currentPath = "";
	}
}


<?php
	}

}

?>
