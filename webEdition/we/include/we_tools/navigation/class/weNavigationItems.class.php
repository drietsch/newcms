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

include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/navigation/class/weNavigation.class.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/navigation/class/weDynList.class.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/we_imageDocument.inc.php');
if (defined('CUSTOMER_TABLE')) {
	include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_modules/customer/weNavigationCustomerFilter.class.php");
}

/**
 * simplified representation of the navigation item
 */
class weNavigationItem
{

	var $id;

	var $icon;

	var $docid;

	var $table;

	var $parentid;

	var $text;

	var $display;

	var $name;

	var $href;

	var $type;

	var $level;

	var $position;

	var $current = 'false';

	var $containsCurrent = 'false';

	var $visible = 'true';

	//attributes
	var $title;

	var $anchor;

	var $target;

	var $lang;

	var $hreflang;

	var $accesskey;

	var $tabindex;

	var $rel;

	var $rev;

	var $limitaccess = 0;

	var $customers;

	var $items = array();

	var $Storage = array();

	function weNavigationItem($id, $docid, $table, $text, $display, $href, $type, $icon, $attributes, $limitaccess, $customers = "")
	{
		$this->id = $id;
		$this->parentid = 0;
		$this->name = $text;
		$this->text = (isset($display) && !empty($display) && $display != $text) ? $display : $text;
		$this->display = $display;
		$this->docid = $docid;
		$this->table = $table;
		$this->href = $href;
		$this->type = $type;
		$this->icon = $icon;
		$this->level = 0;
		$this->position = 0;
		
		if (!is_array($attributes)) {
			$attributes = @unserialize($attributes);
		}
		$this->attributes = $attributes;
		
		$this->title = isset($attributes['title']) ? $attributes['title'] : '';
		$this->anchor = isset($attributes['anchor']) ? $attributes['anchor'] : '';
		$this->target = isset($attributes['target']) ? $attributes['target'] : '';
		$this->lang = isset($attributes['lang']) ? $attributes['lang'] : '';
		$this->hreflang = isset($attributes['hreflang']) ? $attributes['hreflang'] : '';
		$this->accesskey = isset($attributes['accesskey']) ? $attributes['accesskey'] : '';
		$this->tabindex = isset($attributes['tabindex']) ? $attributes['tabindex'] : '';
		$this->rel = isset($attributes['rel']) ? $attributes['rel'] : '';
		$this->rev = isset($attributes['rev']) ? $attributes['rev'] : '';
		
		$this->limitaccess = $limitaccess;
		$this->customers = $customers;
		
		if ($this->table == FILE_TABLE) {
			$__parts = explode("?", $this->href);
			$__path = $__parts[0];
			$__id = path_to_id($__path, FILE_TABLE);
			if ($__id) {
				$_v = f(
						'SELECT ID FROM ' . FILE_TABLE . ' WHERE ID=' . abs($__id) . ' AND Published>0', 
						'ID', 
						new DB_WE());
				$this->visible = !empty($_v) ? 'true' : 'false';
			}
		}
	
	}

	function addItem(&$item)
	{
		$item->parentid = $this->id;
		$item->level = $this->level + 1;
		$this->items['id' . $item->id] = &$item;
		$item->position = sizeof($this->items);
	}

	function setCurrent(&$weNavigationItems, $self = true)
	{
		
		if ($self) {
			$this->current = 'true';
		}
		
		if (isset($weNavigationItems->items['id' . $this->parentid]) && $this->level != 0) {
			$weNavigationItems->items['id' . $this->parentid]->setCurrent($weNavigationItems);
			$this->setContainsCurrent($weNavigationItems);
		}
	}

	function unsetCurrent(&$weNavigationItems, $self = true)
	{
		
		if ($self) {
			$this->current = 'false';
		}
		
		if (isset($weNavigationItems->items['id' . $this->parentid]) && $this->level != 0) {
			//$weNavigationItems->items['id' . $this->parentid]->unsetCurrent($weNavigationItems);
			foreach ($this->items as $_i) {
				$_i->unsetCurrent($weNavigationItems);
			}
			$this->unsetContainsCurrent($weNavigationItems);
		}
	}

	function setContainsCurrent($weNavigationItems, $self = true)
	{
		if ($self) {
			$this->containsCurrent = 'true';
		}
	}

	function unsetContainsCurrent($weNavigationItems, $self = true)
	{
		if ($self) {
			$this->containsCurrent = 'false';
		}
	}

