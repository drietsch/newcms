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

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/voting/weVoting.php");

function we_tag_votingSelect($attribs, $content){
 	global $DB_WE,$we_editmode;
	
 	if($we_editmode && isset($GLOBALS['_we_voting']) && isset($GLOBALS['_we_voting_namespace'])){
		$firstentry = we_getTagAttribute("firstentry",$attribs);
		$submitonchange = we_getTagAttribute("submitonchange",$attribs,"",true);
		
		$where = ' WHERE IsFolder=0 ' . weVoting::getOwnersSql();
		
		$select_name = $GLOBALS['_we_voting_namespace'];
		
		$newAttribs = array();
		$newAttribs['name'] = 'we_' . $GLOBALS["we_doc"]->Name . '_txt['.$select_name.']';
				
		$val = htmlspecialchars(isset($GLOBALS["we_doc"]->elements[$select_name]["dat"]) ? $GLOBALS["we_doc"]->getElement($select_name) : 0);

		if($submitonchange){
			$newAttribs['onchange'] = 'we_submitForm();';
		}
		
		$options = '';
		
		if(isset($attribs['firstentry'])){
		    $options = getHtmlTag('option',array('value'=>''),$firstentry,true);
		}
		
		$DB_WE->query("SELECT ID,Text FROM " . VOTING_TABLE . " $where ORDER BY Text;");
		while($DB_WE->next_record()){
				$options .= getHtmlTag('option',($DB_WE->f('ID')==$val ? array('value'=>$DB_WE->f("ID"),'selected'=>'selected') : array('value'=>$DB_WE->f("ID"))), $DB_WE->f("Text")) . "\n";
		}
	
		return getHtmlTag('select',$newAttribs,$options,true);
 	}
	
}
?>