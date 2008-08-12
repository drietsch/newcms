<?php

/**
 * webEdition SDK
 *
 * LICENSE_TEXT
 *
 * TODO insert license text
 *
 * @category   we
 * @package    we_util
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENCE_TYPE  TODO insert license type and url
 * @version    $Id: Strings.php,v 1.6 2008/06/30 10:31:27 thomas.kneip Exp $
 */

/**
 * Utility class for string manipulation and creation
 * 
 * @category   we
 * @package    we_util
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
class we_util_Strings
{

	/**
	 * Returns an unique ID
	 *
	 * @param integer $length  length of generated ID
	 * @return string
	 */
	static function createUniqueId($length = 32)
	{
		return substr(md5(uniqid(time())), 0, $length);
	}
	
	/**
	 * Returns cvs of array values
	 *
	 * @param string $arr
	 * @param string $prePostKomma
	 * @param string $sep
	 * @return string
	 */
	static function makeCSVFromArray($arr,$prePostKomma=false,$sep=",") {
		if(!sizeof($arr))
			return "";

		$replaceKomma = (count($arr)>1) || ($prePostKomma==true);
		
		if ($replaceKomma){
			for($i=0;$i<sizeof($arr);$i++) {
				$arr[$i] = str_replace($sep,"###komma###",$arr[$i]);
			}
		}
		$out = implode($sep,$arr);
		if($prePostKomma) {
			$out = $sep.$out.$sep;
		}
		if ($replaceKomma){
			$out = str_replace("###komma###","\\$sep",$out);
		}
		return $out;
	}
	
	/**
	 * Returns an array of cvs values
	 *
	 * @param string $csv
	 * @return array
	 */
	static function makeArrayFromCSV($csv) {
	
		$csv = str_replace("\\,","###komma###",$csv);
	
		if(substr($csv,0,1) == ","){
		    $csv = substr($csv,1);
		}
		if(substr($csv,-1) == ","){
		    $csv = substr($csv,0,strlen($csv)-1);
		}
		if($csv == "" && $csv != "0"){
		    $foo = array();
		} else {
			$foo = explode(",",$csv);
			for($i=0;$i<sizeof($foo);$i++){
			    $foo[$i] = str_replace("###komma###",",",$foo[$i]);
			}
		}
		return $foo;
	}
	
	static function quoteForJSString($text, $quoteForSingle=true) {
		if ($quoteForSingle) {
			return str_replace('\'', '\\\'', str_replace('\\', '\\\\', $text));
		} else {
			return str_replace("\"", "\\\"", str_replace("\\", "\\\\", $text));
		}
	}

}
