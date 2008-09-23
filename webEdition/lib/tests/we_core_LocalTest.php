<?php

include_once ('webEdition/lib/we/core/autoload.php');

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * we_core_Local test case.
 */
class we_core_LocalTest extends PHPUnit_Framework_TestCase
{

	/**
	 * Tests weLangToLocale::weLangToLocale()
	 */
	public function testWeLangToLocale()
	{
		$this->assertEquals(we_core_Local::weLangToLocale('Deutsch'), 'de');
	}

	/**
	 * Tests we_core_Local::localeToWeLang()
	 */
	public function testLocaleToWeLang()
	{
		$this->assertEquals(we_core_Local::localeToWeLang('de'), 'Deutsch_UTF-8');
	
	}

}