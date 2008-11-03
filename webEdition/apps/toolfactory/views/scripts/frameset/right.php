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

$appDir = Zend_Controller_Front::getInstance()->getParam('appDir');

$client = we_ui_Client::getInstance();

$frameset = new we_ui_layout_Frameset();

$params = 	($this->tab ?
				'/tab/' . $this->tab :
				'') .
			($this->sid ?
				'/sid/' . $this->sid :
				'') .
			($this->modelId ?
				'/modelId/' . $this->modelId :
				'');
			
$controller = $this->modelId ? 'editor/index' . $params : 'home/index/';
	
			
if ($client->getBrowser() == we_ui_Client::kBrowserGecko) {
	$frameset->setCols('*');
	$frameset->addFrame(array(
		'src' => $appDir . '/index.php/' . $controller,
		'name' => 'editor', 
		'noresize' => 'noresize', 
		'scrolling' => 'no'
	));
} else if ($client->getBrowser() == we_ui_Client::kBrowserWebkit) {
	$frameset->setCols('1,*');
	$frameset->addFrame(array(
		'src' => '/webEdition/html/safariResize.html', 
		'name' => 'separator', 
		'noresize' => null, 
		'scrolling' => 'no'
	));
	$frameset->addFrame(array(
		'src' => $appDir . '/index.php/' . $controller,
		'name' => 'editor', 
		'noresize' => 'noresize', 
		'scrolling' => 'no'
	));
} else {
	$frameset->setCols('2,*');
	$frameset->addFrame(array(
		'src' => '/webEdition/html/ieResize.html', 
		'name' => 'separator', 
		'noresize' => 'noresize', 
		'scrolling' => 'no'
	));
	$frameset->addFrame(array(
		'src' => $appDir . '/index.php/' . $controller,
		'name' => 'editor', 
		'noresize' => 'noresize', 
		'scrolling' => 'no'
	));
}

$page = we_ui_layout_HTMLPage::getInstance();
$page->setFrameset($frameset);

echo $page->getHTML();	
