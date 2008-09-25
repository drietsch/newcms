/**
 * Base class for app models
 * 
 * @category   app
 * @package    app_models
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */
class <?php print $CLASSNAME;?>_models_Default extends we_app_Model
{
	/**
	 * ContentType attribute
	 *
	 * @var string
	 */
	public $ContentType = "<?php print $TOOLNAME;?>/item";
	
	/**
	 * _appName attribute
	 *
	 * @var string
	 */
	protected $_appName = '<?php print $TOOLNAME;?>';

	/**
	 * Constructor
	 * 
	 * @param string $<?php print $TOOLNAME;?>ID
	 * @return void
	 */
	function __construct($<?php print $TOOLNAME;?>ID = 0)
	{
		parent::__construct(<?php print (isset($TABLECONSTANT) && $TABLEEXISTS && !empty($TABLECONSTANT)) ? $TABLECONSTANT : "''";?>);
		if ($<?php print $TOOLNAME;?>ID) {
			$this->{$this->_primaryKey} = $<?php print $TOOLNAME;?>ID;
			$this->load($<?php print $TOOLNAME;?>ID);
		}
		<?php if(!isset($TABLECONSTANT) || !$TABLEEXISTS || (isset($TABLECONSTANT) && empty($TABLECONSTANT))) {?>
			$this->setPersistentSlots(array('ID', 'Text'));
		<?php } ?>
	
	}
	
	/**
	 * set Fields
	 * 
	 * @param array $fields
	 * @return void
	 */
	public function setFields($fields) {
		parent::setFields($fields);
		<?php if(isset($TABLECONSTANT) && $TABLEEXISTS && !empty($TABLECONSTANT)) {?>
			$this->setPath();
		<?php } ?>
	}
	
	<?php if(!isset($TABLECONSTANT) || !$TABLEEXISTS || (isset($TABLECONSTANT) && empty($TABLECONSTANT))) {?>
	/**
	 * Load entry
	 * 
	 * @param integer $id 
	 * @return boolean returns true on success, otherwise false
	 */
	function load($id)
	{
		return true;
	}
	
	/**
	 * Save entry
	 * 
	 * @return boolean returns true on success, otherwise false
	 */
	function save()
	{
		return true;
	}
	<?php } ?>

}
