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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/tree.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlElement.inc.php");

class weTree{

	var $db;
	var $topFrame;
	var $treeFrame;
	var $cmdFrame;

	var $initialized=0;


	var $treeItems=array();

	var $frameset="";


	var $styles=array();


	var $tree_states=array(
									"edit"=>"0",
									"select"=>"1",
									"selectitem"=>"2",
									"selectgroup"=>"3",
								);

	var $tree_layouts=array(
									"0"=>"tree",
									"1"=>"tree",
									"2"=>"tree",
									"3"=>"tree"
								);

	var $node_layouts=array(
									"item"=>"tree",
									"group"=>"group"
								);


	var $tree_image_dir;
	var $tree_icon_dir;

	var $default_segment=30;

//Initialization

	function weTree($frameset="",$topFrame="",$treeFrame="",$cmdFrame=""){
		$this->db=new DB_WE();
		$this->setTreeImageDir(TREE_IMAGE_DIR);
		$this->setTreeIconDir(ICON_DIR);
		if($frameset!="" && $topFrame!=""  && $treeFrame!=""  && $cmdFrame!="") $this->init($frameset,$topFrame,$treeFrame,$cmdFrame);

		include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/css/css.inc.php");

		$styles=array();
		$styles[]='.item {color: black; font-size: '.($GLOBALS["BROWSER"] == "NN" && ($GLOBALS["SYSTEM"] == "WIN") ? "10px" : (($GLOBALS["SYSTEM"] == "X11") ? "11px" : "9px")).'; font-family: '.$GLOBALS["l_css"]["font_family"].';}';
		$styles[]='.item a { text-decoration:none;}';

		$styles[]='.group {color: black; font-weight: bold; font-size: '.($GLOBALS["BROWSER"] == "NN" && ($GLOBALS["SYSTEM"] == "WIN") ? "10px" : (($GLOBALS["SYSTEM"] == "X11") ? "11px" : "9px")).'; font-family: '.$GLOBALS["l_css"]["font_family"].';}';
		$styles[]='.group a { text-decoration:none;}';


		$styles[]='.selected_item {color: black; font-size: '.($GLOBALS["BROWSER"] == "NN" && ($GLOBALS["SYSTEM"]== "WIN") ? "10px" : (($GLOBALS["SYSTEM"] == "X11") ? "11px" : "9px")).'; font-family: '.$GLOBALS["l_css"]["font_family"].'; background-color: #6070B6; cursor: pointer;}';
		$styles[]='.selected_item a { text-decoration:none;}';

		$styles[]='.selected_group {color: black; font-weight: bold; font-size: '.($GLOBALS["BROWSER"] == "NN" && ($GLOBALS["SYSTEM"]== "WIN") ? "10px" : (($GLOBALS["SYSTEM"] == "X11") ? "11px" : "9px")).'; font-family: '.$GLOBALS["l_css"]["font_family"].'; background-color: #6070B6; cursor: pointer;}';
		$styles[]='.selected_group a { text-decoration:none;}';

		$this->setStyles($styles);

		$this->setItemsCount(getPref("default_tree_count"));


	}

	function init($frameset,$topFrame,$treeFrame,$cmdFrame){
		$this->frameset=$frameset;
		$this->setTopFrame($topFrame);
		$this->setTreeFrame($treeFrame);
		$this->setCmdFrame($cmdFrame);
		$this->initialized=1;
	}

	function setTreeFrame($treeFrame){
		$this->treeFrame=$treeFrame;
	}

	function setTopFrame($topFrame){
		$this->topFrame=$topFrame;
	}

	function setCmdFrame($cmdFrame){
		$this->cmdFrame=$cmdFrame;
	}

	function setTreeImageDir($dir){
		$this->tree_image_dir=$dir;
	}
	
	function setTreeIconDir($dir){
		$this->tree_icon_dir=$dir;
	}

	function setTreeStates($tree_states){
			$this->tree_states=$tree_states;
	}

	function setTreeLayouts($tree_layout){
			$this->tree_layouts=$tree_layout;
	}

