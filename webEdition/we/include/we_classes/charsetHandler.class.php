<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/charset/charset.inc.php");

class charsetHandler{
	
	var $charsets = array();

	
	/**
	* @return charsetHandler
	* initialises with all available charsets
	*/
	function charsetHandler(){
		
		//	First ISO-8859-charsets
		$_charsets["west_european"]["national"] = "West Europe";				//	Here is the name of the country in mother language
		$_charsets["west_european"]["charset"] = "ISO-8859-1";
		$_charsets["west_european"]["international"] = $GLOBALS["_charset"]["titles"]["west_european"];	//	Name in selected language
		
		$_charsets["central_european"]["national"] = "Central Europe";
		$_charsets["central_european"]["charset"] = "ISO-8859-2";
		$_charsets["central_european"]["international"] = $GLOBALS["_charset"]["titles"]["central_european"];
		
		$_charsets["south_european"]["national"] = "South Europe";
		$_charsets["south_european"]["charset"] = "ISO-8859-3";
		$_charsets["south_european"]["international"] = $GLOBALS["_charset"]["titles"]["south_european"];
		
		$_charsets["north_european"]["national"] = "North Europe";
		$_charsets["north_european"]["charset"] = "ISO-8859-4";
		$_charsets["north_european"]["international"] = $GLOBALS["_charset"]["titles"]["north_european"];
		
		$_charsets["cyrillic"]["national"] = ";&#1077;&#1086;&#1073;&#1077;&#1089;&#1087;&#1077;&#1095;";
		$_charsets["cyrillic"]["charset"] = "ISO-8859-5";
		$_charsets["cyrillic"]["international"] = $GLOBALS["_charset"]["titles"]["cyrillic"];
		
		$_charsets["arabic"]["national"] = "&#1578;&#1587;&#1580;&#1617;&#1604; &#1575;&#1604;&#1570;&#1606;"; 
		$_charsets["arabic"]["charset"] = "ISO-8859-6";
		$_charsets["arabic"]["international"] = $GLOBALS["_charset"]["titles"]["arabic"];
		
		$_charsets["greek"]["national"] = "Greek";
		$_charsets["greek"]["charset"] = "ISO-8859-7";
		$_charsets["greek"]["international"] = $GLOBALS["_charset"]["titles"]["greek"];
		
		$_charsets["hebrew"]["national"] = "&#1488;&#1497;&#1512;&#1493;&#1508;&#1492;";
		$_charsets["hebrew"]["charset"] = "ISO-8859-8";
		$_charsets["hebrew"]["international"] = $GLOBALS["_charset"]["titles"]["hebrew"];
		
		$_charsets["turkish"]["national"] = "Turkish";
		$_charsets["turkish"]["charset"] = "ISO-8859-9";
		$_charsets["turkish"]["international"] = $GLOBALS["_charset"]["titles"]["turkish"];
		
		$_charsets["nordic"]["national"] = "Nordic";
		$_charsets["nordic"]["charset"] = "ISO-8859-10";
		$_charsets["nordic"]["international"] = $GLOBALS["_charset"]["titles"]["nordic"];
		
		$_charsets["thai"]["national"] = "Thai";
		$_charsets["thai"]["charset"] = "ISO-8859-11";
		$_charsets["thai"]["international"] = $GLOBALS["_charset"]["titles"]["thai"];
		
		$_charsets["baltic"]["national"] = "baltic";
		$_charsets["baltic"]["charset"] = "ISO-8859-13";
		$_charsets["baltic"]["international"] = $GLOBALS["_charset"]["titles"]["baltic"];

		$_charsets["keltic"]["national"] = "keltic";
		$_charsets["keltic"]["charset"] = "ISO-8859-14";
		$_charsets["keltic"]["international"] = $GLOBALS["_charset"]["titles"]["keltic"];
		
		$_charsets["extended_european"]["national"] = "ISO-8859-15";
		$_charsets["extended_european"]["charset"] = "ISO-8859-15";
		$_charsets["extended_european"]["international"] = $GLOBALS["_charset"]["titles"]["extended_european"];
		
		$_charsets["unicode"]["national"] = "Unicode";
		$_charsets["unicode"]["charset"] = "UTF-8";
		$_charsets["unicode"]["international"] = $GLOBALS["_charset"]["titles"]["unicode"];
		
		$_charsets["windows_1251"]["national"]      = "Windows-1251";
		$_charsets["windows_1251"]["charset"]       = "Windows-1251";
		$_charsets["windows_1251"]["international"] = $GLOBALS["_charset"]["titles"]["windows_1251"];
		
		$_charsets["windows_1252"]["national"]      = "Windows-1252";
		$_charsets["windows_1252"]["charset"]       = "Windows-1252";
		$_charsets["windows_1252"]["international"] = $GLOBALS["_charset"]["titles"]["windows_1252"];
		
		$this->charsets = $_charsets;
	}
	
	/**
	* @return array
	* @param $availableChars array
	* @desc This function returns an array(key = charset / value = charset - name(international) (name(national)))
 	*/
	function getCharsetsForTagWizzard(){
		
		$_charsets = $this->charsets;
		
		$retArr = array();
		$first = true;
		
		while(list($key, $val) = each($_charsets)){
			
			$retArr[$val["charset"]] = $val["charset"] . " - " . $val["international"] . " (" . $val["national"] . ")";
		}
		reset($_charsets);
		return $retArr;
	}
	

	/**
	* @return array
	* @param string $charset
	* @desc returns array (national, international, charset, when charset is known)
	*/
	function getCharsetArrByCharset($charset){
		
		$_charsets = $this->charsets;
		
		$_charsetArray = false;
		
		while(list($key, $val) = each($_charsets)){
			
			if(strtolower($val["charset"]) == strtolower($charset) ){
				return $_charsets[$key];
			}
		}
		return $_charsetArray;
	}
	
	/**
	* @return array
	* @param $availableChars array
	* @desc This function returns an array for the property page of a webEdition document
	*/
	function getCharsetsByArray($availableChars){
		
		$_charsets = $this->charsets;
		
		$tmpCharArray = array();
		$retArray = array();
		
		for($i=0;$i<sizeof($availableChars); $i++){

			if( $charset = $this->getCharsetArrByCharset( $availableChars[$i] ) ){
				array_push($tmpCharArray, $charset);
			} else {
				array_push($tmpCharArray, array( "charset" => $availableChars[$i] ));
			}
			
		}
		reset($tmpCharArray);
		
		while(list($key,$val) = each($tmpCharArray)){

			if( isset($val["international"]) ){
				$retArr[$val["charset"]] = $val["charset"] . " - " . $val["international"] . " (" . $val["national"] . ")";
			} else {
				$retArr[$val["charset"]] = $val["charset"];
			}
		}
		
		return $retArr;
	}
}
?>