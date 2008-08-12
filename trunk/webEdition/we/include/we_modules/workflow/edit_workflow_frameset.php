<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/workflow/weWorkflowFrames.php");

	htmlTop();

	print STYLESHEET;

	$workflowFrame=new weWorkflowFrames();
	$workflowFrame->View->processVariables();
	$workflowFrame->View->processCommands();

	if(isset($_GET["pnt"])){
	    $what = $_GET["pnt"];
	} else {
	    $what="frameset";
	}

	if(isset($_GET["art"])){
	    $mode=$_GET["art"];
	} else {
	    $mode=0;
	}
	
	if(isset($_GET["type"])){
	    $type=$_GET["type"];
	} else {
	    $type=0;
	}

	switch($what){
		case "frameset":
			print $workflowFrame->getHTMLFrameset();
			break;
			
		case "header":print $what;
			print $workflowFrame->getHTMLHeader();
			break;
			
		case "resize":
			print $workflowFrame->getHTMLResize();
			break;
			
		case "left":
			print $workflowFrame->getHTMLLeft();
			break;
		case "right":
			print $workflowFrame->getHTMLRight();
			break;
			
		case "editor":
			print $workflowFrame->getHTMLEditor();
			break;
			
		case "edheader":
			print $workflowFrame->getHTMLEditorHeader($mode);
			break;
			
		case "edbody":
			print $workflowFrame->getHTMLEditorBody();
			break;
			
		case "edfooter":
			print $workflowFrame->getHTMLEditorFooter($mode);
			break;
			
		case "qlog":
			print $workflowFrame->getHTMLLogQuestion();
			break;
			
		case "log":
			print $workflowFrame->getHTMLLog($mode,$type);
			break;
			
		case "cmd":
			print $workflowFrame->getHTMLCmd();
			break;

		default:
	}

?>