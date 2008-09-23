<?php

require_once 'PHPUnit/Framework/TestSuite.php';

require_once 'webEdition/lib/tests/we_ui_controls_TextFieldTest.php';

require_once 'webEdition/lib/tests/we_ui_controls_TextFieldTest2.php';

/**
 * Static test suite.
 */
class textFieldTestsSuite extends PHPUnit_Framework_TestSuite
{

	/**
	 * Constructs the test suite handler.
	 */
	public function __construct()
	{
		$this->setName('textFieldTestsSuite');
		
		$this->addTestSuite('we_ui_controls_TextFieldTest');
		
		$this->addTestSuite('we_ui_controls_TextFieldTest2');
	
	}

	/**
	 * Creates the suite.
	 */
	public static function suite()
	{
		return new self();
	}
}