	function setNodeLayouts($node_layout){
			$this->node_layouts=$node_layout;
	}

	function setStyles($styles){
		$this->styles=$styles;
	}


	/*
		the functions prints tree javascript
		should be placed in a frame which doesn't reloads

	*/

	function getJSIncludeFunctions(){

		return '
			'.$this->getJSDrawTree().'

			'.$this->getJSUpdateItem().'

			'.$this->getJSDeleteItem().'

			'.$this->getJSClearTree().'

			'.$this->getJSSetTreeState().'

			'.$this->getJSOpenClose().'

			'.$this->getJSGetTreeLayout().'

			'.$this->getJSApplyLayout().'

			'.$this->getJSGetLayout().'

			'.$this->getJSContainer().'

			'.$this->getJSAddNode().'

			'.$this->getJSRootAdd().'

			'.$this->getJSMakeFoldersOpenString().'

			'.$this->getJSCheckNode().'

			'.$this->getJSInfo().'

			'.$this->getJSSelectNode().'

			'.$this->getJSUnselectNode().'

			'.$this->getJSShowSegment().'

			'.$this->getJSClearItems().'
		';

	}


	function getJSTreeCode($withTag=true){

		$out="";

		if ($withTag) {
			$out.=we_htmlElement::jsElement("",array("src"=>JS_DIR."images.js"));
		}
		$js='
			var treeData = new container();

			var we_scrollY = new Array();
			//var 	setScrollY;

			'.$this->getJSIncludeFunctions().'

 			function indexOfEntry(id){var ai = 1;while (ai <= treeData.len) { if (treeData[ai].id == id) return ai;ai++;}return -1;}

 			function get(eintrag){var nf = new container();var ai = 1;while (ai <= treeData.len) {if (treeData[ai].id == eintrag) nf=treeData[ai];ai++;}return nf;}

 			function search(eintrag){var nf = new container();var ai = 1;while (ai <= treeData.len) {if (treeData[ai].parentid == eintrag) nf.add(treeData[ai]);ai++;}return nf;}

 			function add(object){this.len++;this[this.len] = object;}

 			function containerClear(){this.len =0;}

			'.$this->getJSAddSortFunction().'
			'.$this->getJSTreeFunctions().'

 			var startloc=0;
			var treeHTML;
 			self.focus();
		';

		$out.= $withTag ? we_htmlElement::jsElement($js) : $js;

		return $out;

 	}

 	function getJSAddSortFunction() {

 		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_browserDetect.inc.php");
		$insp=new we_browserDetect();

 		return '
 		function addSort(object){
				this.len++;
				for(var i=this.len; i>0; i--){
					if(i > 1 && (this[i-1].text.toLowerCase() > object.text.toLowerCase()'.( $insp->getSystem()!="mac" ? " || (this[i-1].typ>object.typ)" : "" ).')){
						this[i] = this[i-1];
					}
					else{
						this[i] = object;
						break;
					}
				}
		}
 		';
 	}

