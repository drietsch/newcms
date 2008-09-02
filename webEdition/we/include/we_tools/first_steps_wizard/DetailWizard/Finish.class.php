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

include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/weSidebarDocumentParser.class.php");

class Finish extends leWizardStepBase
{

	var $EnabledButtons = array();

	function execute(&$Template)
	{
		
		// copy new Sidebar file to correct position
		$NewSidebarFile = $_SERVER['DOCUMENT_ROOT'] . WEBEDITION_DIR . "sidebar/first_steps_wizard.php";
		$OldSidebarFile = LIVEUPDATE_CLIENT_DOCUMENT_DIR . "/tmp/files/SideBar.php";
		
		if (file_exists($NewSidebarFile) && is_file($NewSidebarFile)) {
			
			if (!unlink($NewSidebarFile)) {
				return LE_WIZARDSTEP_ERROR;
			
			}
		
		}
		
		if (file_exists($OldSidebarFile) && is_file($OldSidebarFile)) {
			
			if (!copy($OldSidebarFile, $NewSidebarFile)) {
				return LE_WIZARDSTEP_ERROR;
			
			}
		
		}
		
		// now change paths in sidebar document(!)
		$content = implode("", file($NewSidebarFile));
		$Parser = new weSidebarDocumentParser();
		$content = $Parser->parseCode($content, $_SESSION['we_fsw_document_path']);
		
		// change mastertemplate in installed templates
		$TemplateIds = array();
		foreach ($_SESSION['fsw_importRefTable'] as $index => $entry) {
			if ($entry['Table'] == TEMPLATES_TABLE) {
				$TemplateIds[] = $entry['ID'];
			}
		}
		we_loadDefaultMasterTemplateConfig();
		$query = "UPDATE " . TEMPLATES_TABLE . " SET MasterTemplateID = " . FSW_DEFAULT_MASTER_TEMPLATE . " WHERE ID IN (" . implode(
				",", 
				$TemplateIds) . ")"; // AND MasterTemplateID != 0";
		$DB_WE = new DB_WE();
		$DB_WE->query($query);
		
		// write new content
		$fh = fopen($NewSidebarFile, "w+");
		if (!$fh || !fputs($fh, $content) || !fclose($fh)) {
			return LE_WIZARDSTEP_ERROR;
		
		}
		
		// oputput of the wizard step
		$weButton = new we_button();
		
		$RebuildBtnWidth = ($GLOBALS["WE_LANGUAGE"] == "Finnish") ? "130" : "100";
		$Rebuild = $weButton->create_button('rebuild', 'javascript:top.openRebuild();', true, $RebuildBtnWidth, 22);
		
		$SidebarFile = WEBEDITION_DIR . "/sidebar/first_steps_wizard.php";
		$webEditionDir = WEBEDITION_DIR;
		
		$NextStep = <<<EOF
top.weButton.enable("next");
top.leWizardForm.next = function() {
	top.opener.top.weSidebar.open('{$SidebarFile}', 300);
	top.close();
}
top.openRebuild = function() {
	top.opener.top.openWindow("{$webEditionDir}we_cmd.php?we_cmd[0]=rebuild&step=2&btype=rebuild_all","resave",-1,-1,600,130,0,true);
}
EOF;
		
		$Template->addJavascript($NextStep);
		
		$Content = <<<EOF
		{$Rebuild}<br /><br />
		{$this->Language['content_2']}
		
EOF;
		
		$this->setContent($Content);
		
		return LE_WIZARDSTEP_NEXT;
	
	}

}

?>