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

include_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/modules/"."weModelBase.php");

//voting status codes
define('VOTING_SUCCESS',1);
define('VOTING_ERROR',2);
define('VOTING_ERROR_REVOTE',3);
define('VOTING_ERROR_ACTIVE',4);
define('VOTING_ERROR_BLACKIP',5);
//number precision
define('VOTING_PRECISION',2);


/**
* General Definition of WebEdition Voting
*
*/
class weVoting extends weModelBase{

	//properties
	var $ID;
	var $Text;
    var $ParentID;
	var $Icon;
	var $IsFolder;
	var $Path;
	var $QASet=array();
	var $Scores;
	var $PublishDate = 0;
	var $RestrictOwners = 0;
	var $Owners = array();
	var $Active = 1;
	var $Valid = 0;

	var $RevoteControl = 1;
	var $RevoteTime = -1;

	// it is not automatically (un)serialized
	var $Revote = "";
	var $RevoteUserAgent = "";


	var $answerCount = -1;
	var $defVersion = 0;

	var $FallbackIp=0;
	var $UserAgent=0;
	var $Log=0;
	var $LogData=array();

	var $RestrictIP=0;
	var $BlackList=array();

	var $ActiveTime = 0;

	var $protected=array("ID","ParentID","Icon","IsFolder","Path","Text");

	var $FallbackActive = 0;
	/**
	* Default Constructor
	* Can load or create new Newsletter depends of parameter
	*/

	function weVoting($votingID = 0){
		$this->table=VOTING_TABLE;

		weModelBase::weModelBase(VOTING_TABLE);

		if ($votingID){
			$this->ID=$votingID;
			$this->load($votingID);
		}

		if(empty($this->QASet)) {
			$this->QASet = array(
				0=>array(
					"question" => "",
					"answers" => array(
						0 => "",
						1 => ""
					)
				)
			);
		}

		if($this->Valid==0) $this->Valid = time()+31536000; //365 days

		if($this->Valid<time() && $this->ActiveTime==1) $this->Active = 0;

		if(empty($this->Scores)) $this->Scores = array();

		if($this->PublishDate==0) $this->PublishDate = time();

	}

	function load($id="0") {
		if(parent::load($id)) {
			$this->QASet=@unserialize($this->QASet);
			$this->Scores=@unserialize($this->Scores);
			$this->Owners=makeArrayFromCSV($this->Owners);
			$this->BlackList=makeArrayFromCSV($this->BlackList);
		}
	}

	function save($with_scores=true){

		$this->Icon = ($this->IsFolder==1 ? 'folder.gif' : 'link.gif');

		if($this->ActiveTime && $this->Valid<time()) $this->Active = 0;

		if(!$this->IsFolder && ($with_scores || $this->ID==0)){
			$qaset_count = count($this->QASet[$this->defVersion]['answers']);
			$scores_count = count($this->Scores);

			if($qaset_count != $scores_count){
				$diff = $qaset_count - $scores_count;
				if($diff>0) {
					for($i=0;$i<$diff;$i++){
						$this->Scores[]=0;
					}
				}
				if($diff<0) {
					$diff = abs($diff);
					for($i=0;$i<$diff;$i++){
						array_splice($this->Scores,(count($this->Scores)-1),1);
					}
				}
			}
		}

		$this->ParentID = !empty($this->ParentID) ? $this->ParentID : 0;
		if(isset($_SESSION["user"]["ID"]) && ($this->RestrictOwners && empty($this->Owners) || !in_array($_SESSION["user"]["ID"],$this->Owners))) $this->Owners[] = $_SESSION["user"]["ID"];

		$_old_QASet = f("SELECT QASet FROM " . VOTING_TABLE . " WHERE Text='" . $this->Text . "'","QASet",$GLOBALS["DB_WE"]);
		$_new_QASet = $this->QASet;
		
		$this->QASet = serialize($this->QASet);
		if($with_scores || $this->ID==0){
			$this->Scores = serialize($this->Scores);
		} elseif (isset($_REQUEST['updateScores']) && $_REQUEST['updateScores']){ 
			for ($_xcount=0; $_xcount<$_REQUEST['item_count'];$_xcount++){
				if (isset($_REQUEST['scores_'.$_xcount])) {
					$temp[$_xcount]=$_REQUEST['scores_'.$_xcount];
				}
				$this->Scores = serialize($temp);
			}
		} else {
			$temp = $this->Scores;
			unset($this->Scores);
		}
		
		$logdata = $this->LogData;
		unset($this->LogData);
		$oldid = $this->ID;

		$this->Owners = array_unique($this->Owners);
		$this->Owners=makeCSVFromArray($this->Owners,true);

		$this->BlackList = array_unique($this->BlackList);
		$this->BlackList=makeCSVFromArray($this->BlackList,true);

		parent::save();

		$this->QASet=unserialize($this->QASet);
		if($with_scores || $oldid==0){
			$this->Scores=unserialize($this->Scores);
		} else {
			$this->Scores = $temp;
		}
		$this->Owners=makeArrayFromCSV($this->Owners);
		$this->BlackList=makeArrayFromCSV($this->BlackList);
		$this->LogData = $logdata;
	}

