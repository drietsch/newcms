<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");


class weGlossaryTreeLoader{

	function getItems($ParentId, $Offset = 0, $Segment = 500, $Sort = "") {
		
		$Types = array(
			'abbreviation',
			'acronym',
			'foreignword',
			'link',
		);
		
		$Temp = explode("_", $ParentId);

		if(in_array($Temp[(sizeof($Temp)-1)], $Types)) {
			$Type = array_pop($Temp);
			$Language = implode("_", $Temp);
			return weGlossaryTreeLoader::getItemsFromDB($Language, $Type, $Offset, $Segment);
			
		} else if(in_array($ParentId, array_keys($GLOBALS['weFrontendLanguages']))) {
			return weGlossaryTreeLoader::getTypes($ParentId);
			
		} else {
			return weGlossaryTreeLoader::getLanguages();
		}
		
	}


	function getLanguages() {
		
		$Items = array();
		
		foreach($GLOBALS['weFrontendLanguages'] as $Key => $Val) {
			
			$Item = array(
				'id'		=> $Key,
				'parentid'	=> 0,
				'text'		=> $Val,
				'typ'		=> 'group',
				'open'		=> 0,
				'disabled'	=> 0,
				'tooltip'	=> $Val,
				'offset'	=> 0,
				'published'	=> 1,
				'cmd'		=> "view_folder",
			);
			
			array_push($Items, $Item);
			
		}
		
		return $Items;

	}


	function getTypes($Language) {
		
		$Items = array();
				
		$Types = array(
			'abbreviation'	=> $GLOBALS['l_glossary']['abbreviation'],
			'acronym'		=> $GLOBALS['l_glossary']['acronym'],
			'foreignword'	=> $GLOBALS['l_glossary']['foreignword'],
			'link'			=> $GLOBALS['l_glossary']['link'],
		);
			
		foreach($Types as $Key => $Val) {
			
			$Item = array(
				'id'		=> $Language . "_" . $Key,
				'parentid'	=> $Language,
				'text'		=> $Val,
				'typ'		=> 'group',
				'open'		=> 0,
				'disabled'	=> 0,
				'tooltip'	=> $Val,
				'offset'	=> 0,
				'published'	=> 1,
				'cmd'		=> 'view_type',
			);
			
			array_push($Items, $Item);
			
		}
			
		if(we_hasPerm("EDIT_GLOSSARY_DICTIONARY")) {
			$Item = array(
				'id'		=> $Language . "_exception",
				'parentid'	=> $Language,
				'text'		=> $GLOBALS['l_glossary']['exception'],
				'typ'		=> 'item',
				'open'		=> 0,
				'disabled'	=> 0,
				'tooltip'	=> $GLOBALS['l_glossary']['exception'],
				'offset'	=> 0,
				'published'	=> 1,
				'cmd'		=> 'view_exception',
				'Icon'		=> 'prog.gif'
			);
		 
		 	array_push($Items, $Item);
		 	
		}
		
		return $Items;

	}

	
	function getItemsFromDB($Language, $Type, $Offset = 0, $Segment = 500) {
		
		$Db = new DB_WE();
		$Table = GLOSSARY_TABLE;
		
		$Items = array();
		
		$Where = " WHERE Language = '$Language' AND Type = '$Type'";	
				
		$PrevOffset = $Offset-$Segment;
		$PrevOffset = ($PrevOffset<0) ? 0 : $PrevOffset;
		
		if($Offset && $Segment){	
			$Item = array(
				"id"			=> "prev_" . $Language . "_" . $Type,
				"parentid"		=> $Language . "_" . $Type,
				"text"			=> "display (" . $PrevOffset . "-" . $Offset . ")",
				"contenttype"	=> "arrowup",
				"table"			=> GLOSSARY_TABLE,
				"typ"			=> "threedots",
				"icon"			=> "arrowup.gif",
				"open"			=> 0,
				"disabled"		=> 0,
				"tooltip"		=> "",
				"offset"		=> $PrevOffset,
			);
		 	array_push($Items, $Item);
		 	
		}
		
		$Query = 	"SELECT "
				.	"ID, "
				.	"Type, "
				.	"Language, "
				.	"Text, "
				.	"Icon, "
				.	"abs(Text) as Nr, "
				.	"(Text REGEXP '^[0-9]') as isNr, "
				.	"Published "
				.	"FROM "
				.	$Table . " "
				.	$Where . " "
				.	"ORDER BY "
				.	"isNr DESC, "
				.	"Nr, "
				.	"Text "
				.	($Segment ?  "LIMIT $Offset,$Segment" : "");
				
		$Db->query($Query);
		while($Db->next_record()){

			$Item = array(
				'id'		=> $Db->f('ID'),
				'parentid'	=> $Language . "_" . $Type,
				'text'		=> $Db->f('Text'),
				'typ'		=> 'item',
				'open'		=> 0,
				'disabled'	=> 0,
				'tooltip'	=> $Db->f('ID'),
				'offset'	=> $Offset,
				'published'	=> ($Db->f('Published')>0?true:false),
				"icon"		=> $Db->f('Icon'),
			);

			switch($Type) {
						
				case 'abbreviation':
					$Item['cmd'] = "edit_glossary_abbreviation";
					break;
				case 'acronym':
					$Item['cmd'] = "edit_glossary_acronym";
					break;
				case 'foreignword':
					$Item['cmd'] = "edit_glossary_foreignword";
					break;
				case 'link':
					$Item['cmd'] = "edit_glossary_link";
					break;
			}
				
 			foreach($Db->Record as $Key => $Val) {
 				if(!is_numeric($Key)) {
 					//if(strtolower($Key)=="text") {
 					//	$Item[strtolower($Key)] = htmlentities($Val);
 					//}
 					//else  {
 						$Item[strtolower($Key)] = $Val;
 					//}
 				}
 				
 			}
		 
		 	array_push($Items, $Item);
		}

		$Total = f("SELECT COUNT(*) as total FROM $Table $Where","total",$Db);
		
		$NextOffset = $Offset + $Segment;
		if($Segment && ($Total > $NextOffset)){
			$Item = array(
				"id"			=> "next_" . $Language . "_" . $Type,
				"parentid"		=> $Language . "_" . $Type,
				"text"			=> "display (" . $NextOffset . "-" . ($NextOffset+$Segment) . ")",
				"contenttype"	=> "arrowdown",
				"table"			=> GLOSSARY_TABLE,
				"typ"			=> "threedots",
				"icon"			=> "arrowdown.gif",
				"open"			=> 0,
				"disabled"		=> 0,
				"tooltip"		=> "",
				"offset"		=> $NextOffset,
			);
		 
		 	array_push($Items, $Item);
		 	
		}
		
		return $Items;

	}


}

?>