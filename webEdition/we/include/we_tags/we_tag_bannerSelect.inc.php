<?php

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/banner/weBanner.php");

function we_tag_bannerSelect($attribs, $content){
 	global $DB_WE;
	$foo = attributFehltError($attribs,"name","banner");if($foo) return $foo;
 	
	$name = we_getTagAttribute("name",$attribs);
	$customer = we_getTagAttribute("customer",$attribs,"",true);
	$rootdir = we_getTagAttribute("rootdir",$attribs,"/");
	$firstentry = we_getTagAttribute("firstentry",$attribs);
	$showpath = we_getTagAttribute("showpath",$attribs,"",true);
	$submitonchange = we_getTagAttribute("submitonchange",$attribs,"",true);
	
	$where = " WHERE IsFolder=0 ";
	
	$newAttribs = removeAttribs($attribs,array('showpath','rootdir','firstentry','submitonchange','customer'));
	if($submitonchange){
	    $newAttribs['onchange'] = 'we_submitForm();';
	}
	
	$options = '';
	if($firstentry){
	    $options = getHtmlTag('option',array('value'=>''),$firstentry,true);
		$select .= '<option value="">'.$firstentry."</option>\n";
	}
	$DB_WE->query("SELECT ID,Text,Path,Customers FROM " . BANNER_TABLE . " $where ORDER BY Path");
	while($DB_WE->next_record()){
		if((!defined("CUSTOMER_TABLE")) || (!$customer) || ($customer && defined("CUSTOMER_TABLE") && weBanner::customerOwnsBanner($_SESSION["webuser"]["ID"],$DB_WE->f("ID")))){
			if(!isset($_REQUEST[$name])){
				$_REQUEST[$name] = $DB_WE->f("Path");
			}
			if($_REQUEST[$name]==$DB_WE->f("Path")){
			    $options .= getHtmlTag('option',array('value'=>$DB_WE->f("Path"),'selected'=>'selected'), $showpath ? $DB_WE->f("Path") : $DB_WE->f("Text")) . "\n";
			} else {
			    $options .= getHtmlTag('option',array('value'=>$DB_WE->f("Path")), $showpath ? $DB_WE->f("Path") : $DB_WE->f("Text")) . "\n";
			}
		}
	}
	
	if(isset($_REQUEST[$name])){
		 $GLOBALS[$name] = $_REQUEST[$name];
	}
	return getHtmlTag('select',$newAttribs,$options,true);
}
?>