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
	include_once(WE_BANNER_MODULE_DIR."weBannerFrames.php");

	htmlTop();
	print STYLESHEET;

	$bannerFrame=new weBannerFrames();
	$bannerFrame->View->processVariables();
	$bannerFrame->View->processCommands();

	if(isset($_REQUEST["pnt"])) $what=$_REQUEST["pnt"];
	else $what="frameset";

	if(isset($_REQUEST["art"])) $mode=$_REQUEST["art"];
	else $mode=0;
		

	switch($what){
		case "frameset": print $bannerFrame->getHTMLFrameset();break;
		case "header": print $bannerFrame->getHTMLHeader();break;
		case "resize": print $bannerFrame->getHTMLResize();break;
		case "left": print $bannerFrame->getHTMLLeft();break;
		case "right": print $bannerFrame->getHTMLRight();break;
		case "editor": print $bannerFrame->getHTMLEditor();break;
		case "edheader": print $bannerFrame->getHTMLEditorHeader($mode);break;
		case "edbody": print $bannerFrame->getHTMLEditorBody();break;
		case "edfooter": print $bannerFrame->getHTMLEditorFooter($mode);break;
		case "cmd": print $bannerFrame->getHTMLCmd();break;
      default:
	}

?>