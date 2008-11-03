<?php

include_once('webEdition/lib/we/core/autoload.php');

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * we_ui_controls_Tabs test case.
 */
class we_ui_controls_TabsTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var we_ui_controls_Tabs
	 */
	private $we_ui_controls_Tabs;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		parent::setUp();
		$this->we_ui_controls_Tabs = new we_ui_controls_Tabs();
		$this->we_ui_controls_Tabs->setId('id1');
		$this->we_ui_controls_Tabs->setDisabled(false);
		$this->we_ui_controls_Tabs->setHidden(false);
		$this->we_ui_controls_Tabs->setTabs(array(
											array(
												'id'=>'tab9', 
												'text'=>'Tab 9', 
												'hidden'=>false,
												'title'=>'Tab 9'
											),
											array(
												'id'=>'tab10', 
												'text'=>'Tab 10', 
												'hidden'=>false,
												'title'=>'Tab 10'
											),
											array(
												'id'=>'tab11', 
												'text'=>'Tab 11', 
												'hidden'=>false,
												'title'=>'Tab 11'
											),
										));
	
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown()
	{
		$this->we_ui_controls_Tabs = null;
		parent::tearDown();
	}

	/**
	 * Constructs the test case.
	 */
	public function __construct()
	{
	}

	/**
	 * Tests we_ui_controls_Tabs->getHTML()
	 */
	public function testGetHTML()
	{
		$this->assertEquals($this->we_ui_controls_Tabs->getHTML(),'<div class="we_ui_controls_Tabs_Container" id="id1"><div  title="Tab 9" id="Tabs_tab9" onclick="if ( we_ui_controls_Tabs.allowed_change_edit_page() ){ we_ui_controls_Tabs.setTabClass(\'id1\',this); we_ui_controls_Tabs.setTab(\'id1\',\'tab9\',\'\');}"  class="we_ui_controls_Tab_Normal"><table border="0" height="100%" cellspacing="0" cellpadding="0"><tr><td>Tab 9</td></tr></table><img src="/webEdition/images/multiTabs/tabBorder.gif" border="0"  class="we_ui_controls_Tab_ImageBorder" height="21" /></div><div  title="Tab 10" id="Tabs_tab10" onclick="if ( we_ui_controls_Tabs.allowed_change_edit_page() ){ we_ui_controls_Tabs.setTabClass(\'id1\',this); we_ui_controls_Tabs.setTab(\'id1\',\'tab10\',\'\');}"  class="we_ui_controls_Tab_Normal"><table border="0" height="100%" cellspacing="0" cellpadding="0"><tr><td>Tab 10</td></tr></table><img src="/webEdition/images/multiTabs/tabBorder.gif" border="0"  class="we_ui_controls_Tab_ImageBorder" height="21" /></div><div  title="Tab 11" id="Tabs_tab11" onclick="if ( we_ui_controls_Tabs.allowed_change_edit_page() ){ we_ui_controls_Tabs.setTabClass(\'id1\',this); we_ui_controls_Tabs.setTab(\'id1\',\'tab11\',\'\');}"  class="we_ui_controls_Tab_Normal"><table border="0" height="100%" cellspacing="0" cellpadding="0"><tr><td>Tab 11</td></tr></table><img src="/webEdition/images/multiTabs/tabBorder.gif" border="0"  class="we_ui_controls_Tab_ImageBorder" height="21" /></div></div><div style="clear:left;"></div>');
	}
	
	/**
	 * Tests we_ui_controls_Tabs->getTabs()
	 */
	public function testGetTabs()
	{
		$this->assertEquals($this->we_ui_controls_Tabs->getTabs(), array(
											array(
												'id'=>'tab9', 
												'text'=>'Tab 9', 
												'hidden'=>false,
												'title'=>'Tab 9'
											),
											array(
												'id'=>'tab10', 
												'text'=>'Tab 10', 
												'hidden'=>false,
												'title'=>'Tab 10'
											),
											array(
												'id'=>'tab11', 
												'text'=>'Tab 11', 
												'hidden'=>false,
												'title'=>'Tab 11'
											),
										));
	
	}

	/**
	 * Tests we_ui_controls_Tabs->getTabsHTML()
	 */
	public function testGetTabsHTML()
	{
		$this->assertEquals($this->we_ui_controls_Tabs->getTabsHTML(), '<div  title="Tab 9" id="Tabs_tab9" onclick="if ( we_ui_controls_Tabs.allowed_change_edit_page() ){ we_ui_controls_Tabs.setTabClass(\'id1\',this); we_ui_controls_Tabs.setTab(\'id1\',\'tab9\',\'\');}"  class="we_ui_controls_Tab_Normal"><table border="0" height="100%" cellspacing="0" cellpadding="0"><tr><td>Tab 9</td></tr></table><img src="/webEdition/images/multiTabs/tabBorder.gif" border="0"  class="we_ui_controls_Tab_ImageBorder" height="21" /></div><div  title="Tab 10" id="Tabs_tab10" onclick="if ( we_ui_controls_Tabs.allowed_change_edit_page() ){ we_ui_controls_Tabs.setTabClass(\'id1\',this); we_ui_controls_Tabs.setTab(\'id1\',\'tab10\',\'\');}"  class="we_ui_controls_Tab_Normal"><table border="0" height="100%" cellspacing="0" cellpadding="0"><tr><td>Tab 10</td></tr></table><img src="/webEdition/images/multiTabs/tabBorder.gif" border="0"  class="we_ui_controls_Tab_ImageBorder" height="21" /></div><div  title="Tab 11" id="Tabs_tab11" onclick="if ( we_ui_controls_Tabs.allowed_change_edit_page() ){ we_ui_controls_Tabs.setTabClass(\'id1\',this); we_ui_controls_Tabs.setTab(\'id1\',\'tab11\',\'\');}"  class="we_ui_controls_Tab_Normal"><table border="0" height="100%" cellspacing="0" cellpadding="0"><tr><td>Tab 11</td></tr></table><img src="/webEdition/images/multiTabs/tabBorder.gif" border="0"  class="we_ui_controls_Tab_ImageBorder" height="21" /></div>');
	
	}


}

