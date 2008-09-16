

$controller = Zend_Controller_Front::getInstance();
$appName = $controller->getParam('appName');
$appDir = $controller->getParam('appDir');

//	Include the menu config
include ($appName . '/conf/we_menu_' . $appName . '.conf.php');
		
$lang_arr = 'we_menu_' . $appName;

$menu = new we_ui_controls_JavaMenu(array(
	'entries'   => $$lang_arr,
	'width'     => 350,
	'height'    => 30,
	'cmdURL'    => $appDir . '/index.php/cmd/menu/name/',
	'cmdTarget'	=> 'cmd_' . $appName
));
		
$messageConsole = new we_ui_controls_MessageConsole(array('consoleName' => 'toolFrame'));
$table = new we_ui_layout_Table();
$table->setWidth('100%');

$table->addElement($menu, 0, 0);
$table->setCellAttributes(array('align' => 'left', 'valign' => 'top'));
$table->addElement($messageConsole, 1, 0);
$table->setCellAttributes(array('style'=>'padding-right:10px;', 'align' => 'right', 'valign' => 'bottom'));

$page = we_ui_layout_HTMLPage::getInstance();
$page->setBodyAttributes(array('class'=>'weMenuBody'));
$page->addElement($table);
		
// needed for menu !!
$page->addJSFile('/webEdition/js/attachKeyListener.js');

echo $page->getHTML();
