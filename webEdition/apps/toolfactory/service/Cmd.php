<?php
/**
 * webEdition CMS
 *
 * This source is part of webEdition CMS. webEdition CMS is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package    webEdition_toolfactory
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */

/**
 * class for Services
 * 
 * @category   app
 * @package    app_service
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */
class toolfactory_service_Cmd extends we_app_service_AbstractCmd
{
	/**
	 * check arguments and save the model
	 * @param array $args
	 * 
	 * @return void
	 */
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
					$translate->_('The name must not be empty!',null,$utf8_decode), 
					we_service_ErrorCodes::kModelTextEmpty);
			$ex->setType('warning');
			throw $ex;
		}
		
		// check if name is empty after converting text name for internal use
		if ($model->classname === '') {
			$ex = new we_service_Exception(
					$translate->_('The name of the model class could not be empty!',null,$utf8_decode), 
					we_service_ErrorCodes::kModelTextEmpty);
			$ex->setType('warning');
			throw $ex;
		}
		
		// check if it is a folder saving in itself
		if ($model->IsFolder && $model->ID > 0 && $model->ParentID == $model->ID) {
			$ex = new we_service_Exception(
					$translate->_('The folder cannot be saved in the chosen folder!',null,$utf8_decode), 
					we_service_ErrorCodes::kModelTextEmpty);
			$ex->setType('warning');
			throw $ex;
		}
		// check all required fields
		$_miss = array();
		if (!$model->hasRequiredFields($_miss)) {
			$ex = new we_service_Exception(
					$translate->_('Required fields are empty!',null,$utf8_decode), 
					we_service_ErrorCodes::kModelTextEmpty);
			$ex->setType('warning');
			throw $ex;
		}
								
		// check if maintable name is valid
		if($model->maintablenameNotValid()){
			$ex = new we_service_Exception(
					$translate->_('The name of the maintable is not valid!',null,$utf8_decode), 
					we_service_ErrorCodes::kModelTextEmpty);
			$ex->setType('warning');
			throw $ex;
		}
		
		// check if maintable exists
		if((isset($model->maintable) && $model->maintable!="")) {
			if(we_io_DB::tableExists($model->maintable)){
				$ex = new we_service_Exception(
					$translate->_('The maintable exists!',null,$utf8_decode), 
					we_service_ErrorCodes::kModelTextEmpty);
				$ex->setType('warning');
				throw $ex;
			}
		}
		
		if($model->filenameNotValid()) {
			$ex = new we_service_Exception(
				$translate->_('The name is not valid!',null,$utf8_decode), 
				we_service_ErrorCodes::kModelTextEmpty);
			$ex->setType('warning');
			throw $ex;
		}
		
		if($model->fileclassnameNotValid()) {
			$ex = new we_service_Exception(
				$translate->_('The name of the model class is not valid!',null,$utf8_decode), 
				we_service_ErrorCodes::kModelTextEmpty);
			$ex->setType('warning');
			throw $ex;
		}
		
		if($model->modelclassExists($model->classname)) {
			$ex = new we_service_Exception(
				$translate->_('The model class exists!',null,$utf8_decode), 
				we_service_ErrorCodes::kModelTextEmpty);
			$ex->setType('warning');
			throw $ex;
		}
		
		$charset = we_core_Local::getComputedUICharset();
		//$model->realname = htmlentities($model->Text,ENT_QUOTES);
		$text = $model->Text;
		
		$text = utf8_decode($model->Text);
		
		$model->realname = addslashes($text);		
		
		/*
		if($model->toolExists($model->realname)) {
			$ex = new we_service_Exception(
				$translate->_('The application exists!',null,$utf8_decode), 
				we_service_ErrorCodes::kModelTextEmpty);
			$ex->setType('warning');
			throw $ex;
		}
		*/

		try {
			$model->save();
		} catch (we_core_ModelException $e) {
			switch ($e->getCode()) {
				case we_service_ErrorCodes::kPathExists :
					$ex = new we_service_Exception(
							$translate->_('The name already exists! Please choose another name or folder.',null,$utf8_decode), 
							$e->getCode());
					$ex->setType('warning');
					throw $ex;
					break;
				default :
					throw new we_service_Exception($e->getMessage(), $e->getCode());
			}
		
		}
		$model->ID = $model->classname;
		
		return array(
			'model' => $model, 'newBeforeSaving' => $newBeforeSaving
		);
	}

	/**
	 * check arguments and delete the model
	 * @param array $args
	 * 
	 * @return array
	 */
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