	function saveField($name,$serialize=false) {
		if($serialize) $field = serialize($this->$name);
		else $field = $this->$name;

		$this->db->query('UPDATE ' . $this->table . ' SET ' . $name . '="' . addslashes($field) . '" WHERE ID=\'' . $this->ID . '\';');
		return $this->db->affected_rows();
	}

	function delete(){
		if (!$this->ID) return false;
		if($this->IsFolder) $this->deleteChilds();
		parent::delete();
		return true;
	}

	function deleteChilds(){
		$this->db->query("SELECT ID FROM ". VOTING_TABLE . " WHERE ParentID='".$this->ID."'");
		while($this->db->next_record()){
			$child=new weVoting($this->db->f("ID"));
			$child->delete();
		}
	}

	function setPath(){
		$ppath = f('SELECT Path FROM ' . VOTING_TABLE . ' WHERE ID=' . $this->ParentID . ';','Path',$this->db);
		$this->Path=$ppath."/".$this->Text;
	}

	function pathExists($path){
		$this->db->query('SELECT * FROM '.$this->table.' WHERE Path = \''.$path.'\' AND ID <> \''.$this->ID.'\';');
		if($this->db->next_record()) return true;
		else return false;
	}

	function isSelf(){
		if(ereg('/'.$this->Text.'/',clearPath(dirname($this->Path) . '/'))) return true;
		else return false;
	}

	function evalPath($id=0) {
		$db_tmp=new DB_WE();
		$path = "";
		if($id==0) {
			$id=$this->ParentID;
			$path=$this->Text;
		}

		$foo=getHash("SELECT Text,ParentID FROM ".VOTING_TABLE." WHERE ID='".$id."';",$db_tmp);
		$path="/". (isset($foo["Text"]) ? $foo["Text"] : "") .$path;

		$pid=isset($foo["ParentID"]) ? $foo["ParentID"] : "";
		while($pid > 0) {
				$db_tmp->query("SELECT Text,ParentID FROM ".VOTING_TABLE." WHERE ID='$pid'");
				while($db_tmp->next_record()) {
					$path = "/".$db_tmp->f("Text").$path;
					$pid = $db_tmp->f("ParentID");
				}
		}
		return $path;
	}

	function initByName($name){
		$id = f('SELECT ID FROM ' . VOTING_TABLE . ' WHERE Text=\'' . addslashes($name) . '\';','ID',$this->db);
		return $this->load($id);
	}

	function clearSessionVars(){
			if(isset($_SESSION["voting_session"])) unset($_SESSION["voting_session"]);
	}

	function filenameNotValid($text){
			return eregi('[^a-z0-9���\._\@\ \-]',$text);
	}

	function getNext(){
		$this->answerCount++;
		if($this->answerCount<count($this->QASet[$this->defVersion]['answers'])) return true;
		return false;
	}

	function resetSets(){
		$this->answerCount = -1;
	}

