<?php

include_once ('webEdition/lib/we/core/autoload.php');

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * we_util_Strings test case.
 */
class we_util_StringsTest extends PHPUnit_Framework_TestCase
{

	/**
	 * Tests we_util_Strings::createUniqueId()
	 */
	public function testCreateUniqueId()
	{
		$this->assertEquals(strlen(we_util_Strings::createUniqueId(12)), 12);
	}

}

