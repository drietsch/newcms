
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
