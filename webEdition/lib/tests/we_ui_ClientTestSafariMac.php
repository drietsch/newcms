<?php

require_once 'webEdition/lib/we/ui/Client.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * we_ui_Client test case.
 */
class we_ui_ClientTestSafariMac extends PHPUnit_Framework_TestCase
{

	/**
	 * @var we_ui_Client
	 */
	private $we_ui_Client;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		parent::setUp();
		$this->we_ui_Client = new we_ui_Client('Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_2; de-de) AppleWebKit/525.18 (KHTML, like Gecko) Version/3.1.1 Safari/525.18');
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown()
	{
		$this->we_ui_Client = null;
		parent::tearDown();
	}


	/**
	 * Tests we_ui_Client->getBrowser()
	 */
	public function testGetBrowser()
	{
		$this->assertEquals($this->we_ui_Client->getBrowser(), we_ui_Client::kBrowserWebkit);
	}

	/**
	 * Tests we_ui_Client->getVersion()
	 */
	public function testGetVersion()
	{
		$this->assertEquals($this->we_ui_Client->getVersion(), 525.18);
	}

	/**
	 * Tests we_ui_Client->getSystem()
	 */
	public function testGetSystem()
	{
		$this->assertEquals(we_ui_Client::kSystemMacOS, $this->we_ui_Client->getSystem());
	}

}

