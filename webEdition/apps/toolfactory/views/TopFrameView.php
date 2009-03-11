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
 * @see we_app_TopFrameView
 */
Zend_Loader::loadClass('we_app_TopFrameView');

/**
 * Base class for TopFrameView 
 * 
 * @category   app
 * @package    app_views
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */
class toolfactory_views_TopFrameView extends we_app_TopFrameView {

	/**
	 * return the javascript code of the top frame
	 * 
	 * @return string
	 */
	public function getJSTop()
	{
		
		$page = we_ui_layout_HTMLPage::getInstance();
		$page->addJSFile('/webEdition/lib/we/ui/layout/Dialog.js');
		
		$translate = we_core_Local::addTranslation('apps.xml');
		we_core_Local::addTranslation('default.xml', 'toolfactory');
		
		$fs = self::kEditorFrameset;		
		
		// predefined message for JS output

		$saveMessage = we_util_Strings::quoteForJSString($translate->_('The application \'%s\' has been succesfully saved. Please restart webEdition!'), false);
		
		$saveEntryMessageCall = we_core_MessageReporting::getShowMessageCall('msg', we_core_MessageReporting::kMessageNotice, true);
		
		$nothingToSaveMessage = we_util_Strings::quoteForJSString($translate->_('There is nothing to save!'), false);
		
		$nothingToSaveMessageCall = we_core_MessageReporting::getShowMessageCall($nothingToSaveMessage, we_core_MessageReporting::kMessageNotice);
		
		$nothingToDeleteMessage = we_util_Strings::quoteForJSString($translate->_('There is nothing to delete!'), false);
		
		$nothingToDeleteMessageCall = we_core_MessageReporting::getShowMessageCall($nothingToDeleteMessage, we_core_MessageReporting::kMessageNotice);
		
		$deleteMessage = we_util_Strings::quoteForJSString($translate->_('The entry/folder \'%s\' has been succesfully deleted.'), false);
		
		$deleteMessageCall = we_core_MessageReporting::getShowMessageCall('msg', we_core_MessageReporting::kMessageNotice, true);
		
		$errorMessageCall = we_core_MessageReporting::getShowMessageCall('err', we_core_MessageReporting::kMessageError, true);
		$noticeMessageCall = we_core_MessageReporting::getShowMessageCall('err', we_core_MessageReporting::kMessageNotice, true);
		$warningMessageCall = we_core_MessageReporting::getShowMessageCall('err', we_core_MessageReporting::kMessageWarning, true);
		
		$loadingWheelFrame = $fs.".edbody.";
		$loadingWheelContainer = "document.getElementById('containerDivBody')";
		$loadingWheelImg = we_ui_layout_Image::kLoading;
		
		$js = <<<EOS


self.hot = false;
self.focus();
self.appName = "{$this->appName}";

parent.document.title = "webEdition {$translate->_('Applications')} - {$translate->_($this->appName)}";


/*******************************************
****************** Events ******************
********************************************/

/***************** Error Handling *****************/

/* cmdError */
weEventController.register("cmdError", function(data, sender) {
	if (typeof(data.errorMessage) != "undefined") {
		err = data.errorMessage;
	} else {
		err = "Unknown Error";
	}
	$errorMessageCall
	__removeLoadingWheel__(data, sender);	
});

/* cmdNotice */
weEventController.register("cmdNotice", function(data, sender) {
	if (typeof(data.errorMessage) != "undefined") {
		err = data.errorMessage;
	} else {
		err = "Unknown Error";
	}
	$noticeMessageCall	
	__removeLoadingWheel__(data, sender);
});

/* cmdWarning */
weEventController.register("cmdWarning", function(data, sender) {
	if (typeof(data.errorMessage) != "undefined") {
		err = data.errorMessage;
	} else {
		err = "Unknown Error";
	}
	$warningMessageCall	
	__removeLoadingWheel__(data, sender);
});



/***************** Document based events *****************/

/* docChanged */
weEventController.register("docChanged", function(data, sender) {
	self.hot = true;
});

/* remove Loading Wheel */
function __removeLoadingWheel__(data, sender) {
	var loadingWheel = {$loadingWheelFrame}document.getElementById('loadingWheelDiv');
	if (typeof({$loadingWheelFrame}{$loadingWheelContainer}) != "undefined") {
		{$loadingWheelFrame}{$loadingWheelContainer}.removeChild(loadingWheel);	
	}
}
weEventController.register("save", __removeLoadingWheel__);


/* save */
weEventController.register("save", function(data, sender) {

	self.hot = false;
	var msg = "$saveMessage";
	
	//datasource: table
	if(data.model.Path!=null) {
		text = data.model.Path;
	}
	else {
		//custom tool, no Path
		text = data.model.Text;
	}
	msg = msg.replace(/%s/, data.model.Text);
	
	$saveEntryMessageCall	

	
});

/* delete */
weEventController.register("delete", function(data, sender) {
	// fire home command, because when entry is deleted we can't show it anymore!
	weCmdController.fire({"cmdName": "app_{$this->appName}_home"});
	self.hot = false;  // reset hot
	var msg = "$deleteMessage";
	msg = msg.replace(/%s/, data.model.Path);
	$deleteMessageCall	
	
});

/*******************************************
***************** COMMANDS *****************
********************************************/

/* new */
weCmdController.register('new_top', 'app_{$this->appName}_new', function(cmdObj) {
	if (self.hot && ! cmdObj.ignoreHot) {
		_weYesNoCancelDialog(cmdObj);
	} else {
		{$fs}.location.replace("{$this->appDir}/index.php/editor/index");
		// tell the command controller that the command was ok. Needed to check if there is a following command
		weCmdController.cmdOk(cmdObj);
	}
});

/* new folder */
weCmdController.register('new_folder_top', 'app_{$this->appName}_new_folder', function(cmdObj) {
	if (self.hot && ! cmdObj.ignoreHot) {
		_weYesNoCancelDialog(cmdObj);
	} else {
		{$fs}.location.replace("{$this->appDir}/index.php/editor/index/folder/1");
		// tell the command controller that the command was ok. Needed to check if there is a following command
		weCmdController.cmdOk(cmdObj);
	}
});

/* open */
weCmdController.register('open_top', 'app_{$this->appName}_open', function(cmdObj) {
	if (self.hot && ! cmdObj.ignoreHot) {
		_weYesNoCancelDialog(cmdObj);
	} else {
		{$fs}.location.replace("{$this->appDir}/index.php/editor/index/modelId/" + cmdObj.id);
		// tell the command controller that the command was ok. Needed to check if there is a following command
		weCmdController.cmdOk(cmdObj);
	}
});

/* save */
weCmdController.register('save_top', 'app_{$this->appName}_save', function(cmdObj) {
	if (typeof({$fs}.edbody) == "undefined") {
		$nothingToSaveMessageCall
	} else {
		addLoadingWheel();
		we_core_JsonRpc.callMethod(
			cmdObj, 
			"{$this->appDir}/index.php/rpc/index", 
			"{$this->appName}.service.Cmd", 
			"save", 
			{$fs}.edbody.document.we_form
		);
	}
});


/* delete */
weCmdController.register('delete_top', 'app_{$this->appName}_delete', function(cmdObj) {
	if (typeof({$fs}.edbody) == "undefined") {
		$nothingToDeleteMessageCall
	} else {
		we_core_JsonRpc.callMethod(
			cmdObj, 
			"{$this->appDir}/index.php/rpc/index", 
			"{$this->appName}.service.Cmd", 
			"delete", 
			{$fs}.edbody.document.we_form.ID.value
		);
	}
});


/* home */
weCmdController.register('home_top', 'app_{$this->appName}_home', function(cmdObj) {
	{$fs}.location.replace("{$this->appDir}/index.php/home/index");
	// tell the command controller that the command was ok. Needed to check if there is a following command
	weCmdController.cmdOk(cmdObj);
});

/* exit */
weCmdController.register('exit_top', 'app_{$this->appName}_exit', function(cmdObj) {
	if (self.hot && ! cmdObj.ignoreHot) {
		_weYesNoCancelDialog(cmdObj);
	} else {
		top.close();
	}
});

/* help */
weCmdController.register('help_top', 'app_{$this->appName}_help', function(cmdObj) {
	var dialog = new we_ui_layout_Dialog("/webEdition/getHelp.php", 900, 700, null);
	dialog.open();
});

/* info */
weCmdController.register('info_top', 'app_{$this->appName}_info', function(cmdObj) {
	var dialog = new we_ui_layout_Dialog("/webEdition/we_cmd.php?we_cmd[0]=info", 432, 350, null);
	dialog.open();
});


/*************************** Helper functions ******************************/

function _weYesNoCancelDialog(cmdObj) {
	var yesCmd = {cmdName : "app_{$this->appName}_save", followCmd : cmdObj};
	var noCmd = cmdObj;
	noCmd.ignoreHot = true;
	var dialog = new we_ui_layout_Dialog("{$this->appDir}/index.php/editor/exitdocquestion", 380, 130, {"yesCmd":yesCmd, "noCmd":noCmd});
	dialog.open();
}

function addLoadingWheel() {
	var loadingImgDiv = {$loadingWheelFrame}document.createElement('div');
	loadingImgDiv.id = "loadingWheelDiv";
	loadingImgDiv.className = 'weLoadingWheelDiv';
	var loadingImg = {$loadingWheelFrame}document.createElement('img');
	loadingImg.src = "{$loadingWheelImg}";
	loadingImg.className = 'weLoadingWheel';
	loadingImgDiv.appendChild(loadingImg);	
	{$loadingWheelFrame}{$loadingWheelContainer}.appendChild(loadingImgDiv);	
}

EOS;
		return $js;
	}
}