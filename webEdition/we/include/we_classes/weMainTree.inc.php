<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weTree.inc.php");


	class weMainTree extends weTree{

		function weMainTree($frameset="",$topFrame="",$treeFrame="",$cmdFrame=""){

			weTree::weTree($frameset,$topFrame,$treeFrame,$cmdFrame);


			$node_layouts=array(
									"item"=>"item",
									"group"=>"group",
									"threedots"=>"changed",
									"item-disabled"=>"disabled",
									"group-disabled"=>"disabled",
									"group-disabled-open"=>"disabled",
									"item-checked"=>"checked_item",
									"group-checked"=>"checked_group",
									"group-open"=>"group",
									"group-checked-open"=>"checked_group",
									"item-notpublished"=>"notpublished",
									"item-checked-notpublished"=>"checked_notpublished",
									"item-changed"=>"changed",
									"item-checked-changed"=>"checked_changed",
									"item-selected"=>"selected_item",
									"item-selected-notpublished"=>"selected_notpublished_item",
									"item-selected-changed"=>"selected_changed_item",
									"group-selected"=>"selected_group",
									"group-selected-open"=>"selected_open_group"


								);

			$this->setNodeLayouts($node_layouts);

			$styles=array();

			$styles[]='.item {color: black; font-size: '.($GLOBALS["BROWSER"] == "NN" && ($GLOBALS["SYSTEM"] == "WIN") ? "10px" : (($GLOBALS["SYSTEM"] == "X11") ? "11px" : "9px")).'; font-family: '.$GLOBALS["l_css"]["font_family"].'; cursor: pointer;}';
			$styles[]='.item a { text-decoration:none;}';

			$styles[]='.group {color: black; font-weight: bold; font-size: '.($GLOBALS["BROWSER"] == "NN" && ($GLOBALS["SYSTEM"] == "WIN") ? "10px" : (($GLOBALS["SYSTEM"] == "X11") ? "11px" : "9px")).'; font-family: '.$GLOBALS["l_css"]["font_family"].'; cursor: pointer;}';
			$styles[]='.group a { text-decoration:none;}';

			$styles[]='.checked_item {color: black; font-size: '.($GLOBALS["BROWSER"] == "NN" && ($GLOBALS["SYSTEM"]== "WIN") ? "10px" : (($GLOBALS["SYSTEM"] == "X11") ? "11px" : "9px")).'; font-family: '.$GLOBALS["l_css"]["font_family"].'; background-color: #D4DBFA; cursor: pointer;}';
			$styles[]='.checked_item a { text-decoration:none;}';

			$styles[]='.checked_group {color: black; font-weight: bold; font-size: '.($GLOBALS["BROWSER"] == "NN" && ($GLOBALS["SYSTEM"]== "WIN") ? "10px" : (($GLOBALS["SYSTEM"] == "X11") ? "11px" : "9px")).'; font-family: '.$GLOBALS["l_css"]["font_family"].'; background-color: #D4DBFA; cursor: pointer;}';
			$styles[]='.checked_group a { text-decoration:none;}';

			$styles[]='.notpublished {color: red; font-size: '.($GLOBALS["BROWSER"]== "NN" && ($GLOBALS["SYSTEM"] == "WIN") ? "10px" : (($GLOBALS["SYSTEM"] == "X11") ? "11px" : "9px")).'; font-family: '.$GLOBALS["l_css"]["font_family"].'; cursor: pointer;}';
			$styles[]='.notpublished a { text-decoration:none;}';

			$styles[]='.checked_notpublished {color: red; font-size: '.($GLOBALS["BROWSER"]== "NN" && ($GLOBALS["SYSTEM"] == "WIN") ? "10px" : (($GLOBALS["SYSTEM"] == "X11") ? "11px" : "9px")).'; font-family: '.$GLOBALS["l_css"]["font_family"].'; background-color: #D4DBFA; cursor: pointer;}';
			$styles[]='.checked_notpublished a { text-decoration:none;}';

			$styles[]='.changed {color: #3366CC; font-size: '.($GLOBALS["BROWSER"] == "NN" && ($GLOBALS["SYSTEM"] == "WIN") ? "10px" : (($GLOBALS["SYSTEM"] == "X11") ? "11px" : "9px")).'; font-family: '.$GLOBALS["l_css"]["font_family"].'; cursor: pointer;}';
			$styles[]='.changed a { text-decoration:none;}';

			$styles[]='.checked_changed {color: #3366CC; font-size: '.($GLOBALS["BROWSER"] == "NN" && ($GLOBALS["SYSTEM"] == "WIN") ? "10px" : (($GLOBALS["SYSTEM"] == "X11") ? "11px" : "9px")).'; font-family: '.$GLOBALS["l_css"]["font_family"].'; background-color: #D4DBFA; cursor: pointer;}';
			$styles[]='.checked_changed a { text-decoration:none;}';

			$styles[]='.disabled {color: gray; font-size: '.($GLOBALS["BROWSER"] == "NN" && ($GLOBALS["SYSTEM"] == "WIN") ? "10px" : (($GLOBALS["SYSTEM"] == "X11") ? "11px" : "9px")).'; font-family: '.$GLOBALS["l_css"]["font_family"].'; cursor: pointer;}';
			$styles[]='.disabled a { text-decoration:none;}';

			$styles[]='.selected_item {color: black; font-size: '.($GLOBALS["BROWSER"] == "NN" && ($GLOBALS["SYSTEM"]== "WIN") ? "10px" : (($GLOBALS["SYSTEM"] == "X11") ? "11px" : "9px")).'; font-family: '.$GLOBALS["l_css"]["font_family"].'; background-color: #D4DBFA; cursor: pointer;}';
			$styles[]='.selected_item a { text-decoration:none;}';

			$styles[]='.selected_notpublished_item {color: red; font-size: '.($GLOBALS["BROWSER"] == "NN" && ($GLOBALS["SYSTEM"]== "WIN") ? "10px" : (($GLOBALS["SYSTEM"] == "X11") ? "11px" : "9px")).'; font-family: '.$GLOBALS["l_css"]["font_family"].'; background-color: #D4DBFA; cursor: pointer;}';
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
			function openClose(id) {

				if(id=="") return;
				var eintragsIndex = indexOfEntry(id);
				var status;

				if(treeData[eintragsIndex].open==0) openstatus=1;
				else openstatus=0;
				treeData[eintragsIndex].open=openstatus;
				if(openstatus && treeData[eintragsIndex].loaded!=1){
					we_cmd("loadFolder",top.treeData.table,treeData[eintragsIndex].id);
					toggleBusy(1);
				}else{
					we_cmd("closeFolder",top.treeData.table,treeData[eintragsIndex].id);
					drawTree();
				}
				if(openstatus==1) treeData[eintragsIndex].loaded=1;
			}
		';
		}

		function getJSTreeFunctions(){

			$out=weTree::getJSTreeFunctions();

			$out.='
			function doClick(id){
				var node='.$this->topFrame.'.get(id);
				var ct=node.contenttype;
				var table=node.table;
				setScrollY();
				if('.$this->topFrame.'.wasdblclick && ct != \'folder\' && table!=\'' . TEMPLATES_TABLE . '\'' . (defined("OBJECT_TABLE") ? ' && table!=\'' . OBJECT_TABLE . '\' && table!=\'' . OBJECT_FILES_TABLE . '\'' : '' ) . '){
					top.openBrowser(\''.WEBEDITION_DIR.'we_redirect.php?id=\'+id);
					setTimeout(\'wasdblclick=0;\',400);
				} else {
					top.weEditorFrameController.openDocument(table,id,ct);
				}
			}
			';

			return $out;
	}

	function getJSUpdateTreeScript($doc,$select=true){


		$published=((($doc->Published != 0) && ($doc->Published < $doc->ModDate) && ($doc->ContentType == "text/html" || $doc->ContentType == "text/webedition" || $doc->ContentType == "objectFile")) ? -1 : $doc->Published);

		//	This is needed in SeeMode
		$s  = "isEditInclude = false;\n";
		$s .= "weWindow = top;\n";
		$s .= "while(1){\n";
		$s .= "    if(!weWindow.top.opener || weWindow.top.opener.top.win){\n";
		$s .= "        break;\n";
        $s .= "      } else {\n";
        $s .= "          isEditInclude = true;\n";
        $s .= "          weWindow = weWindow.opener.top;\n";
        $s .= "      }\n";
        $s .= "}\n";
        if($_SESSION["we_mode"] == "seem"){
			return $s;
		}

        $s .= "if(weWindow.treeData){\n";;
        $s .= "var obj = weWindow.treeData;\n";
		$s .= "var isIn = false;\n";

		if($select){
			$s .= '		weWindow.treeData.selection_table="'.$doc->Table.'";'."\n";
			$s .= '		weWindow.treeData.selection="'.$doc->ID.'";'."\n";
		}
		else{

			$s .= '		weWindow.treeData.unselectnode();'."\n";
		}

		$s .= 'if(weWindow.treeData.table == "'.$doc->Table.'"){'."\n";

		$s .= '	if(weWindow.treeData[top.indexOfEntry("'.$doc->ParentID.'")]){'."\n";
		$s .= '		var attribs=new Array();'."\n";
		$s .= '		attribs["id"]=\''.$doc->ID.'\';'."\n";
		$s .= '		attribs["parentid"]=\''.$doc->ParentID.'\';'."\n";
		$s .= '		attribs["text"]=\''.$doc->Text.'\';'."\n";
		$s .= '		attribs["published"]=\''.$published.'\';'."\n";
		$s .= '		attribs["table"]=\''.$doc->Table.'\';'."\n";

		$s .= '		if('.$this->topFrame.'.indexOfEntry("'.$doc->ParentID.'")!=-1)'."\n";
		$s .= '			var visible='.$this->topFrame.'.treeData['.$this->topFrame.'.indexOfEntry("'.$doc->ParentID.'")].open;'."\n";
		$s .= '		else '."\n";
		$s .= '			var visible=0'."\n";

		$s .= '		if('.$this->topFrame.'.indexOfEntry('.$doc->ID.')!=-1){'."\n";
		$s .= "				isIn=true;\n";

		$s .= '				var ai = 1;'."\n";
		$s .= '				while (ai <= '.$this->topFrame.'.treeData.len) {'."\n";
		$s .= '					if ('.$this->topFrame.'.treeData[ai].id==attribs["id"]){'."\n";
		$s .= '						'.$this->topFrame.'.treeData[ai].text=attribs["text"];'."\n";
		$s .= '						'.$this->topFrame.'.treeData[ai].parentid=attribs["parentid"];'."\n";
		$s .= '						'.$this->topFrame.'.treeData[ai].table=attribs["table"];'."\n";
		$s .= '						'.$this->topFrame.'.treeData[ai].published=attribs["published"];'."\n";
		$s .= '					}'."\n";
		$s .= '					ai++;'."\n";
		$s .= '				}'."\n";

		//$s .= '				'.$this->topFrame.'.updateEntry("'.$doc->ID.'","'.$doc->Text.'","'.$doc->ParentID.'","'.$doc->Table.'");'."\n";

		$s .= "		}\n";
		$s .= "		else{\n";

		$s .= '				attribs["icon"]=\''.$doc->Icon.'\';'."\n";
		$s .= '				attribs["contenttype"]=\''.$doc->ContentType.'\';'."\n";
		$s .= '				attribs["isclassfolder"]=\''.(isset($doc->IsClassFolder) ? $doc->IsClassFolder : false).'\';'."\n";
		$s .= '				attribs["isnoteditable"]=\''.(isset($doc->IsNotEditable) ? $doc->IsNotEditable : false).'\';'."\n";
		$s .= '				attribs["checked"]=\'0\';'."\n";
		$s .= '				attribs["typ"]=\''.($doc->IsFolder ? "group" : "item").'\';'."\n";
		$s .= '				attribs["open"]=\'0\';'."\n";
		$s .= '				attribs["disabled"]=\'0\';'."\n";
		$s .= '				attribs["tooltip"]=\''.$doc->ID.'\';'."\n";
		$s .= '				'.$this->topFrame.'.treeData.addSort(new '.$this->topFrame.'.node(attribs));'."\n";

		$s .= "		}\n";
		$s .= "		weWindow.drawTree();\n";
		$s .= "	}\n";

		$s .= '	else if('.$this->topFrame.'.indexOfEntry('.$doc->ID.')!=-1){'."\n";
		$s .= $this->topFrame.'.deleteEntry('.$doc->ID.');'."\n";
		$s .= "	}\n";


		$s .= "}\n";
		$s .= "}\n";

		return $s;

	}

 	function getJSGetLayout(){
		$js='
				function getLayout(){
						if(this.typ=="threedots") return treeData.node_layouts["threedots"];
						var layout_key=(this.typ=="group" ? "group" : "item")+
							(this.selected==1 ? "-selected" : "")+
							(this.disabled==1 ? "-disabled" : "")+
							(this.checked==1 ? "-checked" : "")+
							(this.open==1 ? "-open" : "")+
							(this.typ=="item" && this.published==0 ? "-notpublished" : "")+
							(this.typ=="item" && this.published==-1 ? "-changed" : "") ;

						return treeData.node_layouts[layout_key];
				}
		';
		return $js;
	}

	function getJSInfo(){
		return '
			function info(text) {
				t=TreeInfo.window.document.getElementById("infoField");
				s=TreeInfo.window.document.getElementById("search");
				if(text!=" "){
					s.style.display="none";
					t.style.display="block";
					t.innerHTML = text;
				} else {
					s.style.display="block";
					t.innerHTML = text;
					t.style.display="none";
				}
			}
		';

	}

 	function getJSUpdateItem(){
 		return '
		function updateEntry(id,text,pid,tab){
			//if((treeData.table == tab)&&(treeData[indexOfEntry(pid)])&&(treeData[indexOfEntry(pid)].loaded)){
			if((treeData.table == tab)&&(treeData[indexOfEntry(pid)])){
				var ai = 1;
				while (ai <= treeData.len) {
					if (treeData[ai].id==id){
						if(text) treeData[ai].text=text;
						if(pid) treeData[ai].parentid=pid;
						if(tab) treeData[ai].table=tab;
					}
					ai++;
				}
				drawTree();
			}
		}
		';
 	}

	function getJSMakeNewEntry(){
 		return '
		function makeNewEntry(icon,id,pid,txt,open,ct,tab){
			if(treeData.table == tab){
				if(treeData[indexOfEntry(pid)]){
					if(treeData[indexOfEntry(pid)].loaded){

						var attribs=new Array();

						attribs["id"]=id;
						attribs["icon"]=icon;
						attribs["text"]=txt;
						attribs["parentid"]=pid;
						attribs["open"]=open;
						attribs["typ"]=(ct=="folder" ? "group" : "item");
						attribs["table"]=tab;
						attribs["tooltip"]=id;
						attribs["contenttype"]=ct;


						attribs["disabled"]=0;
						if(attribs["typ"]=="item") attribs["published"]=0;

						attribs["selected"]=0;

						treeData.addSort(new node(attribs));

						drawTree();
					}
				}
			}
		}
		';
	}

	function getJSIncludeFunctions(){
		$out=weTree::getJSIncludeFunctions();

		$out.='
			we_scrollY["' . FILE_TABLE . '"] = 0;
			we_scrollY["' . TEMPLATES_TABLE . '"] = 0;
		' .
			(defined("OBJECT_TABLE") ? '
			we_scrollY["' . OBJECT_TABLE . '"] = 0;
			we_scrollY["' . OBJECT_FILES_TABLE . '"] = 0;
			'
			:
			'')
		. '

			treeData.table="' . FILE_TABLE . '";

			'.$this->getJSMakeNewEntry().'
		';

		return $out;
	}

	function getJSLoadTree($treeItems){
			$js="";
			$out="";
			$js="var attribs=new Array();\n";

			$nextCode="";
			if(is_array($treeItems)) {
				foreach($treeItems as $item){
					$buff="";
					$buff.="		if(".$this->topFrame.".indexOfEntry('".$item["id"]."')<0){ \n";
					foreach($item as $k=>$v)
					$buff.='
								attribs["'.strtolower($k).'"]=\''.addslashes($v).'\';';
	
					$js.=$buff.'
						'.$this->topFrame.'.treeData.add(new '.$this->topFrame.'.node(attribs));
					}
					';
	
				}
			}
			$js.=$nextCode;

			$js.=$this->topFrame.'.drawTree();';

			return $js;
	}



}
?>