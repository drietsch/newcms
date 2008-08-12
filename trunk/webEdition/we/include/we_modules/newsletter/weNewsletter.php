<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once(WE_NEWSLETTER_MODULE_DIR."weNewsletterBase.php");
include_once(WE_NEWSLETTER_MODULE_DIR."weNewsletterBlock.php");
include_once(WE_NEWSLETTER_MODULE_DIR."weNewsletterGroup.php");

/**
 * General Definition of WebEdition Newsletter
 *
 */
class weNewsletter extends weNewsletterBase{

	//properties
	var $ID;
	var $ParentID;
	var $IsFolder;
	var $Text;
	var $Path;
	var $Icon;
	var $Subject;
	var $Sender;
	var $Reply;
	var $Attachments;
	var $Customers;
	var $Emails;
	var $Test;
	var $Step;
	var $Offset;
	var $Charset = "";

	var $log=array();
	var $blocks=array();
	var $groups=array();

	/**
	 * Default Constructor
	 * Can load or create new Newsletter depends of parameter
	 *
	 * @param int $newsletterID
	 * @return weNewsletter
	 */

	function weNewsletter($newsletterID = 0)
	{

		parent::weNewsletterBase();

		$this->table=NEWSLETTER_TABLE;

		$this->persistents[]="ID";
		$this->persistents[]="ParentID";
		$this->persistents[]="Text";
		$this->persistents[]="Path";
		$this->persistents[]="Icon";
	  	$this->persistents[]="Subject";
		$this->persistents[]="Sender";
		$this->persistents[]="Reply";
		$this->persistents[]="Test";
		$this->persistents[]="Step";
		$this->persistents[]="Offset";
		$this->persistents[]="IsFolder";
		$this->persistents[]="Charset";

		$this->ID = 0;
		$this->ParentID = 0;
		$this->IsFolder = 0;
		$this->Text = "";
		$this->Path = "/";
		$this->Icon= "newsletter.gif";
		$this->Subject="";
		$this->Sender="";
		$this->Reply="";
		$this->Attachments="";
		$this->Customers="";
		$this->Emails="";
		$this->Test="";
		$this->Step=0;
		$this->Offset=0;
		$this->Charset=$GLOBALS["_language"]["charset"];
		$this->log=array();
		$this->blocks=array();
		$this->groups=array();

		$this->addBlock();
		$this->addGroup();

		if ($newsletterID){
			$this->ID=$newsletterID;
			$this->load($newsletterID);
		}
	}

	/**
	 * get newsletter from database
	 *
	 * @param int $newsletterID
	 */
	function load($newsletterID){
		parent::load($newsletterID);		
		$this->Text=stripslashes($this->Text);
		if($this->Path=="") $this->Path="/";		
		$this->Subject=stripslashes($this->Subject);				  
		$this->groups=weNewsletterGroup::__getAllGroups($newsletterID);
		$this->blocks=weNewsletterBlock::__getAllBlocks($newsletterID);
		if($this->Charset == "") $this->Charset=$GLOBALS["_language"]["charset"];
	}

	/**
	 * save newsletter in db
	 *
	 * @param string $message
	 * @param bool $check
	 * @return int
	 */
	function save(&$message,$check=true){
		global $l_newsletter;
		
		//check addesses
		if($check){
			$ret=$this->checkEmails($message);
			if($ret!=0) return $ret;
		}

		if(!$this->checkParents($this->ParentID)){
			$message=$l_newsletter["path_nok"];
			return -10;
		}
		
		if($this->IsFolder){
			$this->Icon="folder.gif";
			$this->fixChildsPaths();
		}

		if($this->Step!=0 || $this->Offset!=0) $this->addLog("log_campagne_reset");
		$this->Step=0;
		$this->Offset=0;
		
		parent::save();

						
		$this->db->query("DELETE FROM ".NEWSLETTER_GROUP_TABLE." WHERE NewsletterID=".$this->ID);
		$this->db->query("DELETE FROM ".NEWSLETTER_BLOCK_TABLE." WHERE NewsletterID=".$this->ID);

		foreach($this->groups as $group){
			$group->NewsletterID = $this->ID;
			$group->save();
		}
		$count_group=count($this->groups);
		$groups=array();
		foreach($this->blocks as $block){
		 $groups=makeArrayFromCSV($block->Groups);
			foreach($groups as $k=>$v) if($v>$count_group) array_splice($groups,$k);
			$block->Groups=makeCSVFromArray($groups);
			$block->NewsletterID = $this->ID;
			$block->Source=addslashes($block->Source);
			$block->Html=addslashes($block->Html);
			$block->save();
			$block->Source=stripslashes($block->Source);
			$block->Html=stripslashes($block->Html);
		}

		$this->addLog("log_save_newsletter");
		return 0;
	}

	/**
	 * delete newsletter from database
	 *
	 * @return bool
	 */
	function delete(){
			
		if($this->IsFolder) $this->deleteChilds();
		foreach($this->blocks as $block){
			$block->delete();
			$block=new weNewsletterBlock();
		}
		foreach($this->groups as $group){
			$group->delete();
			$group=new weNewsletterGroup();
		}
		$this->clearLog();
		parent::delete();
		return true;
	}
	
