

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
