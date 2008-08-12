<?php
					
class leer_models_Default extends we_app_Model
{

	public $ContentType = "leer/item";
	
	protected $_appName = 'leer';

	function __construct($leerID = 0)
	{
		parent::__construct(LEER_TABLE);
		if ($leerID) {
			$this->{$this->_primaryKey} = $leerID;
			$this->load($leerID);
		}
			
	}
	
	public function setFields($fields) {
		parent::setFields($fields);
					$this->setPath();
			}
	
	
}

		?>