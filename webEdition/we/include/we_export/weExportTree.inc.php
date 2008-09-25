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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weMainTree.inc.php");

class weExportTree extends weMainTree{

	function getJSInfo(){
		return '
			function info(text) {
			}
		';

	}

	function getJSOpenClose(){

 		return '
		function openClose(id){

			if(id=="") return;
		
			var eintragsIndex = indexOfEntry(id);
			var status;
	
			if(treeData[eintragsIndex].open==0) openstatus=1;
			else openstatus=0;
			treeData[eintragsIndex].open=openstatus;		
			if(openstatus && treeData[eintragsIndex].loaded!=1){
 				'.$this->cmdFrame.'.location="'.$this->frameset.'?pnt=load&tab="+'.$this->topFrame.'.table+"&cmd=load&pid="+id;
 				'.$this->topFrame.'.openFolders['.$this->topFrame.'.table]+=","+id;
			}else{
 				var arr = '.$this->topFrame.'.openFolders['.$this->topFrame.'.table].split(",");
 				'.$this->topFrame.'.openFolders['.$this->topFrame.'.table]="";
 				for(var t=0;t<arr.length;t++){
					if(arr[t]!="" && arr[t]!=id){ 				
 						'.$this->topFrame.'.openFolders['.$this->topFrame.'.table]+=","+arr[t];
					}
 				}
				drawTree();
			}
			if(openstatus==1) treeData[eintragsIndex].loaded=1;
 		}
 		';

	}

	function getJSLoadTree($treeItems){
			$js="";
			$out="";

			$js='
			function in_array(arr,item){
				for(i=0;i<arr.length;i++){
					if(arr[i]==item) return true;
				}
				return false;
			}
			';

			$js.="var attribs=new Array();\n";
			$js.=$this->topFrame.".treeData.table=".$this->topFrame.".table;\n";

			foreach($treeItems as $item){
				//if(strpos($item["contenttype"], "text") !== false || strpos($item["contenttype"], "folder") !== false || strpos($item["contenttype"], "object") !== false){

					$js.="		if(".$this->topFrame.".indexOfEntry('".$item["id"]."')<0){ \n";
					foreach($item as $k=>$v){
						if(strtolower($k)=="checked")
						$js.='
							if(in_array('.$this->topFrame.'.SelectedItems[attribs["table"]],"'.$item["id"].'"))
								attribs["'.strtolower($k).'"]=\'1\';
							else
								attribs["'.strtolower($k).'"]=\''.$v.'\';
						';
						else
						$js.='
								attribs["'.strtolower($k).'"]=\''.$v.'\';
						';
					}
					$js.='
						'.$this->topFrame.'.treeData.addSort(new '.$this->topFrame.'.node(attribs));
					}
					';
				//}
			}
			$js.=$this->topFrame.'.treeData.setstate('.$this->topFrame.'.treeData.tree_states["select"]);';

			$js.=$this->topFrame.'.drawTree();';

