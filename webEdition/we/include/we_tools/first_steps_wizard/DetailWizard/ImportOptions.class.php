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

class ImportOptions extends leWizardStepBase
{

	var $EnabledButtons = array(
		'next'
	);

	function execute(&$Template)
	{
		
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/weSuggest.class.inc.php");
		$WizardSuggest = & weSuggest::getInstance();
		
		$we_button = new we_button();
		
		// Hidden Field
		$Hidden = "<input type=\"hidden\" name=\"startImport\" value=\"1\">";
		
		// MasterTemplate
		$MasterTemplateID = path_to_id("/master/standard.php", TEMPLATES_TABLE);
		we_loadDefaultMasterTemplateConfig();
		
		$table = TEMPLATES_TABLE;
		$textname = 'MasterTemplate';
		$idname = 'MasterTemplateID';
		$myid = FSW_DEFAULT_MASTER_TEMPLATE;
		$path = id_to_path(FSW_DEFAULT_MASTER_TEMPLATE, TEMPLATES_TABLE);
		
		$MastertemplateInput = htmlTextInput(
				$textname, 
				30, 
				$path, 
				255, 
				' readonly="readonly" id="' . $textname . '"', 
				'text', 
				388);
		$MastertemplateHidden = "<input type=\"hidden\" id=\"" . $idname . "\" name=\"" . $idname . "\" value=\"" . $myid . "\">";
		$MastertemplateButton = $we_button->create_button(
				"select", 
				"javascript:we_cmd('openDocselector',document.getElementById('$idname').value,'$table','document.getElementById(\\'$idname\\').value','document.getElementById(\\'$textname\\').value','','" . session_id() . "','','text/weTmpl',1)");
		$MastertemplateTrash = $we_button->create_button(
				"image:btn_function_trash", 
				"javascript:document.getElementById('$idname').value='$myid';document.getElementById('$textname').value='$path';", 
				true, 
				27, 
				22);
		
		$MastertemplateChooserText = $this->Language['choose_mastertemplate'];
		$MastertemplateChooser = htmlFormElementTable(
				$MastertemplateInput, 
				"", 
				"left", 
				"defaultfont", 
				$MastertemplateHidden . getPixel(20, 1), 
				$MastertemplateButton, 
				getPixel(10, 1), 
				$MastertemplateTrash);
		
		// Use Documents
		$Name = 'le_documents_use';
		$Value = 1;
		$OnClick = 'document.getElementById(\'DocumentsForm\').style.display = (this.checked ? \'block\' : \'none\');';
		$Text = $this->Language["labelUseDocuments"];
		$Checked = true;
		$StyleDisplayDocuments = $Checked ? "block" : "none";
		
		$UseDocuments = we_forms::checkbox($Value, $Checked, $Name, $Text, false, "defaultfont", $OnClick);
		
		// DocumentPath
		$table = FILE_TABLE;
		$textname = 'DocumentPath';
		$idname = 'DocumentPathID';
		$myid = 0;
		$path = "/";
		
		$DocumentInput = htmlTextInput(
				$textname, 
				30, 
				$path, 
				255, 
				' readonly="readonly" id="' . $textname . '"', 
				'text', 
				388);
		$DocumentHidden = "<input type=\"hidden\" id=\"" . $idname . "\" name=\"" . $idname . "\" value=\"" . $myid . "\">";
		$DocumentButton = $we_button->create_button(
				"select", 
				"javascript:we_cmd('openDirselector',document.getElementById('$idname').value,'$table','document.getElementById(\\'$idname\\').value','document.getElementById(\\'$textname\\').value','','" . session_id() . "','','text/weFolder',1)");
		$DocumentTrash = $we_button->create_button(
				"image:btn_function_trash", 
				"javascript:document.getElementById('$idname').value='$myid';document.getElementById('$textname').value='$path';", 
				true, 
				27, 
				22);
		
		$DocumentChooserText = $this->Language['choose_document_path'];
		$DocumentChooser = htmlFormElementTable(
				$DocumentInput, 
				"", 
				"left", 
				"defaultfont", 
				$DocumentHidden . getPixel(20, 1), 
				$DocumentButton, 
				getPixel(10, 1), 
				$DocumentTrash);
		
		// Use Navigation
		$Name = 'le_navigation_use';
		$Value = 1;
		$OnClick = 'document.getElementById(\'NavigationForm\').style.display = (this.checked ? \'block\' : \'none\');';
		$Text = $this->Language["labelUseNavigation"];
		$Checked = true;
		$StyleDisplayNavigation = $Checked ? "block" : "none";
		
		$UseNavigation = we_forms::checkbox($Value, $Checked, $Name, $Text, false, "defaultfont", $OnClick);
		
		// Navigation Path
		$_dirs = array(
			'0' => '/'
		);
		$_wrkNavi = '';
		if (!we_hasPerm('ADMINISTRATOR')) {
			$_wrkNavi = makeArrayFromCSV(
					f(
							'SELECT workSpaceNav FROM ' . USER_TABLE . ' WHERE ID=' . $_SESSION['user']['ID'], 
							'workSpaceNav', 
							new DB_WE()));
			$_condition = array();
			foreach ($_wrkNavi as $_key => $_value) {
				$_condition[] = 'Path LIKE "' . id_to_path($_value, NAVIGATION_TABLE) . '/%"';
			}
			$_dirs = array();
		}
		
		$_db = new DB_WE();
		$_db->query(
				'SELECT * FROM ' . NAVIGATION_TABLE . ' WHERE IsFolder=1 ' . (!empty($_wrkNavi) ? ' AND (ID IN (' . implode(
						',', 
						$_wrkNavi) . ') OR (' . implode(' OR ', $_condition) . '))' : '') . ' ORDER BY Path;');
		while ($_db->next_record()) {
			$_dirs[$_db->f('ID')] = $_db->f('Path');
		}
		
		$NavigationChooserText = $this->Language['choose_navigation_path'];
		$NavigationChooser = htmlSelect('NavigationPathID', $_dirs, 1, 0, false, 'style="width: 388px;"');
		
		// Suggestion
		

		$Content = <<<EOF
<script type="text/javascript">
top.we_cmd=function(){
	var args = "";
	var url = "/webEdition/we_cmd.php?"; for(var i = 0; i < arguments.length; i++){ url += "we_cmd["+i+"]="+escape(arguments[i]); if(i < (arguments.length - 1)){ url += "&"; }}

	switch (arguments[0]){
		case "openDirselector":
		case "openDocselector":
			new top.jsWindow(url,"we_fileselector",-1,-1,900, 685 ,true,true,true,true);
			break;
		default:
			for(var i = 0; i < arguments.length; i++){
				args += 'arguments['+i+']' + ((i < (arguments.length-1)) ? ',' : '');
			}
			eval('top.opener.top.we_cmd('+args+')');
	}
}
</script>
{$Hidden}
<br />
{$MastertemplateChooserText}<br />
{$MastertemplateChooser}
<br />
{$UseDocuments}
<div id="DocumentsForm" style="display: {$StyleDisplayDocuments};" class="defaultfont">
	{$DocumentChooserText}<br />
	{$DocumentChooser}
	<br />
	{$UseNavigation}
	<div id="NavigationForm" style="display: {$StyleDisplayNavigation};" class="defaultfont">
		{$NavigationChooserText}<br />
		{$NavigationChooser}
	</div>
</div>
EOF;
		
		$this->setContent($Content);
		
		return LE_WIZARDSTEP_NEXT;
	
	}