	function isCurrent($weNavigationItems)
	{
		
		if (isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] == $this->href) {
			// fastest way
			

			$this->setCurrent($weNavigationItems);
			return true;
		}
		
		if (isset($GLOBALS["we_obj"]) && $this->table == OBJECT_FILES_TABLE) {
			$id = $GLOBALS["we_obj"]->ID;
		} else 
			if (isset($GLOBALS["WE_MAIN_DOC"]) && (!isset($GLOBALS["WE_MAIN_DOC"]->TableID)) && $this->table == FILE_TABLE) {
				$id = $GLOBALS["WE_MAIN_DOC"]->ID;
			}
		
		if (isset($id) && ($this->docid == $id)) {
			
			$this->setCurrent($weNavigationItems);
			return true;
		
		} else {
			
			if ($this->current == 'true') {
				
				$this->unsetCurrent($weNavigationItems);
			}
			return false;
		
		}
	}

	function isVisible()
	{
		if ($this->visible == 'false') {
			return false;
		}
		
		if (defined('CUSTOMER_TABLE') && $this->limitaccess) { // only init filter if access is limited
			

			$_filter = new weNavigationCustomerFilter();
			$_filter->initByNavItem($this);
			
			return $_filter->customerHasAccess();
		}
		return true;
	
	}

	function writeItem(&$weNavigationItems, $depth = false)
	{
		if (!($depth === false || $this->level <= $depth)) {
			return '';
		}
		if (!$this->isVisible()) {
			return false;
		}
		$template = $weNavigationItems->getTemplate($this);
		
		$GLOBALS['weNavigationItemArray'][] = & $this;
		
		$content = $template;
		ob_start();
		eval('?>' . $content);
		$executeContent = ob_get_contents();
		ob_end_clean();
		
		array_pop($GLOBALS['weNavigationItemArray']);
		
		return $executeContent;
	}

	function getNavigationField($attribs)
	{
		// name
		

		if (isset($attribs['name'])) {
			$fieldname = $attribs['name'];
			if (isset($this->$fieldname) && $this->$fieldname != '') {
				if ($fieldname == 'title') {
					return htmlspecialchars($this->$fieldname);
				} else {
					return $this->$fieldname;
				}
			} else 
				if (isset($this->attributes[$fieldname]) && $this->attributes[$fieldname] != '') {
					if ($fieldname == 'title') {
						return htmlspecialchars($this->attributes[$fieldname]);
					} else {
						return $this->attributes[$fieldname];
					}
				} else {
					return '';
				}
		}
		
		// complete
		if (isset($attribs['complete'])) {
			$_compl = $attribs['complete'];
			unset($attribs['complete']);
			if ((($_compl == 'link' && isset($this->text)) || ($_compl == 'image' && isset($this->icon) && $this->icon != '/'))) {
				unset($attribs['complete']);
				$attribs['attributes'] = $_compl;
				$attribs = $this->getNavigationFieldAttributes($attribs);
				if ($_compl == 'image') {
					return getHtmlTag('img', $attribs);
				} else {
					return getHtmlTag('a', $attribs, $this->text);
				}
			}
			return '';
		
		}
		
		// attributes
		$_attributes = array();
		$code = '';
		if (isset($attribs['attributes'])) {
			$_attributes = $this->getNavigationFieldAttributes($attribs);
			foreach ($_attributes as $_key => $_value) {
				$code .= " $_key=\"" . $_value . "\"";
			}
		}
		return $code;
	
	}

	function getNavigationFieldAttributes($attribs)
	{
		if (isset($attribs['attributes'])) {
			$code = '';
			$_fields = makeArrayFromCSV($attribs['attributes']);
			unset($attribs['attributes']);
			foreach ($_fields as $_field) {
				switch ($_field) {
					case 'link' :
						$useFields = array(
							
								'href', 
								'title', 
								'target', 
								'lang', 
								'hreflang', 
								'accesskey', 
								'tabindex', 
								'rel', 
								'rev'
						);
						foreach ($useFields as $field) {
							if (isset($this->$field) && $this->$field != '') {
								if ($field == 'title') {
									$attribs[$field] = htmlspecialchars($this->$field);
								} else {
									$attribs[$field] = $this->$field;
								}
								//$attribs[$field] = $this->$field;
							} else 
								if (isset($this->attributes[$field]) && $this->attributes[$field] != '') {
									//$attribs[$field] = $this->attributes[$field];
									$attribs[$field] = htmlspecialchars(
											$this->attributes[$field]);
								}
						}
						
						if (isset($this->attributes['popup_open']) && $this->attributes['popup_open']) {
							$this->getPopupJs($attribs);
						}
						break;
					case 'image' :
						$_iconid = path_to_id($this->icon, FILE_TABLE);
						if ($_iconid) {
							$attribs['src'] = $this->icon;
							$useFields = array(
								'width', 'height', 'border', 'hspace', 'vspace', 'align', 'alt', 'title'
							);
							foreach ($useFields as $field) {
								if (isset($this->attributes['icon_' . $field]) && $this->attributes['icon_' . $field] != '') {
									$attribs[$field] = $this->attributes['icon_' . $field];
								}
							}
							$_imgObj = new we_imageDocument();
							$_imgObj->initByID($_iconid);
							
							$_js = $_imgObj->getRollOverScript();
							$_js = ereg_replace("<[^>]+><!--", "", $_js);
							$_js = ereg_replace("//--><[^>]+>", "", $_js);
							$_js = ereg_replace("\r?\n", '', $_js);
							
							$_arr = $_imgObj->getRollOverAttribsArr();
							if (count($_arr)) {
								$_arr['onmouseover'] = $_js . $_arr['onmouseover'];
								$_arr['onmouseout'] = $_js . $_arr['onmouseout'];
								$_arr['name'] = $_imgObj->getElement('name');
								$attribs = array_merge($attribs, $_arr);
							}
						}
						break;
					default :
						if (isset($this->$_field) && $this->$_field != '') {
							$attribs[$_field] = htmlspecialchars($this->$_field);
						} else 
							if (isset($this->attributes[$_field]) && $this->attributes[$_field] != '') {
								$attribs[$_field] = htmlspecialchars($this->attributes[$_field]);
							}
				}
			
			}
		}
		
		return $attribs;
	
	}

	function getPopupJs(&$attributes)
	{
		
		$js = 'var we_winOpts;';
		
		if ($this->attributes['popup_center'] && $this->attributes['popup_width'] && $this->attributes['popup_height']) {
			$js .= 'if (window.screen) {var w = ' . $this->attributes['popup_width'] . ';var h = ' . $this->attributes['popup_height'] . ';var screen_height = screen.availHeight - 70;var screen_width = screen.availWidth-10;var w = Math.min(screen_width,w);var h = Math.min(screen_height,h);var x = (screen_width - w) / 2;var y = (screen_height - h) / 2;we_winOpts = \'left=\'+x+\',top=\'+y;}else{we_winOpts=\'\';};';
		} else 
			if ($this->attributes['popup_xposition'] != '' || $this->attributes['popup_yposition'] != '') {
				if ($this->attributes['popup_xposition'] != '') {
					$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'left=' . $this->attributes['popup_xposition'] . '\';';
				}
				if ($this->attributes['popup_yposition'] != '') {
					$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'top=' . $this->attributes['popup_yposition'] . '\';';
				}
			}
		if (isset($this->attributes['popup_width']) && $this->attributes['popup_width'] != '') {
			$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'width=' . $this->attributes['popup_width'] . '\';';
		}
		
		if (isset($this->attributes['popup_height']) && $this->attributes['popup_height'] != '') {
			$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'height=' . $this->attributes['popup_height'] . '\';';
		}
		
		if (isset($this->attributes['popup_status']) && $this->attributes['popup_status'] != '') {
			$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'status=yes\';';
		} else {
			$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'status=no\';';
		}
		
		if (isset($this->attributes['popup_scrollbars']) && $this->attributes['popup_scrollbars'] != '') {
			$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'scrollbars=yes\';';
		} else {
			$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'scrollbars=no\';';
		}
		
		if (isset($this->attributes['popup_menubar']) && $this->attributes['popup_menubar'] != '') {
			$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'menubar=yes\';';
		} else {
			$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'menubar=no\';';
		}
		
		if (isset($this->attributes['popup_resizable']) && $this->attributes['popup_resizable'] != '') {
			$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'resizable=yes\';';
		} else {
			$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'resizable=no\';';
		}
		
		if (isset($this->attributes['popup_location']) && $this->attributes['popup_location'] != '') {
			$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'location=yes\';';
		} else {
			$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'location=no\';';
		}
		
		if (isset($this->attributes['popup_toolbar']) && $this->attributes['popup_toolbar'] != '') {
			$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'toolbar=yes\';';
		} else {
			$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'toolbar=no\';';
		}
		
		$js .= "var we_win = window.open('" . $this->href . "','" . "we_ll_" . $this->id . "',we_winOpts);";
		
		$attributes = removeAttribs($attributes, array(
			'name', 'target', 'href', 'onClick', 'onclick'
		));
		
		$attributes['target'] = 'we_ll_' . $this->id;
		$attributes['onclick'] = $js;
	
	}

}