			return $js;

	}

	function getJSStartTree(){
		return 'function startTree(){				
				'.$this->cmdFrame.'.location="'.$this->frameset.'?pnt=load&cmd=load&tab="+'.$this->topFrame.'.table+"&pid=0&openFolders="+'.$this->topFrame.'.openFolders['.$this->topFrame.'.table];
			}';
	}

	function getJSTreeCode(){
		$js=weMainTree::getJSTreeCode();
		$js.=we_htmlElement::jsElement($this->getJSStartTree());

		return $js;
	}

	function getJSDrawTree(){

 		return '
 		function drawTree(){
			var out=\'<table border=0 cellpadding=0 cellspacing=0 width=100%><tr><td>'.getPixel(5,7).'</td></tr><tr><td class="\'+treeData.getlayout()+\'">\n<nobr>\n\';
			out+=draw(treeData.startloc,"");
			out+="</nobr>\n</td></tr></table>\n";
			'.$this->treeFrame.'.document.getElementById("treetable").innerHTML=out;
			/*nurl="treeMain.php";
			win=window.open(nurl);
			win.document.open();
			win.document.write(top.treeHTML.innerHTML);
			win.document.close();*/	
   		} 
				
 		'.$this->getJSDraw();
	}
	
  	function getJSCheckNode(){
	return '
 	function checkNode(imgName) {
		var object_name = imgName.substring(4,imgName.length);
		for(i=1;i<=treeData.len;i++) {
			if(treeData[i].id == object_name) {
				'.$this->treeFrame.'.populate(treeData[i].id,treeData.table);
				if(treeData[i].checked==1) {
					if(document.images) {
						eval("if("+treeData.treeFrame+".document.images[imgName]) "+treeData.treeFrame+".document.images[imgName].src=treeData.check0_img.src;");
					}
					treeData[i].checked=0;
					if('.$this->topFrame.'.SelectedItems['.$this->topFrame.'.table].length>1){
						found=false;
						'.$this->topFrame.'.SelectedItems['.$this->topFrame.'.table].length='.$this->topFrame.'.SelectedItems['.$this->topFrame.'.table].length+1;
						for(z=0;z<'.$this->topFrame.'.SelectedItems['.$this->topFrame.'.table].length;z++){
							if('.$this->topFrame.'.SelectedItems['.$this->topFrame.'.table][z]==treeData[i].id) found=true;
							if(found)
								'.$this->topFrame.'.SelectedItems['.$this->topFrame.'.table][z]='.$this->topFrame.'.SelectedItems['.$this->topFrame.'.table][z+1];
						}
						'.$this->topFrame.'.SelectedItems['.$this->topFrame.'.table].length='.$this->topFrame.'.SelectedItems['.$this->topFrame.'.table].length-2;
					}
					else '.$this->topFrame.'.SelectedItems['.$this->topFrame.'.table]=new Array();

					treeData[i].applylayout();
					break;
				}
				else {
					if(document.images) {
						eval("if("+treeData.treeFrame+".document.images[imgName]) "+treeData.treeFrame+".document.images[imgName].src=treeData.check1_img.src;");
					}
					treeData[i].checked=1;
					'.$this->topFrame.'.SelectedItems['.$this->topFrame.'.table].push(treeData[i].id);
					treeData[i].applylayout();
					break;
				}
			}

		}
		if(top.content) {
			if(typeof(top.content.hot) != "undefined") {
				top.content.hot=1;
			}
		}
		if(!document.images) drawTree();
		}
		';
 	}

 	 	
 	function getHTMLMultiExplorer($width=500,$height=250){
 		global $l_export;		

		$js=$this->getJSTreeCode().we_htmlElement::jsElement('
			function populate(id,table){

			}

			function setHead(tab){
				'.$this->topFrame.'.table=tab;
				'.$this->topFrame.'.document.we_form.table.value=tab;
				setTimeout("'.$this->topFrame.'.startTree()",100);
			}					
			
			var SelectedItems= new Array();
			SelectedItems["'.FILE_TABLE.'"]=new Array();' .
			(defined("OBJECT_FILES_TABLE") ? (
				'SelectedItems["'.OBJECT_FILES_TABLE.'"]=new Array();
				SelectedItems["'.OBJECT_TABLE.'"]=new Array();
				') : '') . '

			SelectedItems["'.TEMPLATES_TABLE.'"]=new Array();

			var openFolders= new Array();
			openFolders["'.FILE_TABLE.'"]="";' .
			(defined("OBJECT_FILES_TABLE") ? ('
			openFolders["'.OBJECT_FILES_TABLE.'"]="";
			openFolders["'.OBJECT_TABLE.'"]="";
			') : '') . '
			openFolders["'.TEMPLATES_TABLE.'"]="";


		'.$this->getJSStartTree());

		$parts=array();

		$style_code="";
		if(isset($this->SelectionTree->styles)) foreach($this->SelectionTree->styles as $st) $style_code.=$st."\n";

		$header = new we_htmlTable(array("cellpadding" => 0,"cellspacing" => 0, "border" => "0"), 3, 1);

		$header->setCol(0,0,array("bgcolor"=>"white"),getPixel(5,5));
		
		$captions = array();
		
		if(we_hasPerm("CAN_SEE_DOCUMENTS")){
			$captions[FILE_TABLE] = $l_export["documents"];
		}
		if(we_hasPerm("CAN_SEE_TEMPLATES")){
			$captions[TEMPLATES_TABLE] = $l_export["templates"];
		}
		if(defined("OBJECT_FILES_TABLE") && we_hasPerm("CAN_SEE_OBJECTFILES")) {
			$captions[OBJECT_FILES_TABLE] = $l_export["objects"];
		}
		if(defined("OBJECT_TABLE") && we_hasPerm("CAN_SEE_OBJECTS")) {
			$captions[OBJECT_TABLE] = $l_export["classes"];
		}

		$header->setColContent(1,0,htmlSelect('headerSwitch',$captions,1,(isset($_REQUEST['headerSwitch']) ? $_REQUEST['headerSwitch'] : 0),false,'onChange="setHead(this.value);"','value',$width));		
		$header->setColContent(2,0,getPixel(5,5));		

		return $js.$header->getHtmlCode().we_htmlElement::htmlDiv(array('id'=>'treetable','class'=>'blockwrapper','style'=>'width: '.$width.'px; height: '.$height.'px; border:1px #dce6f2 solid;'),'');

 	}
 	
}