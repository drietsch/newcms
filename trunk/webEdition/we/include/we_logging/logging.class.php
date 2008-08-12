<?php


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");


class logging{
	
	
	public $db;
	public $table;
	public $userID;
	public $timestamp;
	public $persistent_slots=array();
	
	
	
	function __construct() {
		
		$this->db = new DB_WE();
		$this->userID = $_SESSION['user']['ID'];
		$this->timestamp = time();
		$this->loadPresistents();
		
	}
	
	function loadPresistents(){
		
		$tableInfo = $this->db->metadata($this->table);
		$sizeTable = count($tableInfo);
		for($i=0;$i<$sizeTable;$i++){
				$columnName=$tableInfo[$i]["name"];
				$this->persistent_slots[] = $columnName;
				if(!isset($this->$columnName)) $this->$columnName="";
		}
	}
	
	function load()	{
		
		$content = array();
		$tableInfo = $this->db->metadata($this->table);
		$this->db->query("SELECT ID,timestamp,action,userID FROM ".$this->table." ORDER BY timestamp DESC");
		$m=0;
		while($this->db->next_record()){
			for($i=0;$i<count($tableInfo);$i++){
				$columnName = $tableInfo[$i]["name"];
				if(in_array($columnName,$this->persistent_slots)){
					$content[$m][$columnName] = $this->db->f($columnName);
					
				}
			}
			$m++;
		}
		
		return $content;
	}
	
	function saveLog(){
		
		$keys=array();
		$values=array();

		foreach($this->persistent_slots as $key=>$val){
			
				if(isset($this->$val)) {
					$keys[]='`'.$val.'`'; 
					$values[]="'".$this->$val."'";
				}
		}
		

		$keys=implode(",",$keys);
		$values=implode(",",$values);

		if (!empty($keys) && !empty($values)){
			
			$query = 'INSERT INTO '.$this->table.' ('.$keys.') VALUES ('.$values.')';
			$this->db->query($query);
		}
			
	}
	
	function __destruct() {
		
		unset($this);
		
	}

}

?>