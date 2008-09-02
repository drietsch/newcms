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

// Workarround for bug 1292
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/we_class.inc.php");

if (!isset($l_alert)) {
	include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/alert.inc.php");
}


// Dreamweaver RPC Command ShowPreparedPreview
// disable javascript errors
if (isset($_REQUEST["cmd"]) && $_REQUEST['cmd'] == "ShowPreparedPreview") {

	print
"<script type=\"text/javascript\">

	// overwrite/disable some functions in javascript!!!!
	window.open = function(){};
	window.onerror = function () {
		return true;

	}

	function we_rpc_dw_onload() {
		we_cmd = function(){};
		we_submitForm = function(){};
		doUnload = function(){};

	}

	if (window.addEventListener) {
		window.addEventListener('load', we_rpc_dw_onload);

	} else {
		window.attachEvent('onload', we_rpc_dw_onload);

	}

</script>
";
}

?>
<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR ?>we_textarea.js?<?php print WE_VERSION ?>"></script>
<?php if (isset($we_doc)) { ?>
<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR ?>seeMode.php?EditPage=<?php print $we_doc->EditPageNr; ?>&ContentType=<?php print $we_doc->ContentType; ?>"></script>

<?php } ?>
<script language="JavaScript" type="text/javascript">

var _controller = (opener && opener.top.weEditorFrameController) ? opener.top.weEditorFrameController : top.weEditorFrameController;


var _EditorFrame = _controller.getEditorFrame(parent.name);
if (!_EditorFrame) {

	<?php
	if (isset($_REQUEST["we_transaction"])) {
		print "_EditorFrame = _controller.getEditorFrameByTransaction('" . $_REQUEST["we_transaction"] . "');";
	} else {
		print "_EditorFrame = _controller.getEditorFrame();";
	}
	?>

}


<?php if (isset($we_doc)) { ?>

<?php

if (isset($we_doc->ApplyWeDocumentCustomerFiltersToChilds) && $we_doc->ApplyWeDocumentCustomerFiltersToChilds) {
	print "top.we_cmd('copyWeDocumentCustomerFilter', '" . $we_doc->ID . "', '" . $we_doc->Table . "', '" . $we_doc->ParentID . "');";
}

?>

// check if parentId was changed
var ajaxCallback = {
	success: function(o) {
		if(typeof(o.responseText) != 'undefined' && o.responseText != '') {
			var weResponse = false;
			try {
				eval( o.responseText );
				if ( weResponse ) {
					if (weResponse["data"] == "true") {
						_question = "<?php print ($we_doc->IsFolder ? $l_confim["applyWeDocumentCustomerFiltersFolder"] : $l_confim["applyWeDocumentCustomerFiltersDocument"] ) ?>";
						if ( confirm(_question) ) {
							top.we_cmd("applyWeDocumentCustomerFilterFromFolder");

						}
					}
				}
			} catch (exc){}
		}
	},
	failure: function(o) {

	}
}

var _oldparentid = <?php print $we_doc->ParentID; ?>;
function updateCustomerFilterIfNeeded() {
	if (_elem = document.we_form["we_<?php print $we_doc->Name; ?>_ParentID"]) {
		_parentid = _elem.value;
		if ( _parentid != _oldparentid ) {
			top.YAHOO.util.Connect.asyncRequest( 'GET', '/webEdition/rpc/rpc.php?cmd=GetUpdateDocumentCustomerFilterQuestion&cns=customer&folderId=' + _parentid + '&we_transaction=<?php if(isset($_REQUEST["we_transaction"])) print $_REQUEST["we_transaction"]; ?>&table=<?php print $we_doc->Table; ?>&classname=<?php print $we_doc->ClassName; ?>', ajaxCallback );
			_oldparentid = _parentid;
		}
	}
}

// check If Filename was changed..
function pathOfDocumentChanged() {

	var _oldfilepath = '';

	var _filetext = '';
	var _filepath = '';
	var elem = false;

	elem = document.we_form["we_<?php print $we_doc->Name; ?>_Filename"]; // documents
	if (!elem) { // object
		elem = document.we_form["we_<?php print $we_doc->Name; ?>_Text"]
	}

	if (elem) {

		// text
		_filetext = elem.value;
		// Extension if there
		if (document.we_form["we_<?php print $we_doc->Name; ?>_Extension"]) {
			_filetext += document.we_form["we_<?php print $we_doc->Name; ?>_Extension"].value;
		}

		// path
		if (_elem = document.we_form["we_<?php print $we_doc->Name; ?>_ParentPath"]) {
			_filepath = _elem.value;
		}
		if (_filepath != "/") {
			_filepath += "/";
		}

		_filepath += _filetext;
		parent.frames[0].we_setPath(_filepath, _filetext);
		<?php
			if ( defined("CUSTOMER_TABLE") && in_array(WE_EDITPAGE_WEBUSER, $we_doc->EditPageNrs) && isset($we_doc->documentCustomerFilter) ) {
				// only use this when customer filters are possible
		?>
		updateCustomerFilterIfNeeded();
		<?php
			}
		?>
	}
}

<?php } ?>

