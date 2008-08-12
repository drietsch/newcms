<?php
// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_export/weExportWizard.inc.php");

$frames = new weExportWizard("/webEdition/we/include/we_export/export_frameset.php");

//	Starting output .

if(isset($_REQUEST["pnt"])){
	$what = $_REQUEST["pnt"];
} else {	
	$what = "frameset";
}

if(isset($_REQUEST["step"])){
	$step= $_REQUEST["step"];
}
else $step=0;


switch ($what) {
	
	case "frameset" :
		print $frames->getHTMLFrameset();
		break;
		
	case "header" : 
		print $frames->getHTMLHeader($step);
		break;
			
	case "body" : 
		print $frames->getHTMLStep($step);
		break;

	case "footer" :
		print $frames->getHTMLFooter($step);
		break;

	case "load" :
		print $frames->getHTMLCmd();
		break;
		
	default :
		die("Unknown command: " . $what . "\n");
		break;
}

?>