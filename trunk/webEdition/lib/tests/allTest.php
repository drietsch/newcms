<?php

require_once 'PHPUnit/Framework/TestSuite.php';

require_once 'webEdition/lib/tests/textFieldTestsSuite.php';

require_once 'webEdition/lib/tests/we_ui_controls_TextFieldTest.php';

require_once 'webEdition/lib/tests/we_ui_controls_TextFieldTest2.php';

require_once 'webEdition/lib/tests/we_ui_layout_HTMLPageTest.php';

require_once 'webEdition/lib/tests/we_util_StringsTest.php';

require_once 'webEdition/lib/tests/we_xml_TagsTest.php';

require_once 'webEdition/lib/tests/we_ui_layout_ImageTest.php';

require_once 'webEdition/lib/tests/we_ui_ClientTestSafariMac.php';

require_once 'webEdition/lib/tests/we_ui_ClientTestFirefoxMac.php';

require_once 'webEdition/lib/tests/we_ui_controls_ButtonTest.php';

require_once 'webEdition/lib/tests/we_ui_controls_LabelTest.php';

require_once 'webEdition/lib/tests/we_ui_layout_FormTest.php';

require_once 'webEdition/lib/tests/we_ui_layout_HeadlineIconTableRowTest.php';

require_once 'webEdition/lib/tests/we_ui_layout_HeadlineIconTableTest.php';

require_once 'webEdition/lib/tests/we_ui_layout_TableTest.php';

require_once 'webEdition/lib/tests/we_ui_controls_CheckboxTest.php';

require_once 'webEdition/lib/tests/we_ui_controls_RadioButtonTest.php';

require_once 'webEdition/lib/tests/we_ui_controls_SelectTest.php';

require_once 'webEdition/lib/tests/we_ui_controls_TabsTest.php';

require_once 'webEdition/lib/tests/we_ui_controls_TextareaTest.php';

/**
 * Static test suite.
 */
class allTest extends PHPUnit_Framework_TestSuite
{

	/**
	 * Constructs the test suite handler.
	 */
	public function __construct()
	{
		$this->setName('allTest');
		
		$this->addTestSuite('textFieldTestsSuite');
		
		$this->addTestSuite('we_ui_controls_TextFieldTest');
		
		$this->addTestSuite('we_ui_controls_TextFieldTest2');
		
		$this->addTestSuite('we_ui_layout_HTMLPageTest');
		
		$this->addTestSuite('we_util_StringsTest');
		
		$this->addTestSuite('we_xml_TagsTest');
		
		$this->addTestSuite('we_ui_layout_ImageTest');
		
		$this->addTestSuite('we_ui_ClientTestSafariMac');

		$this->addTestSuite('we_ui_ClientTestFirefoxMac');

		$this->addTestSuite('we_ui_controls_ButtonTest');

		$this->addTestSuite('we_ui_controls_LabelTest');
		
		$this->addTestSuite('we_ui_layout_FormTest');
		
		$this->addTestSuite('we_ui_layout_HeadlineIconTableRowTest');
		
		$this->addTestSuite('we_ui_layout_HeadlineIconTableTest');
		
		$this->addTestSuite('we_ui_layout_TableTest');
		
		$this->addTestSuite('we_ui_controls_CheckboxTest');
		
		$this->addTestSuite('we_ui_controls_RadioButtonTest');
		
		$this->addTestSuite('we_ui_controls_SelectTest');
		
		$this->addTestSuite('we_ui_controls_TabsTest');
		
		$this->addTestSuite('we_ui_controls_TextareaTest');
}

	/**
	 * Creates the suite.
	 */
	public static function suite()
	{
		return new self();
	}
}

