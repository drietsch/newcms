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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tagParser.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_util.inc.php");

function we_tag_addPercent($attribs,$content){
	$foo = attributFehltError($attribs,"percent","addPercent");if($foo) return $foo;
	$percent = we_getTagAttribute("percent",$attribs);
	$num_format = we_getTagAttribute("num_format",$attribs);

	$tp = new we_tagParser();
	$tags = $tp->getAllTags($content);
	$GLOBALS["calculate"]=1;
	$tp->parseTags($tags,$content);
	$GLOBALS["calculate"]=0;
	$content=we_util::std_numberformat($content);
	$result = ($content/100)*(100+$percent);
	if($num_format=="german"){
		$result=number_format($result,2,",",".");
	}else if($num_format=="french"){
		$result=number_format($result,2,","," ");
	}else if($num_format=="english"){
		$result=number_format($result,2,".","");
	}
	return $result;
}

?>