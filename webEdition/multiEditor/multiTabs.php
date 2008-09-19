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

include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_browserDetect.inc.php');
include_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_ContentTypes.inc.php");

// generate ContentType JS-String
$_contentTypes = '
var _Contentypes = new Object();
	_Contentypes["cockpit"] = "icon_cockpit.gif";';
foreach ($WE_CONTENT_TYPES as $ct => $ctData) {

	$_contentTypes .= '
	_Contentypes["' . $ct . '"] = "' . $ctData["Icon"] . '";';
}


/*
 * Browser dependences
 */

switch ($BROWSER) {
	case "SAFARI":
		$heightPlus = "";
		$textvalign = "top";
		$imgmargintop = 2;
		$imgvalign = "top";
		$frameDefaultHeight = 22;
		$tabDummy = '<div class="hidden" id="tabDummy" title="" name="" onclick="top.weMultiTabs.selectFrame(this)"><nobr><span class="spacer">&nbsp;<img src="/webEdition/images/pixel.gif" width="16" height="16" id="###loadId###" title="" class="status">&nbsp;</span><span id="###tabTextId###" class="text"></span><span class="spacer"><img src="/webEdition/images/pixel.gif" width="5" height="16" id="###modId###" class="status"><img src="/webEdition/images/multiTabs/close.gif" id="###closeId###" border="0" vspace="0" hspace="0" onclick="top.weMultiTabs.onCloseTab(this)" onmouseover="this.src=\'/webEdition/images/multiTabs/closeOver.gif\'" onmouseout="this.src=\'/webEdition/images/multiTabs/close.gif\'" class="close">&nbsp;</span><img src="/webEdition/images/multiTabs/tabBorder.gif" height="21" style="vertical-align:bottom;"></nobr><span><img src="/webEdition/images/pixel.gif" height="0"></span></div>';
		$tabBorder = "border:0px;";
		$tabBG ="";
		break;
	case "IE":
		$heightPlus = "";
		$textvalign = "middle";
		$imgmargintop = 0;
		$imgvalign = "middle";
		$frameDefaultHeight = 22;
		$tabDummy = '<div class="hidden" id="tabDummy" title="" name="" onclick="top.weMultiTabs.selectFrame(this)"><nobr><span class="spacer">&nbsp;<img src="/webEdition/images/pixel.gif" width="16" height="16" id="###loadId###" title="" class="status">&nbsp;</span><span id="###tabTextId###" class="text"></span><span class="spacer"><img src="/webEdition/images/pixel.gif" width="5" height="16" id="###modId###" class="status"><img src="/webEdition/images/multiTabs/close.gif" id="###closeId###" border="0" vspace="0" hspace="0" onclick="top.weMultiTabs.onCloseTab(this)" onmouseover="this.src=\'/webEdition/images/multiTabs/closeOver.gif\'" onmouseout="this.src=\'/webEdition/images/multiTabs/close.gif\'" class="close">&nbsp;</span><img src="/webEdition/images/multiTabs/tabBorder.gif" height="21" style="vertical-align:bottom;"></nobr></div>';
		$tabBorder = "border:0px;";
		$tabBG ="background-position:bottom; ";
		break;
	default:
		$heightPlus = "+1";
		$textvalign = "top";
		$imgmargintop = 2;
		$imgvalign = "top";
		$frameDefaultHeight = 22;
		$tabDummy = '<div class="hidden" id="tabDummy" title="" name="" onclick="top.weMultiTabs.selectFrame(this)"><nobr><span class="spacer">&nbsp;<img src="/webEdition/images/pixel.gif" width="16" height="16" id="###loadId###" title="" class="status">&nbsp;</span><span id="###tabTextId###" class="text"></span><span class="spacer"><img src="/webEdition/images/pixel.gif" width="5" height="16" id="###modId###" class="status"><img src="/webEdition/images/multiTabs/close.gif" id="###closeId###" border="0" vspace="0" hspace="0" onclick="top.weMultiTabs.onCloseTab(this)" onmouseover="this.src=\'/webEdition/images/multiTabs/closeOver.gif\'" onmouseout="this.src=\'/webEdition/images/multiTabs/close.gif\'" class="close">&nbsp;</span></nobr>
		</div>'."\n\n";
		$tabBorder = "border: 0px; border-bottom: 1px solid #888888; border-right: 1px solid #888888;";
		$tabBG ="";
		if($SYSTEM == "MAC") {
			if (isset($FF) && $FF < 3) {
				$tabDummy = '<div class="hidden" id="tabDummy" title="" name="" ondblclick=";" onclick="top.weMultiTabs.selectFrame(this)"><nobr><span class="spacer">&nbsp;<img src="/webEdition/images/pixel.gif" width="16" height="16" id="###loadId###" title="" class="status">&nbsp;</span><span id="###tabTextId###" class="text"></span><span class="spacer"><img src="/webEdition/images/pixel.gif" width="5" height="16" id="###modId###" class="status"><img src="/webEdition/images/multiTabs/close.gif" id="###closeId###" border="0" vspace="0" hspace="0" onclick="top.weMultiTabs.onCloseTab(this)" onmouseover="this.src=\'/webEdition/images/multiTabs/closeOver.gif\'" onmouseout="this.src=\'/webEdition/images/multiTabs/close.gif\'" class="close">&nbsp;</span><img src="/webEdition/images/multiTabs/tabBorder.gif" height="21" style="vertical-align:bottom;"></nobr></div>';
			}
			$tabBorder = "border:0px;";
		} elseif ($SYSTEM == "X11") {
			if (isset($FF) && $FF < 3) {
				$tabDummy = '<div class="hidden" id="tabDummy" title="" name="" onclick="top.weMultiTabs.selectFrame(this)"><nobr><span class="spacer">&nbsp;<img src="/webEdition/images/pixel.gif" width="16" height="16" id="###loadId###" title="" class="status">&nbsp;</span><span id="###tabTextId###" class="text"></span><span class="spacer"><img src="/webEdition/images/pixel.gif" width="5" height="16" id="###modId###" class="status"><img src="/webEdition/images/multiTabs/close.gif" id="###closeId###" border="0" vspace="0" hspace="0" onclick="top.weMultiTabs.onCloseTab(this)" onmouseover="this.src=\'/webEdition/images/multiTabs/closeOver.gif\'" onmouseout="this.src=\'/webEdition/images/multiTabs/close.gif\'" class="close">&nbsp;</span><img src="/webEdition/images/multiTabs/tabBorder.gif" height="21" style="vertical-align:bottom;"></nobr></div>';
			}
			$tabBorder = "border:0px;";
		}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Horizontale Navigationsleiste zentriert</title>
<script type="text/javascript">
<?php

print $_contentTypes;

?>


function _getIcon(contentType, extension) {
	if (contentType == "application/*") {
		switch(extension){
			case ".pdf":
				return "pdf.gif";
			case ".zip":
			case ".sit":
			case ".hqx":
			case ".bin":
				return "zip.gif";
			case ".doc":
				return "word.gif";
			case ".xls":
				return "excel.gif";
			case ".ppt":
				return "powerpoint.gif";
		}
		return "prog.gif";

	} else {
		return _Contentypes[contentType];
	}
}

// fits the frame height on resize, add or remove tabs if the tabs wrap
function setFrameSize() {
	tabsHeight = (document.getElementById('tabContainer').clientHeight ? (document.getElementById('tabContainer').clientHeight <?php echo $heightPlus; ?>) : (document.body.clientHeight <?php echo $heightPlus; ?> ) );
 	tabsHeight = tabsHeight < <?php echo $frameDefaultHeight; ?> ? <?php echo $frameDefaultHeight; ?> : tabsHeight;
	parent.document.getElementById('multiEditorContainer').rows = (tabsHeight+',*,0');
}

/**
 * class declaration
 * the class TabView controls the behaviort of the tabs
 * onload a instance of this class is created
 */
TabView = function(myDoc) {
	this.myDoc = myDoc;
	this.init();
}
/**
 * class TabView methods and properties
 */
TabView.prototype = {
	/**
	 * if a tab for the given frameId exists, it will be selected
	 * if not if will be added
	 */
	openTab: function(frameId,text,title) {
		if(this.myDoc.getElementById("tab_"+frameId)==undefined) {
			this.addTab(frameId,text,title);
		} else {
			this.selectTab(frameId);
		}
	},
	/**
	 * adds an new tab to the tab view
	 */
	addTab: function(frameId,text,title){
		newtab = this.tabDummy.cloneNode(true);
		newtab.innerHTML = newtab.innerHTML.replace(/###tabTextId###/g, "text_"+frameId);
		newtab.innerHTML = newtab.innerHTML.replace(/###modId###/g, "mod_"+frameId);
		newtab.innerHTML = newtab.innerHTML.replace(/###loadId###/g, "load_"+frameId);
		newtab.innerHTML = newtab.innerHTML.replace(/###closeId###/g, "close_"+frameId);
		newtab.id        = "tab_" + frameId;
		newtab.name      = "tab";
		newtab.title     = title;
		newtab.className = "tabActive";
		this.tabContainer.appendChild(newtab);
		this.setText(frameId, text);
		this.setTitle(frameId, title);
		this.selectTab(frameId);
		setTimeout("setFrameSize()",100);
	},
	/**
	 * controls the click on the close button
	 */
	onCloseTab : function(val) {
		frameId = (typeof val) == "object" ? val.id.replace(/close_/g, "") : val;
		top.weEditorFrameController.closeDocument(frameId);

	},
	/**
	 * removes a tab from the tab view
	 */
	closeTab : function(frameId) {
		this.tabContainer.removeChild(this.myDoc.getElementById('tab_'+frameId));
		if (this.activeTab == frameId) this.activeTab = null;
		setFrameSize();
		this.contentType[frameId] = "";
	},
	/**
	 * selects a tab (set style for selected tabs)
	 */
	selectTab: function(frameId) {
		this.deselectAll();
		if(this.activeTab != null) {
			this.deselectTab(this.activeTab);
		}
		if( this.myDoc.getElementById('tab_' + frameId) && typeof(this.myDoc.getElementById('tab_' + frameId)) == "object" ) {
			this.myDoc.getElementById('tab_' + frameId).className = 'tabActive';
		}
		this.activeTab = frameId;
	},
	/**
	 * deselects a tab (set style for deselected tabs)
	 */
	deselectTab: function(frameId) {
		if (this.myDoc.getElementById('tab_' + frameId)) {
			this.myDoc.getElementById('tab_' + frameId).className = "tab";
		}
	},
	/**
	 * deselects all tab (set style for deselected tabs to all tabs)
	 */
	deselectAll: function() {
		tabs = this.myDoc.getElementsByName("tab");
		for(i=0; tabs.length; i++) {
			tabs[i].className = "tab";
		}
	},
	/**
	 * sets the tab label
	 */
	setText: function(frameId, val) {
		this.myDoc.getElementById('text_' + frameId).innerHTML = val;
		setTimeout("setFrameSize()",50);
	},
	/**
	 * sets the tab title
	 */
	setTitle: function(frameId, val) {
		this.myDoc.getElementById('tab_' + frameId).title = val;
	},
	/**
	 * sets the id to the icon
	 */
	setId: function(frameId, val) {
		this.myDoc.getElementById('load_' + frameId).title = val;
	},
	/**
	 * marks a tab as modified an not safed
	 */
	setModified: function(frameId, modified) {
		if(modified) {
			this.myDoc.getElementById('mod_' + frameId).src = "/webEdition/images/multiTabs/modified.gif";
		} else {
			this.myDoc.getElementById('mod_' + frameId).src = "/webEdition/images/pixel.gif";
		}
	},
	/**
	 * displays the loading loading icon
	 */
	setLoading: function(frameId, loading) {
		if(loading) {
			this.myDoc.getElementById('load_' + frameId).src = "/webEdition/images/spinner.gif";
		} else {



			if ( _Contentypes[this.contentType[frameId]]) {
				var _text = this.myDoc.getElementById('text_' + frameId).innerHTML;
				var _ext = _text ? _text.replace(/^.*\./,".") : "";
				this.myDoc.getElementById('load_' + frameId).src = "/webEdition/images/tree/icons/" + _getIcon(this.contentType[frameId], _ext);
			} else {
				this.myDoc.getElementById('load_' + frameId).src = "/webEdition/images/pixel.gif";
			}
		}
	},
	/**
	 * displays the content type icon
	 */
	setContentType: function(frameId,contentType) {
		this.contentType[frameId] = contentType;
		this.setLoading(frameId,false);
	},
	/**
	 * controls the click on a tab
	 */
	selectFrame: function(val) {
		frameId = (typeof val) == "object" ? val.id.replace(/tab_/g, "") : val;
		top.weEditorFrameController.showEditor(frameId);
		//this.selectTab(frameId);
	},
	/**
	 * inits some vars
	 */
	init: function() {
		this.tabs = new Array();
		this.frames = new Array();
		this.activeTab = null;
		this.tabContainer = this.myDoc.getElementById('tabContainer');
		this.tabDummy = this.myDoc.getElementById('tabDummy');
		this.contentType = new Array();
	}
}
/**
 * document init
 */
function init() {
	top.weMultiTabs = new TabView(document);
}

</script>
<style type="text/css">
body {
	margin:0px; padding:0px;
	border: 0px; border-top: 1px solid #000000;
	font-family: Verdana, Arial, sans-serif;
	font-size: 10px;
	color: #000000;
	background-color: silver;
	background-image: url(/webEdition/images/backgrounds/multitabBG.gif);
}
#tabContainer{
	width:100%;
	margin: 0px; padding: 0;
	border: 0px;
	overflow:hidden;
}
div.tab{
	margin: 0px; padding: 0;
	<?php echo $tabBorder; ?>
	display:inline;
	background-image:url(/webEdition/images/multiTabs/tabsBG_normal.gif);
	background-repeat: repeat-x;
	line-height:21px;
	font-size:17px;
	cursor:pointer;
}
div.tabOver{
	margin: 0px; padding: 0;
	<?php echo $tabBorder; ?>
	display:inline;
	background-image:url(/webEdition/images/multiTabs/tabsBG_over.gif);
	background-repeat: repeat-x;
	<?php echo $tabBG; ?>
	line-height:21px;
	font-size:17px;
	cursor:pointer;
}
div.tabActive{
	margin: 0px; padding: 0;
	<?php echo $tabBorder; ?>
	display: inline;
	background-image:url(/webEdition/images/multiTabs/tabsBG_active.gif);
	background-repeat: repeat-x;
	<?php echo $tabBG; ?>
	line-height:21px;
	font-size:17px;
	cursor:pointer;
}
span.text{
	margin:0px; padding:0px;
	font-size: 10px;
	vertical-align:<?php echo $textvalign; ?>;
}
span.spacer{
	font-size: 4px;
	vertical-align:<?php echo $textvalign; ?>;
}
img.close{
	vertical-align:<?php echo $imgvalign; ?>;
	cursor:pointer;
	margin:<?php echo $imgmargintop; ?>px;
}
span.status{
	vertical-align:<?php echo $imgvalign; ?>;
	padding:0px;
}
img.status{
	vertical-align:<?php echo $imgvalign; ?>;
	padding:0px;
	margin:<?php echo $imgmargintop; ?>px;
}
.hidden{
	display: none;
}
.visible{
	display: inline;
}
</style>
</head>
<body bgcolor="Silver" onresize="setFrameSize()" onload="init()">
<div id="tabContainer" name="tabContainer">
</div>
<?php echo $tabDummy; ?>
</body>
</html>