/**
 * collection of the navigation items
 */
class weNavigationItems
{

	var $items;

	var $templates;

	var $rootItem = 0;

	var $hasCurrent = false;

	var $currentRules = array();

	function weNavigationItems()
	{
	}

	function getCustomerData($navi)
	{
		$_customer = array(
			'id' => '', 'filter' => '', 'blacklist' => '', 'whitelist' => '', 'usedocumentfilter' => 1
		);
		
		if (!is_array($navi->Customers)) {
			$navi->Customers = makeArrayFromCSV($navi->Customers);
		}
		
		if (!is_array($navi->BlackList)) {
			$navi->BlackList = makeArrayFromCSV($navi->BlackList);
		}
		
		if (!is_array($navi->WhiteList)) {
			$navi->WhiteList = makeArrayFromCSV($navi->WhiteList);
		}
		
		if (!is_array($navi->CustomerFilter)) {
			$navi->CustomerFilter = @unserialize($navi->CustomerFilter);
		}
		
		if ($navi->LimitAccess) {
			$_customer['id'] = $navi->AllCustomers == 0 ? $navi->Customers : array();
			$_customer['filter'] = $navi->ApplyFilter == 1 ? $navi->CustomerFilter : array();
			$_customer['blacklist'] = $navi->ApplyFilter == 1 ? $navi->BlackList : array();
			$_customer['whitelist'] = $navi->ApplyFilter == 1 ? $navi->WhiteList : array();
			$_customer['usedocumentfilter'] = $navi->UseDocumentFilter ? 1 : 0;
			return $_customer;
		}
		
		return $_customer;
	
	}

