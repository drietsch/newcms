<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


/**
* Util Functions
* 
* all functions in this class are static! Please use it in static form:
*    we_util::function_name();
*
*
* @static
* @package WebEdition.Classes
* @author holger meyer, slavko tomcic
* @version 1.0
* @date 27.07.2002
*/
class we_util{
	
	/**
	* Default constructor. WARNING !!! (not usefull).
	*
	* All functions in this class is static, and there is no logic to create instance of this class
	*/
	function we_global(){
		die("Please don't create instance of class we_global"); 
	}
	
	/**
	* Searches a string for matches to the regular expressions given in pattern
	*   
	* @static
	* @access public
	* 
	* @param array pattern Array of patterns
	* @param string string
	*/
	function eregi_array($pattern,$string){
		foreach($pattern as $reg){
			if(eregi($reg,$string)){
				return true;
			}	
		}
		return false;
	}

	/**
	* Formates a number with a country specific format into computer readable format.
	* Returns the formated number.
	*   
	* @static
	* @access public
	* 
	* @param mixed number
	*/
	function std_numberformat($number){
	    if(strpos($number,'E')){   //  when number is too big, it is shown with E+xx
	        $number = number_format($number,2,'.','');
	    }
		if(ereg('.*,[0-9]*$',$number)){ // deutsche schreibweise
			$umschreib = ereg_replace('(.*),([0-9]*)$','\1.\2',$number);
			$pos = strrpos($number,",");
			$vor = str_replace(".","",substr($umschreib,0,$pos));
			$number = $vor . substr($umschreib,$pos,strlen($umschreib)-$pos);
		}else if(ereg('.*\.[0-9]*$',$number)){ // engl schreibweise
			$pos = strrpos($number,".");
			$vor = substr($number,0,$pos);
			$vor = ereg_replace('[,\.]','',$vor);
			$number = $vor . substr($number,$pos,strlen($number)-$pos);
		}else{
			$number = ereg_replace('[,\.]','',$number);
		}
		return $number;
	}

	/**
	* Converts all windows and mac newlines from string to unix newlines
	* Returns the converted String.
	*   
	* @static
	* @access public
	* 
	* @param mixed number
	*/
	function cleanNewLine($string){
		$string = eregi_replace("\r\n","\n",$string);
		$string = eregi_replace("\n\r","\n",$string);
		$string = eregi_replace("\r","\n",$string);
		return $string;
	}


	/**
	* Removes from string all newlines and converts all <br> to newlines
	* Returns the converted String.
	*   
	* @static
	* @access public
	* 
	* @param mixed number
	*/
	function br2nl($string){
		$string = eregi_replace("\r\n","",$string);
		$string = eregi_replace("\n\r","",$string);
		$string = eregi_replace("\n","",$string);
		$string = eregi_replace("\r","",$string);
		return eregi_replace("<br ?/?>","\n",$string);
	}

}
