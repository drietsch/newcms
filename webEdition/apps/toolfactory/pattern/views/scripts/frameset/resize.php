
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
