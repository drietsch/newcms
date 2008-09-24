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

function we_tag_econda($attribs, $content){
	// Define globals
	global $we_editmode, $l_global;
	
	$type = we_getTagAttribute("type",$attribs);
	if ($type=="exclude" && !$GLOBALS["we_doc"]->InWebEdition) {
			return "\n".'<script type="text/javascript">
//<!--
	var emosTrackClicks=false;
//-->
</script>'."\n";
	} else if($type == "content"){
		$retEdit = "";
		$contentType = we_getTagAttribute("contentType",$attribs,"path");
		switch ($contentType){
			case "input":
				$name = "econda_content";
				$value = we_getTagAttribute("value", $attribs);
				$contentLabel = htmlspecialchars(isset($GLOBALS["we_doc"]->elements["econda_content"]["dat"]) ? $GLOBALS["we_doc"]->getElement("econda_content") : $value);
				$retEdit = '<input onchange="_EditorFrame.setEditorIsHot(true);" class="wetextinput" type="text" name="we_' . $GLOBALS["we_doc"]->Name . '_txt[' . $name . ']" value="' . $val . '"' . ($attr ? " $attr" : "") . '>';
				break;
			case "hidden":
				$name = "econda_content";
				$value = we_getTagAttribute("value", $attribs);
				$contentLabel = htmlspecialchars(isset($GLOBALS["we_doc"]->elements["econda_content"]["dat"]) ? $GLOBALS["we_doc"]->getElement("econda_content") : $value);
				$retEdit = '<input onchange="_EditorFrame.setEditorIsHot(true);" type="hidden" name="we_' . $GLOBALS["we_doc"]->Name . '_txt[' . $name . ']" value="' . $val . '"' . ($attr ? " $attr" : "") . '>';
				break;
			case "navigation":
				if(isset($GLOBALS["we_doc"]->NavigationItems) && $GLOBALS["we_doc"]->NavigationItems != "") {
					$navItems = explode(",",$GLOBALS["we_doc"]->NavigationItems);
					$contentLabel = $navItems[1]; 
				}
				break;
			case "path":
				$contentLabel = substr($GLOBALS["we_doc"]->Path,1);
				break;
			case "category":
				if(isset($GLOBALS["we_doc"]->Category) && $GLOBALS["we_doc"]->Category != "") {
					$catIds = explode(",",$GLOBALS["we_doc"]->Category); 
					$contentLabel = f("SELECT Path FROM " . CATEGORY_TABLE . " WHERE ID=" . $catIds[1], "Path", $GLOBALS["DB_WE"]);
				}
				break;
			default:
				$contentLabel = substr($GLOBALS["we_doc"]->Path,1);
		}

		if ($we_editmode) {
			return $retEdit;
		} else if(!$GLOBALS["we_doc"]->InWebEdition){
			return '<a name="emos_name" title="content" rel="'.$contentLabel.'" rev=""></a>';
		}
	} else if($type == "orderProcess") {
		if(!$GLOBALS["we_doc"]->InWebEdition){
			$step = we_getTagAttribute("step",$attribs);
			$pageName = we_getTagAttribute("pageName",$attribs);
			return '<a name="emos_name" title="orderProcess" rel="'.$step.'_'.$pageName.'" rev=""></a>';
		}
		
	} else {
		
	}
}