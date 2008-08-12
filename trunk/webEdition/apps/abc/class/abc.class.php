<?php
					

include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/tools/weToolModel.class.php');

class abc extends weToolModel {

	/**
	* Default Constructor
	* Can load or create new abc object depends of parameter
	*/
	
	var $ModelClassName = 'abc';
	var $Icon = 'abc.gif';
	var $toolName = 'abc';
	
	function abc($abcID=0){

		parent::weToolModel('');
		if ($abcID){
			$this->ID=$abcID;
			$this->load($abcID);
		}

	}
	
	function setIsFolder($value) {
		$this->IsFolder = $value;
		if($value) {
			$this->Icon = 'folder.gif';
		} else {
			$this->Icon = 'abc.gif';
		}
	}
	
	
}

		?>