	function initByNavigationObject($showRoot = true)
	{
		
		$this->items = array();
		$_navigation = unserialize($_SESSION['navigation_session']);
		
		$this->rootItem = $_navigation->ID;
		
		// set defaultTemplates
		$this->setDefaultTemplates();
		
		$this->readItemsFromDb($this->rootItem);
		
		$this->items['id' . $_navigation->ID] = new weNavigationItem(
				$_navigation->ID, 
				$_navigation->LinkID, 
				($_navigation->IsFolder ? ($_navigation->FolderSelection == "objLink" ? OBJECT_FILES_TABLE : FILE_TABLE) : (($_navigation->SelectionType == 'classname' || $_navigation->SelectionType == 'objLink') ? OBJECT_FILES_TABLE : FILE_TABLE)), 
				$_navigation->Text, 
				$_navigation->Display, 
				$_navigation->getHref(
						$_navigation->SelectionType, 
						$_navigation->LinkID, 
						$_navigation->Url, 
						$_navigation->Parameter, 
						$_navigation->WorkspaceID), 
				$showRoot ? 'folder' : 'root', 
				$this->id2path($_navigation->IconID), 
				$_navigation->Attributes, 
				$_navigation->LimitAccess, 
				$this->getCustomerData($_navigation));
		
		$_items = $_navigation->getDynamicPreview($this->Storage);
		
		$_new_items = weNavigationItems::getStaticSavedDynamicItems($_navigation);
		
		// fetch the new items in item array
		$_depended = array();
		foreach ($_items as $k => $v) {
			if ($v['depended'] == 1 && $v['parentid'] == $_navigation->ID) {
				$_depended[] = $k;
			}
		}
		
		$i = 0;
		foreach ($_new_items as $_new) {
			if (isset($_depended[$i])) {
				$_items[$_depended[$i]] = $_new;
			} else {
				$_items[] = $_new;
			}
			$i++;
		}
		
		$_all = count($_items) - count($_depended) + count($_new_items);
		$_items = array_splice($_items, 0, $_all);
		foreach ($_items as $_item) {
			$this->items['id' . $_item['id']] = new weNavigationItem(
					$_item['id'], 
					$_item['docid'], 
					$_item['table'], 
					$_item['text'], 
					$_item['display'], 
					$_item['href'], 
					$_item['type'], 
					$_item['icon'], 
					$_item['attributes'], 
					$_item['limitaccess'], 
					$_item['customers']);
			if (isset($this->items['id' . $_item['parentid']])) {
				$this->items['id' . $_item['parentid']]->addItem($this->items['id' . $_item['id']]);
			}
		}
	
	}

