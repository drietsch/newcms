<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_toolfactory
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

$appDir = Zend_Controller_Front::getInstance()->getParam('appDir');

$frameset = new we_ui_layout_Frameset(array('rows' => '1,*'));
$frameset->addFrame(array(
	'src' => '/webEdition/html/frameheader.html', 
	'name' => 'treeheader', 
	'noresize' => 'noresize', 
	'scrolling' => 'no'
));

$frameset->addFrame(array(
	'src' => $appDir . '/index.php/tree/index' .
		($this->modelId ?
			'/modelId/' . $this->modelId :
			''),
	'name' => 'tree', 
	'noresize' => 'noresize', 
	'scrolling' => 'auto'
));


$page = we_ui_layout_HTMLPage::getInstance();
$page->setFrameset($frameset);
echo $page->getHTML();
