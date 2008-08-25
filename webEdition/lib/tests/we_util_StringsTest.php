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

	
	/**
	 * Tests we_util_Strings::makeCSVFromArray()
	 */
	public function testMakeCSVFromArray()
	{
		$this->assertEquals(we_util_Strings::makeCSVFromArray(array("x","y")), "x,y");
	}
	
	/**
	 * Tests we_util_Strings::makeArrayFromCSV()
	 */
	public function testMakeArrayFromCSV()
	{
		$this->assertEquals(we_util_Strings::makeArrayFromCSV("x,y"), array("x","y"));
	}
	
	/**
	 * Tests we_util_Strings::quoteForJSString()
	 */
	public function testQuoteForJSString()
	{
		$this->assertEquals(we_util_Strings::quoteForJSString("test'test"), "test\'test");
	}
	
	/**
	 * Tests we_util_Strings::shortenPath()
	 */
	public function testShortenPath()
	{
		$this->assertEquals(we_util_Strings::shortenPath("Averylonghlongword", 12), "Aver....word");
	}

}