	function getStaticSavedDynamicItems($_nav, $rules = false)
	{
		$_items = array();
		$_dyn_items = $_nav->getDynamicEntries();
		if (is_array($_dyn_items)) {
			foreach ($_dyn_items as $_dyn) {
				
				$_href = id_to_path($_dyn['id']);
				$_items[] = array(
					
						'id' => $_dyn['id'], 
						'text' => isset($_dyn['field']) && !empty($_dyn['field']) ? $_dyn['field'] : $_dyn['text'], 
						'display' => isset($_dyn['display']) && !empty($_dyn['display']) ? $_dyn['display'] : '', 
						'name' => !empty($_dyn['field']) ? $_dyn['field'] : (isset($_dyn['name']) && !empty(
								$_dyn['name']) ? $_dyn['name'] : $_dyn['text']), 
						'docid' => $_dyn['id'], 
						'table' => (($_nav->SelectionType == 'classname' || $_nav->SelectionType == 'objLink') ? OBJECT_FILES_TABLE : FILE_TABLE), 
						'href' => $_href, 
						'type' => 'item', 
						'parentid' => $_nav->ID, 
						'workspaceid' => $_nav->WorkspaceID, 
						'icon' => isset($this->Storage['ids'][$_nav->IconID]) ? $this->Storage['ids'][$_nav->IconID] : id_to_path(
								$_nav->IconID), 
						'attributes' => $_nav->Attributes, 
						'limitaccess' => $_nav->LimitAccess, 
						'customers' => weNavigationItems::getCustomerData($_nav), 
						'depended' => 1
				);
				
				if ($rules) {
					$_items[(sizeof($_items) - 1)]['currentRule'] = weNavigationRule::getWeNavigationRule(
							'defined_' . (!empty($_dyn['field']) ? $_dyn['field'] : $_dyn['text']), 
							$_nav->ID, 
							$_nav->SelectionType, 
							$_nav->FolderID, 
							$_nav->DocTypeID, 
							$_nav->ClassID, 
							$_nav->CategoryIDs, 
							$_nav->WorkspaceID, 
							$_href, 
							false);
				}
			}
		}
		return $_items;
	
	}

	function loopAllRules($id)
	{
		
		if (!$this->hasCurrent) {
			
			// add defined rules
			$newRules = weNavigationRuleControl::getAllNavigationRules();
			
			foreach ($newRules as $_rule) {
				$this->currentRules[] = $_rule;
			}
			
			$this->checkCurrent($this->items['id' . $id]->items);
		}
	
	}

	function initFromCache($parentid = 0, $showRoot = true)
	{
		
		$this->items = array();
		$this->rootItem = $parentid;
		$this->setDefaultTemplates();
		
		$_cache = $_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/navigation/cache/navigation_' . $parentid . '.php';
		
		if (file_exists($_cache)) {
			$_part = weFile::loadPart($_cache, 0, 10);
			if (eregi("<?php", $_part)) {
				include ($_cache);
			} else {
				$navigationItemsStorage = weFile::load($_cache);
			}
			
			$this->items = unserialize($navigationItemsStorage);
			unset($navigationItemsStorage);
			
			$this->items['id' . $parentid]->type = $showRoot ? ($_parent == 0 ? 'root' : $this->items['id' . $parentid]->type) : 'root';
			
			$_cache = $_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/navigation/cache/rules.php';
			if (file_exists($_cache)) {
				$_part = weFile::loadPart($_cache, 0, 10);
				if (eregi("<?php", $_part)) {
					include ($_cache);
				} else {
					$navigationRulesStorage = weFile::load($_cache);
				}
				$this->currentRules = unserialize($navigationRulesStorage);
				unset($navigationRulesStorage);
			}
			
			foreach ($this->items as $_k => $_item) {
				
				if (strtolower(get_class($_item)) == 'wenavigationitem') {
					
					if ($this->items[$_k]->isCurrent($this)) {
						$this->hasCurrent = true;
					} else {
						$this->hasCurrent = false;
					}
				
				}
			
			}
			
			$this->loopAllRules($parentid);
			
			return true;
		
		}
		
		return false;
	
	}

