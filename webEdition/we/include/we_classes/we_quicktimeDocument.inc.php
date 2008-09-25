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
 * @package    webEdition_class
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/"."we_binaryDocument.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/global.inc.php");

/*  a class for handling quicktimeDocuments. */
class we_quicktimeDocument extends we_binaryDocument {
	######################################################################################################################################################
	##################################################################### Variables ######################################################################
	######################################################################################################################################################

	/* Name of the class => important for reconstructing the class from outside the class */
	var $ClassName="we_quicktimeDocument";

	/* ContentType of the Object  */
	var $ContentType="video/quicktime";

	/* Parameternames which are placed within the object-Tag */
	var $ObjectParamNames = array("width","height","name","vspace","hspace");


	######################################################################################################################################################
	##################################################################### FUNCTIONS ######################################################################
	######################################################################################################################################################


	/* Constructor */
	function we_quicktimeDocument(){
		$this->we_binaryDocument();
		array_push($this->EditPageNrs,WE_EDITPAGE_PREVIEW);
	}

	/* must be called from the editor-script. Returns a filename which has to be included from the global-Script */
	function editor() {
		switch($this->EditPageNr){
			case WE_EDITPAGE_PREVIEW:
			return "we_templates/we_editor_flash_preview.inc.php";
			default:
			return parent::editor();
		}
	}

	// is not written yet
	function initByAttribs($attribs){
		foreach($attribs as $a=>$b){
			if($b != ""){
				if($a == "Pluginspage" || $a == "Codebase"){
					$this->setElement($a,$b,"txt");
				}else{
					$this->setElement($a,$b,"attrib");
				}
			}
		}
	}

	/* gets the HTML for including in HTML-Docs */
	function getHtml($dyn=false){
		global $we_transaction;

		//    At the moment it is not possible to make this tag xhtml valid, so the output is only posible
		//    non xhtml valid

		$_data = $this->getElement("data");
		if ($this->ID || ($_data && !is_dir($_data) && is_readable($_data))) {
			$pluginspage = $this->getElement("Pluginspage") ? $this->getElement("Pluginspage") : "http://www.apple.com/quicktime/download/";
			$codebase = $this->getElement("Codebase") ? $this->getElement("Codebase") : "http://www.apple.com/qtactivex/qtplugin.cab";

			/***********************************************
			first we make valid object-tag
			************************************************/
			srand ((double)microtime()*1000000);
			$randval = rand();
			$src = $dyn ?
					WEBEDITION_DIR.'we_cmd.php?we_cmd[0]=show_binaryDoc&we_cmd[1]='.$this->ContentType.'&we_cmd[2]='.$we_transaction."&rand=".$randval :
					$this->Path;

			$filter = array("filesize","type","xml");
            $noAtts = array("scale","volume");      //  no atts for xml

			// fix. older versions of webEdition bgcolor was type txt and not attrib
            if (isset($this->elements["bgcolor"])) {
            	$this->elements["bgcolor"]["type"] = "attrib";
            }

            $this->resetElements();
            while(list($k,$v) = $this->nextElement("attrib")){
            	if(in_array($k,$this->ObjectParamNames)){
            		$_objectAtts[$k] = $v["dat"];
            	}
            }

            //  $_xml = $this->getElement("xml");
            //  xhtml output is not possible to work for IE and Mozilla
            //  therefore it is deactivated
            $_xml = 'false';
            $_objectAtts['xml'] = $_xml;

            //  <embed> for none xhtml
            $_embed = '';

            //  <params>
            $_params = "\n" . getHtmlTag('param', array('name' => 'src', 'value' => $src, 'xml' => $_xml)) . "\n";

			if($_xml == "true"){  //  only object tag

               $_objectAtts['type'] = 'video/quicktime';
               $_objectAtts['data'] = $src;

            	$this->resetElements();
            	while(list($k,$v) = $this->nextElement("attrib")){
            		if(!in_array($k,$filter) && !in_array($k,$this->ObjectParamNames)){

                        if($v["dat"] != ""){    //  dont use empty params
                            if(!in_array($k,$noAtts)){
                                $_objectAtts[$k] = $v["dat"];
                            }
                            $_params .= getHtmlTag('param', array('name' => $k, 'value' => $v["dat"], 'xml' => $_xml)) . "\n";
            		    }
            		}
            	}

			} else {                                 //  object tag and embed
    			$_objectAtts['classid'] = 'clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B';
    			$_objectAtts['codebase'] = $codebase;
			    //   we need embed as well

			    $_embedAtts['type'] = 'video/quicktime';
			    $_embedAtts['pluginspace'] = $pluginspage;
			    $_embedAtts['xml'] = $_xml;
			    $_embedAtts['src'] = $src;

			    $this->resetElements();
			    while(list($k,$v) = $this->nextElement("attrib")){
           			if(!in_array($k,$filter) && $v["dat"] != ""){

                        if($v["dat"] != ""){    //  dont use empty params
                            $_params .= getHtmlTag('param', array('name' => $k, 'value' => $v["dat"], 'xml' => $_xml)) . "\n";
            		    }

            		    $_embedAtts[$k] = $v["dat"];
            		}
            	}
            	$_embed = "\n" . getHtmlTag('embed', $_embedAtts, "", true);
			}
			$_objectAtts = removeEmptyAttribs($_objectAtts);
			$this->html = getHtmlTag('object', $_objectAtts,$_params . $_embed);


		}else{

		    $_imgAttr['src']    = IMAGE_DIR.'icons/no_quicktime.gif';
		    $_imgAttr['width']  = 64;
		    $_imgAttr['height'] = 64;
		    $_imgAttr['border'] = 0;
		    $_imgAtts["style"] = "margin:8px 18px;";
		    $_imgAttr['alt'] = "";
		    $_imgAttr['xml'] = $this->getElement("xml");

		    if(isset($this->name)){
		        $_imgAttr['name'] = $this->name;
		    }
			$this->html = getHtmlTag('img', $_imgAttr);
		}
		return $this->html;
	}

