<?php

class we_service_Cmd extends we_service_AbstractService{

	public function createModel($args) {
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