	function getAnswer($ansn=-1){
		return $this->QASet[$this->defVersion]['answers'][$this->answerCount];
	}

	function getResult($type='count',$num_format='',$precision=VOTING_PRECISION){
		switch ($type){
			case 'percent':
				$total = $this->getResult('total');
				if($total<=0) return 0;
				$_scores = isset($this->Scores[$this->answerCount]) ? $this->Scores[$this->answerCount] : 0;
				if($total>0 && $this->answerCount>=0) $result = round((($_scores/$total)*100),$precision);
				else $result = 100;
			break;
			case 'total':
				$result = array_sum($this->Scores);
			break;
			case 'count':
			default:
				if($this->answerCount>=0 && isset($this->Scores[$this->answerCount])) $result = $this->Scores[$this->answerCount];
			break;
		}

		if(!empty($num_format)) {
			 $result = $this->formatNumber($result,$num_format,$precision);
		}
		return $result;
	}

	function formatNumber($number,$format,$precision=VOTING_PRECISION){
			switch ($format) {
				case 'german':
				case 'deutsch':
					$result=number_format($number,$precision,",",".");
				break;
				case 'french':
					$result=number_format($number,$precision,","," ");
				break;
				case 'english':
					$result=number_format($number,$precision,".","");
				break;
				case 'swiss':
					$result=number_format($number,$precision,",","'");
				break;
				default:
					$result=number_format($number,$precision,".","");
			}
			return $result;
	}

	function isLastSet(){
		if($this->answerCount>=count($this->QASet[$this->defVersion]['answers'])-1) return true;
		return false;
	}

	function setDefVersion($version) {
		if($version<0) $this->defVersion = 0;
		if($version<count($this->QASet)) $this->defVersion = $version;
		else $this->defVersion = count($this->QASet)-1;
	}

	function isAllowedForUser(){

		if($this->RestrictOwners==0) return true;

		if(!defined("BIG_USER_MODULE")) return true;

		if(we_hasPerm('ADMINISTRATOR')) return true;

		if(in_array($_SESSION['user']['ID'],$this->Owners)){
			return true;
		}

		$userids = array();

		we_readParents($_SESSION['user']['ID'],$userids,USER_TABLE,'IsFolder',1);

		foreach ($userids as $uid) {
			if(in_array($uid,$this->Owners)){
				return true;
			}
		}

		return false;

	}

	function getOwnersSql(){
		$owners_sql = "";
		if(defined("BIG_USER_MODULE") && in_array("busers",$GLOBALS["_pro_modules"])){
			if(!we_hasPerm('ADMINISTRATOR')){
				$userids = array();
				$userids[] = $_SESSION['user']['ID'];
				we_readParents($_SESSION['user']['ID'],$userids,USER_TABLE,'IsFolder',1);

				$sqlarr = array();
				foreach ($userids as $uid) {
					$sqlarr[] = 'Owners LIKE ("%,' . $uid . ',%")';
				}
				$owners_sql = ' AND (RestrictOwners=0 OR (' .implode(' OR ',$sqlarr) . ')) ';
			}
		}

		return $owners_sql;

	}

