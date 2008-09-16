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
   include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");

	protect();

	if(isset($_REQUEST["pnt"])) $what=$_REQUEST["pnt"];
	else $what="frameset";
	if(isset($_REQUEST["art"])) $mode=$_REQUEST["art"];
	else $mode=0;

	if($what=="export" || $what=="eibody" || $what=="eifooter" || $what=="eiload" || $what=="import" || $what=="eiupload"){

		include_once(WE_CUSTOMER_MODULE_DIR."weCustomerEIWizard.php");
		$ExImport=new weCustomerEIWizard();

		if(isset($_REQUEST["step"])) $step=$_REQUEST["step"];
		else $step=0;

	}
	else{
		include_once(WE_CUSTOMER_MODULE_DIR."weCustomerFrames.php");
		$weFrame=new weCustomerFrames();
		$weFrame->View->processVariables();
		$weFrame->View->processCommands();
	}

	switch($what){
		case "frameset": print $weFrame->getHTMLFrameset();break;
		case "header": print $weFrame->getHTMLHeader();break;
		case "resize": print $weFrame->getHTMLResize();break;
		case "left":  print $weFrame->getHTMLLeft();break;
		case "right": print $weFrame->getHTMLRight();break;
		case "editor": print $weFrame->getHTMLEditor();break;
		case "edheader": print $weFrame->getHTMLEditorHeader();break;
		case "edbody": print $weFrame->getHTMLEditorBody(); break;
		case "edfooter": print $weFrame->getHTMLEditorFooter();break;
		case "cmd": print $weFrame->getHTMLCmd();break;
		case "treeheader": print $weFrame->getHTMLTreeHeader();break;
		case "treefooter": print $weFrame->getHTMLTreeFooter();break;
		case "customer_admin": print $weFrame->getHTMLCustomerAdmin();break;
		case "branch_editor": print $weFrame->getHTMLFieldEditor("branch",$mode);break;
		case "field_editor": print $weFrame->getHTMLFieldEditor("field",$mode);break;
		case "sort_admin": print $weFrame->getHTMLSortEditor();break;
		case "search": print $weFrame->getHTMLSearch();break;
		case "settings": print $weFrame->getHTMLSettings();break;

		case "export":
		case "import": print $ExImport->getHTMLFrameset($what);break;
		case "eibody":print $ExImport->getHTMLStep($mode,$step);break;
		case "eifooter":print $ExImport->getHTMLFooter($mode,$step);break;
		case "eiload":print $ExImport->getHTMLLoad();break;

		default:
			error_log(__FILE__ . " unknown reference: $what");
	}

?>