	/**
	 * delete childs from database
	 *
	 */
	function deleteChilds(){		
		$this->db->query("SELECT ID FROM ".NEWSLETTER_TABLE . " WHERE ParentID='".$this->ID."'");
		while($this->db->next_record()){
			$child=new weNewsletter($this->db->f("ID"));
			$child->delete();
			$child=new weNewsletter();
		}
	}
	

	/**
	 * gets all newsletter names from database
	 * 
	 * gets all newsletter names from databes and returns them as an associated array with id as key and name as value
	 *
	 * @return array
	 */
	function getAllNewsletter(){

		$db=new DB_WE();

		$db->query("SELECT ID,Text FROM ".NEWSLETTER_TABLE." ORDER BY ID");
		$nl = array();
		while ($db->next_record())
		{
			$nl[$db->f("ID")] = $db->f("Text") ;
		}
		return $nl;
	}

	/**
	 * add a new block to a newsletter
	 *
	 * @param string $where
	 */
	function addBlock($where=-1){
		if($where!=-1){
			if($where>count($this->blocks)-1) $this->blocks[]=new weNewsletterBlock();
			else{
				$temp=array();
				foreach($this->blocks as $k=>$v){
					if($k==$where) $temp[]=new weNewsletterBlock();
					$temp[]=$v;
				}
				$this->blocks=$temp;
			}
		}
		else $this->blocks[]=new weNewsletterBlock();
	}

	/**
	 * remove newsletters block
	 *
	 * @param int $id
	 */
	function removeBlock($id){
		foreach($this->blocks as $k=>$v){
			if($id==$k){
				$v->delete();
				$v=new weNewsletterBlock();
				array_splice($this->blocks,$id,1);
			}
		}
	}

	/**
	 * add new group to newsletter
	 *
	 */
	function addGroup(){
		$this->groups[]=new weNewsletterGroup();
	}

	/**
	 * remove newsletter group
	 *
	 * @param int $group
	 */
	function removeGroup($group){
		$link=$group+1;
		foreach($this->blocks as $bk=>$block){
			$arr=makeArrayFromCSV($block->Groups);
			foreach($arr as $k=>$v){
				if($v==$link) $arr[$k]=-1;
				if($v>$link) $arr[$k]=$v-1;
			}
			foreach($arr as $k=>$v) if($v==-1) array_splice($arr,$k,1);
			$this->blocks[$bk]->Groups=makeCSVFromArray($arr,true);
		}
		array_splice($this->groups,$group,1);
	}

	/**
	 * check email syntax
	 *
	 * @param string $malformed
	 * @return int
	 */
	function checkEmails(&$malformed){

		if(!$this->check_email($this->Sender)){
			$malformed=$this->Sender;
			return -1;
		}
		if(!$this->check_email($this->Reply)){
			$malformed=$this->Reply;
			return -2;
		}
		if(!$this->check_email($this->Test)){
			$malformed=$this->Test;
			return -3;
		}

		foreach($this->groups as $k=>$v){
			$ret=$v->checkEmails($k+1,$malformed);
			if($ret!=0) return $ret;
		}
		return 0;
	}

	/**
	 * set log in db
	 *
	 * @param string $log
	 * @param string $param
	 */
	function addLog($log,$param=""){ 
		$this->db->query("INSERT INTO ".NEWSLETTER_LOG_TABLE."(NewsletterID,LogTime,Log,Param) VALUES('".$this->ID."','".time()."','".$log."','".$param."');");
	}

	/**
	 * clear log in db
	 *
	 */
	function clearLog(){
		$this->db->query("DELETE FROM ".NEWSLETTER_LOG_TABLE." WHERE NewsletterID='".$this->ID."';");
	}
	
	/**
	 * checks recursive the parents to detect if path is ok or not
	 *
	 * @param int $id
	 * @return bool
	 */
	function checkParents($id){
		$count=0;
		while($id>0){			
			if($count>1000) break;
			if($id==$this->ID) return false;
			$h=getHash("SELECT IsFolder,ParentID FROM ".NEWSLETTER_TABLE." WHERE ID=".$id,$this->db);
			if($h["IsFolder"]!=1) return false;
			$id=$h["ParentID"];
			$count++;
		}
		return true;
	}
	
	/**
	 * fix childs path if parets changes
	 *
	 */
	function fixChildsPaths(){
		
		$dbtmp=new DB_WE;
		$oldpath=f("SELECT Path FROM ".NEWSLETTER_TABLE." WHERE ID=".$this->ID,"Path",$this->db);
		
		if(trim($oldpath)!="" && trim($oldpath)!="/"){		
			$this->db->query("SELECT ID,Path FROM ".NEWSLETTER_TABLE." WHERE Path LIKE '".$oldpath."%'");		
			while($this->db->next_record()){
				$dbtmp->query("UPDATE ".NEWSLETTER_TABLE." SET Path='".str_replace($oldpath,$this->Path,$this->db->f("Path"))."' WHERE ID=".$this->db->f("ID"));			
			}
		}
	}
	
	/**
	 * checks if filename is well formated
	 *
	 * @return bool
	 */
	function filenameNotValid(){
			return eregi('[^a-z0-9\ \._\-]',$this->Text);
	}	

}


?>
