<?php

/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   we
 * @package    we_rpc
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

class rpcResponse {
	
	var $Success = true;
	
	var $Reason = '';
	
	var $DataArray = array();

	function rpcResponse(){
    	
    }
    
    function getStatus() {
    	return $this->Success;
    }
    
 	
    function setStatus($success) {
    	$this->Success = $success;	
    }
    
    function getReason(){
    	return $this->Reason;
    }
    
    function setReason($reason){
    	$this->Reason = $reason;
    }
    
    function addData($name,$data){
    	$this->DataArray[$name] = $data;
    }
    
 	
    function setData($name,$data){
    	$this->addData($name,$data);
    }
    
    function getData($name){
    	return isset($this->DataArray[$name]) ? $this->DataArray[$name] : "";
    }
     	
    function getDataArray(){
    	return $this->DataArray;    	
    }
    
    function merge($response){
    	$this->setStatus($response->getStatus());
    	$this->setReason($response->getReason());
    	$this->DataArray = array_merge($this->DataArray,$response->getDataArray());
    }
}
?>