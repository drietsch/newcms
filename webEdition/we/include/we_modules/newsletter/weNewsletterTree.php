<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weMainTree.inc.php");


	class weNewsletterTree extends weMainTree{
	
		
		function weNewsletterTree($frameset='',$topFrame='',$treeFrame='',$cmdFrame=''){

			weMainTree::weMainTree($frameset,$topFrame,$treeFrame,$cmdFrame);

		}		
		
		function getJSMakeNewEntry(){
	 		return '
			function makeNewEntry(icon,id,pid,txt,open,ct,tab){
					if(treeData[indexOfEntry(pid)]){
						if(treeData[indexOfEntry(pid)].loaded){

	 						if(ct=="folder") ct="group";
	 						else ct="item";

							var attribs=new Array();
	
							attribs["id"]=id;
							attribs["icon"]=icon;
							attribs["text"]=txt;
							attribs["parentid"]=pid;
							attribs["open"]=open;

	 						attribs["tooltip"]=id;
	 						attribs["typ"]=ct;
	 						
	 						attribs["contenttype"]="newsletter";
	
							attribs["disabled"]=0;
							attribs["published"]=1;
	
							attribs["selected"]=0;
	 		
							treeData.addSort(new node(attribs));
	
							drawTree();
						}
					}
			}
			';
		}		
		
 		function getJSUpdateItem(){
 			return '
 				function updateEntry(id,text,pid){
        			var ai = 1;
        			while (ai <= treeData.len) {
            			if (treeData[ai].id==id) {                 			
                 			treeData[ai].text=text;                	 		
                 			treeData[ai].parentid=pid;
             			}
            	 		ai++;
        			}
					drawTree();
 				}	
			';
 		}

		function getJSTreeFunctions(){
	
			$out=weTree::getJSTreeFunctions();
	
			$out.='
			
				function doClick(id,typ){
					var node='.$this->topFrame.'.get(id);    		
    				'.$this->topFrame.'.we_cmd(\'edit_newsletter\',node.id,node.typ,node.table);
				}
				'.$this->topFrame.'.loaded=1;
			'.$this->getJSMakeNewEntry();			
			return $out;
		}  	
		
		function getJSStartTree(){
			
			return 'function startTree(){
				'.$this->cmdFrame.'.location="'.$this->frameset.'?pnt=cmd&pid=0";
				drawTree();
			}';
			
		}
		
		function getJSIncludeFunctions(){

			$out=weTree::getJSIncludeFunctions();			
			$out.="\n".$this->getJSStartTree()."\n";
		
			return $out;   
		}
		
		
		function getJSInfo(){
			return '
			function info(text) {

			}
		';

		}
		
		function getJSOpenClose(){
 			return '
  			function openClose(id){
				var sort="";
				if(id=="") return;
				var eintragsIndex = indexOfEntry(id);
				var openstatus;
				
						
				if(treeData[eintragsIndex].open==0) openstatus=1;
				else openstatus=0;
				
				treeData[eintragsIndex].open=openstatus;

				if(openstatus && treeData[eintragsIndex].loaded!=1){
					if(sort!="")
						'.$this->cmdFrame.'.location="'.$this->frameset.'?pnt=cmd&pid="+id+"&sort="+sort;
					else
						'.$this->cmdFrame.'.location="'.$this->frameset.'?pnt=cmd&pid="+id;
				}else{
					drawTree();
				}
				if(openstatus==1) treeData[eintragsIndex].loaded=1;
 			}
 			';
 		}		

			
	}

?>