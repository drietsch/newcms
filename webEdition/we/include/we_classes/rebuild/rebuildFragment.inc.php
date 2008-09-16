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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/taskFragment.class.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/rebuild/we_rebuild.class.php");

class rebuildFragment extends taskFragment{

	function rebuildFragment($name,$taskPerFragment,$pause=0,$bodyAttributes="",$initdata="") {
		parent::taskFragment($name,$taskPerFragment,$pause,$bodyAttributes,$initdata);

	}

	function doTask(){
		we_rebuild::rebuild($this->data);
		$this->updateProgressBar();
	}

	function updateProgressBar() {
		$percent = round((100/count($this->alldata))*(1+$this->currentTask));
		print '<script language="JavaScript" type="text/javascript">if(parent.wizbusy.document.getElementById("progr")){parent.wizbusy.document.getElementById("progr").style.display="";};parent.wizbusy.setProgressText("pb1",(parent.wizbusy.document.getElementById("progr") ? "'.addslashes(shortenPath($this->data["path"],33)).'" : "'.$GLOBALS["l_rebuild"]["savingDocument"].addslashes(shortenPath($this->data["path"],60)).'") );parent.wizbusy.setProgress('.$percent.');</script>';

	}

	function finish(){
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/rebuild.inc.php");
		$responseText = isset($_REQUEST["responseText"]) ? $_REQUEST["responseText"] : "";
		htmlTop();
		print '<script language="JavaScript" type="text/javascript">
			' . we_message_reporting::getShowMessageCall( addslashes($responseText ? $responseText : $GLOBALS["l_rebuild"]["finished"]), WE_MESSAGE_NOTICE ) . '
			top.close();
		</script>
		</head>
		</html>';
	}

	function printHeader(){
		protect();
		//print "<html><head><title></title></head>";
	}
	function printBodyTag($attributes=""){

	}
	function printFooter(){
		$this->printJSReload();
	}
}
?>