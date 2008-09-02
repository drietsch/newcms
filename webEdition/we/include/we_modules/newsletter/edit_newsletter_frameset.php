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
	include_once(WE_NEWSLETTER_MODULE_DIR . "weNewsletterFrames.php");

	protect();
	
	if (isset($_REQUEST["pnt"])) {
		$what = $_REQUEST["pnt"];
	} else {
		$what = "frameset";
	}

	if (isset($_REQUEST["art"])) {
		$mode = $_REQUEST["art"];
	} else {
		$mode = 0;
	}

	if ($what != "send" && $what != "send_body" && $what != "send_cmd" && $what != "edbody" && $what != "preview" && $what != "black_list" && $what != "newsletter_settings" && $what != "eemail" && $what != "edit_file" && $what != "clear_log" && $what != "export_csv_mes" && $what != "qsend" && $what != "qsave1")  {
		htmlTop();
		print STYLESHEET;
	}

	$newsletterFrame = new weNewsletterFrames();

	if (isset($_REQUEST["inid"])) {
		$newsletterFrame->View->newsletter = new weNewsletter($_REQUEST["inid"]);
	} else {
		if ($what != "export_csv_mes" && $what != "newsletter_settings" && $what != "qsend" && $what != "eedit" && $what != "black_list" && $what != "upload_csv") {
			$newsletterFrame->View->processVariables();
		}
	}

	if ($what != "export_csv_mes" && $what != "preview" && $what != "domain_check" && $what != "newsletter_settings" && $what != "show_log" && $what != "print_lists" && $what != "qsend" && $what != "eedit" && $what != "black_list") {
		$newsletterFrame->View->processCommands();
	}

	switch ($what) {
		case "frameset":
			print $newsletterFrame->getHTMLFrameset();
			break;

		case "header":
			print $newsletterFrame->getHTMLHeader();
			break;

		case "resize":
			print $newsletterFrame->getHTMLResize();
			break;

		case "left":
			print $newsletterFrame->getHTMLLeft();
			break;

		case "right":
			print $newsletterFrame->getHTMLRight();
			break;

		case "editor":
			print $newsletterFrame->getHTMLEditor();
			break;

		case "edheader":
			print $newsletterFrame->getHTMLEditorHeader($mode);
			break;

		case "edbody":
			print $newsletterFrame->getHTMLEditorBody();
			break;

		case "edfooter":
			print $newsletterFrame->getHTMLEditorFooter($mode);
			break;

		case "qlog":
			print $newsletterFrame->getHTMLLogQuestion();
			break;

		case "domain_check":
			print $newsletterFrame->getHTMLDCheck();
			break;

		case "show_log":
			print $newsletterFrame->getHTMLLog();
			break;

		case "newsletter_settings":
			print $newsletterFrame->getHTMLSettings();
			break;

		case "print_lists":
			print $newsletterFrame->getHTMLPrintLists();
			break;

		case "cmd":
			print $newsletterFrame->getHTMLCmd();
			break;

		case "qsend":
			print $newsletterFrame->getHTMLSendQuestion();
			break;

		case "qsave1":
			print $newsletterFrame->getHTMLSaveQuestion1();
			break;

		case "eemail":
			print $newsletterFrame->getHTMLEmailEdit();
			break;

		case "preview":
			print $newsletterFrame->getHTMLPreview();
			break;

		case "black_list":
			print $newsletterFrame->getHTMLBlackList();
			break;

		case "upload_black":
			print $newsletterFrame->getHTMLUploadCsv("javascript:we_cmd('do_upload_black');");
			break;

		case "upload_csv":
			print $newsletterFrame->getHTMLUploadCsv();
			break;

		case "export_csv_mes":
			print $newsletterFrame->getHTMLExportCsvMessage();
			break;

		case "edit_file":
			print $newsletterFrame->getHTMLEditFile($mode);
			break;
			
		case "clear_log": 
			print $newsletterFrame->getHTMLClearLog();
			break;

		case "send":
			print $newsletterFrame->getHTMLSendWait();
			break;
			
		case "send_frameset":
			print $newsletterFrame->getHTMLSendFrameset();
			break;

		case "send_body":
			print $newsletterFrame->getHTMLSendBody();
			break;			

		case "send_cmd":
			print $newsletterFrame->getHTMLSendCmd();
			break;
		case "send_control":
			print $newsletterFrame->getHTMLSendControl();
			break;			
			
		default:

}

?>