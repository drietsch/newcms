

/**
 * @see we_ui_controls_Tree
 */
Zend_Loader::loadClass('we_ui_controls_Tree');


class <?php print $TOOLNAME;?>_ui_controls_Tree extends we_ui_controls_Tree
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
	
	/**
	 * Retrieve class of tree icon
	 * 
	 * @param string $contentType
	 * @param string $extension
	 * @return string
	 */
	public static function getTreeIconClass($contentType, $extension='')  
	{
		switch($contentType) {
			case "<?php print $TOOLNAME;?>/item":
				return "<?php print $TOOLNAME;?>_item";
				break;
			default:
				return we_ui_controls_Tree::getTreeIconClass($contentType, $extension='');
		}
	}
	
}
