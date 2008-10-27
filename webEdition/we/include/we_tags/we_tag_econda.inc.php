<?php
/**
 * webEdition CMS
 *
 * This source is part of webEdition CMS. webEdition CMS is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
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
		$contentType = we_getTagAttribute("labelFrom",$attribs,"path");
		$retView = '<?php $GLOBALS["weEconda"]["content"]["from"] = "'.$contentType.'"; ?>';
		switch ($contentType){
			case "input":
				$name = "econda_content";
				$value = we_getTagAttribute("value", $attribs);
				$contentLabel = htmlspecialchars(isset($GLOBALS["we_doc"]->elements["econda_content"]["dat"]) ? $GLOBALS["we_doc"]->getElement("econda_content") : $value);
				$retEdit = '<input onchange="_EditorFrame.setEditorIsHot(true);" class="wetextinput" type="text" name="we_' . $GLOBALS["we_doc"]->Name . '_txt[' . $name . ']" value="' . $val . '"' . ($attr ? " $attr" : "") . '>';
				$retView .= '<a name="emos_name" title="content" rel="'.$contentLabel.'" rev=""></a>';
				break;
			case "hidden":
				$name = "econda_content";
				$value = we_getTagAttribute("value", $attribs);
				$contentLabel = htmlspecialchars(isset($GLOBALS["we_doc"]->elements["econda_content"]["dat"]) ? $GLOBALS["we_doc"]->getElement("econda_content") : $value);
				$retEdit = '<input onchange="_EditorFrame.setEditorIsHot(true);" type="hidden" name="we_' . $GLOBALS["we_doc"]->Name . '_txt[' . $name . ']" value="' . $val . '"' . ($attr ? " $attr" : "") . '>';
				$retView .= '<a name="emos_name" title="content" rel="'.$contentLabel.'" rev=""></a>';
				break;
		}

		if ($we_editmode) {
			return $retEdit;
		} else if(!$GLOBALS["we_doc"]->InWebEdition){
			return $retView;
			//return '<a name="emos_name" title="content" rel="'.$contentLabel.'" rev=""></a>';
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