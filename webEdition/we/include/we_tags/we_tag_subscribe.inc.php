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


function we_tag_subscribe($attribs, $content){
	$type = we_getTagAttribute("type",$attribs,"email");
	$values = we_getTagAttribute("values",$attribs);
	$value = we_getTagAttribute("value",$attribs);
	$xml = we_getTagAttribute("xml",$attribs,"");
	$checked = we_getTagAttribute("checked",$attribs,"",true);

	switch($type){
		case "listCheckbox":
			$nr = isset($GLOBALS["WE_TAG_SUBSCRIBE_LISTCHECKBOX_NR"]) ? ($GLOBALS["WE_TAG_SUBSCRIBE_LISTCHECKBOX_NR"]+1) : 0;
			$GLOBALS["WE_TAG_SUBSCRIBE_LISTCHECKBOX_NR"] = $nr;

			$newAttribs = removeAttribs($attribs,array('name','type','value'));

			$newAttribs['type'] = 'checkbox';
			$newAttribs['name'] = 'we_subscribe_list__['.$nr.']';
			$newAttribs['value'] = $nr;

			if( $checked || (isset($_REQUEST["we_subscribe_list__"]) && in_array($nr,$_REQUEST["we_subscribe_list__"])) ){
			    $newAttribs['checked'] = 'checked';
			}

			return getHtmlTag('input', array('type'=>'hidden','name'=>'we_use_lists__','value'=>1,'xml'=>$xml)) .
			       getHtmlTag('input', $newAttribs);

		case "listSelect":
			if($values){
			    $newAttribs = removeAttribs($attribs, array('name','type','value','values','lists','maxlength','checked'));
				$newAttribs['name'] = 'we_subscribe_list__[]';
				$newAttribs['multiple'] = 'multiple';
				$options = '';
				$vals = makeArrayFromCSV($values);
				foreach($vals as $i=>$v){
				    if( (isset($_REQUEST["we_subscribe_list__"]) && in_array($i,$_REQUEST["we_subscribe_list__"])) ){
				        $options .= getHtmlTag('option', array('value'=>$i,'selected'=>'selected'),htmlspecialchars($v));
				    } else {
				        $options .= getHtmlTag('option', array('value'=>$i),htmlspecialchars($v));
				    }
				}
				return getHtmlTag('input',array('type'=>'hidden','name'=>'we_use_lists__','value'=>1,'xml'=>$xml)) .
				       getHtmlTag('select', $newAttribs, $options, true);
			}
			return '';

		case "htmlCheckbox":
            $newAttribs = removeAttribs($attribs,array('name','type','value','checked','values'));
            $newAttribs['name'] = 'we_subscribe_html__';
            $newAttribs['type'] = 'checkbox';
			$newAttribs['value'] = '1';
            if( (isset($_REQUEST["we_subscribe_html__"]) && ($_REQUEST["we_subscribe_html__"] == 1 || $_REQUEST["we_subscribe_html__"] == 'on') ) || $checked ){
                $newAttribs['checked'] = 'checked';
            }
            return getHtmlTag('input',$newAttribs);

        case "htmlSelect":
            $newAttribs = removeAttribs($attribs,array('name','type','value','size','values','maxlength','checked'));
            $newAttribs['name'] = 'we_subscribe_html__';
			$value = we_getTagAttribute("value",$attribs,"",true);
			if(isset($_REQUEST["we_subscribe_html__"])){
				$ishtml = $_REQUEST["we_subscribe_html__"];
			}else{
				$ishtml = isset($attribs["value"]) ? $value : 0;
			}
			if($values){
				$values = makeArrayFromCSV($values);
			}else{
				$values = array("Text","HTML");
			}

			if($ishtml){
			    $options = getHtmlTag('option',array('value'=>0),htmlspecialchars($values[0])) . "\n";
			    $options .= getHtmlTag('option',array('value'=>1,'selected'=>'selected'),htmlspecialchars($values[1])) . "\n";
			} else {
                $options = getHtmlTag('option',array('value'=>0,'selected'=>'selected'),htmlspecialchars($values[0])) . "\n";
			    $options .= getHtmlTag('option',array('value'=>1),htmlspecialchars($values[1])) . "\n";
			}
			return getHtmlTag('select', $newAttribs, $options, true);

		case "firstname":
            $newAttribs = removeAttribs($attribs, array('name','type','value','values'));

            $newAttribs['type'] = 'text';
		    $newAttribs['name'] = 'we_subscribe_firstname__';

			if(isset($_REQUEST["we_subscribe_firstname__"])){
                $newAttribs['value'] = htmlspecialchars($_REQUEST["we_subscribe_firstname__"]);
			} else {
			    $newAttribs['value'] = htmlspecialchars($value);
			}
			return getHtmlTag('input',$newAttribs);

        case "salutation":

            if($values){
			    $newAttribs = removeAttribs($attribs, array('name','type','value','values','maxlength','checked'));
			    $newAttribs['name'] = 'we_subscribe_salutation__';
			    $_optAtts['xml'] = $xml;
				$attr = we_make_attribs($attribs,"name,type,values");
				$options = getHtmlTag('option', $_optAtts,'',true);
				$vals = makeArrayFromCSV($values);
				$value = isset($_REQUEST["we_subscribe_salutation__"]) ? $_REQUEST["we_subscribe_salutation__"] : $value;
				foreach($vals as $v){
				    $_optAtts['value'] = htmlspecialchars($v);
				    if($v==$value){
				        $options .= getHtmlTag('option',array_merge($_optAtts, array('selected'=>'selected')),htmlspecialchars($v)) . "\n";
				    } else {
                        $options .= getHtmlTag('option',$_optAtts,htmlspecialchars($v)) . "\n";
				    }
				}
				return getHtmlTag('select',$newAttribs,$options, true);
			}else{
			    $newAttribs = removeAttribs($attribs, array('name','type','value','values'));
			    $newAttribs['name'] = 'we_subscribe_salutation__';
			    $newAttribs['type'] = 'text';

    			if(isset($_REQUEST["we_subscribe_salutation__"])){
                    $newAttribs['value'] = htmlspecialchars($_REQUEST["we_subscribe_salutation__"]);
    			} else {
    			    $newAttribs['value'] = htmlspecialchars($value);
    			}
				return getHtmlTag('input',$newAttribs);
			}

		case "title":
			if($values){
			    $newAttribs = removeAttribs($attribs, array('name','type','value','values','maxlength','checked'));
			    $newAttribs['name'] = 'we_subscribe_title__';
			    $_optAtts['xml'] = $xml;
				$attr = we_make_attribs($attribs,"name,type,values");
				$options = getHtmlTag('option', $_optAtts,'',true);
				$vals = makeArrayFromCSV($values);
				$value = isset($_REQUEST["we_subscribe_title__"]) ? $_REQUEST["we_subscribe_title__"] : $value;
				foreach($vals as $v){
				    $_optAtts['value'] = htmlspecialchars($v);
				    if($v==$value){
				        $options .= getHtmlTag('option',array_merge($_optAtts, array('selected'=>'selected')),htmlspecialchars($v)) . "\n";
				    } else {
                        $options .= getHtmlTag('option',$_optAtts,htmlspecialchars($v)) . "\n";
				    }
				}
				return getHtmlTag('select',$newAttribs,$options,true);
			}else{
			    $newAttribs = removeAttribs($attribs, array('name','type','value','values'));
			    $newAttribs['name'] = 'we_subscribe_title__';
			    $newAttribs['type'] = 'text';

    			if(isset($_REQUEST["we_subscribe_title__"])){
                    $newAttribs['value'] = htmlspecialchars($_REQUEST["we_subscribe_title__"]);
    			} else {
    			    $newAttribs['value'] = htmlspecialchars($value);
    			}
				return getHtmlTag('input',$newAttribs); // '<input type="text" name="we_subscribe_title__"'.($attr ? " $attr" : "").($value ? ' value="'.htmlspecialchars($value).'"' : '').($xml ? ' /' : '').'>';
			}

		case "lastname":
            $newAttribs = removeAttribs($attribs, array('name','type','value','values'));

            $newAttribs['type'] = 'text';
		    $newAttribs['name'] = 'we_subscribe_lastname__';

			if(isset($_REQUEST["we_subscribe_lastname__"])){
                $newAttribs['value'] = htmlspecialchars($_REQUEST["we_subscribe_lastname__"]);
			} else {
			    $newAttribs['value'] = htmlspecialchars($value);
			}
			return getHtmlTag('input',$newAttribs);

		case "email":
		default:

		    $newAttribs = removeAttribs($attribs, array('name','type','value','values'));
		    $newAttribs['type'] = 'text';
		    $newAttribs['name'] = 'we_subscribe_email__';

			if(isset($_REQUEST["we_subscribe_email__"])){
			    $newAttribs['value'] = htmlspecialchars($_REQUEST["we_subscribe_email__"]);
			} else {
			    $newAttribs['value'] = htmlspecialchars($value);
			}
			return getHtmlTag('input',$newAttribs);// '<input type="text" name="we_subscribe_email__"'.($attr ? " $attr" : "").($value ? ' value="'.htmlspecialchars($value).'"' : '').($xml ? ' /' : '').'>';
	}

	return "";
}
?>