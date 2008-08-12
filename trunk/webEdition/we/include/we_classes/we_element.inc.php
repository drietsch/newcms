<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/"."modules/weModelBase.php");

	
	class we_element{		
		
		var $ClassName="we_element";
		
		var $DID=0;
		var $Name="";
		var $Type="";
		
		var $CID=0;
		var $BDID=0;
		var $Dat="";
		var $IsBinary=0;
		var $AutoBR=0;
		var $LangugeID=0;
		var $Len=0;
		
		var $link_attribs=array("DID","Name","Type");
		var $content_attribs=array("CID","BDID","Dat","IsBinary","AutoBR","LanguageID");
		var $persistent_slots=array("ClassName","Name","Type","BDID","Dat","IsBinary","AutoBR","LanguageID");
		
		var $Link;
		var $Content;
		
		var $linked=false;
		
		function we_element($link_props=true,$options=array()){
			$this->DID=0;
			$this->Link=new weModelBase(LINK_TABLE);
			$this->Link->setKeys(array("DID","CID"));
			$this->Content=new weModelBase(CONTENT_TABLE);			
			if(is_array($options)){
				if($link_props)
					$this->fetchLinkedOptions($options);
				else
					$this->fetchOptions($options);
			}
						
			if($link_props){
				$this->linked=true;
				$this->linkProps();
			}
			else{
				$this->persistent_slots=array_keys($options);
			}
		}
		
		
		function fetchOptions($options=array()){
			foreach($options as $k=>$v){
				eval('$this->'.$k.'=$options["'.$k.'"];');
			}
		}		
		
		function fetchLinkedOptions($options=array()){
			if(is_array($options)){
				foreach($options as $k=>$v){
					foreach($this->link_attribs as $k=>$v){
						eval('if(isset($options["'.$k.'"]) && isset($this->Link->'.$k.')) $this->Link->'.$k.'=$options["'.$k.'"];');
					}
					foreach($this->content_attribs as $k=>$v){
						eval('if(isset($options["'.$k.'"]) && isset($this->Content->'.$k.')) $this->Content->'.$k.'=$options["'.$k.'"];');
					}
				
				}
			}			
		}
		
		function save(){
			$this->Content->save();
			$this->Link->CID=$this->Content->ID;
			$this->Link->save();
		}
		
		function load($DID,$Name,$Table){			
			$this->Link->setKeys(array("DID","Name","DocumentTable"));
			if($this->Link->load("$DID,$Name,$Table")){
				$this->Content->load($this->Link->CID);
				return true;
			}
			return false;
		}
		
		function linkProps(){
				
				$this->DID=&$this->Link->DID;
				$this->Name=&$this->Link->Name;
				$this->Type=&$this->Link->Type;
				
				$this->CID=&$this->Content->CID;
				$this->BDID=&$this->Content->BDID;
				$this->Dat=&$this->Content->Dat;
				$this->IsBinary=&$this->Content->CID;
				$this->AutoBR=&$this->Content->AutoBR;
				$this->LanguageID=&$this->Content->LanguageID;
							
		}
		
		function getElement(){
			
			if($this->linked)
				return array(
					$this->Name=>array(
						"id"=>$this->CID,
						"bdid"=>$this->BDID,
						"isbinary"=>$this->IsBinary,
						"autobr"=>$this->AutoBR,
						"languageid"=>$this->LanguageID,
						"cid"=>$this->CID,
						"type"=>$this->Type,
						"dat"=>$this->Dat
					)
				);
			else
			return array(
				$this->Name=>array(
					"dat"=>$this->Dat,
					"type"=>$this->Type,
					"len"=>$this->Len
				)
			);
			
		}
		
		function getObjectElement(){
			return array(
				$this->Name=>array(
					"dat"=>base64_decode($this->Dat),
					"type"=>$this->Type,
					"len"=>$this->Len
				)
			);
		}		
		
	}

?>