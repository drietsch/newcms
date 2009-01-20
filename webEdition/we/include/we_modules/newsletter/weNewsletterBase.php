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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");

/**
* Definition of WebEdition Newsletter Base
*
*/
class weNewsletterBase{

	var $db;
	var $table="";
	var $persistents=array();

   /**
	* Default Constructor
	*/

	function weNewsletterBase()
	{
		$this->db=new DB_WE();
		$this->persistents=array();
	}

	
	/**
	 * Load entry from database
	 *
	 * @param Int $id
	 * @return Boolean
	 */
	function load($id=0)
	{
		if($id) $this->ID=abs($id);
		if ($this->ID){
			$tableInfo = $this->db->metadata($this->table);
			$this->db->query("SELECT * FROM ".mysql_real_escape_string($this->table)." WHERE ID='".$this->ID."'");
			if($this->db->next_record())
			for($i=0;$i<sizeof($tableInfo);$i++){
				$fieldName = $tableInfo[$i]["name"];
				if(in_array($fieldName,$this->persistents)){
					$this->$fieldName=$this->db->f($fieldName);
				}
			}

			return true;
		}
		else
		{
			return false;
		}

	}

	/**
	* save entry in database
   */
	function save(){
		$sets=array();
		$wheres=array();
		foreach($this->persistents as $val){
			if($val=="ID") $wheres[]=$val."='".addslashes($this->$val)."'";
			if($val=="Filter") {
				$value = unserialize($this->$val);
				if(is_array($value)) {
					foreach($value as $c=>$v) {
						if(isset($value[$c]['fieldname']) && ($value[$c]['fieldname']=="MemberSince" || $value[$c]['fieldname']=="LastAccess" || $value[$c]['fieldname']=="LastLogin")) {
							if(isset($value[$c]['fieldvalue']) && $value[$c]['fieldvalue']!="") {
								$date = explode(".", $value[$c]['fieldvalue']);
								$day = $date[0];
								$month = $date[1];
								$year = $date[2];
								$hour = $value[$c]['hours'];
								$minute = $value[$c]['minutes'];
								$timestamp = mktime($hour, $minute, 0, $month, $day, $year);
								$value[$c]['fieldvalue'] = $timestamp;
								$this->$val = serialize($value);
							}
						}
					}
				}
			}

			$sets[]=$val."='".($this->table == NEWSLETTER_BLOCK_TABLE ? $this->$val : mysql_real_escape_string($this->$val))."'";
			
		}
		$where=implode(",",$wheres);
		$set=implode(",",$sets);

	  if ($this->ID==0){

			$query = 'INSERT INTO '.mysql_real_escape_string($this->table).' SET '.$set;
			$this->db->query($query);
			# get ID #
			$this->db->query("SELECT LAST_INSERT_ID()");
			$this->db->next_record();
			$this->ID = $this->db->f(0);
		}
		else{
			$query = 'UPDATE '.$this->table.' SET '.$set.' WHERE '.$where;
			$this->db->query($query);

		}
	}


	/**
	* delete entry from database
	*/
	function delete()
	{
		if (!$this->ID)
		{
			return false;
		}
	  $this->db->query('DELETE FROM '.mysql_real_escape_string($this->table).' WHERE ID="' . $this->ID . '"');
		return true;
	}

	/**
	* check email syntax
	*/
	function check_email($email){
		return we_check_email($email);
	}

	/**
	* check domain
	*/
	function check_domain($email,&$domain){
		$mxhosts="";
		
		//$exp="/[[:space:]\<_\.0-9A-Za-z-]+@([0-9a-zA-Z][0-9a-zA-Z-\.]+)(\>)?/";
		//if(preg_match_all($exp,$email,$out,PREG_PATTERN_ORDER)){
			$domain=weNewsletterBase::get_domain($email);
			if($domain){
				if(eregi("IIS",$_SERVER["SERVER_SOFTWARE"]) || eregi("Microsoft",$_SERVER["SERVER_SOFTWARE"]) || eregi("Windows",$_SERVER["SERVER_SOFTWARE"]) || eregi("Win32",$_SERVER["SERVER_SOFTWARE"])){	
					if(gethostbyname(trim($domain))==$domain) return false;
					else return true;
				}
				else{
					if(getmxrr(trim($domain),$mxhosts))return true;
					else return false;
				}
			}
		//}

		return false;
	}
	
	function get_domain($email){
		$exp="/[[:space:]\<_\.0-9A-Za-z-]+@([0-9a-zA-Z][0-9a-zA-Z-\.]+)(\>)?/";
		if(preg_match_all($exp,$email,$out,PREG_PATTERN_ORDER)) return $out[1][0];
		
		return false;
	}

	function getEmailsFromList($emails,$emails_only=0,$group=0,$blocks=array()){
		$ret=array();
		$arr=array();
		$arr=explode("\n",$emails);
		if(count($arr)){
			foreach($arr as $row){
				if($row!=""){
					$arr2=array();
					$arr2=explode(",",$row);
					if(count($arr2)){
						if($emails_only) $ret[]=$arr2[0];
						else $ret[]=array($arr2[0],isset($arr2[1]) ? $arr2[1] : 0,isset($arr2[2]) ? $arr2[2] : "",isset($arr2[3]) ? $arr2[3] : "",isset($arr2[4]) ? $arr2[4] : "",isset($arr2[5]) ? $arr2[5] : "",$group,$blocks);
					}
				}
			}
		}

		return $ret;
	}
	
