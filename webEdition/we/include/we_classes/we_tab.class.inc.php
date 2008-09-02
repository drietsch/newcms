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

class we_tab {
	var $tab;
	
	function we_tab($href='#', $text, $status='TAB_NORMAL', $jscmd='', $attribs=array()) {
		$class = $status == 'TAB_ACTIVE' ? "tabActive":"tabNormal";
		$att = "";
		if (isset($attribs) && is_array($attribs)) {
			foreach ($attribs as $key=>$val) {
				$att .= $key . '="' . $val . '" ';
			}
		}

		global $BROWSER,$SYSTEM;
		switch ($BROWSER) {
			case "SAFARI":
				//$tabDummy = '<div class="hidden" id="tabDummy" title="" name="" onclick="top.weMultiTabs.selectFrame(this)" onmouseover="if(this.className==\'tab\') this.className=\'tabOver\'" onmouseout="if(this.className==\'tabOver\') this.className=\'tab\'"><nobr><span class="spacer">&nbsp;<img src="/webEdition/images/pixel.gif" width="16" height="16" id="###loadId###" class="status">&nbsp;</span><span id="###tabTextId###" class="text"></span><span class="spacer"><img src="/webEdition/images/pixel.gif" width="5" height="16" id="###modId###" class="status"><img src="/webEdition/images/multiTabs/close.gif" id="###closeId###" border="0" vspace="0" hspace="0" onclick="top.weMultiTabs.onCloseTab(this)" onmouseover="this.src=\'/webEdition/images/multiTabs/closeOver.gif\'" onmouseout="this.src=\'/webEdition/images/multiTabs/close.gif\'" class="close">&nbsp;</span><img src="/webEdition/images/multiTabs/tabBorder.gif" height="21" style="vertical-align:bottom;"></nobr><span><img src="/webEdition/images/pixel.gif" height="0"></span></div>';
				//$this->container .= '<div class="hidden" id="tabDummy" title="" name="" onclick="top.weMultiTabs.selectFrame(this)"><nobr><span class="spacer">&nbsp;<img src="/webEdition/images/pixel.gif" width="16" height="16" id="###loadId###" class="status">&nbsp;</span><span id="###tabTextId###" class="text"></span><span class="spacer"><img src="/webEdition/images/pixel.gif" width="5" height="16" id="###modId###" class="status"><img src="/webEdition/images/multiTabs/close.gif" id="###closeId###" border="0" vspace="0" hspace="0" onclick="top.weMultiTabs.onCloseTab(this)" onmouseover="this.src=\'/webEdition/images/multiTabs/closeOver.gif\'" onmouseout="this.src=\'/webEdition/images/multiTabs/close.gif\'" class="close">&nbsp;</span><img src="/webEdition/images/multiTabs/tabBorder.gif" height="21" style="vertical-align:bottom;"></nobr><span><img src="/webEdition/images/pixel.gif" height="0"></span></div>';
				$this->tab = '<div ' . $att . ' onclick="if ( allowed_change_edit_page() ){ setTabClass(this); ' . $jscmd . '}" class="' . $class . '"><nobr><span class="spacer">&nbsp;&nbsp;</span><span class="text">' . $text . '</span>&nbsp;&nbsp;<img src="/webEdition/images/multiTabs/tabBorder.gif" height="21" style="vertical-align:bottom;"></nobr><span><img src="/webEdition/images/pixel.gif" height="0"></span></div>';
				break;
			case "IE":
				//$this->container .= '<div class="hidden" id="tabDummy" title="" name="" onclick="top.weMultiTabs.selectFrame(this)"><nobr><span class="spacer">&nbsp;<img src="/webEdition/images/pixel.gif" width="16" height="16" id="###loadId###" class="status">&nbsp;</span><span id="###tabTextId###" class="text"></span><span class="spacer"><img src="/webEdition/images/pixel.gif" width="5" height="16" id="###modId###" class="status"><img src="/webEdition/images/multiTabs/close.gif" id="###closeId###" border="0" vspace="0" hspace="0" onclick="top.weMultiTabs.onCloseTab(this)" onmouseover="this.src=\'/webEdition/images/multiTabs/closeOver.gif\'" onmouseout="this.src=\'/webEdition/images/multiTabs/close.gif\'" class="close">&nbsp;</span><img src="/webEdition/images/multiTabs/tabBorder.gif" height="21" style="vertical-align:bottom;"></nobr></div>';
				$this->tab = '<div ' . $att . ' onclick="if ( allowed_change_edit_page() ){ setTabClass(this); ' . $jscmd . '}" class="' . $class . '"><nobr><span class="spacer">&nbsp;&nbsp;</span><span class="text">' . $text . '</span>&nbsp;&nbsp;<img src="/webEdition/images/multiTabs/tabBorder.gif" height="21" style="vertical-align:bottom;"></nobr></div>';
				break;
			default:
				//$this->container .= '<div class="hidden" id="tabDummy" title="" name="" onclick="top.weMultiTabs.selectFrame(this)"><nobr><span class="spacer">&nbsp;<img src="/webEdition/images/pixel.gif" width="16" height="16" id="###loadId###" class="status">&nbsp;</span><span id="###tabTextId###" class="text"></span><span class="spacer"><img src="/webEdition/images/pixel.gif" width="5" height="16" id="###modId###" class="status"><img src="/webEdition/images/multiTabs/close.gif" id="###closeId###" border="0" vspace="0" hspace="0" onclick="top.weMultiTabs.onCloseTab(this)" onmouseover="this.src=\'/webEdition/images/multiTabs/closeOver.gif\'" onmouseout="this.src=\'/webEdition/images/multiTabs/close.gif\'" class="close">&nbsp;</span></nobr>
				//</div>'."\n\n";
				$this->tab = '<div ' . $att . ' onclick="if ( allowed_change_edit_page() ){ setTabClass(this); ' . $jscmd . '}" class="' . $class . '"><nobr><span class="spacer">&nbsp;&nbsp;</span><span class="text">' . $text . '</span>&nbsp;&nbsp;<img src="/webEdition/images/multiTabs/tabBorder.gif" height="21" style="vertical-align:bottom;"></nobr></div>';
				if($SYSTEM == "MAC") {
					//$this->container .= '<div class="hidden" id="tabDummy" title="" name="" onclick="top.weMultiTabs.selectFrame(this)"><nobr><span class="spacer">&nbsp;<img src="/webEdition/images/pixel.gif" width="16" height="16" id="###loadId###" class="status">&nbsp;</span><span id="###tabTextId###" class="text"></span><span class="spacer"><img src="/webEdition/images/pixel.gif" width="5" height="16" id="###modId###" class="status"><img src="/webEdition/images/multiTabs/close.gif" id="###closeId###" border="0" vspace="0" hspace="0" onclick="top.weMultiTabs.onCloseTab(this)" onmouseover="this.src=\'/webEdition/images/multiTabs/closeOver.gif\'" onmouseout="this.src=\'/webEdition/images/multiTabs/close.gif\'" class="close">&nbsp;</span><img src="/webEdition/images/multiTabs/tabBorder.gif" height="21" style="vertical-align:bottom;"></nobr></div>';
					$this->tab = '<div ' . $att . ' onclick="if ( allowed_change_edit_page() ){ setTabClass(this); ' . $jscmd . '}" class="' . $class . '"><nobr><span class="spacer">&nbsp;&nbsp;</span><span class="text">' . $text . '</span>&nbsp;&nbsp;<img src="/webEdition/images/multiTabs/tabBorder.gif" height="21" style="vertical-align:bottom;"></nobr></div>';
				} elseif ($SYSTEM == "X11") {
					//$this->container .= '<div class="hidden" id="tabDummy" title="" name="" onclick="top.weMultiTabs.selectFrame(this)"><nobr><span class="spacer">&nbsp;<img src="/webEdition/images/pixel.gif" width="16" height="16" id="###loadId###" class="status">&nbsp;</span><span id="###tabTextId###" class="text"></span><span class="spacer"><img src="/webEdition/images/pixel.gif" width="5" height="16" id="###modId###" class="status"><img src="/webEdition/images/multiTabs/close.gif" id="###closeId###" border="0" vspace="0" hspace="0" onclick="top.weMultiTabs.onCloseTab(this)" onmouseover="this.src=\'/webEdition/images/multiTabs/closeOver.gif\'" onmouseout="this.src=\'/webEdition/images/multiTabs/close.gif\'" class="close">&nbsp;</span><img src="/webEdition/images/multiTabs/tabBorder.gif" height="21" style="vertical-align:bottom;"></nobr></div>';
					$this->tab = '<div ' . $att . ' onclick="if ( allowed_change_edit_page() ){ setTabClass(this); ' . $jscmd . '}" class="' . $class . '"><nobr><span class="spacer">&nbsp;&nbsp;</span><span class="text">' . $text . '</span>&nbsp;&nbsp;<img src="/webEdition/images/multiTabs/tabBorder.gif" height="21" style="vertical-align:bottom;"></nobr></div>';
				}
		}
		
	}
	
	function getHTML() {
		return $this->tab;
	}
	
}
?>