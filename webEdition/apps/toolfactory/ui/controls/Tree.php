<?php


/* webEdition SDK
 *
 * LICENSE_TEXT
 *
 * TODO insert license text
 *
 * @category   toolfactory
 * @package    toolfactory_ui
 * @subpackage toolfactory_ui_controls
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENCE_TYPE  TODO insert license type and url
 * @version    $Id: Tree.php,v 1.3 2008/07/14 06:49:09 thomas.kneip Exp $
 */

/**
 * @see we_ui_controls_Tree
 */
Zend_Loader::loadClass('we_ui_controls_Tree');

/**
 * Class to display a tree for toolfactory objects
 * 
 * @category   toolfactory
 * @package    toolfactory_ui
 * @subpackage toolfactory_ui_controls
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
class toolfactory_ui_controls_Tree extends we_ui_controls_Tree
{
	/**
	 * Constructor
	 * 
	 * Sets object propeties if set in $properties array
	 * 
	 * @param array $properties associative array containing named object properties
	 * @return void
	 */
	public function __construct($properties = null)
	{
		parent::__construct($properties);
		
		// add needed CSS files
		$this->addCSSFile(we_ui_layout_Themes::computeCSSURL(__CLASS__));		
	}
	
	public function getNodeObject($id, $text) 
	{

		$out = 'var myobj = { ';
				$out .= 'label: "<span title=\"'.$text.'\" id=\"spanText_' . $this->_id . '_'.$id.'\">'.$text.'</span>"';
				$out .= ',';
				$out .= 'id: "'.$id.'"';
				$out .= ',';
				$out .= 'text: "'.$text.'"';
				$out .= ',';
				$out .= 'title: "'.$id.'"';			
		$out .= '}; ';
		
		return $out;
	}
		
	
	public static function doCustom()
	{
		$items=array();
		include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_classes/tools/weToolLookup.class.php');
		$_tools = weToolLookup::getAllTools();

		foreach($_tools as $_k=>$_tool) {		
			if(!weToolLookup::isInIgnoreList($_tool['name'])) {
				if(isset($_tool['realname'])) {
					$name = html_entity_decode($_tool['realname'],ENT_QUOTES);
				}
				else {
					$name = $_tool['name'];
				}
				$items[]=array(
					'ID'=>$_tool['name'],
					'ParentID'=>0,
					'Text'=>$name,
					'ContentType'=>'toolfactory/item',
					'IsFolder'=>0
				);
			}
			
		}
		
		return $items;
	}
	
	public static function getTreeIconClass($contentType, $extension='')  
	{
		switch($contentType) {
			case "toolfactory/item":
				return "toolfactory_item";
				break;
			default:
				return we_ui_controls_Tree::getTreeIconClass($contentType, $extension='');
		}
	}
	
	
	protected function _renderHTML() 
	{
		
		$this->setUpData();
		$session = new Zend_Session_Namespace($this->_sessionName);
		if(!isset($session->openNodes)) {
			$session->openNodes = $this->getOpenNodes();
		}

		$js = '
			var tree_' . $this->_id . ' = new YAHOO.widget.TreeView("'.$this->_id.'");
			var tree_' . $this->_id . '_activEl = 0;       

			(function() {

				function tree_' . $this->_id . '_Init() { 
												
					'.$this->getNodesJS().'
							
					tree_' . $this->_id . '.draw(); 
				}

				YAHOO.util.Event.addListener(window, "load", tree_' . $this->_id . '_Init); 

			})();
		';
		
		$page = we_ui_layout_HTMLPage::getInstance();
		$page->addInlineJS($js);
		
		return '<div id="'.htmlspecialchars($this->_id).'"></div>';
	}
	
}
