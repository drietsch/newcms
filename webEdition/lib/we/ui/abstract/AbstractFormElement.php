<?php
/**
 * webEdition SDK
 *
 * LICENSE_TEXT
 *
 * TODO insert license text
 *
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_abstract
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENCE_TYPE  TODO insert license type and url
 * @version    $Id: AbstractFormElement.php,v 1.2 2008/05/15 12:07:15 holger.meyer Exp $
 */

/**
 * @see we_ui_abstract_AbstractElement
 */
Zend_Loader::loadClass('we_ui_abstract_AbstractElement');

/**
 * Base class for elements in html forms
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_abstract
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
abstract class we_ui_abstract_AbstractFormElement extends we_ui_abstract_AbstractElement
{

	/**
	 * id attribute
	 *
	 * @var string
	 */
	protected $_name = '';

	/**
	 * Retrieve name attribute
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->_name;
	}

	/**
	 * Set name attribute
	 * 
	 * @param string $name
	 * @return void
	 */
	public function setName($name)
	{
		$this->_name = $name;
	}

}