	function initById($parentid = 0, $depth = false, $showRoot = true)
	{
		$this->items = array();
		$this->rootItem = abs($parentid);
		
		$_navigation = new weNavigation();
		
		$this->readItemsFromDb($this->rootItem);
		
		$_item = $this->getItemFromPool($parentid);
		
		$_navigation->initByRawData($_item ? $_item : array(
			'ID' => 0, 'Path' => '/'
		));
		
		// set defaultTemplates
		$this->setDefaultTemplates();
		
		$this->items['id' . $_navigation->ID] = new weNavigationItem(
				$_navigation->ID, 
				$_navigation->LinkID, 
				($_navigation->IsFolder ? ($_navigation->FolderSelection == "objLink" ? OBJECT_FILES_TABLE : FILE_TABLE) : (($_navigation->SelectionType == 'classname' || $_navigation->SelectionType == 'objLink') ? OBJECT_FILES_TABLE : FILE_TABLE)), 
				$_navigation->Text, 
				$_navigation->Display, 
				$_navigation->getHref($this->Storage['ids']), 
				$showRoot ? ($_navigation->ID == 0 ? 'root' : ($_navigation->IsFolder ? 'folder' : 'item')) : 'root', 
				$this->id2path($_navigation->IconID), 
				$_navigation->Attributes, 
				$_navigation->LimitAccess, 
				$this->getCustomerData($_navigation));
		
		$_items = $_navigation->getDynamicPreview($this->Storage, true);
		
		foreach ($_items as $_item) {
			
			if (!empty($_item['id'])) {
				if (isset($_item['name']) && !empty($_item['name'])) {
					$_item['text'] = $_item['name'];
				}
				$this->items['id' . $_item['id']] = new weNavigationItem(
						$_item['id'], 
						$_item['docid'], 
						$_item['table'], 
						$_item['text'], 
						$_item['display'], 
						$_item['href'], 
						$_item['type'], 
						$_item['icon'], 
						$_item['attributes'], 
						$_item['limitaccess'], 
						$_item['customers']);
				
				if (isset($this->items['id' . $_item['parentid']])) {
					$this->items['id' . $_item['parentid']]->addItem($this->items['id' . $_item['id']]);
				}
				
				if ($this->items['id' . $_item['id']]->isCurrent($this)) {
					$this->hasCurrent = true;
				}
				
				// add currentRules
				if (isset($_item['currentRule'])) {
					$this->currentRules[] = $_item['currentRule'];
				}
			}
		}
		
		$this->loopAllRules($_navigation->ID);
	
	}

	function checkCategories($idRule, $idDoc)
	{
		
		$idsRule = makeArrayFromCSV($idRule);
		
		if (sizeof($idsRule)) {
			for ($i = 0; $i < sizeof($idsRule); $i++) {
				if (strpos($idDoc, ",$idsRule[$i],") !== false) {
					return true;
				}
			}
		} else {
			return true;
		}
		return false;
	}

	function setCurrent($navigationID, $current)
	{
		if (isset($this->items["id$navigationID"])) {
			
			$this->items["id$navigationID"]->setCurrent($this, true);
		}
	}

