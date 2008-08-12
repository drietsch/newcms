<?php

/**
 * webEdition SDK
 *
 * LICENSE_TEXT
 *
 * TODO insert license text
 *
 * @category   we
 * @package    we_core
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENCE_TYPE  TODO insert license type and url
 * @version    $Id: AbstractObject.php,v 1.3 2008/06/13 17:01:58 holger.meyer Exp $
 */

/**
 * Base class for all webEdition SDK classes
 * 
 * @category   we
 * @package    we_core
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
abstract class we_core_AbstractObject
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
		if (!is_null($properties)) {
			foreach ($properties as $key => $val) {
				$methodName = 'set' . ucfirst($key);
				if (method_exists($this, $methodName)) {
					$this->$methodName($val);
				}
			}
		}
	}

}
