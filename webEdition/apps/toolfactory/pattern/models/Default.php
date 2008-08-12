
class <?php print $CLASSNAME;?>_models_Default extends we_app_Model
{

	public $ContentType = "<?php print $TOOLNAME;?>/item";
	
	protected $_appName = '<?php print $TOOLNAME;?>';

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
	
	public function setFields($fields) {
		parent::setFields($fields);
		<?php if(isset($TABLECONSTANT) && $TABLEEXISTS && !empty($TABLECONSTANT)) {?>
			$this->setPath();
		<?php } ?>
	}
	
	<?php if(!isset($TABLECONSTANT) || !$TABLEEXISTS || (isset($TABLECONSTANT) && empty($TABLECONSTANT))) {?>
	function load($id)
	{
		return true;
	}
	
	function save()
	{
		return true;
	}
	<?php } ?>

}
