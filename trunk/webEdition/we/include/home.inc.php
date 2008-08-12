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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlTable.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/cockpit.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/SEEM.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_widget.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_widgets/cfg.inc.php");

protect();
htmlTop();
print STYLESHEET;

print "
<style type=\"text/css\">
.rssDiv, .rssDiv *{
	background-color: transparent;
	color: black;
	font-size: ".(($SYSTEM=="MAC")?"10px":(($SYSTEM=="X11")?"12px":"11px")).";
	font-family: ".$l_css["font_family"]." ! important;
}


.rssDiv a {
	color: black;
	text-decoration:none;
}
</style>";

if (we_hasPerm("CAN_SEE_QUICKSTART") ) {
	
	$iLayoutCols = isset($_SESSION["prefs"]["cockpit_amount_columns"]) ? $_SESSION["prefs"]["cockpit_amount_columns"] : 3;
	$bResetProps = ($_REQUEST["we_cmd"][0] == "reset_home")? true : false;
	
	if (!$bResetProps && $iLayoutCols) {
		
		$aDatTblPref = getPref("cockpit_dat"); // array as saved in the prefs
		$aDat = (!empty($aDatTblPref))? unserialize($aDatTblPref) : $aCfgProps; // 
		$aTrf = array_pop($aDat);
		if (sizeof($aDat)>$iLayoutCols) {
			while (sizeof($aDat)>$iLayoutCols) {
				$aDelCol = array_pop($aDat);
				foreach ($aDelCol as $aShiftWidget) {
					array_push($aDat[sizeof($aDat)-1],$aShiftWidget);
				}
			}
			setUserPref("cockpit_dat",serialize($aDat));
		}
		$iDatLen = sizeof($aDat);
		
	} else {
		
		$iLayoutCols = $iDefCols;
		$_SESSION["prefs"]["cockpit_amount_columns"] = $iDefCols;
		
		setUserPref("cockpit_amount_columns",$iDefCols);
		setUserPref("cockpit_dat",serialize($aCfgProps));
		$aDat = $aCfgProps;
		$aTrf = array_pop($aDat);
		$iDatLen = sizeof($aDat);
		
	}

	function in_array_recursive($value, $array) {
		foreach ($array as $item) {
			if (!is_array($item)) {
				if ($item == $value) return true;
				else continue;
			}
			if (in_array($value, $item)) return true;
			else if (in_array_recursive($value, $item)) return true;
		}
		return false;
	}
?>
<script language="JavaScript" type="text/javascript">
top.cockpitFrame=top.cockpitFrame=top.weEditorFrameController.getActiveDocumentReference();
var _EditorFrame = top.weEditorFrameController.getEditorFrame(window.name);
_EditorFrame.initEditorFrameData(
	{
		"EditorType":"cockpit",
		"EditorDocumentText":"<?php echo $l_cockpit['cockpit']; ?>",
		"EditorDocumentPath":"Cockpit",
		"EditorContentType":"cockpit",
		"EditorEditCmd":"open_cockpit"
	}
);

var quickstart=true;
var _iInitCols=_iLayoutCols=<?php echo $iLayoutCols; ?>;
var _bDgSave=false;
var bInitDrag=false;
var oTblWidgets=null;
<?php echo $jsPrefs; ?>

function gel(id_){ 
	return document.getElementById ? document.getElementById(id_) : null;
}

for(var _file_ in oCfg.js_load_){
	document.write('<scr'+'ipt src="<?php echo JS_DIR;?>'+oCfg.js_load_[_file_]+'.js"></scri'+'pt>');
}

jsCss='<style type="text/css">';
for(var _cls_ in oCfg.color_scheme_){
	jsCss+='.bgc_'+_cls_+'{background-color:'+oCfg.color_scheme_[_cls_]+';}';
}
jsCss+='.wildcard{position:relative;width:1px;height:1px;}'+
	'.le_widget{margin-bottom:10px;background-color:'+oCfg.color_scheme_['white']+';}'+
	'.label{font-family:'+oCfg.label_['font-family']+';font-size:'+oCfg.label_['font-size']+'px;color:'+oCfg.label_['color']+';font-weight:'+oCfg.label_['font-weight']+';}'+
	'#widgets{position:absolute;top:27px;left:45px;z-index:3;}'+
	'#le_tblWidgets{table-layout:fixed;}';
for(i=1;i<=10;i++){
	jsCss+='.cls_'+i+'_collapse{width:'+oCfg.general_['cls_collapse']+'px;vertical-align:top;}'+
		'.cls_'+i+'_expand{width:'+oCfg.general_['cls_expand']+'px;vertical-align:top;}';
	}
jsCss+='</style>';
document.write(jsCss);

function getColumnAsoc(id){
	var oNode=gel(id);
	var iNodeLen=oNode.childNodes.length;
	var aNodeSet=new Array();
	var k=0;
	for(var i=0;i<iNodeLen;i++){
		var oChild=oNode.childNodes[i];
		if(oChild.tagName=='DIV'&&oChild.className=='le_widget'){
			var sAttrId=oChild.getAttribute('id');
			aNodeSet[k]={'type':gel(sAttrId+'_type').value,'cls':gel(sAttrId+'_cls').value,
					'res':gel(sAttrId+'_res').value,'csv':gel(sAttrId+'_csv').value,'id':sAttrId}
			k++;
		}
	}
	return aNodeSet;
}

function getWidgetProps(p){
	var oProps=new Object();
	for(i=1;i<=_iLayoutCols;i++){
		var node=gel('c_'+i);
		for(var j=0;j<node.childNodes.length;j++){
			var child=node.childNodes[j];
			if(child.tagName=='DIV'&&child.className=='le_widget'){
				var attr_id=child.getAttribute('id');
				oProps[attr_id]=gel(attr_id+'_'+p).value;
			}
		}
	}
	return oProps;
}

function isHot(){
	var ix=['type','cls','res','csv'];
	var ix_len=ix.length;
	var dat=[
<?php
	$j = 0;
	$count_j = $iDatLen;
	foreach($aDat as $d){
		$i = 0;
		$count_i = sizeof($d);
		echo "\t\t[";
		reset($d);
		while(list(,$v) = each($d)) {
			$i++;
 		  echo "{'type':'".$v[0]."','cls':'".$v[1]."','res':".$v[2].",'csv':'".$v[3]."'}".(($i < $count_i)? "," : "");
		}
		$j++;
		echo "]".(($j < $count_j)? "," : "")."\n";
	}
?>
	];
	if(_iInitCols!=_iLayoutCols)return true;
	for(var i=0;i<_iLayoutCols;i++){
		var asoc=getColumnAsoc('c_'+(i+1));
		var asoc_len=asoc.length;
		if((typeof(dat[i])=='undefined'&&!!asoc_len)||(typeof(dat[i])!='undefined'&&asoc_len!=dat[i].length)){
			return true;
		}
		for(var k=0;k<asoc_len;k++){
			for(var j=0;j<ix_len;j++){
				if(typeof(dat[i][k][ix[j]])=='undefined'||asoc[k][ix[j]]!=dat[i][k][ix[j]]){
					return true;
				}
			}
		}
	}
	if(_isHotTrf){
		return true;
	}
	return false;
}

function modifyLayoutCols(iCols){
	if(iCols>_iLayoutCols){
		var iAppendCols=iCols-_iLayoutCols;
		var oTbl=gel('le_tblWidgets');
		var oRow=gel('rowWidgets');
		for(var i=1;i<=iAppendCols;i++){
			var oSpacer=document.createElement('TD');
			oSpacer.setAttribute('id','spacer_'+(_iLayoutCols+(i-1)));
			oSpacer.setAttribute('style', 'width:5px;');
			oSpacerTxt=document.createTextNode(' ');
			var oCell=document.createElement('TD');
			oCell.setAttribute('id','c_'+(_iLayoutCols+i));
			oCell.setAttribute('class','cls_'+(_iLayoutCols+i)+'_collapse');
			var oWildcard=document.createElement('DIV');
			oWildcard.setAttribute('class','wildcard');
			oCell.appendChild(oWildcard);
			oSpacer.appendChild(oSpacerTxt);
			oRow.appendChild(oSpacer);
			oRow.appendChild(oCell);
			gel( 'spacer_'+(_iLayoutCols+(i-1)) ).style.width="5px";
		}
		_iLayoutCols+=iAppendCols;
		le_dragInit(oTbl);
	}else{
		var iRemoveCols=_iLayoutCols-iCols;
		var k=parseInt(iCols)+1;
		while(k<=_iLayoutCols){
			var aSoc=getColumnAsoc('c_'+k);
			var aSocLen=aSoc.length;
			for(var i=0;i<aSocLen;i++){
				createWidget(aSoc[i]['type'],0,iCols);
			}
			k++;
		}
		for(var i=_iLayoutCols;i>iCols;i--){
			var asoc=getColumnAsoc('c_'+i);
			for(var j=0;j<asoc.length;j++){
				gel(asoc[j]['id']).parentNode.removeChild(gel(asoc[j]['id']));
			}
			var oRemoveCol=gel('c_'+i);
			oRemoveCol.parentNode.removeChild(oRemoveCol);
			var oSpacer=gel('spacer_'+(i-1));
			oSpacer.parentNode.removeChild(oSpacer);
		}
		_iLayoutCols-=iRemoveCols;
		le_dragInit(gel('le_tblWidgets'));
	}
}

function setPrefs(_pid,sBit,sTitleEnc){
	var iframeEl = document.getElementById(_pid+"_inline");

	var iframeWin;

	if (iframeEl.contentWindow) {
    	iframeWin = iframeEl.contentWindow;
	} else if (iframeEl.contentDocument) { // Dom Level 2
	    iframeWin = iframeEl.contentDocument.defaultView;
	} else {  // Safari
    	iframeWin = frames.we_wysiwyg_lng_frame;
	}

	iframeWin._sInitProps=sBit;
	iframeWin._ttlB64Esc=sTitleEnc;
}

function saveSettings(){
	var aDat=new Array();
	for(var i=0;i<_iLayoutCols;i++){
		var aSoc=getColumnAsoc('c_'+(i+1));
		aDat[i]=new Array();
		for(var iPos in aSoc){
			aDat[i][iPos]=new Array();
			var aRef=['type','cls','res','csv'];
			for(var tp in aSoc[iPos]){
				var idx=findInArray(aRef,tp);
				if(idx>-1){
					aDat[i][iPos][idx]=aSoc[iPos][tp];
				}
			}
		}
	}
	aDat[_iLayoutCols]=new Array();
	var topRssFeedsLen=_trf.length;
	for(var i=0;i<topRssFeedsLen;i++){
		aDat[_iLayoutCols][i]=[_trf[i][0],_trf[i][1]];
	}
	if(_bDgSave){
		var sDg='';
		for(var i=0;i<aDat.length;i++){
			sDg+=i+":\n";
			for(var j=0;j<aDat[i].length;j++){
				sDg+="\t"+aDat[i][j]+"\n";
			}
		}
		// interne Meldung - debug
		alert(sDg);
	}
	
	fo=self.document.forms['we_form'];
	fo.elements['we_cmd[1]'].value = serialize(aDat);
	top.YAHOO.util.Connect.setForm(fo); 
	var cObj = top.YAHOO.util.Connect.asyncRequest('POST', '<?php echo WEBEDITION_DIR; ?>we/include/we_widgets/cmd.inc.php', top.weDummy);
}

function resizeIdx(a,id){
	var res=gel(id+'_res').value;
	switch(a){
		case 'swap':
			gel(id+'_res').value=(res==0)?1:0;
			gel(id+'_icon_resize').title=(res==0)?'<?php echo $l_cockpit["reduce_size"].'\':\''.$l_cockpit["increase_size"]; ?>';
		break;
		case 'get':
			return res;
		break;
	}
}

function hasExpandedWidget(node){
	for(var i=0;i<node.childNodes.length;i++){
		var currentChild=node.childNodes[i];
		if(currentChild.tagName=='DIV' && currentChild.className=='le_widget'){
			if(gel(currentChild.getAttribute('id')+'_res').value==1){
				return true;
			}
		}
	}
	return false;
}

function jsStyleCls(evt,obj,cls1,cls2){
	switch(evt){
		case 'swap':
			obj.className=!jsStyleCls('verify',obj,cls1)?obj.className.replace(cls2,cls1):obj.className.replace(cls1,cls2);
		break;
		case 'add':
			if(!jsStyleCls('verify',obj,cls1)){
				obj.className+=obj.className?' '+cls1:cls1;
			}
		break;
		case 'remove':
			var rem=obj.className.match(' '+cls1)?' '+cls1:cls1;
			obj.className=obj.className.replace(rem,'');
		break;
		case 'verify':
			return new RegExp('\\b'+cls1+'\\b').test(obj.className)
		break;
	}
}

function updateJsStyleCls(){
	for(var i=1;i<=_iLayoutCols;i++){
		var oCol=gel('c_'+i);
		if(hasExpandedWidget(oCol)){
			cls1='cls_'+i+'_expand';
			cls2='cls_'+i+'_collapse';
		} else{
			cls1='cls_'+i+'_collapse';
			cls2='cls_'+i+'_expand';
		}
		if(!jsStyleCls('verify',oCol,cls1)){
			if(jsStyleCls('verify',oCol,cls2)){
				jsStyleCls('swap',oCol,cls2,cls1);
			} else{
				jsStyleCls('add',oCol,cls1);
			}
		}
	}
}

function getLabel(id){
	return strip_tags(gel(id+'_prefix').value+gel(id+'_postfix').value);
}

function setLabel(id,prefix,postfix){
	var el_label=gel(id+'_lbl');
	var w=parseInt(el_label.style.width);
	var suspensionPts='';
	if(typeof(prefix)=='undefined'||typeof(postfix)=='undefined'){
		label=getLabel(id);
	} else{
		label=strip_tags(prefix+postfix);
		label = label.replace(/\[\[/g,"<");
		label = label.replace(/\]\]/g,">");
	}
	if (label.indexOf("<span") == -1) {
		while(getDimension(label+suspensionPts,'label').width+10>w){
			label=label.substring(0,label.length-1);
			suspensionPts='...';
		}
	}
	el_label.innerHTML=label+suspensionPts;
}

function setWidth(id,w){
	gel(id).style.width=w;
}

function setWidgetWidth(id,w){
	var rudebox={'_inline':w,'_bx':w+(2*oCfg.general_['wh_edge']),'_tb':w+(2*oCfg.general_['wh_edge']),
		'_h':w-oCfg.general_['w_icon_bar'],'_lbl':w-(2*oCfg.general_['w_icon_bar'])};
	for(var v in rudebox){
		setWidth(id+v,rudebox[v]);
	}
}

function resizeWidget(id){
	
	var _type=gel(id+'_type').value;
	var w=(resizeIdx('get',id)==0)?oCfg.general_['w_expand']:oCfg.general_['w_collapse'];
	resizeIdx('swap',id);
	setWidgetWidth(id,w)
	gel(id+'_lbl').innerHTML='';
	setLabel(id);
	updateJsStyleCls();
	
	initWidget(id); // resize widget, etc.
	
}

function initWidget( _id ) {
	
	if (gel(_id+'_type').value == "sct") {
		
		var _width = "100%";
		if ( resizeIdx('get', _id) == 1 ) {
			_width = "48%";
		}
		
		var _elem = gel(_id);
		var _inlineDivs = _elem.getElementsByTagName('div');
		
		for (i=0;i<_inlineDivs.length;i++) {
			if (_inlineDivs[i].className == "sct_row") {
				_inlineDivs[i].style.width = _width;
				
			}
		}
	}
}

function setTheme(wizId,wizTheme){
	var objs=[gel(wizId+'_wrapper'),gel(wizId+'_vll'),gel(wizId+'_vlr'),gel(wizId+'_bottom'),
		gel(wizId+'_img_cl'),gel(wizId+'_img_cr')];
	var clsElement=gel(wizId+'_cls');
	var replaceClsName=clsElement.value;
	clsElement.value=wizTheme;
	for(var o in objs){
		if(!objs[o].src){
			jsStyleCls('swap',objs[o],objs[o].className,'bgc_'+wizTheme);
		}else{
			var _source=objs[o].src;
			objs[o].src=_source.replace(replaceClsName,wizTheme);
		}
	}
	var _bgObjs=[gel(wizId+'_lbl_mgnl'),gel(wizId+'_lbl'),gel(wizId+'_lbl_mgnr')];
	for(var o in _bgObjs){
		_bgObjs[o].style.background='url(<?php echo IMAGE_DIR; ?>pd/header_'+wizTheme+'.gif)';
	}
}

function setOpacity(sId,degree){
	var obj=gel(sId);
	obj.style.opacity=(degree/100);
	obj.style.MozOpacity=(degree/100);
	obj.style.KhtmlOpacity=(degree/100);
	obj.style.filter='alpha(opacity='+degree+')';
}

function fadeTrans(wizId,start,end,ms){
	var v=Math.round(ms/100);
	var t=0;
	if(start>end){
		for(i=start;i>=end;i--){
			var obj=gel(wizId);
			setTimeout('setOpacity("'+wizId+'",'+i+')',(t*v));
			t++;
		}
	}else if(start<end){
		for(i=start;i<=end;i++){
			setTimeout('setOpacity("'+wizId+'",'+i+')',(t*v));
			t++;
		}
	}
}

function toggle(wizId,wizType,prefix,postfix){
	var defH=eval('oCfg.'+wizType+'_props_["height"]');
	var defRes=eval('oCfg.'+wizType+'_props_["res"]');
	var defW=(!!defRes)?oCfg.general_['w_expand']:oCfg.general_['w_collapse'];
	var asoc={'width':{'_inline':defW,'_bx':defW+(2*oCfg.general_['wh_edge']),'_tb':defW+(2*oCfg.general_['wh_edge']),
		'_h':defW-oCfg.general_['w_icon_bar'],'_lbl':defW-(2*oCfg.general_['w_icon_bar'])},
		'height':{'_bx':defH+(2*oCfg.general_['wh_edge']),'_vline_l':defH,'_vline_r':defH}};
	var props={'prefix':prefix,'postfix':postfix,'type':wizType,'res':defRes};
	for(var att_name in asoc){
		for(var v in asoc[att_name]){
			eval('gel(wizId+v).style.'+att_name+'=asoc[att_name][v]');
		}
	}
	for(var p in props){
		gel(wizId+'_'+p).value=props[p];
	}
	if(defRes==1&&!jsStyleCls('verify',gel('c_1'),'cls_1_expand')){
		updateJsStyleCls();
	}
}

function pushContent(wizType,wizId,cNode,prefix,postfix,sCsv){
	var cNodeReceptor=gel(wizId+'_content');
	var wizTheme=eval("oCfg."+wizType+"_props_['cls']");
	cNodeReceptor.innerHTML=cNode;
	gel(wizId+'_csv').value=sCsv;
	toggle(wizId,wizType,prefix,postfix);
	setLabel(wizId);
	if(wizTheme!='white'){
		setTheme(wizId,wizTheme);
	}
	gel(wizId).style.display='block';
	if(!!oCfg.blend_['fadeIn']){
		fadeTrans(wizId,0,100,oCfg.blend_['v']);
	}
}

function createWidget(typ,row,col){
	// for IE
	if(typ=='pad') {
		document.getElementById('c_'+col).className = 'cls_'+col+'_expand';
	}
	//EOF for IE
	var domNode=gel('c_'+col);
	var asoc=getColumnAsoc('c_'+col);
	var properties=getWidgetProps('type');
	var numWidgets=sizeof(properties);
	var idx=numWidgets+1;
	while(!!gel('m_'+idx)){
		idx++;
	}
	var new_id='m_'+idx;
	var cloneSampleId='divClone';
	for(var currentId in properties){
		if(properties[currentId]==typ){
			cloneSampleId=currentId;
			break;
		}
	}
	var nodeToClone=gel(cloneSampleId);
	var regex=cloneSampleId;
	var re=new RegExp(((cloneSampleId=='divClone')?new_id+'|clone':cloneSampleId),'g');
	var sClonedNode = nodeToClone.innerHTML.replace(re,new_id);
	if(cloneSampleId=='divClone'){
		sClonedNode=sClonedNode.replace(/_reCloneType_/g,typ);
	}
	var divClone=document.createElement('DIV');
	divClone.setAttribute('id',new_id);
	divClone.setAttribute('class','le_widget');
	divClone.className = 'le_widget'; // for IE
	divClone.setAttribute('style','position:relative');
	divClone.innerHTML=sClonedNode;
	if(!!oCfg.blend_['fadeIn']){
		divClone.style.display='none';
	}
	if(asoc.length && row){
		domNode.insertBefore(divClone,gel(asoc[row-1]['id']));
		
	}else{ // add to empty col - before wildcard!!
		var _td = gel("c_" + col);
		_td.insertBefore(
			divClone,
			_td.childNodes[0]
		);
	}
	if(findInArray(_noResizeTypes,typ)>-1){
		var oPrc=gel(new_id+'_ico_prc');
		var oPc=gel(new_id+'_ico_pc');
		if (oPrc) {
			oPrc.parentNode.removeChild(oPrc);
		}
		if (oPc) {
			oPc.style.display='block';
		}
	}
	if(!!oCfg.blend_['fadeIn']){
		setOpacity(divClone.id,0);
	}
	if(cloneSampleId!='divClone'){
		divClone.style.display='block';
		if(!!oCfg.blend_['fadeIn']){
			fadeTrans(new_id,0,100,oCfg.blend_['v']);
		}
	}else{
		top.we_cmd('edit_home','add',typ,new_id);
	}
	tableNode=gel('le_tblWidgets');
	le_dragInit(tableNode);
	saveSettings();
}

function removeWidget(wizId){
	var remove=confirm('<?php echo $l_cockpit["pre_remove"]; ?>"'+getLabel(wizId)+'"<?php echo $l_cockpit["post_remove"]; ?>');
	if(remove==true){
		gel(wizId).parentNode.removeChild(gel(wizId));
		updateJsStyleCls();
	}
	saveSettings();
}

function implode(arr,delimeter,enclosure){
	if(typeof(delimeter)=='undefined'){delimeter=',';}
	if(typeof(enclosure)=='undefined'){enclosure="'";}
	var out='';
	for(var i=0;i<arr.length;i++){
		if(i!=0){out+=delimeter;}
		out+=enclosure+escape(arr[i])+enclosure;
	}	
	return out;
}

function composeUri(args){
	var uri='<?php echo WEBEDITION_DIR; ?>we/include/we_widgets/dlg/'+args[0]+'.inc.php?';
	for(var i=1;i<args.length;i++){
		uri+='we_cmd['+(i-1)+']='+args[i];
		if(i<(args.length-1)){
			uri+='&';
		}
	}
	return uri;
}

/** Enable disable the spinning wheel ... **/

	/**
	 * show the spinning wheel for a widget
	 */
	function showLoadingSymbol(elementId) {
		
		var saf=navigator.userAgent.match(/Safari/i);
		
		if (!saf) {
			
			if (!gel('rpcBusyClone_' + elementId)) { // only show ONE loading symbol per widget
			
				var clone=gel('rpcBusy').cloneNode(true);
				var wpNode=gel(elementId+'_wrapper');
				var ctNode=gel(elementId+'_content');
		
				ctNode.style.display='none';
				wpNode.style.textAlign='center';
				wpNode.style.verticalAlign='middle';
				wpNode.insertBefore(clone,ctNode);
				clone.id="rpcBusyClone_" + elementId;
				clone.style.display='inline';
			}
		}
	}
	
	
	/**
	 * hide the spinning wheel for a widget
	 */
	function hideLoadingSymbol( elementId ) {
		
		var saf=(navigator.userAgent.toLowerCase().indexOf('safari')>-1)?1:0;
		
		if(!saf && gel('rpcBusyClone_' + elementId)){
			var oWrapper=gel(elementId+'_wrapper');
			oWrapper.style.textAlign='left';
			oWrapper.style.verticalAlign='top';
			gel('rpcBusyClone_' + elementId).parentNode.removeChild(gel('rpcBusyClone_' + elementId));
		}
		
	}

/** async REQUEST for preview **/
	
	function updateWidgetContent(widgetType, widgetId, contentData, titel) {
		
		var docIFrm,iFrmScr;
		var oInline = gel(widgetId+'_inline'); // object-inline
	
		var saf=(navigator.userAgent.toLowerCase().indexOf('safari')>-1)?1:0;
		if(!saf) {
			oInline.style.display='block';
		}
		if(widgetType=='pad'){
			if(oInline.contentDocument){
				docIFrm=oInline.contentDocument;
				iFrmScr=oInline.contentWindow;
			}else if(oInline.contentWindow){
				docIFrm=oInline.contentWindow.document;
				iFrmScr=oInline.contentWindow;
			}else if(oInline.document){
				docIFrm=oInline.document;
				iFrmScr=oInline;
			}else{
				return true;
			}
		}
		
		var oContent=gel(widgetId+'_content');
		oContent.style.display='block';
		hideLoadingSymbol(widgetId);
		
		eval(((widgetType=='pad')?'docIFrm.getElementById(widgetType)':'oInline')+ '.innerHTML=contentData;');
		if(widgetType=='pad')iFrmScr.calendarSetup();
		setLabel(widgetId,titel,'');
		initWidget( widgetId );
		
	}
	
	/**
	 * executes a real AJAX command, instead of using an iframe
	 * the received ajax-response will use the function "updateWidgetContent" to replace the content of the widget
	 * @param param_1 string: individual foreach widget
	 * @param initCfg string: configuration (position, etc)
	 * @param param_3 string: 
	 * @param param_4 string: 
	 * @param titel string: titel of the widget
	 * @param widgetId string: id fo widget
	 * 
	 */
	function executeAjaxRequest( param_1, initCfg, param_3, param_4, titel, widgetId ) {
		
		// determine type of the widget
		var widgetType = gel( widgetId + '_type').value;
		
		showLoadingSymbol( arguments[5] );
		
		var args = '';
		for(var i = 0; i < arguments.length; i++) {
			args += '&we_cmd['+i+']='+escape(arguments[i]);
		}
		
		var _cmdName = null;
		
		switch ( widgetType ) {
			case "rss":
				_cmdName = "GetRss";
			break;
		}
		top.YAHOO.util.Connect.asyncRequest( 'GET', '/webEdition/rpc/rpc.php?cmd=' + _cmdName + '&cns=widgets' + args + '&weSessionId=<?php print session_id(); ?>' , ajaxCallback );
		
	}
	
		var ajaxCallback = {
			success: function(o) {
				if(typeof(o.responseText) != 'undefined' && o.responseText != '') {
					var weResponse = false;
					try {
						eval( o.responseText );
						if ( weResponse ) {
							updateWidgetContent( weResponse.widgetType, weResponse.widgetId, weResponse.data, weResponse.titel );
							
						}
					} catch (exc){
						alert("Could not complete the ajax request");
					}
				}
			},
			failure: function(o) {
				alert("Could not complete the ajax request");
				
			}
		}
	
	/**
	 * Old ajax functions using an iframe
	 */
	function rpc(){
		
		if(!document.createElement){
			return true;
		}
		var docIFrm;
		var sType=gel(arguments[5]+'_type').value;
		showLoadingSymbol( arguments[5] );
		
		// temporaryliy add a form submit the form and save all !!
			// start bugfix #1145
			var _tmpForm = document.createElement("form");
			document.getElementsByTagName("body")[0].appendChild(_tmpForm);
			var path=(sType!='rss'&&sType!='pad'&&sType!='plg'&&sType!='sct')?'dlg/'+arguments[6]:'mod/'+sType;
			_tmpForm.id = "_tmpSubmitForm";
			_tmpForm.method = "POST";
			_tmpForm.action = '<?php echo WEBEDITION_DIR; ?>we/include/we_widgets/'+path+'.inc.php';
			_tmpForm.target = "RSIFrame";
			for(var i=0;i<arguments.length;i++){
				var _tmpField = document.createElement('input');
				_tmpForm.appendChild(_tmpField);
				
				_tmpField.name = "we_cmd[" + i + "]";
				_tmpField.value = unescape(arguments[i]);
				_tmpField.style.display = "none";
			}
			_tmpForm.submit();
			// remove form after submitting everything
			document.getElementsByTagName("body")[0].removeChild( document.getElementById("_tmpSubmitForm") );
			
			return false;
			// end bugfix #1145
	}
	
	
	function rpcHandleResponse(sType,sObjId,oDoc,sCsvLabel){
		
	
		var docIFrm,iFrmScr;
		var oInline=gel(sObjId+'_inline');
	
		var saf=(navigator.userAgent.toLowerCase().indexOf('safari')>-1)?1:0;
		if(!saf) {
			oInline.style.display='block';
		}
		
		if(sType=='rss'||sType=='pad'){
			if(oInline.contentDocument){
				docIFrm=oInline.contentDocument;
				iFrmScr=oInline.contentWindow;
			}else if(oInline.contentWindow){
				docIFrm=oInline.contentWindow.document;
				iFrmScr=oInline.contentWindow;
			}else if(oInline.document){
				docIFrm=oInline.document;
				iFrmScr=oInline;
			}else{
				return true;
			}
		}
		var oContent=gel(sObjId+'_content');
		oContent.style.display='block';
		
		hideLoadingSymbol(sObjId);
		
		eval(((sType=='rss'||sType=='pad')?'docIFrm.getElementById(sType)':'oInline')+ '.innerHTML=oDoc.innerHTML;');
		if(sType=='pad')iFrmScr.calendarSetup();
		setLabel(sObjId,sCsvLabel,'');
		
		initWidget( sObjId );
	}

var _propsDlg=new Array();
function propsWidget(){
	eval('var iHeight=oCfg.'+arguments[0]+'_props_["iDlgHeight"]');
	var uri=composeUri(arguments);
	eval('_propsDlg["'+arguments[1]+'"]=window.open(uri,arguments[1],"location=0,status=1,scrollbars=0,width='+oCfg.general_['iDlgWidth']+',height='+iHeight+'")');
}

function closeAllModalWindows() {
	try{
		for (dialog in _propsDlg) {
			_propsDlg[dialog].close();
		}
	} catch(e){
		
	}
}

<?php
	echo "\n_isHotTrf=false;\n";
	echo "var _trf=new Array();\n";
	$iCurrRssFeed = 0;
	foreach($aTrf as $aRssFeed){
		echo "_trf[".$iCurrRssFeed."]=['".$aRssFeed[0]."','".$aRssFeed[1]."'];\n";
		$iCurrRssFeed++;
	}
	$_transact = md5(uniqid(rand()));

	echo "function newMessage(username){\n";
	if (defined("WE_MESSAGING_MODULE_PATH")) {
		echo "	new jsWindow('" . WE_MESSAGING_MODULE_PATH . "messaging_newmessage.php?we_transaction=" . $_transact . "&mode=u_'+escape(username),'messaging_new_message',-1,-1,670,530,true,false,true,false);\n";
	}
	echo "}";
?>

function setMsgCount(num){
	if(gel('msg_count')){
		gel('msg_count').innerHTML='<b>'+num+'</b>';
	}
}

function setTaskCount(num){
	if(gel('task_count')){
		gel('task_count').innerHTML='<b>'+num+'</b>';
	}
}
<?php 

if(in_array_recursive('usr', $aDat) && defined("USER_TABLE")) { 

?>

function setUsersOnline(num){
	if(gel('num_users')){
		gel('num_users').innerHTML=num;
	}
}

function setUsersListOnline(users){
	if(gel('users_online')){
		gel('users_online').innerHTML=users;
	}
}
<?php } ?>


function getUser(){
	var url = '/webEdition/we_cmd.php?';
	for(var i = 0; i < arguments.length; i++) {
		url += 'we_cmd['+i+']='+escape(arguments[i]);
		if(i < (arguments.length - 1)) url += '&';
	}
	
	new jsWindow(url,'browse_users',-1,-1,500,300,true,false,true);
}

</script>
</head>
<?php
	$aCmd = split('_',$_REQUEST['we_cmd'][0]);
	if($aCmd[0]=='new'){
		$in = array(substr($aCmd[2],-3),1,1);
		$aDat[0] = array_merge(array_slice($aDat[0],0,0), array($in), array_slice($aDat[0],0));
	}
	$oWidget = new we_widget();
	$aDiscard = array('rss','pad');
	$s1 = '';
	$iCurrCol = 0;
	$iCurrId = 0;
	foreach ($aDat as $d) {
		$bExtendedCol = false;
		$s2 = '';
		$iCurrCol++;
		foreach ($d as $aProps) {
			$iCurrId++;
			if (!((($aProps[0] == 'usr' || $aProps[0] == 'msg') && !defined('USER_TABLE')) ||
				($aProps[0] == 'msg' && !defined('MESSAGING_SYSTEM')) ||
				($aProps[0] == 'plg' && (!defined("WE_TRACKER_DIR") || !WE_TRACKER_DIR || !file_exists($_SERVER["DOCUMENT_ROOT"].WE_TRACKER_DIR."/includes/showme.inc.php"))))) {
				$iWidth = ((!$aProps[2])? $small : $large);
				if (!in_array($aProps[0],$aDiscard)) {
					include($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_widgets/mod/'.$aProps[0].'.inc.php');
					if ($aProps[0] == 'usr' || $aProps[0] == 'msg') {
						array_push($aDiscard,$aProps[0]);
					}
				}
				if ($aProps[2]) {
					$bExtendedCol = true;
				}
				include($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_widgets/inc/'.$aProps[0].'.inc.php');
				$$aProps[0] = $oWidget->create('m_'.$iCurrId,$aProps[0],$oTblCont,$aLang,$aProps[1],$aProps[2],$aProps[3],$iWidth,$aPrefs[$aProps[0]]["height"],$aPrefs[$aProps[0]]["isResizable"]);
				$s2 .= we_htmlElement::htmlDiv(array("id"=>"m_".$iCurrId,"class"=>"le_widget","style"=>"position:relative;"), $$aProps[0]->getHtmlCode());
				$s2 .= we_htmlElement::jsElement( "initWidget('" . 'm_'.$iCurrId . "');" );
			}
		}
		$s1 .= "<td id=\"c_".$iCurrCol."\" class=\"cls_".$iCurrCol.(($bExtendedCol)? "_expand" : "_collapse")."\">\n";
		$s1 .= $s2;
		$s1 .= we_htmlElement::htmlDiv(array("class"=>"wildcard"),"")."</td>\n";
		if ($iDatLen>$iCurrCol) {
			$s1 .= "<td id=\"spacer_".$iCurrCol."\" style=\"width: 5px;\"></td>\n";
		}
	}
	while ($iCurrCol<$iLayoutCols) {
		$iCurrCol++;
		$s1 .= "<td id=\"c_".$iCurrCol."\" class=\"cls_".$iCurrCol."_collapse\">".we_htmlElement::htmlDiv(array("class"=>"wildcard"),"")."</td>\n";
		if ($iLayoutCols>$iCurrCol) $s1 .= "<td>&nbsp;&nbsp;</td>\n";
	}
	
	$oTblWidgets = new we_htmlTable(array("cellpadding"=>"0","cellspacing"=>"0","border"=>"0","height"=>"98%"),1,1);
	$oTblWidgets->setCol(0,0,array("valign"=>"top","width"=>"100%", "align" => "left"),we_htmlElement::htmlDiv(array("id"=>"modules"),"<table id=\"le_tblWidgets\" cellspacing=\"0\" border=\"0\">\n<tr id=\"rowWidgets\">\n".$s1."</tr>\n</table>"));
	
	// this is the clone widget
	$oClone = $oWidget->create("clone","_reCloneType_",null,array("",""),"white",0,"",100,60);
	
	print we_htmlElement::htmlBody(
		array("onload" => "_EditorFrame.initEditorFrameData({'EditorIsLoading':false});","marginwidth"=>"10","marginheight"=>"10","leftmargin"=>"10","topmargin"=>"10","class"=>"bgc_white"),
			we_htmlElement::htmlForm(array("name"=>"we_form"),we_htmlElement::htmlHidden(array("name"=>"we_cmd[0]","value"=>"save")).we_htmlElement::htmlHidden(array("name"=>"we_cmd[1]","value"=>"")).we_htmlElement::htmlHidden(array("name"=>"we_cmd[2]","value"=>""))).
			we_htmlElement::htmlDiv(array("id"=>"rpcBusy","style"=>"display:none;"),we_htmlElement::htmlImg(array("src"=>IMAGE_DIR."pd/busy.gif","width"=>32,"height"=>32,"border"=>0,"style"=>"margin-left:10px;"))).
			we_htmlElement::htmlDiv(array("id"=>"widgets"),"").
			$oTblWidgets->getHtmlCode().we_htmlElement::jsElement("oTblWidgets=gel('le_tblWidgets');initDragWidgets();") .
			we_htmlElement::htmlDiv(array("id"=>"divClone","style"=>"position:relative;display:none;"),$oClone->getHtmlCode())
			);
		
} else {// no right to see cockpit!!!
	
	$we_button = new we_button();
	
	
	print we_htmlElement::jsElement('
		
		function isHot(){
			return false;
		}
		function closeAllModalWindows(){}
		
		var _EditorFrame = top.weEditorFrameController.getEditorFrame(window.name);
		_EditorFrame.initEditorFrameData(
		{
			"EditorType":"cockpit",
			"EditorDocumentText":"Cockpit",
			"EditorDocumentPath":"Cockpit",
			"EditorContentType":"cockpit",
			"EditorEditCmd":"open_cockpit"
		}
		);
	');
	
	print we_htmlElement::cssElement(
		'
		html {
			heigth: 90%;
		}
		body {
			background: #DDE7F1 url( "/webEdition/images/backgrounds/blank_editor.gif" ) no-repeat fixed bottom right;
			height:100%;
			margin: 0;
			padding: 0;
			text-align: center;
		}
		
		.errorMessage {
			position: relative;
			top: 250px;
			display: block;
			border: 1px solid #999;
			margin: auto;
			padding: auto;
		}
		'
	);
	
	print "</head>";
	print we_htmlElement::htmlBody(
		array("onload" => "_EditorFrame.initEditorFrameData({'EditorIsLoading':false});"),
			
		we_htmlElement::htmlDiv(
			array("class"=>"defaultfont errorMessage", "style" => "width: 400px;"),
			( we_hasPerm("CHANGE_START_DOCUMENT") && we_hasPerm("EDIT_SETTINGS") ? htmlAlertAttentionBox("<strong>" . $l_we_SEEM["question_change_startdocument"] . "</strong><br /><br />" . $we_button->create_button("preferences", "javascript:top.we_cmd('openPreferences');"), 1, 0, false)
												  : htmlAlertAttentionBox("<strong>" . $l_we_SEEM["start_with_SEEM_no_startdocument"] . "</strong>", 1, 0, false)
			)
		)
	);
}
echo "
<iframe id=\"RSIFrame\" name=\"RSIFrame\" style=\"border:0px;width:1px;height:1px; visibility:hidden\"></iframe>
</html>\n";

?>