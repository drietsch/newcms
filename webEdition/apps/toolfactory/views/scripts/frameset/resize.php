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

$param = 	($this->tab ?
				'/tab/' . $this->tab :
				'') .
			($this->sid ?
				'/sid/' . $this->sid :
				'') .
			($this->modelId ?
				'/modelId/' . $this->modelId :
				'');
			
if ($client->getBrowser() == we_ui_Client::kBrowserGecko) {
	$frameAttribs = array(
		'cols' => '200,*', 
		'border' => '1', 
		'id' => 'resizeframeid',
		'frameborder' =>'',
		'framespacing'=>''
	);
} else {
	$frameAttribs = array(
		'cols' => '200,*', 
		'id' => 'resizeframeid'
	);
}

$frameset = new we_ui_layout_Frameset($frameAttribs);

if ($client->getBrowser() == we_ui_Client::kBrowserIE) {
	$frameset->addFrame(array(
		'src' => $appDir . '/index.php/frameset/left' . $param,
		'name' => 'left', 
		'scrolling' => 'no', 
		'frameborder' => 'no'
	));
} else {
	$frameset->addFrame(array(
		'src' => $appDir . '/index.php/frameset/left' . $param,
		'name' => 'left', 
		'scrolling' => 'no'
	));
}

$frameset->addFrame(array(
		'src' => $appDir . '/index.php/frameset/right' . $param,
		'name' => 'right'
));

$page = we_ui_layout_HTMLPage::getInstance();
$page->setFrameset($frameset);

echo $page->getHTML();
