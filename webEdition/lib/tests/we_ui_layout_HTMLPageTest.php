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
	 * Tests we_ui_layout_HTMLPage->getHTML()
	 */
	public function testGetHTML()
	{
		$this->assertEquals($this->we_ui_layout_HTMLPage->getHTML(), '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="de">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
	<title>My Title</title>
	<link rel="stylesheet" type="text/css" href="/webEdition/lib/we/ui/themes/we_ui_layout_HTMLPage/style.css" media="all" />
	<link rel="stylesheet" type="text/css" href="/webEdition/lib/we/ui/themes/we_ui_controls_TextField/style.css" media="all" />
	<style>
a {border: 1px solid black;}
	</style>
	<script type="text/javascript" language="JavaScript" src="/webEdition/lib/we/ui/controls/TextField.js"></script>
	<script type="text/javascript" language="JavaScript">
var a=0;
	</script>
</head>
<body onload="var b=999;" onunload="var b=998;">
<input id="testid" name="test" type="text" class="we_ui_controls_TextInput" onFocus="this.className=&quot;we_ui_controls_TextInput_Selected&quot;;" onBlur="this.className=&quot;we_ui_controls_TextInput&quot;;"/><pre>TEST</pre>
</body>
</html>
');
	}

	/**
	 * Tests we_ui_layout_HTMLPage->getBodyAttributes()
	 */
	public function testGetBodyAttributes()
	{
		// TODO Auto-generated we_ui_layout_HTMLPageTest->testGetBodyAttributes()
		$this->markTestIncomplete("getBodyAttributes test not implemented");
		
		$this->we_ui_layout_HTMLPage->getBodyAttributes(/* parameters */);
	
	}

	/**
	 * Tests we_ui_layout_HTMLPage->getBodyHTML()
	 */
	public function testGetBodyHTML()
	{
		// TODO Auto-generated we_ui_layout_HTMLPageTest->testGetBodyHTML()
		$this->markTestIncomplete("getBodyHTML test not implemented");
		
		$this->we_ui_layout_HTMLPage->getBodyHTML(/* parameters */);
	
	}

	/**
	 * Tests we_ui_layout_HTMLPage->getCharset()
	 */
	public function testGetCharset()
	{
		// TODO Auto-generated we_ui_layout_HTMLPageTest->testGetCharset()
		$this->markTestIncomplete("getCharset test not implemented");
		
		$this->we_ui_layout_HTMLPage->getCharset(/* parameters */);
	
	}

	/**
	 * Tests we_ui_layout_HTMLPage->getDoctype()
	 */
	public function testGetDoctype()
	{
		// TODO Auto-generated we_ui_layout_HTMLPageTest->testGetDoctype()
		$this->markTestIncomplete("getDoctype test not implemented");
		
		$this->we_ui_layout_HTMLPage->getDoctype(/* parameters */);
	
	}

}