	function vote($answers){
		if(!is_array($answers)){
			if($this->Log) $this->logVoting(VOTING_ERROR);
			return VOTING_ERROR;
		}
		if(!(count($answers)>0)){
			if($this->Log) $this->logVoting(VOTING_ERROR);
			return VOTING_ERROR;
		}

		$ret = $this->canVote();

		if($ret!=VOTING_SUCCESS) {
			if($this->Log) $this->logVoting($ret);
			return $ret;
		}

		foreach($answers as $answer){
			if($answer>-1 && $answer<count($this->Scores)){
				$this->Scores[$answer]++;
			}
		}
		$this->saveField('Scores',true);
		if($this->RevoteTime!=0){
			if($this->RevoteControl==1){
				if($this->RevoteTime<0) $revotetime = 630720000; //20 years
				else $revotetime = $this->RevoteTime;
				setcookie(md5('_we_voting_'.$this->ID),time(),time()+$revotetime);
			} else {
				$this->Revote[$_SERVER['REMOTE_ADDR']] = time();
				$this->saveField('Revote',true);
				if($this->UserAgent){
					$this->RevoteUserAgent = unserialize($this->RevoteUserAgent);
					if(!is_array($this->RevoteUserAgent)) $this->RevoteUserAgent = array();
					if(!isset($this->RevoteUserAgent[$_SERVER['REMOTE_ADDR']]) || !is_array($this->RevoteUserAgent[$_SERVER['REMOTE_ADDR']])) $this->RevoteUserAgent[$_SERVER['REMOTE_ADDR']] = array();
					$this->RevoteUserAgent[$_SERVER['REMOTE_ADDR']][] = $_SERVER['HTTP_USER_AGENT'];
					$this->saveField('RevoteUserAgent',true);
				}
			}
		}
		if($this->Log) $this->logVoting($ret);
		return $ret;
	}

	function canVote() {
		if(!$this->isActive()) return VOTING_ERROR_ACTIVE;
		if($this->isBlackIP()) return VOTING_ERROR_BLACKIP;
		if($this->RevoteTime==0) return VOTING_SUCCESS;

		if($this->RevoteControl==1){
			return $this->canVoteCookie();

		} else {
			return $this->canVoteIP();
		}

		return VOTING_SUCCESS;

	}

	function canVoteCookie(){
		if($this->cookieDisabled() && $this->FallbackIp) {
			$this->RevoteControl = 0;
			$this->FallbackActive = 1;
			return $this->canVoteIP();
		}

		if(isset($_COOKIE[md5('_we_voting_'.$this->ID)])){
			return VOTING_ERROR_REVOTE;
		} else return VOTING_SUCCESS;
	}

	function canVoteIP(){

		$this->Revote = unserialize($this->Revote);
		if(!is_array($this->Revote)) $this->Revote = array();

		if($this->RevoteTime<0) $revotetime = time()+5;
		else $revotetime = $this->RevoteTime;

		if(in_array($_SERVER['REMOTE_ADDR'],array_keys($this->Revote))){
			if(($revotetime+$this->Revote[$_SERVER['REMOTE_ADDR']])>time()) {
				$revoteua = unserialize($this->RevoteUserAgent);
				if($this->UserAgent){
					if(!is_array($revoteua)){
						return VOTING_ERROR_REVOTE;
					}
					if(isset($revoteua[$_SERVER['REMOTE_ADDR']]) && is_array($revoteua[$_SERVER['REMOTE_ADDR']])){
						if(in_array($_SERVER['HTTP_USER_AGENT'],$revoteua[$_SERVER['REMOTE_ADDR']])){
							return VOTING_ERROR_REVOTE;
						} else {
							return VOTING_SUCCESS;
						}
					}
				}

				return VOTING_ERROR_REVOTE;
			}
			else {
				return VOTING_SUCCESS;
			}

		} else return VOTING_SUCCESS;
	}

	function isActive(){
		if(!$this->Active) return false;
		if($this->ActiveTime==0) return true;
		if(time()>$this->Valid) return false;
		return true;
	}

	function cookieDisabled(){
		if(isset($_SESSION['_we_cookie_'])) return false;
		else return true;
	}

	function isBlackIP(){
		if(!$this->RestrictIP) return false;
		$ip = $_SERVER['REMOTE_ADDR'];
		foreach($this->BlackList as $fip) {
			$reg = str_replace('*','[0-9]+',$fip);
			if(ereg($reg,$ip)) {
				return true;
			}
		}
		return false;
	}


	function resetIpData(){
		$this->Revote = "";
		$this->RevoteUserAgent = "";
		$this->saveField('Revote');
		$this->saveField('RevoteUserAgent');
	}

	function logVoting($status){
		$this->LogData = unserialize($this->LogData);
		if(!is_array($this->LogData)) $this->LogData = array();
		$this->LogData[] = array(
			'time' => time(),
			'ip' => $_SERVER['REMOTE_ADDR'],
			'agent' => $_SERVER['HTTP_USER_AGENT'],
			'cookie' => $this->cookieDisabled() ? 0 : 1,
			'fallback' => $this->FallbackActive,
			'status' => $status
		);
		$this->saveField('LogData',true);
	}

