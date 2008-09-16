<?php

include_once ('webEdition/lib/we/core/autoload.php');

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * we_core_MessageReporting test case.
 */
class we_core_MessageReportingTest extends PHPUnit_Framework_TestCase
{

	/**
	 * Tests we_core_MessageReporting::getShowMessageCall()
	 */
	public function testGetShowMessageCall()
	{
		$this->assertEquals(we_core_MessageReporting::getShowMessageCall('hello',1), 'top.we_showMessage("hello", 1, window);');
	}
	
}

