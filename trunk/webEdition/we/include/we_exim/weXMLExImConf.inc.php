<?php
		include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/charset/charset.inc.php");

		$GLOBALS['weXmlExImNewLine'] = "\n";

		$GLOBALS['weXmlExImHeader'] = '<?xml version="1.0" encoding="'.$_language['charset'].'" standalone="yes"?>' . $GLOBALS['weXmlExImNewLine'] .
					 '<webEdition version="' . WE_VERSION . '" xmlns:we="we-namespace">' . $GLOBALS['weXmlExImNewLine'];
					 
		$GLOBALS['weXmlExImFooter'] = '</webEdition>';
		
		$GLOBALS['weXmlExImProtectCode'] = '<?php exit();?>';


?>