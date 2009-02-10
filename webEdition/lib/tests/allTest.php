<?php

require_once 'PHPUnit/Framework/TestSuite.php';

$unittestdir = 'webEdition/lib/tests';

$unittest = array();
if($handle = opendir(".")) {
	while (false !== ($unittestfile = readdir($handle))){
		$unittestfile = strtr($unittestfile, array(".php"=>"", ".svn"=>"", "."=>""));
		if ($unittestfile != 'allTest' && $unittestfile != '') {
			require_once $unittestdir . "/" . $unittestfile . ".php";
			$unittest[] = $unittestfile;
		}	
	}
}

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
		global $unittest;
		
		$this->setName('allTest');
		
		foreach ($unittest as $testSuite){
			$this->addTestSuite($testSuite);
		}
	}

	/**
	 * Creates the suite.
	 */
	public static function suite()
	{
		return new self();
	}
}