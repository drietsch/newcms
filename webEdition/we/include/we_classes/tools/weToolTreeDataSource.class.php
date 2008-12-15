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

include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we.inc.php');


class weToolTreeDataSource {

	var $SourceType;
	var $SourceName;
	
	function weToolTreeDataSource($ds) {
		
		$_dsd = explode(':',$ds);
		if(isset($_dsd[0]) && isset($_dsd[1])) {
			$this->SourceType = $_dsd[0];
			$this->SourceName = $_dsd[1];
		}
		
		
	}
	
	function getItems($pid,$offset=0,$segment=500,$sort=''){
		switch ($this->SourceType) {
			case 'table' :
				return $this->getItemsFromDB($pid,$offset,$segment);
			case 'file':
				return $this->getItemsFromFile($pid,$offset,$segment);
			case 'custom':
				return $this->getCustomItems($pid,$offset,$segment);
		}

	}

	
	function getQueryParents($path){
		$out = "";
		while($path != "/" && $path != "\\" && $path){
			$out .= "Path='$path' OR ";
			$path = dirname($path);
		}
		if($out){
			return substr($out,0,strlen($out)-3);
		}else{
			return "";
		}
	}	

	function getItemsFromDB($ParentID=0,$offset=0,$segment=500,$elem='ID,ParentID,Path,Text,Icon,IsFolder',$addWhere='',$addOrderBy=''){
		
		$db=new DB_WE();
		$table=$this->SourceName;
		
		$items=array();
		
		$wsQuery = '';
		$_aWsQuery=array();
		$parentpaths = array();

		if($ws = get_ws($table)) {
			$wsPathArray = id_to_path($ws,$table,$db,false,true);
			foreach($wsPathArray as $path){
				$_aWsQuery[] = " Path like '".mysql_real_escape_string($path)."/%' OR ".weToolTreeDataSource::getQueryParents($path);
				while($path != "/" && $path != "\\" && $path){
					array_push($parentpaths,$path);
					$path = dirname($path);
				}
			}
			$wsQuery = !empty($_aWsQuery) ? '(' .implode(' OR ',$_aWsQuery) . ') AND ' : '';
		}
				
		$prevoffset=$offset-$segment;
		$prevoffset=($prevoffset<0) ? 0 : $prevoffset;
		if($offset && $segment){	
				$items[]=array(
										'icon'=>'arrowup.gif',
										'id'=>'prev_'.$ParentID,
										'parentid'=>$ParentID,
										'text'=>'display ('.$prevoffset.'-'.$offset.')',
										'contenttype'=>'arrowup',
										'table'=>$table,
										'typ'=>'threedots',
										'open'=>0,
										'published'=>0,
										'disabled'=> 0,
										'tooltip'=>'',
										'offset'=>$prevoffset
				);	
		}		
		
		$where=" WHERE $wsQuery ParentID=".abs($ParentID)." ".$addWhere;		
	
		$db->query("SELECT $elem, abs(text) as Nr, (text REGEXP '^[0-9]') as isNr from ".mysql_real_escape_string($table)." $where ORDER BY isNr DESC,Nr,Text " . ($segment ?  "LIMIT ".abs($offset).",".abs($segment).";" : ";" ));
		$now = time();
		
		while($db->next_record()){

			if($db->f('IsFolder')==1) $typ=array('typ'=>'group');
			else $typ=array('typ'=>'item');

			$typ['icon']=$db->f('Icon');
			$typ['open']=0;
			$typ['disabled']=0;
			$typ['tooltip']=$db->f('ID');
			$typ['offset']=$offset;
			$typ['order']=$db->f('Ordn');
			$typ['published']= 1;
			$typ['disabled']=0;
			
			$fileds=array();
 
 			foreach($db->Record as $k=>$v){
 				if(!is_numeric($k)) $fileds[strtolower($k)]=$v;
 			}
 
 			$items[]=array_merge($fileds,$typ);			

		}
		
		$total=f("SELECT COUNT(*) as total FROM ".mysql_real_escape_string($table)." $where;",'total',$db);
		$nextoffset=$offset+$segment;
		if($segment && ($total>$nextoffset)){
			$items[]=array(
									'icon'=>'arrowdown.gif',
									'id'=>'next_'.$ParentID,
									'parentid'=>$ParentID,
									'text'=>'display ('.$nextoffset.'-'.($nextoffset+$segment).')',
									'contenttype'=>'arrowdown',
									'table'=>$table,
									'typ'=>'threedots',
									'open'=>0,
									'disabled'=>0,
									'tooltip'=>'',
									'offset'=>$nextoffset
			);		
		}		
		
		
		return $items;

	}
	
	function getItemsFromFile($ParentID=0,$offset=0,$segment=500,$elem='ID,ParentID,Path,Text,Icon,IsFolder',$addWhere='',$addOrderBy=''){
		
		$file=$this->SourceName;
		
		$items=array();
		
			
		$items[]=array(
										'icon' => 'link.gif',
										'id'=>1,
										'parentid'=>0,
										'text'=>'Test 1',
										'contenttype'=>'item',
										'table'=>$file,
										'typ'=>'item',
										'open'=>0,
										'published'=>1,
										'disabled'=> 0,
										'tooltip'=>''
				);	
		
		
		
		return $items;

	}
	
	function getCustomItems($ParentID=0,$offset=0,$segment=500,$elem='ID,ParentID,Path,Text,Icon,IsFolder',$addWhere='',$addOrderBy=''){
			
		$items=array();
		
		$items[]=array(
										'icon' => 'folder.gif',
										'id'=>1,
										'parentid'=>0,
										'text'=>'Custom Group',
										'contenttype'=>'item',
										'table'=>'',
										'typ'=>'group',
										'open'=>0,
										'published'=>1,
										'disabled'=> 0,
										'tooltip'=>''
		);	
		
		$items[]=array(
										'icon' => 'link.gif',
										'id'=>2,
										'parentid'=>1,
										'text'=>'Custom Item',
										'contenttype'=>'item',
										'table'=>'',
										'typ'=>'item',
										'open'=>0,
										'published'=>1,
										'disabled'=> 0,
										'tooltip'=>''
		);	
		
		
		return $items;

	}
	
}

?>