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

	include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_classes/weMainTree.inc.php');


	class weToolTree extends weMainTree{


		function weToolTree($frameset='',$topFrame='',$treeFrame='',$cmdFrame=''){

				weMainTree::weMainTree($frameset,$topFrame,$treeFrame,$cmdFrame);

				$styles=array();
				$styles[]='.item {color: black; font-size: '.($GLOBALS['BROWSER'] == 'NN' && ($GLOBALS['SYSTEM'] == 'WIN') ? '10px' : (($GLOBALS['SYSTEM'] == 'X11') ? '11px' : '9px')).'; font-family: '.$GLOBALS['l_css']['font_family'].';}';
				$styles[]='.item a { text-decoration:none;}';

				$styles[]='.group {color: black; font-weight: bold; font-size: '.($GLOBALS['BROWSER'] == 'NN' && ($GLOBALS['SYSTEM'] == 'WIN') ? '10px' : (($GLOBALS['SYSTEM'] == 'X11') ? '11px' : '9px')).'; font-family: '.$GLOBALS['l_css']['font_family'].';}';
				$styles[]='.group a { text-decoration:none;}';

				$styles[]='.notpublished {color: #3366CC; font-size: '.($GLOBALS["BROWSER"]== "NN" && ($GLOBALS["SYSTEM"] == "WIN") ? "10px" : (($GLOBALS["SYSTEM"] == "X11") ? "11px" : "9px")).'; font-family: '.$GLOBALS["l_css"]["font_family"].'; cursor: pointer;}';
				$styles[]='.notpublished a { text-decoration:none;}';

				$styles[]='.selected_item {color: black; font-size: '.($GLOBALS["BROWSER"] == "NN" && ($GLOBALS["SYSTEM"]== "WIN") ? "10px" : (($GLOBALS["SYSTEM"] == "X11") ? "11px" : "9px")).'; font-family: '.$GLOBALS["l_css"]["font_family"].'; background-color: #D4DBFA; cursor: pointer;}';
				$styles[]='.selected_item a { text-decoration:none;}';

				$styles[]='.selected_notpublished_item {color: #3366CC; font-size: '.($GLOBALS["BROWSER"] == "NN" && ($GLOBALS["SYSTEM"]== "WIN") ? "10px" : (($GLOBALS["SYSTEM"] == "X11") ? "11px" : "9px")).'; font-family: '.$GLOBALS["l_css"]["font_family"].'; background-color: #D4DBFA; cursor: pointer;}';
				$styles[]='.selected_notpublished_item a { text-decoration:none;}';

				$styles[]='.selected_changed_item {color: #3366CC; font-size: '.($GLOBALS["BROWSER"] == "NN" && ($GLOBALS["SYSTEM"]== "WIN") ? "10px" : (($GLOBALS["SYSTEM"] == "X11") ? "11px" : "9px")).'; font-family: '.$GLOBALS["l_css"]["font_family"].'; background-color: #D4DBFA; cursor: pointer;}';
				$styles[]='.selected_changed_item a { text-decoration:none;}';

				$styles[]='.selected_group {color: black; font-weight: bold; font-size: '.($GLOBALS["BROWSER"] == "NN" && ($GLOBALS["SYSTEM"]== "WIN") ? "10px" : (($GLOBALS["SYSTEM"] == "X11") ? "11px" : "9px")).'; font-family: '.$GLOBALS["l_css"]["font_family"].'; background-color: #D4DBFA; cursor: pointer;}';
				$styles[]='.selected_group a { text-decoration:none;}';

				$styles[]='.selected_open_group {color: black; font-weight: bold; font-size: '.($GLOBALS["BROWSER"] == "NN" && ($GLOBALS["SYSTEM"]== "WIN") ? "10px" : (($GLOBALS["SYSTEM"] == "X11") ? "11px" : "9px")).'; font-family: '.$GLOBALS["l_css"]["font_family"].'; background-color: #D4DBFA; cursor: pointer;}';
				$styles[]='.selected_open_group a { text-decoration:none;}';

				$this->setStyles($styles);

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


 		function getJSUpdateItem(){
 			return '
 				function updateEntry(id,text,pid,pub,order){
        			var ai = 1;
        			while (ai <= treeData.len) {
            			if (treeData[ai].id==id) {
                 			treeData[ai].text=text;
                 			treeData[ai].parentid=pid;
                 			treeData[ai].order=order;
                 			treeData[ai].tooltip=id;
             			}
            	 		ai++;
        			}
					drawTree();
 				}
			';
 		}


		function getJSStartTree(){

			return 'function startTree(){
				pid = arguments[0] ? arguments[0] : 0;
				offset = arguments[1] ? arguments[1] : 0;
				'.$this->cmdFrame.'.location="'.$this->frameset.'?pnt=cmd&pid="+pid+"&offset="+offset;
				drawTree();
			}';

		}

		function getJSReloadGroup(){
 			return '
 				function reloadGroup(pid){
        			var ai = 1;
        			var it = get(pid);
        			offset = arguments[1] ? arguments[1] : 0;
        			if(it){
        				it.clear();
        				startTree(pid,offset);
        			}
 				}
			';
 		}

		function getJSIncludeFunctions(){

			$out=	weTree::getJSIncludeFunctions() ."\n".
					$this->getJSStartTree()."\n".
					$this->getJSReloadGroup()."\n";

			return $out;
		}

		function getJSMakeNewEntry(){
	 		return '
			function makeNewEntry(icon,id,pid,txt,open,ct,tab,pub,order){
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

							attribs["order"]=order;

	 						attribs["tooltip"]=id;
	 						attribs["typ"]=ct;


							attribs["disabled"]=0;
							attribs["published"]=pub==0 ? 1 : 0;
							attribs["depended"]=pub;

							attribs["selected"]=0;

							treeData.addSort(new node(attribs));

							drawTree();
						}
					}
			}
			';
		}

		function getJSInfo(){
			return '
			function info(text) {
				t='.$this->topFrame.'.resize.left.treefooter.window.document.getElementById("infoField");
				if(text!=" "){
					t.style.display="block";
					t.innerHTML = text;
				} else {
					t.innerHTML = text;
					t.style.display="none";
				}
			}
		';

		}

		function getJSAddSortFunction() {
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_browserDetect.inc.php");
			$insp=new we_browserDetect();
			return '
			function addSort(object){
				this.len++;
				for(var i=this.len; i>0; i--){
					if(i > 1 && (this[i-1].order > object.order)){

						this[i] = this[i-1];
					}
					else{
						for(var j=i; j>0; j--){
							if(j > 1  && (this[j-1].order == object.order) && (this[j-1].text.toLowerCase() > object.text.toLowerCase()'.( $insp->getSystem()!="mac" ? " || (this[j-1].typ>object.typ)" : "" ).')){
								this[j] = this[j-1];
							}
							else{
								this[j] = object;
								break;
							}
						}
						break;
					}
				}
			}
			';
		}

		function getJSClearItems(){
 	 	return '
 		function clearItems(){
			var ai = 1;
			var delid = 1;
			var deleted = 0;

			while (ai <= treeData.len) {
				if (treeData[ai].parentid == this.id){
					if(treeData[ai].contenttype=="group") deleted+=treeData[ai].clear();
					else{
						ind=ai;
                		while (ind <= treeData.len-1) {
                        		treeData[ind]=treeData[ind+1];
		                        ind++;
                		}
                		treeData.len[treeData.len]=null;
                		treeData.len--;
					}
					deleted++;
				}
				else{
					ai++;
				}
			}
			return deleted;
		}
	';
 	}

	function getHTMLContruct(){
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_browser_check.inc.php");
		$style_code="";
		foreach($this->styles as $st) $style_code.=$st."\n";

		return we_htmlElement::htmlHtml(
			we_htmlElement::htmlHead(
				WE_DEFAULT_HEAD.
				STYLESHEET.
				we_htmlElement::cssElement($style_code)
			).
			we_htmlElement::htmlBody(array(
														'bgcolor'=>'#F3F7FF',
														'link'=>'#000000',
														'alink'=>'#000000',
														'vlink'=>'#000000',
														'marginwidth'=>'0',
														'marginheight'=>'4',
														'leftmargin'=>'0',
														'topmargin'=>'4'
													),
					'<div id="treetable"></div>
					'
			)
		);

	}

	function getJSShowSegment(){
 			return '
 				function showSegment(){
					'.$this->topFrame.'.reloadGroup(this.parentid,this.offset);
				}
			';
 	}

 	function getJSTreeFunctions(){
		// must override
		$out=weTree::getJSTreeFunctions();

		$out.='
			function doClick(id,typ){

			}
			'.$this->topFrame.'.loaded=1;
		';
		return $out;

	}
	
	function getJSTreeCode($withTag=true){
		// must override
 		return parent::getJSTreeCode($withTag) . "\n" .
 				
 			($withTag ? we_htmlElement::jsElement('drawTree.selection_table="";') : 'drawTree.selection_table="";');
 	}
 	
}

?>