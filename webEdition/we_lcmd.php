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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/alert.inc.php");

?>
<script language="JavaScript" type="text/javascript">
// bugfix WE-356
self.focus();
<?php
if(isset($_REQUEST["wecmd0"])){ // when calling from applet (we can not call directly we_cmd[0] with the applet =>  Safari OSX doesn't support live connect)
	$_REQUEST["we_cmd"][0] = $_REQUEST["wecmd0"];
}
	switch($_REQUEST["we_cmd"][0]){
		case "trigger_save_document":
			print 'if(top.weEditorFrameController.getActiveDocumentReference() && top.weEditorFrameController.getActiveDocumentReference().frames[3] && top.weEditorFrameController.getActiveDocumentReference().frames[3].weCanSave){
	top.weEditorFrameController.getActiveEditorFrame().setEditorPublishWhenSave(false);
	top.weEditorFrameController.getActiveDocumentReference().frames[3].we_save_document();
}else{
	' . we_message_reporting::getShowMessageCall($l_alert["nothing_to_save"], WE_MESSAGE_ERROR) . '
}
';
			break;

		case "trigger_publish_document":
			print 'if(top.weEditorFrameController.getActiveDocumentReference() && top.weEditorFrameController.getActiveDocumentReference().frames[3] && top.weEditorFrameController.getActiveDocumentReference().frames[3].weCanSave){
	top.weEditorFrameController.getActiveEditorFrame().setEditorPublishWhenSave(true);
	top.weEditorFrameController.getActiveDocumentReference().frames[3].we_save_document();
}else{
	' . we_message_reporting::getShowMessageCall($l_alert["nothing_to_publish"], WE_MESSAGE_ERROR) . '
}
';
			break;
		case "new_webEditionPage":
			print 'top.we_cmd("new","'.FILE_TABLE.'","","text/webedition");'."\n";
			break;
		case "new_image":
			print 'top.we_cmd("new","'.FILE_TABLE.'","","image/*");'."\n";
			break;
		case "new_html_page":
			print 'top.we_cmd("new","'.FILE_TABLE.'","","text/html");'."\n";
			break;
		case "new_flash_movie":
			print 'top.we_cmd("new","'.FILE_TABLE.'","","application/x-shockwave-flash");'."\n";
			break;
		case "new_quicktime_movie":
			print 'top.we_cmd("new","'.FILE_TABLE.'","","video/quicktime");'."\n";
			break;
		case "new_javascript":
			print 'top.we_cmd("new","'.FILE_TABLE.'","","text/js");'."\n";
			break;
		case "new_text_plain":
			print 'top.we_cmd("new","'.FILE_TABLE.'","","text/plain");'."\n";
			break;
		case "new_text_xml":
			print 'top.we_cmd("new","'.FILE_TABLE.'","","text/xml");'."\n";
			break;
		case "new_css_stylesheet":
			print 'top.we_cmd("new","'.FILE_TABLE.'","","text/css");'."\n";
			break;
		case "new_binary_document":
			print 'top.we_cmd("new","'.FILE_TABLE.'","","application/*");'."\n";
			break;
		case "new_template":
			print 'top.we_cmd("new","'.TEMPLATES_TABLE.'","","text/weTmpl");'."\n";
			break;
		case "new_document_folder":
			print 'top.we_cmd("new","'.FILE_TABLE.'","","folder");'."\n";
			break;
		case "new_template_folder":
			print 'top.we_cmd("new","'.TEMPLATES_TABLE.'","","folder");'."\n";
			break;
		case "delete_documents":
			print 'top.we_cmd("del",1,"'.FILE_TABLE.'");'."\n";
			break;
		case "delete_templates":
			print 'top.we_cmd("del",1,"'.TEMPLATES_TABLE.'");'."\n";
			break;
		case "delete_documents_cache":
			print 'top.we_cmd("del",1,"'.FILE_TABLE.'_cache");'."\n";
			break;
		case "move_documents":
			print 'top.we_cmd("mv",1,"'.FILE_TABLE.'");'."\n";
			break;
		case "move_templates":
			print 'top.we_cmd("mv",1,"'.TEMPLATES_TABLE.'");'."\n";
			break;

		case "openDelSelector":
			$openTable = FILE_TABLE;
			if(isset($_SESSION['seemForOpenDelSelector']['Table'])) {
				$openTable = $_SESSION['seemForOpenDelSelector']['Table'];
				unset($_SESSION['seemForOpenDelSelector']['Table']);
			}
			$_cmd = 'top.we_cmd("openDelSelector","","'.$openTable.'","","","","","","",1);';
			print "setTimeout('$_cmd',50)";
			break;

		case "export_documents":
			$_tbl = FILE_TABLE;
		case "export_templates":
			if(!isset($_tbl)){
				$_tbl = TEMPLATES_TABLE;
			}
		case "export_objects":
			if(!isset($_tbl)){
				$_tbl = OBJECT_FILES_TABLE;
			}


		default:

			if(ereg('^new_dtPage(.+)$',$_REQUEST["we_cmd"][0],$regs)){
				$dt = $regs[1];
				print 'top.we_cmd("new","'.FILE_TABLE.'","","text/webedition","'.$dt.'");'."\n";
				break;
			}else if(ereg('^new_ClObjectFile(.+)$',$_REQUEST["we_cmd"][0],$regs)){
				$clID = $regs[1];
				print 'top.we_cmd("new","'.OBJECT_FILES_TABLE.'","","objectFile","'.$clID.'");'."\n";
				break;
			}
			$str = "setTimeout(\"top.we_cmd(";
			for($i=0;$i<sizeof($_REQUEST["we_cmd"]);$i++){
			
				$val = str_replace("'","\\'", $_REQUEST["we_cmd"][$i]);
				$val = str_replace("\"","\\\"", $val);
				
				$str .= "'".$val."'".(($i<(sizeof($_REQUEST["we_cmd"])-1)) ? "," : "");
			}
			$str .= ")\",50);\n";
			print $str;
	}
?>
</script>