	function getEmailsFromExtern($files,$emails_only=0,$group=0,$blocks=array()){
		$ret=array();
		$arr=array();
		$_default_html = f('SELECT pref_value FROM ' . NEWSLETTER_PREFS_TABLE . ' WHERE pref_name="default_htmlmail";','pref_value',new DB_WE());
		$arr=makeArrayFromCSV($files);
		if(count($arr)){
			foreach($arr as $file){
				if(!ereg("\.\.",$file)){ 
					$fh=@fopen($_SERVER["DOCUMENT_ROOT"].$file,"rb");
					if($fh){
						while($dat=fgetcsv($fh,1000)){
							$_alldat = implode("",$dat);
							if (str_replace(" ", "", $_alldat)=="") {
								continue;
							}
							if($emails_only==1){
								$ret[]=$dat[0];
							} else if($emails_only==2) {
								$ret[]=array($dat[0],(isset($dat[1]) && $dat[1]!='') ? $dat[1] : $_default_html,isset($dat[2]) ? $dat[2] : "",isset($dat[3]) ? $dat[3] : "",isset($dat[4]) ? $dat[4] : "",isset($dat[5]) ? $dat[5] : "");						
							} else{
								$ret[]=array($dat[0],(isset($dat[1]) && $dat[1]!='') ? $dat[1] : $_default_html,isset($dat[2]) ? $dat[2] : "",isset($dat[3]) ? $dat[3] : "",isset($dat[4]) ? $dat[4] : "",isset($dat[5]) ? $dat[5] : "",$group,$blocks);
							}
						}
						fclose($fh);			
					}
				}
			}						
		}
		return $ret;
	}	


	/**
	 * Enter description here...
	 *
	 * @param unknown_type $files
	 * @param unknown_type $emails_only
	 * @param unknown_type $group
	 * @param unknown_type $blocks
	 * @param int $status (0=all; 1=invalid; 2=valid )
	 * @return unknown
	 */
	function getEmailsFromExtern2($files,$emails_only=0,$group=0,$blocks=array(),$status=0,&$emailkey){
		$ret=array();
		$arr=array();
		$countEMails=0;
		$_default_html = f('SELECT pref_value FROM ' . NEWSLETTER_PREFS_TABLE . ' WHERE pref_name="default_htmlmail";','pref_value',new DB_WE());
		$arr=makeArrayFromCSV($files);
		if(count($arr)){
			foreach($arr as $file){
				if(!ereg("\.\.",$file)){ 
					$fh=@fopen($_SERVER["DOCUMENT_ROOT"].$file,"rb");
					if($fh){
						while($dat=fgetcsv($fh,1000)){
							$_alldat = implode("",$dat);
							if (str_replace(" ", "", $_alldat)=="") {
								continue;
							}
							$countEMails++;
							if($status==1 && we_check_email($dat[0])) {
								continue;
							} elseif ($status==2 && !we_check_email($dat[0])) {
								continue;
							} 
							$emailkey[]=$countEMails-1;
							if($emails_only==1){
								$ret[]=$dat[0];
							} else if($emails_only==2) {
								$ret[]=array($dat[0],(isset($dat[1]) && $dat[1]!='') ? $dat[1] : $_default_html,isset($dat[2]) ? $dat[2] : "",isset($dat[3]) ? $dat[3] : "",isset($dat[4]) ? $dat[4] : "",isset($dat[5]) ? $dat[5] : "");						
							} else{
								$ret[]=array($dat[0],(isset($dat[1]) && $dat[1]!='') ? $dat[1] : $_default_html,isset($dat[2]) ? $dat[2] : "",isset($dat[3]) ? $dat[3] : "",isset($dat[4]) ? $dat[4] : "",isset($dat[5]) ? $dat[5] : "",$group,$blocks);
							}
						}
						fclose($fh);			
					}
				}
			}						
		}
		return $ret;
	}	
	
	function htmlSelectEmailList($name,$values,$size=1,$selectedIndex="",$multiple=false,$attribs="",$compare="value",$width="",$cls="defaultfont"){
		reset($values);
		$ret = '<select class="'.$cls.'" name="'.trim($name).'" size="'.abs($size).'"'.($multiple ? " multiple" : "").($attribs ? " $attribs" : "").($width ? ' style="width: '.$width.'px"' : '').'>'."\n";
		$selIndex = makeArrayFromCSV($selectedIndex);
		while(list($value,$text) = each($values)){
			$ret .= '<option value="'.htmlspecialchars($value).'"'.(in_array((($compare == "value") ? $value : $text),$selIndex) ? " selected" : "").(we_check_email($text)?' class="markValid"':' class="markNotValid"').'>'.$text."</option>\n";
		}
		$ret .= "</select>";
		return $ret;
	}



}


?>
