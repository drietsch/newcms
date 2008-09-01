<?php

/**
 * webEdition SDK
 *
 * LICENSE_TEXT
 *
 * TODO insert license text
 *
 * @category   we
 * @package    we_service
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENCE_TYPE  TODO insert license type and url
 */

/**
 * class for cmd service
 * 
 * @category   we
 * @package    we_service
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
class we_service_Cmd extends we_service_AbstractService
{
	/**
	 * create model
	 * 
	 * @param array $args 
	 * @return NULL
	 */
	public function createModel($args)
	{
		if (!isset($args[0])) {
			throw new we_service_Exception('No model class name set!');
		}
		try {
			Zend_Loader::loadClass($args[0]);
			$model = new $args[0]();
			if (isset($args[1])) {
				$model->load(($args[1]));
			}
			return $model;
		} catch (Zend_Exception $e) {
			throw new we_service_Exception('Error creating new model: ' . $e->getMessage());
		}
		return NULL;
	}

}