	function checkCurrent(&$items)
	{
		
		$_candidate = 0;
		$_score = 3;
		$_len = 0;
		$_curr_len = 0;
		$_ponder = 0;
		
		$_isObject = (isset($GLOBALS["we_obj"]) && isset($GLOBALS["WE_MAIN_DOC"]->TableID) && $GLOBALS["WE_MAIN_DOC"]->TableID);
		
		if (isset($GLOBALS['WE_MAIN_DOC'])) {
			
			for ($i = 0; $i < sizeof($this->currentRules); $i++) {
				
				$_rule = $this->currentRules[$i];
				
				$_ponder = 4;
				
				if ($_rule->SelectionType == 'doctype' && $_rule->DoctypeID) {
					if (isset($GLOBALS['WE_MAIN_DOC']->DocType) && ($_rule->DoctypeID == $GLOBALS['WE_MAIN_DOC']->DocType)) {
						$_ponder--;
					} else {
						$_ponder = 999; // remove from selection
					}
				}
				
				if ($_rule->SelectionType == 'classname' && $_rule->ClassID) {
					if (isset($GLOBALS["WE_MAIN_DOC"]->TableID) && ($GLOBALS["WE_MAIN_DOC"]->TableID == $_rule->ClassID)) {
						$_ponder--;
					} else {
						$_ponder = 999; // remove from selection
					}
				}
				
				$parentPath = '';
				if ($_rule->SelectionType == 'classname' && $_isObject) {
					
					//$parentPath = id_to_path($_rule->WorkspaceID, FILE_TABLE);
					$parentPath = $this->id2path($_rule->WorkspaceID);
					
					if (!empty($wPath) && $parentPath != '/') {
						$parentPath .= '/';
					}
				
				}
				
				if ($_rule->SelectionType == 'doctype' && !$_isObject) {
					
					//$parentPath = id_to_path($_rule->FolderID, FILE_TABLE);
					$parentPath = $this->id2path($_rule->FolderID);
					
					if (!empty($parentPath) && $parentPath != '/') {
						$parentPath .= '/';
					}
				
				}
				
				if (!empty($parentPath)) {
					
					if (strpos($GLOBALS['WE_MAIN_DOC']->Path, $parentPath) === 0) {
						
						$_ponder--;
						$_curr_len = strlen($parentPath);
						if ($_curr_len > $_len) {
							$_len = $_curr_len;
							$_ponder--;
						}
					}
				
				}
				
				$_cats = makeArrayFromCSV($_rule->Categories);
				if (!empty($_cats)) {
					if ($this->checkCategories($_rule->Categories, $GLOBALS['WE_MAIN_DOC']->Category)) {
						$_ponder--;
					} else {
						$_ponder = 999; // remove from selection
					}
				
				}
				
				if ($_ponder == 0) {
					$this->setCurrent($_rule->NavigationID, $_rule->SelfCurrent);
					return true;
				} else 
					if ($_ponder <= $_score) {
						$_score = $_ponder;
						$_candidate = $_rule->NavigationID;
					}
			
			}
			if ($_candidate != 0) {
				$this->setCurrent($_candidate, null);
				return true;
			}
		}
		return false;
	}

	function getItemIds($id)
	{
		
		$_items[] = $id;
		
		foreach ($this->items[$id]->items as $key => $val) {
			
			if ($val->type == 'folder') {
				$_items = array_merge($_items, $this->getItemIds($key));
			} else {
				$_items[] = $key;
			}
		}
		
		return $_items;
	
	}

	function getItems($id = false)
	{
		
		if ($id) {
			return $this->getItemIds($id);
		} else {
			return array_keys($this->items);
		}
	}

	function getItem($id)
	{
		return isset($this->items[$id]) ? $this->items[$id] : false;
	}

	function getTemplate($item)
	{
		
		if (!isset($this->templates[$item->type])) {
			return $this->getDefaultTemplate($item);
		}
		
		// get correct Level
		if (isset($this->templates[$item->type][$item->level])) {
			$useTemplate = $this->templates[$item->type][$item->level];
		} else {
			$useTemplate = $this->templates[$item->type]['defaultLevel'];
		}
		// get correct position
		if (isset($useTemplate[$item->current])) {
			$useTemplate = $useTemplate[$item->current];
		} else 
			if (isset($useTemplate['defaultCurrent'])) {
				$useTemplate = $useTemplate['defaultCurrent'];
			}
		
		// is last entry??
		if (isset($useTemplate['last'])) {
			
			// check if item is last
			if (sizeof($this->items['id' . $item->parentid]->items) == $item->position) {
				return $useTemplate['last'];
			}
		}
		
		if (isset($useTemplate[$item->position])) {
			
			return $useTemplate[$item->position];
		
		} else {
			
			if ($item->position % 2 === 1) {
				
				if (isset($useTemplate['odd'])) {
					return $useTemplate['odd'];
				}
			
			} else {
				
				if (isset($useTemplate['even'])) {
					return $useTemplate['even'];
				}
			}
		}
		
		if (isset($useTemplate['defaultPosition'])) {
			return $useTemplate['defaultPosition'];
		}
		
		return $this->getDefaultTemplate($item);
	}

