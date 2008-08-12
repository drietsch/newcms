<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//



include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we.inc.php');
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/we_thumbnail.class.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlElement.inc.php");

protect();

if(isset($_GET['u']) && isset($_GET['t']) && isset($_GET['id'])){
	$uniqid = $_GET['u'];
	$we_transaction = $_GET['t'];
	
	$we_dt = isset($_SESSION['we_data'][$we_transaction]) ? $_SESSION['we_data'][$we_transaction] : '';
	include($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_editors/we_init_doc.inc.php');
	
	$thumbIDs = makeArrayFromCSV($_GET['id']);

	htmlTop();
	
	print STYLESHEET . "</head>";
	
	$table = '<table border="0" cellpadding="5" cellspacing="0"><tr>';

	$thumbIDs = makeArrayFromCSV($_GET['id']);
	foreach ($thumbIDs as $thumbid) {

		$thumbObj = new we_thumbnail();
		$thumbObj->initByThumbID(	$thumbid,
									$we_doc->ID,
									$we_doc->Filename,
									$we_doc->Path,
									$we_doc->Extension,
									$we_doc->getElement("origwidth"),
									$we_doc->getElement("origheight"),
									$we_doc->getDocument());
									
		
		srand ((double)microtime()*1000000);
		$randval = rand();

				
		$useOrig = $thumbObj->isOriginal();
					

		if((!$useOrig) && $we_doc->ID && ($we_doc->DocChanged==false) && file_exists($thumbObj->getOutputPath(true))){
				$src = $thumbObj->getOutputPath(false).'?rand='.$randval;
		}else{
				$src = WEBEDITION_DIR.'we_cmd.php?we_cmd[0]=show_binaryDoc&amp;we_cmd[1]='.
							$we_doc->ContentType.'&amp;we_cmd[2]='.
							$we_transaction.'&amp;we_cmd[3]='.($useOrig ? "" : $thumbid).'&amp;rand='.$randval;
		}
	
		$table .= '<td><image src="'.$src.'" width="' . $thumbObj->getOutputWidth() . '" height="' . $thumbObj->getOutputHeight() . '" border="0"></td>';
	}

	$table .= '</tr></table>';
	
	print we_htmlElement::htmlBody(array("bgcolor" => "#ffffff",  "marginwidth" => "5",  "marginheight" => "5",  "leftmargin" => "5",  "topmargin" => "5"), $table) . "</html>";
}

?>