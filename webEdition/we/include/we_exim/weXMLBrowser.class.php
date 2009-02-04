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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/xml_parser.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_live_tools.inc.php");


class weXMLBrowser extends XML_Parser{

	var $cache;
	
	function weXMLBrowser($filename="",$mode="backup"){
		XML_Parser::XML_Parser();
		$this->mode=$mode;
		$this->xmlExt = FALSE;
		if(!empty($filename)) $this->getFile($filename);
	}


	function getNodeset($xpath="*"){
		$xpath.="/child::*";
		return $this->evaluate($xpath);
	}

	function setCache($location){
		$this->cache=$location;
	}
	
	function saveCache($cache="",$expire=0){
		if(empty($cache)) $cache=$this->cache;
		else $this->cache=$cache;
		if($expire==0) $expire=time()+1800;
		
		if (defined("WE_NEW_FOLDER_MOD")){
			eval('$mod = 0' . abs(WE_NEW_FOLDER_MOD) .';');
		} else {
			$mod = 0755;
		}
		
		if(!is_dir(dirname($cache))) {
			createLocalFolder(dirname($cache));
		}
		if(weFile::save($cache,serialize($this->nodes))) insertIntoCleanUp($cache,$expire);
	}
	
	function loadCache($cache=""){				
		if(empty($cache)) $cache=$this->cache;
		else $this->cache=$cache;
		$this->nodes=unserialize(weFile::load($cache));			
	}

	
	
	function getNodeDataset($xpath="*"){
		$nodeSet=$this->getNodeset($xpath);
		foreach ($nodeSet as $node) {
			$nodeattribs=array();
			if ($this->hasAttributes($node)) {
				$attrs = $attrs + array("@n:"=>$l_customer["none"]);
				$attributes = $this->getAttributes($node);
				foreach ($attributes as $name=>$value) {
					$nodeattribs[$name] = $value;
				}
			}
			$nodes[$node]=array(
				"attributes"=>$nodeattribs,
				"content"=>$this->getData($node)
			);
		}
		return $nodes;

	}


	function getSet($search){
		$ret=array();
		foreach($this->nodes as $key=>$val){
				if($key!="" && $key!=$search && strpos($key,$search)!==false) $ret[]=$key;
		}
		return $ret;
	}

	
	function getFile($file) {

		if(file_exists($_SERVER["DOCUMENT_ROOT"]."/webEdition/updateinclude/proxysettings.php")){
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/updateinclude/proxysettings.php");
		}			
		
		if(weFile::hasURL($file)) {
		
				$_opt = getHttpOption();

				if($_opt=='fopen') {						
					if (defined("WE_PROXYHOST")) {
										
						$proxyhost = defined("WE_PROXYHOST") ? WE_PROXYHOST : "";
						$proxyport = (defined("WE_PROXYPORT") && WE_PROXYPORT) ? WE_PROXYPORT : "80";
						$proxy_user = defined("WE_PROXYUSER") ? WE_PROXYUSER : "";
						$proxy_pass = defined("WE_PROXYPASSWORD") ? WE_PROXYPASSWORD : "";
							
						$newfile = $this->getFileThroughProxy($file,$proxyhost,$proxyport,$proxy_user,$proxy_pass);
						if(!empty($newfile)) $file = $newfile;
						else return false;
					}
				}else if($_opt=='curl') {
					$_m = array();
					$_pattern = '/^(((ht|f)tp(s?):\/\/)|(www\.))+(([a-zA-Z0-9\._-]+\.[a-zA-Z]{2,6})|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(\/[a-zA-Z0-9\&amp;%_\.\/-~-]*)?/i';
					if(preg_match($_pattern,$file,$_m)) {
						$_content = getCurlHttp(str_replace($_m[9],'',$file),$_m[9]);
						if($_content['status']===0) {
							$_fn = weFile::saveTemp($_content['data']);							
							$file = $_fn;	
						} else {
							return false;
						}
					} else {
						return false;
					}
					
				} else if($_opt=='none') {						
					// has to be implemented
					return false;
				}
			
				
		
		}
		return XML_Parser::getFile($file);
	}		

	

	function getFileThroughProxy($url,$proxyhost="0.0.0.0",$proxyport=0,$proxy_user="",$proxy_pass=""){
		global $error;
		
		$file = fsockopen($proxyhost, $proxyport, $errno, $errstr,30); 
	
		if( !$file ){
			return "";
		}else{ 
			$newfile = TMP_DIR . '/' . weFile::getUniqueId();
			$realm = base64_encode($proxy_user.":".$proxy_pass);
		
			// send headers
			fputs($file, "GET $url HTTP/1.0\r\n");
			fputs($file, "Proxy-Connection: Keep-Alive\r\n");
			fputs($file, "User-Agent: PHP ".phpversion()."\r\n");
			fputs($file, "Pragma: no-cache\r\n");
			if($proxy_user!=""){
				fputs($file, "Proxy-authorization: Basic $realm\r\n");
			}
			fputs($file, "\r\n");
			// start to write after http header
			$write = false;
			while(!feof($file)){
				$data = fread($file,8192);
				if(ereg("<?xml",$data)){
					$pos = strpos($data,"<?xml");
					if($pos !== false) {
						$data = substr($data,$pos);
					}
					$write = true;
				}
				if($write) weFile::save($newfile,$data,"ab");
			}
			fclose($file);

			return $newfile;
		}
	}		
	


}


?>