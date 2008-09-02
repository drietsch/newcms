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

$frameset = new we_ui_layout_Frameset(array('rows' => '40,*,40'));

$frameset->addFrame(array(
	'src' => $appDir . '/index.php/editor/header' . $this->paramString,
	'name' => 'edheader', 
	'noresize' => 'noresize', 
	'scrolling' => 'no'
));

$frameset->addFrame(array(
	'src' => $appDir . '/index.php/editor/body' . $this->paramString,
	'name' => 'edbody', 
	'scrolling' => 'auto'
));

$frameset->addFrame(array(
	'src' => $appDir . '/index.php/editor/footer' . $this->paramString,
	'name' => 'edfooter', 
	'scrolling' => 'no'
));

// set and return html code		
$page = we_ui_layout_HTMLPage::getInstance();
$page->setFrameset($frameset);


echo $page->getHTML();