	function setDefaultTemplates()
	{
		// the default templates should look like this
		//			$folderTemplate = '<li><a href="<we:navigationField name="href">"><we:navigationField name="text"></a><ul><we:navigationEntries /></ul></li>';
		//			$itemTemplate = '<li><a href="<we:navigationField name="href">"><we:navigationField name="text"></a></li>';
		//			$rootTemplate = '<we:navigationEntries />';
		

		$folderTemplate = '<li><a href="<?php printElement( we_tag("navigationField", array("name"=>"href"), "")); ?>"><?php printElement( we_tag("navigationField", array("name"=>"text"), "")); ?></a><?php if(we_tag("ifHasEntries", array())): ?><ul><?php printElement( we_tag("navigationEntries", array(), "")); ?></ul><?php endif ?></li>';
		$itemTemplate = '<li><a href="<?php printElement( we_tag("navigationField", array("name"=>"href"), "")); ?>"><?php printElement( we_tag("navigationField", array("name"=>"text"), "")); ?></a></li>';
		$rootTemplate = '<?php printElement( we_tag("navigationEntries", array(), "")); ?>';
		
		$this->setTemplate($folderTemplate, 'folder', 'defaultLevel', 'defaultCurrent', 'defaultPosition');
		$this->setTemplate($itemTemplate, 'item', 'defaultLevel', 'defaultCurrent', 'defaultPosition');
		$this->setTemplate($rootTemplate, 'root', 'defaultLevel', 'defaultCurrent', 'defaultPosition');
	}

	function getDefaultTemplate($item)
	{
		return $this->templates[$item->type]['defaultLevel']['defaultCurrent']['defaultPosition'];
	}

	function writeNavigation($depth = false)
	{
		$GLOBALS['weNavigationObject'] = & $this;
		
		$content = '';
		if (isset($this->items['id' . $this->rootItem])) {
			
			if ($this->items['id' . $this->rootItem]->type == 'folder' && $depth !== false) {
				// if initialised by id => root item is on lvl0 -> therefore decrease depth
				// this is to make it equal init by id, parentid
				$depth--;
			}
			$content = $this->items['id' . $this->rootItem]->writeItem($this, $depth);
		}
		
		return $content;
	}

	function setTemplate($content, $type, $level, $current, $position)
	{
		
		$this->templates[$type][$level][$current][$position] = $content;
	}

	function readItemsFromDb($id)
	{
		
		$this->Storage['items'] = array();
		
		$this->Storage['ids'] = array();
		
		$_pathArr = id_to_path($id, NAVIGATION_TABLE, "", false, true);
		$_path = isset($_pathArr[0]) ? $_pathArr[0] : "";
		
		$_db = new DB_WE();
		
		$_path = clearPath($_path . '/%');
		
		$_ids = array();
		
		$query = 'SELECT * FROM ' . NAVIGATION_TABLE . ' WHERE Path LIKE "' . mysql_real_escape_string($_path) . '" ' . ($id != 0 ? ' OR ID="' . abs($id) . '"' : '') . ' ORDER BY Ordn;';
		
		$_db->query($query);
		while ($_db->next_record()) {
			
			$_tmpItem = $_db->Record;
			$_tmpItem["Name"] = $_tmpItem["Text"];
			$this->Storage['items'][] = $_tmpItem;
			unset($_tmpItem);
			
			if ($_db->Record['IsFolder'] == '1' && ($_db->Record['FolderSelection'] == '' || $_db->Record['FolderSelection'] == 'docLink')) {
				$_ids[] = $_db->Record['LinkID'];
			} else 
				if ($_db->Record['Selection'] == 'static' && $_db->Record['SelectionType'] == 'docLink') {
					$_ids[] = $_db->Record['LinkID'];
				} else 
					if (($_db->Record['SelectionType'] == 'category' || $_db->Record['SelectionType'] == 'catLink') && $_db->Record['LinkSelection'] != 'extern') {
						$_ids[] = $_db->Record['UrlID'];
					}
			
			if (!empty($_db->Record['IconID'])) {
				$_ids[] = $_db->Record['IconID'];
			}
		
		}
		
		if (count($_ids)) {
			array_unique($_ids);
			
			$_db->query('SELECT ID,Path FROM ' . FILE_TABLE . ' WHERE ID IN(' . implode(',', $_ids) . ') ORDER BY ID');
			while ($_db->next_record()) {
				$this->Storage['ids'][$_db->f('ID')] = $_db->f('Path');
			}
		}
	
	}

	function getItemFromPool($id)
	{
		
		foreach ($this->Storage['items'] as $item) {
			if ($item['ID'] == $id) {
				return $item;
			}
		}
		
		return null;
	
	}

	function id2path($id)
	{
		
		if (isset($this->Storage['ids'][$id])) {
			return $this->Storage['ids'][$id];
		} else {
			$_path = id_to_path($id, FILE_TABLE);
			$this->Storage['ids'][$id] = $_path;
			return $_path;
		}
	
	}

}
?>