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


	class weCustomerTree extends weTree{


		function weCustomerTree($frameset="",$topFrame="",$treeFrame="",$cmdFrame=""){

				weTree::weTree($frameset,$topFrame,$treeFrame,$cmdFrame);

				$styles=array();
				$styles[]='.item {color: black; font-size: '.($GLOBALS["BROWSER"] == "NN" && ($GLOBALS["SYSTEM"] == "WIN") ? "10px" : (($GLOBALS["SYSTEM"] == "X11") ? "11px" : "9px")).'; font-family: '.$GLOBALS["l_css"]["font_family"].';}';
				$styles[]='.item a { text-decoration:none;}';

				$styles[]='.group {color: black; font-weight: bold; font-size: '.($GLOBALS["BROWSER"] == "NN" && ($GLOBALS["SYSTEM"] == "WIN") ? "10px" : (($GLOBALS["SYSTEM"] == "X11") ? "11px" : "9px")).'; font-family: '.$GLOBALS["l_css"]["font_family"].';}';
				$styles[]='.group a { text-decoration:none;}';

				$this->setStyles($styles);

		}

 		function getJSCustomDraw(){
 			$out=weTree::getJSCustomDraw();
 			$out["group"]="";

			$out["sort"]='

					var newAst = zweigEintrag;

					var zusatz = (ai == nf.laenge) ? "end" : "";
					var oc_img;
					var oc_js;

					if (nf[ai].open == 0) oc_img=treeData.tree_image_dir+"auf"+zusatz+".gif";
					else oc_img=treeData.tree_image_dir+"zu"+zusatz+".gif";

					oc_js=treeData.topFrame+".openClose(\'" + nf[ai].id + "\')\"";


					row+="&nbsp;&nbsp;<a href=\"javascript:"+oc_js+" border=0><img src="+oc_img+" width=19 height=18 align=absmiddle border=0 Alt=\"\"></a>";


					row+="<a name=\'_"+nf[ai].id+"\' href=\"javascript://\" onClick=\""+oc_js+";return true;\" border=0>";
					row+="<img src="+treeData.tree_image_dir+"icons/"+nf[ai].icon+" width=16 height=18 align=absmiddle border=0 Alt=\"\">";
					row+="</a>";

					row+="<a name=\'_"+nf[ai].id+"\' href=\"javascript://\" onClick=\""+oc_js+";return true;\">";
					row+="<label style=\"cursor:pointer\" id=\"lab_"+nf[ai].id+"\" class=\""+treeData.node_layout[nf[ai].state]+"\">&nbsp;" + nf[ai].text+"</label>";
					row+="</a>";

					row+="&nbsp;&nbsp;<br>\n";

					if (nf[ai].open){
						if(ai == nf.laenge) newAst = newAst + "<img src="+treeData.tree_image_dir+"leer.gif width=19 height=18 align=absmiddle border=0>";
						else newAst = newAst + "<img src="+treeData.tree_image_dir+"strich2.gif width=19 height=18 align=absmiddle border=0>";
						row+=draw(nf[ai].id,newAst);
					}
			';

			$out["group"]='
					var newAst = zweigEintrag;

					var zusatz = (ai == nf.len) ? "end" : "";
					var oc_img;
					var oc_js;

					if (nf[ai].open == 1) oc_img=treeData.tree_image_dir+"zu"+zusatz+".gif";
					else oc_img=treeData.tree_image_dir+"auf"+zusatz+".gif";

					if(nf[ai].disabled!=1) oc_js=treeData.topFrame+".setScrollY();"+treeData.topFrame+".openClose(\'" + nf[ai].id + "\')\"";
					else oc_js="//";

					oc_js=treeData.topFrame+".setScrollY();"+treeData.topFrame+".openClose(\'" + nf[ai].id + "\')\"";

					row+="&nbsp;&nbsp;<a href=\"javascript:"+oc_js+" border=0><img src="+oc_img+" width=19 height=18 align=absmiddle border=0 Alt=\"\"></a>";

					var folder_icon;
					folder_icon="folder"+(nf[ai].open==1 ? "open" : "")+(nf[ai].disabled==1 ? "_disabled" : "")+".gif";

					nf[ai].icon=folder_icon;

					if(nf[ai].disabled!=1) row+="<a name=\'_"+nf[ai].id+"\' href=\"javascript:"+oc_js+"\">";

					row+="<img src="+treeData.tree_image_dir+"icons/"+nf[ai].icon+" width=16 height=18 align=absmiddle border=0 alt=\"\">";

					if(nf[ai].disabled!=1) row+="</a>";


					if(nf[ai].disabled!=1) row+="<a name=\'_"+nf[ai].id+"\' href=\"javascript:"+oc_js+"\">";

					row+="<label style=\"cursor:pointer\" id=\"lab_"+nf[ai].id+"\" class=\""+nf[ai].getlayout()+"\">&nbsp;" + nf[ai].text+"</label>";

					if(nf[ai].disabled!=1) row+="</a>";

					row+="&nbsp;&nbsp;<br>\n";

					if (nf[ai].open==1){
						if(ai == nf.len) newAst = newAst + "<img src="+treeData.tree_image_dir+"leer.gif width=19 height=18 align=absmiddle border=0>";
						else newAst = newAst + "<img src="+treeData.tree_image_dir+"strich2.gif width=19 height=18 align=absmiddle border=0>";
						row+=draw(nf[ai].id,newAst);
					}

			';




 			return $out;
 		}

		function getJSOpenClose(){
 			return '
  			function openClose(id){
				var sort="";
				if(id=="") return;
				var eintragsIndex = indexOfEntry(id);
				var openstatus;

				if(treeData[eintragsIndex].typ=="group"){
					sort='.$this->topFrame.'.resize.left.treeheader.document.we_form.sort.value;
				}

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
 				function updateEntry(id,text){
        			var ai = 1;
        			while (ai <= treeData.len) {
            			if (treeData[ai].id==id) {
                 			treeData[ai].text=text;
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
    				if(node.typ==\'item\')
						'.$this->topFrame.'.we_cmd(\'edit_customer\',node.id,node.typ,node.table);
				}
				'.$this->topFrame.'.loaded=1;
			';
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

		function getJSLoadTree($treeItems){

			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/date.inc.php");

			$days = array(
				"Sunday"=>0,
				"Monday"=>1,
				"Tuesday"=>2,
				"Wednesday"=>3,
				"Thursday"=>4,
				"Friday"=>5,
				"Saturday"=>6
			);

			$months= array(
					"January"=>0,
					"February"=>1,
					"March"=>2,
					"April"=>3,
					"May"=>4,
					"June"=>5,
					"July"=>6,
					"August"=>7,
					"September"=>8,
					"October"=>9,
					"November"=>10,
					"December"=>11
			);

			$js="";
			$out="";
			$js="var attribs=new Array();\n";
			foreach($treeItems as $item){
				$js.="		if(".$this->topFrame.".indexOfEntry('".$item["id"]."')<0){ \n";
				foreach($item as $k=>$v){
					if($k=="text") if(in_array($v,array_keys($days))) $v=$GLOBALS['l_dayLong'][$days[$v]];
					if($k=="text") if(in_array($v,array_keys($months))) $v=$GLOBALS['l_monthLong'][$months[$v]];
					$js.='
							attribs["'.strtolower($k).'"]=\''.addslashes(stripslashes($v)).'\';
					';
				}
				$js.='
						'.$this->topFrame.'.treeData.add(new '.$this->topFrame.'.node(attribs));
				}
				';
			}
			$js.=$this->topFrame.'.drawTree();';

			return $js;
		}

		function getJSShowSegment(){
 			return '
 				function showSegment(){
					var sort="";
					parentnode='.$this->topFrame.'.get(this.parentid);
					parentnode.clear();
					sort='.$this->topFrame.'.resize.left.treeheader.document.we_form.sort.value;
					we_cmd("load",parentnode.id,this.offset,sort);
				}
			';
 		}

	}

?>