	function deleteLogData(){
		if(empty($this->LogData) || trim($this->LogData) == "" || $this->LogData = "a:0:{}") {
			$this->deleteLogDataDB();
		} else {
			$this->LogData = array();
			$this->saveField('LogData',true);
		}
		return true;
	}
	
	/* ================================= NEW FUNCTIONS FOR LOGGING TO VOTING_LOG_TABLE ================================= */
	/**
	 * @abstract new functions for logging votings to a separate database table
	 * @internal new logging mode logs votings to a new table called "tblvotinglog" instead of saving them
	 * 			to the field "LogData" as a serialized array. So $this->LogData contains an array if the new mode
	 * 			is used (for newly created votings). For existing votings using the old logging style nothing has changed 
	 * 			and the variable will still contain a string with the serialized logging data array from tblvoting.LogData
	 * 			In the first case the variable $this->LogDB will be set to true, else it will stay false
	 * @author Alexander Lindenstruth
	 * @since 5.1.1.2 - 05.05.2008
	 */
	
	/**
	 * fetches all log entries for current voting from database
	 * @author Alexander Lindenstruth
	 * @since 5.1.1.2 - 02.05.2008
	 */
	function loadDB($id="0") {
		$logEntries = $this->db->query('SELECT '.
			'`' . VOTING_LOG_TABLE . '`.`time`, '.
			'`' . VOTING_LOG_TABLE . '`.`ip`, '.
			'`' . VOTING_LOG_TABLE . '`.`agent`, '.
			'`' . VOTING_LOG_TABLE . '`.`cookie`, '.
			'`' . VOTING_LOG_TABLE . '`.`fallback`, '.
			'`' . VOTING_LOG_TABLE . '`.`status` '.
 			'FROM `' . VOTING_LOG_TABLE . '` WHERE `' . VOTING_LOG_TABLE . '`.`voting` = ' . $id
 		);
		$this->LogData= array();
		while ($this->db->next_record()){
			array_push($this->LogData, array(
	 			'time' => $this->db->f('time'),
	 			'ip' => $this->db->f('ip'),
	 			'agent' => $this->db->f('agent'),
	 			'cookie' => $this->db->f('cookie'),
	 			'fallback' => $this->db->f('fallback'),
	 			'status' => $this->db->f('status'),
	 		));
		}
 		return $this->LogData;
 		
	}
	
	/**
	 * writes a single entry to the voting log table VOTING_LOG_TABLE
	 * @return boolean success or failure of this operation
	 * @author Alexander Lindenstruth
	 * @since 5.1.1.2 - 02.05.2008
	 */
	function logVotingDB($status = NULL) {
		if(is_null($status)) $status = 0;
		$_cookieStatus = $this->cookieDisabled() ? 0 : 1;
		$this->db->query('INSERT INTO `' . VOTING_LOG_TABLE . '` SET ' . 
			'voting = \'' . $this->ID . '\', ' .
			'time = \'' . time() . '\', ' .
			'ip = \'' . $_SERVER['REMOTE_ADDR'] . '\', ' .
			'agent = \'' . $_SERVER['HTTP_USER_AGENT'] . '\', ' .
			'cookie = \'' . $_cookieStatus . '\', ' .
			'fallback = \'' . $this->FallbackActive . '\', ' .
			'status = \'' . $status . '\''
		);
		
		return true;
	}
	
	/**
	 * deletes all log entries for a given voting
	 * @return boolean success or failure of this operation
	 * @author Alexander Lindenstruth
	 * @since 5.1.1.2 - 02.05.2008
	 */
	function deleteLogDataDB() {
		$this->db->query('DELETE FROM `' . VOTING_LOG_TABLE . '` WHERE `' . VOTING_LOG_TABLE . '`.`voting` = ' . $this->ID);
		return true;
	}

}


?>