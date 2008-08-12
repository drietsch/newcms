<?php
// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or higher                                          |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2005 living-e AG                   |
// +----------------------------------------------------------------------+
// +----------------------------------------------------------------------+
// | passwort randomise and generating with attribs by Jan Gorba          |
// +----------------------------------------------------------------------+
//
// $Id: rndGenPass.inc.php,v 1.3 2007/05/22 08:06:40 andreas.frey Exp $

// Class Declaration Starts:
class rndConditionPass{
   
	var $PasswordLength;    // Variable To Assign Password Length
	var $caps = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	var $small= 'abcdefghjkmnpqrstuvwxyz';
	var $nums = '0123456789';
    var $specs= '+-*&$#@!';   // This Can be removed if not Needed
	var $condition;
	var $minLen;
	
	function rndConditionPass($passLen,$condition){ //Constructor To Assign Values
		$this->condition = $condition;  // Will Store the Condition Array to Global Variable
		// Will calculate the Minimum Length
		$this->minLen = $this->condition['caps']+$this->condition['small']+$this->condition['nums']+$this->condition['specs'];
		// Compute the Total Password Length and Store it to the Global Variable
		$this->PasswordLength = max($this->minLen, $passLen);
	}
	
	function PassGen(){ // Function to Generate Random Passowrd
		$i = 1;
		$password = array();
		while ($i < $this->PasswordLength) {
		       if($i < $this->minLen){ 
				    if ($i<$this->condition['specs']) $this->set = $this->specs;
					elseif ($i<($this->condition['specs']+$this->condition['small'])) $this->set = $this->small;
					elseif ($i<($this->condition['specs']+$this->condition['small']+$this->condition['nums'])) $this->set = $this->nums;
			 		elseif ($i<($this->condition['specs']+$this->condition['small']+$this->condition['nums']+$this->condition['caps'])) $this->set = $this->caps;
		 	    	elseif ($i<($this->condition['specs']+$this->condition['small']+$this->condition['nums']+$this->condition['specs'])) $this->set = $this->specs;
  		        }else{							
					if ($i<$this->PasswordLength) $this->set = $this->all;
   	            }
			$tmp = $this->_getPwdChar($this->set);
			$password[] = $tmp;
			$i++;
		}
		
		shuffle($password);
		return implode("", $password);
	}
	
	function PassCheck($pass) {   // Function To Check Whether the Password have those Conditions
		$cond = array('caps'=>0, 'small'=>0, 'nums'=>0, 'specs'=>0);
		for ($i=0;$i<strlen($pass);$i++) {
			$c = substr($pass, $i, 1);
			if (strpos($this->caps, $c)) { $cond['caps']++; }
			if (strpos($this->small, $c)) { $cond['small']++; }
			if (strpos($this->nums, $c)) { $cond['nums']++; }
			if (strpos($this->specs, $c)) { $cond['specs']++; }
		}
		if ($this->condition['caps']<=$cond['caps'] && $this->condition['small']<=$cond['small'] && $this->condition['nums']<=$cond['nums'] && $this->condition['specs']<=$cond['specs']) {
			return true;
		} else {
			return false;
		}
	}
	
	function _getPwdChar($set) {
		mt_getrandmax();  // Returns the maximum value that can be returned by a call  rand
		$num = rand() % strlen($set);
		$tmp = substr($set, $num, 1);
		return $tmp;
	}
}
?>