	function check(&$Template)
	{
		
		if (isset($_REQUEST['startImport']) && $_REQUEST['startImport'] == 1) {
			
			// set Default Master Template
			$MasterTemplateID = $_REQUEST['MasterTemplateID'];
			we_writeDefaultMasterTemplateConfig($MasterTemplateID);
			
			$ImportDocuments = 0;
			$DocumentsPathID = 0;
			$DocumentsPath = '/';
			$ImportNavigation = 0;
			$NavigationPathID = 0;
			$NavigationPath = '/';
			
			if (isset($_REQUEST['le_documents_use'])) {
				$ImportDocuments = 1;
				$DocumentsPathID = $_REQUEST['DocumentPathID'];
				$DocumentsPath = id_to_path($DocumentsPathID, FILE_TABLE);
				$_SESSION['we_fsw_document_path'] = $DocumentsPath;
				
				if (isset($_REQUEST['le_navigation_use'])) {
					$ImportNavigation = 1;
					$NavigationPathID = $_REQUEST['NavigationPathID'];
					$NavigationPath = id_to_path($NavigationPathID, NAVIGATION_TABLE);
				
				}
			
			}
			
			$_REQUEST['cid'] = -2;
			$_REQUEST['v'] = array(
				
					'mode' => 1,  // dont change this
					'cid' => -2,  // dont change this
					'type' => 'WXMLImport',  // dont change this
					'fserver' => '/',  // dont change this
					'rdofloc' => 'lLocal',  // dont change this
					'import_from' => '/webEdition/liveUpdate/tmp/files/Import.xml', 
					'collision' => 'replace', 
					'import_owners' => 0, 
					'owners_overwrite' => 0, 
					'owners_overwrite_id' => 0, 
					'import_docs' => $ImportDocuments, 
					'doc_dir_id' => $DocumentsPathID, 
					'doc_dir' => $DocumentsPath, 
					'restore_doc_path' => 1, 
					'import_templ' => 1, 
					'tpl_dir_id' => 0, 
					'tpl_dir' => '/', 
					'restore_tpl_path' => 1, 
					'import_thumbnails' => 1, 
					'import_objs' => 0, 
					'import_classes' => 0, 
					'import_dt' => 1, 
					'import_ct' => 1, 
					'import_navigation' => $ImportNavigation,  // should navigation be imported
					'navigation_dir_id' => $NavigationPathID, 
					'navigation_dir' => $NavigationPath, 
					'import_binarys' => 1, 
					'rebuild' => 0
			);
			$_REQUEST['mode'] = '';
			$_REQUEST['type'] = '';
		
		}
		
		return true;
	
	}

}

?>