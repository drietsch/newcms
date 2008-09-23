<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */


	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weTree.inc.php");


	class weExportTreeMain extends weTree{
		
		
		function weExportTree($frameset="",$topFrame="",$treeFrame="",$cmdFrame=""){
				
				weTree::weTree($frameset,$topFrame,$treeFrame,$cmdFrame);
				

				
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
						'.$this->cmdFrame.'.location="'.$this->frameset.'?pnt=cmd&cmd=mainload&pid="+id+"&sort="+sort;
					else
						'.$this->cmdFrame.'.location="'.$this->frameset.'?pnt=cmd&cmd=mainload&pid="+id;
				}else{
					drawTree();
				}
				if(openstatus==1) treeData[eintragsIndex].loaded=1;
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
			global $l_export;
			$out=weTree::getJSTreeFunctions();
	
			$out.='
				function doClick(id,typ){
					var cmd = "";
					if(top.content.hot == "1") {
						if(confirm("'.$l_export["save_changed_export"].'")) {
							cmd = "save_export";
							top.content.we_cmd("save_export");
						} else {
							top.content.usetHot();
							cmd = "edit_export";
							var node='.$this->topFrame.'.get(id);
							'.$this->topFrame.'.resize.right.editor.edbody.location="'.$this->frameset.'?pnt=edbody&cmd="+cmd+"&cmdid="+node.id+"&tabnr="+'.$this->topFrame.'.activ_tab;
						}
					} else {
						cmd = "edit_export";
						var node='.$this->topFrame.'.get(id);
						'.$this->topFrame.'.resize.right.editor.edbody.location="'.$this->frameset.'?pnt=edbody&cmd="+cmd+"&cmdid="+node.id+"&tabnr="+'.$this->topFrame.'.activ_tab;
					}
				}
				'.$this->topFrame.'.loaded=1;			
			';
			return $out;
		}  	
		
		function getJSStartTree(){
			
			return 'function startTree(){
				'.$this->cmdFrame.'.location="'.$this->frameset.'?pnt=cmd&cmd=mainload&pid=0";
				drawTree();
			}';
			
		}
		
		function getJSIncludeFunctions(){

			$out=weTree::getJSIncludeFunctions();			
			$out.="\n".$this->getJSStartTree()."\n";
		
			return $out;   
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
	 		
	
							attribs["disabled"]=0;
							if(attribs["typ"]=="item") attribs["published"]=0;
	
							attribs["selected"]=0;
	 		
							treeData.addSort(new node(attribs));
	
							drawTree();
						}
					}
			}
			';
		}		
	 		
 		
	}

?>