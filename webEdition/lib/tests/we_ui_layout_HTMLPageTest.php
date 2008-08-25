<?php

require_once 'webEdition/lib/we/core/autoload.php';

require_once 'webEdition/lib/we/ui/layout/HTMLPage.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * we_ui_layout_HTMLPage test case.
 */
class we_ui_layout_HTMLPageTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var we_ui_layout_HTMLPage
	 */
	private $we_ui_layout_HTMLPage;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		parent::setUp();
		if (!$_SERVER['DOCUMENT_ROOT']) {
			$_SERVER['DOCUMENT_ROOT'] = dirname(dirname(dirname(dirname(__FILE__))));
		}
		
		$textInput = new we_ui_controls_TextField();
		$textInput->setName('test');
		$textInput->setId('testid');
		
		$this->we_ui_layout_HTMLPage = we_ui_layout_HTMLPage::getInstance();
		$this->we_ui_layout_HTMLPage->addBodyAttribute('onload', 'var b=999;');
		$this->we_ui_layout_HTMLPage->addBodyAttribute('onunload', 'var b=998;');
		$this->we_ui_layout_HTMLPage->addCSSFile('we_ui_controls_TextInput');
		$this->we_ui_layout_HTMLPage->addElement($textInput);
		$this->we_ui_layout_HTMLPage->addHTML('<pre>TEST</pre>');
		$this->we_ui_layout_HTMLPage->addInlineCSS('a {border: 1px solid black;}');
		$this->we_ui_layout_HTMLPage->addInlineJS('var a=0;');
		$this->we_ui_layout_HTMLPage->setCharset('ISO-8859-1');
		$this->we_ui_layout_HTMLPage->setLang('de');
		$this->we_ui_layout_HTMLPage->setTitle('My Title');
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown()
	{
		$this->we_ui_layout_HTMLPage = null;
		parent::tearDown();
	}

	/**
	 * Tests we_ui_layout_HTMLPage->getBodyAttributes()
	 */
	public function testGetBodyAttributes()
	{
		$this->assertEquals($this->we_ui_layout_HTMLPage->getBodyAttributes(), array('onload' => 'var b=999;', 'onunload' => 'var b=998;'));
	
	}

	/**
	 * Tests we_ui_layout_HTMLPage->getBodyHTML()
	 */
	public function testGetBodyHTML()
	{
		$this->assertEquals($this->we_ui_layout_HTMLPage->getBodyHTML(), '<input id="testid" name="test" type="text" style="height:17px;" class="we_ui_controls_TextInput" onFocus="YAHOO.util.Dom.addClass(this, &quot;we_ui_controls_TextInput_Selected&quot;);" onBlur="YAHOO.util.Dom.removeClass(this, &quot;we_ui_controls_TextInput_Selected&quot;);"/><pre>TEST</pre><input id="testid" name="test" type="text" style="height:17px;" class="we_ui_controls_TextInput" onFocus="YAHOO.util.Dom.addClass(this, &quot;we_ui_controls_TextInput_Selected&quot;);" onBlur="YAHOO.util.Dom.removeClass(this, &quot;we_ui_controls_TextInput_Selected&quot;);"/><pre>TEST</pre>');
	
	}

	/**
	 * Tests we_ui_layout_HTMLPage->getCharset()
	 */
	public function testGetCharset()
	{
		$this->assertEquals($this->we_ui_layout_HTMLPage->getCharset(), 'ISO-8859-1');
	
	}

	/**
	 * Tests we_ui_layout_HTMLPage->getDoctype()
	 */
	public function testGetDoctype()
	{
		$this->assertEquals($this->we_ui_layout_HTMLPage->getDoctype(), '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">');
	
	}

}