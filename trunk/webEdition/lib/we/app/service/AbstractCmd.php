<?php

/* webEdition SDK
 *
 * LICENSE_TEXT
 *
 * TODO insert license text
 *
 * @category   we
 * @package    we_app
 * @subpackage we_app_service
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENCE_TYPE  TODO insert license type and url
 * @version    $Id: AbstractCmd.php,v 1.8 2008/07/29 13:59:27 thomas.kneip Exp $
 */

/**
 * @see we_service_AbstractService
 */
Zend_Loader::loadClass('we_service_AbstractService');

/**
 * Abstract Class for all App Services
 * 
 * @category   we
 * @package    we_app
 * @subpackage we_app_service
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
abstract class we_app_service_AbstractCmd extends we_service_AbstractService
{

	public function save($args)
	{
		$utf8_decode = true;
		
		$translate = we_core_Local::addTranslation('apps.xml');
		
		if (!isset($args[0])) {
			throw new we_service_Exception(
					'Form data not set (first argument) at save cmd!', 
					we_service_ErrorCodes::kModelFormDataNotSet);
		}
		$formData = $args[0];
		
		$controller = Zend_Controller_Front::getInstance();
		$appName = $controller->getParam('appName');
		$session = new Zend_Session_Namespace($appName);
		if (!isset($session->model)) {
			throw new we_service_Exception(
					'Model is not set in session!', 
					we_service_ErrorCodes::kModelNotSetInSession);
		}
		$model = $session->model;
		$model->setFields($formData);
		
		$newBeforeSaving = $model->ID == 0;
		// check if user has the permissions to create new entries
		if ($model->ID == 0 && !we_core_Permissions::hasPerm('NEW_APP_' . strtoupper($appName))) {
			$ex = new we_service_Exception(
					$translate->_(
							'You do not have the permission to create new entries or folders!',null,$utf8_decode));
			$ex->setType('warning');
			throw $ex;
		}
		
		// check if name is empty
		if ($model->Text === '') {
			$ex = new we_service_Exception(
					$translate->_('The name must not be empty!', null,$utf8_decode), 
					we_service_ErrorCodes::kModelTextEmpty);
			$ex->setType('warning');
			throw $ex;
		}

		// check if name is valid
		if ($model->filenameNotValid()) {
			$ex = new we_service_Exception(
					$translate->_('Invalid filename!', null,$utf8_decode), 
					we_service_ErrorCodes::kModelTextEmpty);
			$ex->setType('warning');
			throw $ex;
		}
		
		// check if it is a folder saving in itself
		if ($model->IsFolder && $model->ID > 0 && $model->ParentID == $model->ID) {
			$ex = new we_service_Exception(
					$translate->_('The folder cannot be saved in the chosen folder!', null,$utf8_decode), 
					we_service_ErrorCodes::kModelTextEmpty);
			$ex->setType('warning');
			throw $ex;
		}
		
		try {
			$model->save();
		} catch (we_core_ModelException $e) {
			switch ($e->getCode()) {
				case we_service_ErrorCodes::kPathExists :
					$ex = new we_service_Exception(
							$translate->_('The name already exists! Please choose another name or folder.',null, $utf8_decode), 
							$e->getCode());
					$ex->setType('warning');
					throw $ex;
					break;
				default :
					throw new we_service_Exception($e->getMessage(), $e->getCode());
			}
		
		}
		return array(
			'model' => $model, 'newBeforeSaving' => $newBeforeSaving
		);
	}

	public function delete($args)
	{
		if (!isset($args[0])) {
			throw new we_service_Exception(
					'ID not set (first argument) at delete cmd!', 
					we_service_ErrorCodes::kModelIdNotSet);
		}
		$IdToDel = $args[0];
		$controller = Zend_Controller_Front::getInstance();
		$appName = $controller->getParam('appName');
		$session = new Zend_Session_Namespace($appName);
		if (!isset($session->model)) {
			throw new we_service_Exception(
					'Model is not set in session!', 
					we_service_ErrorCodes::kModelNotSetInSession);
		}
		$model = $session->model;
		
		if ($model->ID != $IdToDel) {
			throw new we_service_Exception(
					'Security Error: Model Ids are not the same! Id must fit the id of the model stored in the session!', 
					we_service_ErrorCodes::kModelIdsNotTheSame);
		}
		
		try {
			$model->delete();
		} catch (we_core_ModelException $e) {
			throw new we_service_Exception($e->getMessage());
		}
		
		//return deleted model
		return array(
			'model' => $model
		);
	}

}