function weDelCookie(name,path,domain){
	if (getCookie(name)) {
		document.cookie = name + "=" +
		((path == null) ? "" : "; path=" + path) +
		((domain == null) ? "" : "; domain=" + domain) +
		"; expires=Thu, 01-Jan-70 00:00:01 GMT";
	}
}

function doScrollTo(){
	if(parent.scrollToVal){
		window.scrollTo(0,parent.scrollToVal);
		parent.scrollToVal=0;
	}
}

function setScrollTo(){
   parent.scrollToVal=<?php if($GLOBALS["BROWSER"] == "IE"): ?>document.body.scrollTop<?php else: ?>pageYOffset<?php endif ?>;
}

function goTemplate(tid){
	if(tid){
		top.weEditorFrameController.openDocument("<?php print TEMPLATES_TABLE ?>",tid,"text/weTmpl");
	}
}

function translate(c){
	f=c.form;
	n=c.name;
	n2 = n.replace(/tmp_/,"we_");
	n = n2.replace(/^(.+)#.+\]$/,"$1]");
	t=f.elements[n];
	check = f.elements[n2].value;

	t.value = (check=="on") ? br2nl(t.value) : nl2br(t.value);

}
function nl2br(i){
	i = i.replace(/\r\n/g,"<br>");
	i = i.replace(/\n/g,"<br>");
	i = i.replace(/\r/g,"<br>");
	return i.replace(/<br>/g,"<br>\n");
}
function br2nl(i){
	i = i.replace(/\n\r/g,"");
	i = i.replace(/\r\n/g,"");
	i = i.replace(/\n/g,"");
	i = i.replace(/\r/g,"");
	return i.replace(/<br ?\/?>/gi,"\n");
}
function we_submitForm(target,url){
	var f = self.document.we_form;

	parent.openedWithWe = true;

	if (target && url) {

		f.target = target;
		f.action = url;
		f.method = "post";
		if (self.weWysiwygSetHiddenText && _EditorFrame.getEditorDidSetHiddenText() ==  false) {
			weWysiwygSetHiddenText();
		}else if( _EditorFrame.getEditorDidSetHiddenText() ){
			_EditorFrame.setEditorDidSetHiddenText(false);
		}
		if (typeof(self.weEditorSetHiddenText) != "undefined") {
			self.weEditorSetHiddenText();
		}
	}
	f.submit();
}
function doUnload(){

	if(jsWindow_count){
		for(i=0;i<jsWindow_count;i++){
			eval("jsWindow"+i+"Object.close()");
		}
	}
}
function we_cmd(){
	var args = "";
	var url = "<?php print WEBEDITION_DIR; ?>we_cmd.php?"; for(var i = 0; i < arguments.length; i++){ url += "we_cmd["+i+"]="+escape(arguments[i]); if(i < (arguments.length - 1)){ url += "&"; }}
	
	var contentEditor = top.weEditorFrameController.getVisibleEditorFrame();
	
	switch (arguments[0]){
		case "edit_link":
		case "edit_link_at_class":
		case "edit_link_at_object":
			new jsWindow("","we_linkEdit",-1,-1,615,710,true,true,true);
			if(contentEditor.we_submitForm) contentEditor.we_submitForm("we_linkEdit",url);
			break;
		case "edit_linklist":
			new jsWindow("","we_linklistEdit",-1,-1,615,710,true,true,true);
			if(contentEditor.we_submitForm) contentEditor.we_submitForm("we_linklistEdit",url);
			break;
		case "openColorChooser":
			new jsWindow("","we_colorChooser",-1,-1,430,370,true,true,true);
			if(contentEditor.we_submitForm) contentEditor.we_submitForm("we_colorChooser",url);
			break;
		case "openDirselector":
		case "openDocselector":
			new jsWindow(url,"we_fileselector",-1,-1,<?php echo WINDOW_DOCSELECTOR_WIDTH . ", " . WINDOW_DOCSELECTOR_HEIGHT; ?> ,true,true,true,true);
			break;
		case "openSelector":
			new jsWindow(url,"we_fileselector",-1,-1,900,685,true,true,true,true);
			break;
		case "openCatselector":
			new jsWindow(url,"we_catselector",-1,-1,<?php echo WINDOW_CATSELECTOR_WIDTH . ", " . WINDOW_CATSELECTOR_HEIGHT; ?>,true,true,true,true);
			break;
	   case "browse_server":
            new jsWindow(url,"browse_server",-1,-1,840,400,true,false,true);
			break;
		case "browse_users":
	        new jsWindow(url,"browse_users",-1,-1,500,300,true,false,true);
	        break;
		case "editObjectTextArea":
	        new jsWindow(url,"edit_object_text",-1,-1,550,455,true,false,true);
	        break;
		case "editor_uploadFile":
			new jsWindow("","we_uploadFile",-1,-1,450,210,true,true,true);
			if(contentEditor.we_submitForm) contentEditor.we_submitForm("we_uploadFile",url);
			break;
		case "open_templateSelect":
			new jsWindow("","we_templateSelect",-1,-1,600,400,true,true,true);
			if(contentEditor.we_submitForm) contentEditor.we_submitForm("we_templateSelect",url);
			break;
		case "open_tag_wizzard":
			new jsWindow(url,"we_tag_wizzard",-1,-1,600,620,true,true,true);
			break;


<?php if(isset($we_doc) && ($we_doc->ContentType == "text/webedition" || $we_doc->ContentType == "objectFile") && defined("GLOSSARY_TABLE")): ?>
		case "check_glossary":
			new jsWindow(url,"check_glossary",-1,-1,730,400,true,false,true);
			break;
<?php endif ?>

<?php if(isset($we_doc) && $we_doc->ContentType == "image/*"): ?>

		case "add_thumbnail":
			new jsWindow(url,"we_add_thumbnail",-1,-1,400,410,true,true,true);
			break;
		case "image_resize":
			if (typeof CropTool == 'object' && CropTool.triggered) CropTool.drop();
<?php if($we_doc->gd_support()): ?>
			new jsWindow(url,"we_image_resize",-1,-1,260,<?php print ($we_doc->getGDType()=="jpg") ? 250 : 190; ?>,true,false,true);
<?php else:
	print we_message_reporting::getShowMessageCall( sprintf($l_we_class["type_not_supported_hint"],$l_we_class["convert_".$we_doc->getGDType()]), WE_MESSAGE_ERROR );

	endif ?>

			break;
		case "image_convertJPEG":
			if (typeof CropTool == 'object' && CropTool.triggered) CropTool.drop();
			new jsWindow(url,"we_convert_jpg",-1,-1,260,160,true,false,true);
			break;
		case "image_rotate":
			if (typeof CropTool == 'object' && CropTool.triggered) CropTool.drop();
<?php if(function_exists("ImageRotate")): ?>

	<?php if($we_doc->gd_support()): ?>
			new jsWindow(url,"we_rotate",-1,-1,300,<?php print ($we_doc->getGDType()=="jpg") ? 230 : 170; ?>,true,false,true);
	<?php else:
		print we_message_reporting::getShowMessageCall( sprintf($l_we_class["type_not_supported_hint"],$l_we_class["convert_".$we_doc->getGDType()]), WE_MESSAGE_ERROR );
	endif ?>

<?php else:

	print we_message_reporting::getShowMessageCall($l_we_class["rotate_hint"], WE_MESSAGE_ERROR);

	endif ?>
			break;

<?php endif ?>
		case "image_crop":
<?php if(defined("WE_EDIT_IMAGE") && $we_doc->gd_support()) { ?>
			CropTool.crop();
<?php } else if(defined("WE_EDIT_IMAGE")) {

			print we_message_reporting::getShowMessageCall(sprintf($l_we_class["type_not_supported_hint"],$l_we_class["convert_".$we_doc->getGDType()]), WE_MESSAGE_ERROR);
	  } ?>
		break;
		case "crop_cancel":
			CropTool.drop();
		break;
<?php if(defined('SPELLCHECKER')) { ?>
		case "spellcheck":
			var win = new jsWindow("<?php print WE_SPELLCHECKER_MODULE_PATH?>/weSpellchecker.php?editname="+(arguments[1]),"spellcheckdialog",-1,-1,500,450,true,false,true,false);
		break;
<?php } ?>
		// it must be the last command
		case "delete_navi":
			<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_language/' . $GLOBALS['WE_LANGUAGE'] . '/navigation.inc.php');?>
			if(!confirm("<?php print $l_navigation['del_question']?>")) break;
		default:
			for(var i = 0; i < arguments.length; i++){
				args += 'arguments['+i+']' + ((i < (arguments.length-1)) ? ',' : '');
			}
			eval('parent.we_cmd('+args+')');
	}
}

function fields_are_valid() {
	var _checkFields = false;
	var _retVal = true;
	var objFieldErrorMsg = "";
	<?php
	if ( isset($GLOBALS['we_doc']) && $GLOBALS['we_doc']->ContentType == "object" ) {
		print "
	_checkFields = true;";
	}
	?>
	if (_checkFields) {

		var theInputs = document.getElementsByTagName("input");

		for (i=0;i<theInputs.length;i++) {

			if ( (theType = theInputs[i].getAttribute("weType")) && (theVal = theInputs[i].value) ) {

				switch (theType) {

					case "int":
					case "integer":
						if ( !theVal.match(/^-{0,1}\d+$/) ) {
							<?php
							//  don't change the formatting of the fields here
							$_msg = sprintf($l_alert['field_contains_incorrect_chars'], "' + theType + '");
							print we_message_reporting::getShowMessageCall( "'" . $_msg . "'", WE_MESSAGE_ERROR, true ); ?>
							theInputs[i].focus();
							return false;
						} else if(theVal>2147483647) {
							<?php
							//  don't change the formatting of the fields here
							$_msg = sprintf($l_alert['field_int_value_to_height']);
							print we_message_reporting::getShowMessageCall( "'" . $_msg . "'", WE_MESSAGE_ERROR, true ); ?>
							theInputs[i].focus();
							return false;
						}
					break;
					case "float":
						if ( isNaN(theVal) ) {
							<?php
							//  don't change the formatting of the fields here
							$_msg = sprintf($l_alert['field_contains_incorrect_chars'], "' + theType + '");
							print we_message_reporting::getShowMessageCall( "'" . $_msg . "'", WE_MESSAGE_ERROR, true ); ?>
							theInputs[i].focus();
							return false;
						}
					break;
					case "weObject_input_length":
						if ( !theVal.match(/^-{0,1}\d+$/) || theVal<1 || theVal>255) {
							<?php
							//  don't change the formatting of the fields here
							$_msg = sprintf($l_alert['field_input_contains_incorrect_length']);
							print we_message_reporting::getShowMessageCall( "'" . $_msg . "'", WE_MESSAGE_ERROR, true ); ?>
							theInputs[i].focus();
							return false;
						}
					break;
					case "weObject_int_length":
						if ( !theVal.match(/^-{0,1}\d+$/) || theVal<1 || theVal>10) {
							<?php
							//  don't change the formatting of the fields here
							$_msg = sprintf($l_alert['field_int_contains_incorrect_length']);
							print we_message_reporting::getShowMessageCall( "'" . $_msg . "'", WE_MESSAGE_ERROR, true ); ?>
							theInputs[i].focus();
							return false;
						}
					break;
				}
			}
		}

	}
	return true;
}

</script>


<style type="text/css">

	.weEditmodeStyle {
		border: 0px ! important;
	}

</style>