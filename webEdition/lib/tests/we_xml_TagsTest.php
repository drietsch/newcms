<?php

include_once ('webEdition/lib/we/core/autoload.php');

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * we_xml_Tags test case.
 */
class we_xml_TagsTest extends PHPUnit_Framework_TestCase
{

	/**
	 * Tests we_xml_Tags::createAttributeStringFromArray()
	 */
	public function testCreateAttributeStringFromArray()
	{
		
		$this->assertEquals(we_xml_Tags::createAttributeStringFromArray(array('a' => 'Ahhh', 'b' => 'Behh>')), ' a="Ahhh" b="Behh&gt;"');
	}

	/**
	 * Tests we_xml_Tags::createStartTag()
	 */
	public function testCreateStartTag()
	{
		
		$this->assertEquals(we_xml_Tags::createStartTag('TEst', array('a' => 'Ahhh', 'b' => 'Behh>', 'c' => 'no'), 'c', true), '<test a="Ahhh" b="Behh&gt;" />');
	}

}