	function getJSTreeFunctions(){

	$out='

		//var clickCount=0;
		var wasdblclick=0;
		var tout=null;

		function setScrollY(){
			if('.$this->topFrame.'){
				if('.$this->topFrame.'.we_scrollY){
					'.$this->topFrame.'.we_scrollY[treeData.table]='. ($GLOBALS["BROWSER"] == "IE" ? 'document.body.scrollTop' : 'pageYOffset').';
				}
			}
		}

		function setSegment(id){
			var node='.$this->topFrame.'.get(id);
			node.showsegment();
		}
	';

	return $out;

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
			'.$this->cmdFrame.'.location="'.$this->frameset.'?pnt=cmd&pid="+id;
		}else{
			drawTree();
		}
		if(openstatus==1) treeData[eintragsIndex].loaded=1;
 	}
 	';
  }

  function getJSCheckNode(){
	return '
 	function checkNode(imgName) {
		var object_name = imgName.substring(4,imgName.length);
		for(i=1;i<=treeData.len;i++) {

			if(treeData[i].id == object_name) {
				if(treeData[i].checked==1) {
					if(document.images) {
						eval("if("+treeData.treeFrame+".document.images[imgName]) "+treeData.treeFrame+".document.images[imgName].src=treeData.check0_img.src;");
					}
					treeData[i].checked=0;
					treeData[i].applylayout();
					break;
				}
				else {
					if(document.images) {
						eval("if("+treeData.treeFrame+".document.images[imgName]) "+treeData.treeFrame+".document.images[imgName].src=treeData.check1_img.src;");
					}
					treeData[i].checked=1;
					treeData[i].applylayout();
					break;
				}
			}

		}
		if(!document.images) drawTree();
	}
	';
 }


    function getJSGetTreeLayout(){
		$js='
				function getTreeLayout(){
						return this.tree_layouts[this.state];
				}
		';
		return $js;
	}


  	function getJSGetLayout(){
		$js='
				function getLayout(){
						var layout_key=(this.typ=="group" ? "group" : "item");
						return treeData.node_layouts[layout_key];
				}
		';
		return $js;
	}


  function getJSSetTreeState(){
 	return '
		function setTreeState(){
			this.state=arguments[0];

			if(this.state==this.tree_states["edit"]){
				for(i=1;i<=this.len;i++) {
					if(this[i].checked == 1) this[i].checked=0;
				}

			}

		}
	';
 }

 function getJSApplyLayout(){
 	return '
		function applyLayout(){
			if(arguments[0])
				eval("if("+treeData.treeFrame+".document.getElementById(\"lab_"+this.id+"\"))"+treeData.treeFrame+".document.getElementById(\"lab_"+this.id+"\").className =\""+arguments[0]+"\";");
			else
				eval("if("+treeData.treeFrame+".document.getElementById(\"lab_"+this.id+"\"))"+treeData.treeFrame+".document.getElementById(\"lab_"+this.id+"\").className =\""+this.getlayout()+"\";");
		}
	';
 }

 function getJSRootAdd(){
 	return '
		function rootEntry(id,text,rootstat,offset){
			this.id = id;
			this.text = text;
			this.open=1;
			this.loaded=1;
			this.typ = "root";
			this.offset = offset;
			this.rootstat = rootstat;
			this.showsegment=showSegment;
			this.clear=clearItems;

			return this;
		}
	';
 }

 function getJSAddNode(){
 	return '
		function node(attribs){

			for(aname in attribs){
				var val=""+attribs[aname];
				this[aname] = val;
			}

			this.getlayout=getLayout;
			this.applylayout=applyLayout;
			this.showsegment=showSegment;
			this.clear=clearItems;
			return this;
		}
	';

 }

  function getJSSelectNode(){
 	return '
		function selectNode(){
				if(arguments[0]){
        			var ind;
					if(treeData.selection!="" && treeData.selection_table==treeData.table){
						ind=indexOfEntry(treeData.selection);
						if(ind!=-1){
							var oldnode=get(treeData.selection);
							oldnode.selected=0;
							oldnode.applylayout();
						}
					}
					ind=indexOfEntry(arguments[0]);
					if(ind!=-1){
						var newnode=get(arguments[0]);
						newnode.selected=1;
						newnode.applylayout();
					}
					treeData.selection=arguments[0];
					treeData.selection_table=treeData.table;
				}
		}

	';
 }


 function getJSUnselectNode(){
 	return '
 		function unselectNode(){
			if(treeData.selection!="" && treeData.table==treeData.selection_table){
				var ind=indexOfEntry(treeData.selection);
				if(ind!=-1){
					var node=get(treeData.selection);
					node.selected=0;
					if(node.applylayout) node.applylayout();
				}
				treeData.selection="";
			}
		}
	';

 }


 function getJSShowSegment(){
 	return '
 		function showSegment(){
			parentnode='.$this->topFrame.'.get(this.parentid);
			parentnode.clear();
			we_cmd("loadFolder",treeData.table,parentnode.id,"","","",this.offset);
			toggleBusy(1);
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
			drawTree();
			return deleted;
		}
	';
 }


 function getJSContainer(){


 			$ts='this.tree_states=new Array();'."\n";
			foreach($this->tree_states as $k=>$v) $ts.='this.tree_states["'.$k.'"]="'.$v.'";'."\n";

 			$tl='this.tree_layouts=new Array();'."\n";
			foreach($this->tree_layouts as $k=>$v) $tl.='this.tree_layouts["'.$k.'"]="'.$v.'";'."\n";

			$nl='this.node_layouts=new Array();'."\n";
			foreach($this->node_layouts as $k=>$v) $nl.='this.node_layouts["'.$k.'"]="'.$v.'";'."\n";

 			return '
			function container(){
						this.len = 0;
						this.state=0;
						this.startloc=0;
						this.clear=containerClear;
						this.add = add;
						this.addSort = addSort;

						this.table="";

						this.selection="";
						this.selection_table="";
						this.selectnode=selectNode;
						this.unselectnode=unselectNode;

						this.setstate=setTreeState;
						this.getlayout=getTreeLayout;

						this.tree_image_dir="'.$this->tree_image_dir.'";
						this.tree_icon_dir="'.$this->tree_icon_dir.'";
						this.topFrame="'.$this->topFrame.'";
						this.treeFrame="'.$this->treeFrame.'";

						'.$ts.'
						'.$tl.'
						'.(isset($ns) ? $ns : "").'
						'.$nl.'

						this.check0_img=new Image();
						this.check0_img.src="'.$this->tree_image_dir.'check0.gif";

						this.check1_img=new Image();
						this.check1_img.src="'.$this->tree_image_dir.'check1.gif";

						return this;
 			}
			';
 }

 function getJSUpdateItem(){
 		return '
 		function updateEntry(attribs){
        	var ai = 1;
        	while (ai <= treeData.len) {
            	if (treeData[ai].id==attribs["id"]) {
					for(aname in attribs){
						treeData[ai][aname] = attribs[aname];
					}
             	}
             	ai++;
        	}
 		}
	';
 }

 function getJSDeleteItem(){
 	return '
 	function deleteEntry(id){
        var ai = 1;
        var ind=0;
        while (ai <= treeData.len) {

             if (treeData[ai].id==id) {
                 ind=ai;
                 break;
             }
             ai++;
        }
        if(ind!=0){
                ai = ind;
                while (ai <= treeData.len-1) {
                        treeData[ai]=treeData[ai+1];
                        ai++;
                }
                treeData.len[treeData.len]=null;
                treeData.len--;
                drawTree();
        }
 	}
	';
 }

 function getJSMakeFoldersOpenString(){
		return '
			function makeFoldersOpenString() {
				var op = "";
				for(i=1;i<=treeData.len;i++) {
					if(treeData[i].typ == "group" && treeData[i].open == 1)
						op +=  treeData[i].id+",";
				}
				op = op.substring(0,op.length-1);
				return op;
		}
		';
	}


 function getJSClearTree(){
 	  return '
		function clearTree(){
			treeData.clear();
		}
		';
 }

 // Function which control how tree contenet will be displayed

	function getHTMLContruct($onresize=""){

		$style_code="";
		foreach($this->styles as $st) $style_code.=$st."\n";

		//$table=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0","width"=>"100%"),1,1);
		//$table->setCol(0,0,array("id"=>"treetable","class"=>"top"),"<nobr>");

		return we_htmlElement::htmlHtml(
			we_htmlElement::htmlHead(
				WE_DEFAULT_HEAD.
				STYLESHEET.
				we_htmlElement::cssElement($style_code)
			).
			we_htmlElement::htmlBody(array(
														"bgcolor"=>"#F3F7FF",
														"link"=>"#000000",
														"alink"=>"#000000",
														"vlink"=>"#000000",
														"marginwidth"=>"0",
														"marginheight"=>"4",
														"leftmargin"=>"0",
														"topmargin"=>"4",
														"id"=>"treetable",
														"onresize"=>$onresize
													),
					""
			)
		);

	}

	function getJSDrawTree(){

 		return '
 		function drawTree(){

 			if (typeof('.$this->treeFrame.') != "undefined") {

 			} else {
 				window.setTimeout("drawTree()", 500);
 				return;
 			}
			var out="<table border=0 cellpadding=0 cellspacing=0 width=100%><tr><td class=\""+treeData.getlayout()+"\">\n<nobr>\n";
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

	function getJSDraw(){

		$custom_draw=array();
		$draw_code="";
		$custom_draw=$this->getJSCustomDraw();
		foreach($custom_draw as $ck=>$cv)
			if($draw_code=="")
				$draw_code='
										if(nf[ai].typ == "'.$ck.'"){
											'.$cv.'
										}';
			else
				$draw_code.='else if(nf[ai].typ == "'.$ck.'"){
											'.$cv.'
										}';


		return'
 		function draw(startEntry,zweigEintrag){
			var nf = search(startEntry);
			var ai = 1;
			var row="";
			while (ai <= nf.len) {
				row+=zweigEintrag;
				var pind=indexOfEntry(nf[ai].parentid);
				if(pind!=-1)
					if(treeData[pind].open==1){
						'.$draw_code.'
					}


				ai++;

			}

			return row;

 	}

	function zeichne(startEntry,zweigEintrag){
			draw(startEntry,zweigEintrag);
	}
	';

	}

	function getJSCustomDraw($click_handler=""){
		$out=array();

		if($click_handler=="")
			$click_handler='

				if(treeData.selection_table==treeData.table && nf[ai].id==treeData.selection) nf[ai].selected=1;

				if(treeData.state==treeData.tree_states["select"] && nf[ai].disabled!=1) {
					row+="<a href=\"javascript:"+treeData.topFrame+".checkNode(\'img_" + nf[ai].id + "\')\">";
				} else if(treeData.state==treeData.tree_states["selectitem"] && nf[ai].disabled!=1 && nf[ai].typ == "item") {
					row+="<a href=\"javascript:"+treeData.topFrame+".checkNode(\'img_" + nf[ai].id + "\')\">";
				} else if(treeData.state==treeData.tree_states["selectgroup"] && nf[ai].disabled!=1 && nf[ai].typ == "group") {
					row+="<a href=\"javascript:"+treeData.topFrame+".checkNode(\'img_" + nf[ai].id + "\')\">";
				} else {
					if(nf[ai].disabled!=1) {
						row+="<a name=\'_"+nf[ai].id+"\' href=\"javascript://\"  onDblClick=\"'.$this->topFrame.'.wasdblclick=1;clearTimeout('.$this->topFrame.'.tout);'.$this->topFrame.'.doClick(\'"+nf[ai].id+"\');return true;\" onClick=\"'.$this->topFrame.'.tout=setTimeout(\'if('.$this->topFrame.'.wasdblclick==0) '.$this->topFrame.'.doClick(\\\\\'"+nf[ai].id+"\\\\\'); else '.$this->topFrame.'.wasdblclick=0;\',300);return true;\" onMouseOver=\"'.$this->topFrame.'.info(\'ID:"+nf[ai].id+"\')\" onMouseOut=\"'.$this->topFrame.'.info(\' \');\">";
					}
				}

				row+="<img src="+treeData.tree_icon_dir+"/"+nf[ai].icon+" width=16 height=18 align=absmiddle border=0 alt=\"\">";

				if(nf[ai].disabled!=1) row+="</a>";

				if(treeData.state==treeData.tree_states["selectitem"] && (nf[ai].disabled!=1)) {
					var ci;

					if (nf[ai].typ == "group") {

						row+="<label style=\"cursor:pointer\" id=\"lab_"+nf[ai].id+"\""+(nf[ai].tooltip!="" ? " title=\""+nf[ai].tooltip+"\"" : "")+" class=\""+nf[ai].getlayout()+"\">&nbsp;" + nf[ai].text +"</label>";

					} else {

						if (nf[ai].checked==1) ci=treeData.tree_image_dir+"check1.gif";
						else ci=treeData.tree_image_dir+"check0.gif";
						row+="<a href=\"javascript:"+treeData.topFrame+".checkNode(\'img_" + nf[ai].id + "\')\"><img src=\""+ci+"\" width=16 height=18 align=absmiddle border=0 alt=\"\" name=\"img_"+nf[ai].id+"\"></a>";
						row+="<label style=\"cursor:pointer\" id=\"lab_"+nf[ai].id+"\""+(nf[ai].tooltip!="" ? " title=\""+nf[ai].tooltip+"\"" : "")+" class=\""+nf[ai].getlayout()+"\" onClick=\""+treeData.topFrame+".checkNode(\'img_" + nf[ai].id + "\')\">&nbsp;" + nf[ai].text +"</label>";

					}

				}
				else if(treeData.state==treeData.tree_states["selectgroup"] && (nf[ai].disabled!=1)) {
					var ci;

					if (nf[ai].typ == "item") {

						row+="<label style=\"cursor:pointer\" id=\"lab_"+nf[ai].id+"\""+(nf[ai].tooltip!="" ? " title=\""+nf[ai].tooltip+"\"" : "")+" class=\""+nf[ai].getlayout()+"\">&nbsp;" + nf[ai].text +"</label>";

					} else {

						if (nf[ai].checked==1) ci=treeData.tree_image_dir+"check1.gif";
						else ci=treeData.tree_image_dir+"check0.gif";
						row+="<a href=\"javascript:"+treeData.topFrame+".checkNode(\'img_" + nf[ai].id + "\')\"><img src=\""+ci+"\" width=16 height=18 align=absmiddle border=0 alt=\"\" name=\"img_"+nf[ai].id+"\"></a>";
						row+="<label style=\"cursor:pointer\" id=\"lab_"+nf[ai].id+"\""+(nf[ai].tooltip!="" ? " title=\""+nf[ai].tooltip+"\"" : "")+" class=\""+nf[ai].getlayout()+"\" onClick=\""+treeData.topFrame+".checkNode(\'img_" + nf[ai].id + "\')\">&nbsp;" + nf[ai].text +"</label>";

					}

				}
				else if(treeData.state==treeData.tree_states["select"] && (nf[ai].disabled!=1)) {
					var ci;
					if (nf[ai].checked==1) ci=treeData.tree_image_dir+"check1.gif";
					else ci=treeData.tree_image_dir+"check0.gif";

					row+="<a href=\"javascript:"+treeData.topFrame+".checkNode(\'img_" + nf[ai].id + "\')\"><img src=\""+ci+"\" width=16 height=18 align=absmiddle border=0 alt=\"\" name=\"img_"+nf[ai].id+"\"></a>";

					row+="<label style=\"cursor:pointer\" id=\"lab_"+nf[ai].id+"\""+(nf[ai].tooltip!="" ? " title=\""+nf[ai].tooltip+"\"" : "")+" class=\""+nf[ai].getlayout()+"\" onClick=\""+treeData.topFrame+".checkNode(\'img_" + nf[ai].id + "\')\">&nbsp;" + nf[ai].text +"</label>";

				}
				else{
					if(nf[ai].disabled!=1)
							row+="<a name=\'_"+nf[ai].id+"\' href=\"javascript://\"  onDblClick=\"'.$this->topFrame.'.wasdblclick=1;clearTimeout('.$this->topFrame.'.tout);'.$this->topFrame.'.doClick(\'"+nf[ai].id+"\');return true;\" onClick=\"'.$this->topFrame.'.tout=setTimeout(\'if('.$this->topFrame.'.wasdblclick==0) '.$this->topFrame.'.doClick(\\\\\'"+nf[ai].id+"\\\\\'); else '.$this->topFrame.'.wasdblclick=0;\',300);return true;\" onMouseOver=\"'.$this->topFrame.'.info(\'ID:"+nf[ai].id+"\')\" onMouseOut=\"'.$this->topFrame.'.info(\' \');\">";

					row+="<label style=\"cursor:pointer\" id=\"lab_"+nf[ai].id+"\""+(nf[ai].tooltip!="" ? " title=\""+nf[ai].tooltip+"\"" : "")+" class=\""+nf[ai].getlayout()+"\">&nbsp;" + nf[ai].text +"</label>";
					if(nf[ai].disabled!=1) row+="</a>";
				}
				row+="&nbsp;&nbsp;<br>\n";

		';

		$out["item"]='
					if(ai == nf.len) row+="&nbsp;&nbsp;<img src="+treeData.tree_image_dir+"kreuzungend.gif width=19 height=18 align=absmiddle border=0>";
					else
						row+="&nbsp;&nbsp;<img src="+treeData.tree_image_dir+"kreuzung.gif width=19 height=18 align=absmiddle border=0>";

					'.$click_handler.'

		';

		$out["group"]='

					var newAst = zweigEintrag;

					var zusatz = (ai == nf.len) ? "end" : "";
					var oc_img;
					var oc_js;

					if (nf[ai].open == 0) oc_img=treeData.tree_image_dir+"auf"+zusatz+".gif";
					else oc_img=treeData.tree_image_dir+"zu"+zusatz+".gif";

					if(nf[ai].disabled!=1) oc_js=treeData.topFrame+".setScrollY();"+treeData.topFrame+".openClose(\'" + nf[ai].id + "\')\"";
					else oc_js="//";

					oc_js=treeData.topFrame+".setScrollY();"+treeData.topFrame+".openClose(\'" + nf[ai].id + "\')\"";

					row+="&nbsp;&nbsp;<a href=\"javascript:"+oc_js+" border=0><img src="+oc_img+" width=19 height=18 align=absmiddle border=0 Alt=\"\"></a>";

					var folder_icon;
					folder_icon="folder"+(nf[ai].open==1 ? "open" : "")+(nf[ai].disabled==1 ? "_disabled" : "")+".gif";

					nf[ai].icon=folder_icon;

					'.$click_handler.'

					if (nf[ai].open==1){
						if(ai == nf.len) newAst = newAst + "<img src="+treeData.tree_image_dir+"leer.gif width=19 height=18 align=absmiddle border=0>";
						else newAst = newAst + "<img src="+treeData.tree_image_dir+"strich2.gif width=19 height=18 align=absmiddle border=0>";
						row+=draw(nf[ai].id,newAst);
					}
		';

		$out["threedots"]='
					if(ai == nf.len)
						row+="&nbsp;&nbsp;<img src="+treeData.tree_image_dir+"kreuzungend.gif width=19 height=18 align=absmiddle border=0>";
					else
						row+="&nbsp;&nbsp;<img src="+treeData.tree_image_dir+"kreuzung.gif width=19 height=18 align=absmiddle border=0>";

						row+="<a name=\'_"+nf[ai].id+"\' href=\"javascript://\"  onClick=\"'.$this->topFrame.'.setSegment(\'"+nf[ai].id+"\');return true;\">";
						row+="<img src="+treeData.tree_image_dir+"/"+nf[ai].icon+" width=100 height=7 align=absmiddle border=0 alt=\"\">";
						row+="</a>";
						row+="&nbsp;&nbsp;<br>\n";
		';

		return $out;

	}

	function getJSLoadTree($treeItems){
			$js="";
			$out="";
			$js="var attribs=new Array();\n";
			foreach($treeItems as $item){
				$js.="		if(".$this->topFrame.".indexOfEntry('".$item["id"]."')<0){ \n";
				foreach($item as $k=>$v)
				$js.='
							attribs["'.strtolower($k).'"]=\''.addslashes($v).'\';';
				$js.='
					'.$this->topFrame.'.treeData.addSort(new '.$this->topFrame.'.node(attribs));
				}
				';
			}
			$js.=$this->topFrame.'.drawTree();';

			return $js;
	}

	function getJSInfo(){
		return '
			function info(text) {
			}
		';

	}

	function setItemsCount($count){
		$this->default_segment=$count;
	}

}

?>