	function formProperties(){
		global $l_we_class,$l_global;
		$content = '<table border="0" cellpadding="0" cellspacing="0">
	<tr valign="top">
		<td>'.$this->formInput2(155,"width",10,"attrib","onChange=\"_EditorFrame.setEditorIsHot(true);\"").'</td>
		<td>'.getPixel(18,2).'</td>
		<td>'.$this->formInput2(155,"height",10,"attrib","onChange=\"_EditorFrame.setEditorIsHot(true);\"").'</td>
		<td>'.getPixel(18,2).'</td>
		<td>'.$this->formSelectElement2(
					155,"scale",array(
									""=>"",
									"tofit"=>"tofit",
									"aspect"=>"aspect",
									"0.5"=>"0,5x",
									"2"=>"2x",
									"4"=>"4x"
									),
					"attrib",1,"onChange=\"_EditorFrame.setEditorIsHot(true);\""
									).'</td>
	</tr>
	<tr valign="top">
		<td colspan="5">'.getPixel(2,5).'</td>
	</tr>
	<tr valign="top">
		<td>'.$this->formInput2(155,"hspace",10,"attrib","onChange=\"_EditorFrame.setEditorIsHot(true);\"").'</td>
		<td>'.getPixel(18,2).'</td>
		<td>'.$this->formInput2(155,"vspace",10,"attrib","onChange=\"_EditorFrame.setEditorIsHot(true);\"").'</td>
		<td>'.getPixel(18,2).'</td>
		<td>'.$this->formInput2(155,"name",10,"attrib","onChange=\"_EditorFrame.setEditorIsHot(true);\"").'</td>
	</tr>
	<tr valign="top">
		<td colspan="5">'.getPixel(2,5).'</td>
	</tr>
	<tr valign="top">
		<td>'.$this->formSelectElement2(155,"autoplay",array(""=>$l_global["true"],"false"=>$l_global["false"]),"attrib",1,"onChange=\"_EditorFrame.setEditorIsHot(true);\"").'</td>
		<td>'.getPixel(18,2).'</td>
		<td>'.$this->formSelectElement2(155,"controller",array(""=>$l_global["true"],"false"=>$l_global["false"]),"attrib",1,"onChange=\"_EditorFrame.setEditorIsHot(true);\"").'</td>
		<td>'.getPixel(18,2).'</td>
		<td>'.$this->formColor(155,"bgcolor",25,"attrib").'</td>
	</tr>
	<tr valign="top">
		<td colspan="5">'.getPixel(2,5).'</td>
	</tr>
	<tr valign="top">
		<td>'.$this->formSelectElement2(155,"volume",array("100"=>"",0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100),"attrib",1,"onChange=\"_EditorFrame.setEditorIsHot(true);\"").'</td>
		<td>'.getPixel(18,2).'</td>
		<td>'.$this->formSelectElement2(155,"hidden",array("true"=>$l_global["true"],""=>$l_global["false"]),"attrib",1,"onChange=\"_EditorFrame.setEditorIsHot(true);\"").'</td>
		<td>'.getPixel(18,2).'</td>
		<td>'.$this->formSelectElement2(155,"loop",array(""=>$l_global["true"],"false"=>$l_global["false"]),"attrib",1,"onChange=\"_EditorFrame.setEditorIsHot(true);\"") .'</td>
	</tr>
</table>
';
		return $content;
 	}

 	function formOther(){
		global $l_we_class;
		$content = '<table border="0" cellpadding="0" cellspacing="0">
	<tr valign="top">
		<td>'.$this->formInputField("txt","Pluginspage","Pluginspage",24,388, "", "onchange=\"_EditorFrame.setEditorIsHot(true);\"").'</td>
	</tr>
	<tr valign="top">
		<td>'.$this->formInputField("txt","Codebase","Codebase",24,388, "", "onchange=\"_EditorFrame.setEditorIsHot(true);\"").'</td>
	</tr>
</table>
';


 		return $content;
	}

	function getThumbnail() {
		$_width = $this->getElement("width");
		$_height = $this->getElement("height");
		$_scale = $this->getElement("scale");
		$_hspace = $this->getElement("hspace");
		$_vspace = $this->getElement("vspace");
		$_name = $this->getElement("name");
		$_autoplay = $this->getElement("autoplay");
		$_controller = $this->getElement("controller");
		$_bgcolor = $this->getElement("bgcolor");
		$_volume = $this->getElement("volume");
		$_hidden = $this->getElement("hidden");
		$_loop = $this->getElement("loop");

		$this->setElement("width", 150, "attrib");
		$this->setElement("height", 100, "attrib");
		$this->setElement("scale", "aspect", "attrib");
		$this->setElement("hspace", "", "attrib");
		$this->setElement("vspace", "", "attrib");
		$this->setElement("name", "", "attrib");
		$this->setElement("autoplay", "true", "attrib");
		$this->setElement("controller", "false", "attrib");
		$this->setElement("bgcolor", "", "attrib");
		$this->setElement("volume", "", "attrib");
		$this->setElement("hidden", "", "attrib");
		$this->setElement("loop", "", "attrib");
		$html = $this->getHtml(true);
		$this->setElement("width", $_width, "attrib");
		$this->setElement("height", $_height, "attrib");
		$this->setElement("scale", $_scale, "attrib");
		$this->setElement("hspace", $_hspace, "attrib");
		$this->setElement("vspace", $_vspace, "attrib");
		$this->setElement("name", $_name, "attrib");
		$this->setElement("autoplay", $_autoplay, "attrib");
		$this->setElement("controller", $_controller, "attrib");
		$this->setElement("bgcolor", $_bgcolor, "attrib");
		$this->setElement("volume", $_volume, "attrib");
		$this->setElement("hidden", $_hidden, "attrib");
		$this->setElement("loop", $_loop, "attrib");
		return $html;
	}


}

?>
