<?php

require_once 'webEdition/lib/we/ui/layout/Image.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * we_ui_layout_Image test case.
 */
class we_ui_layout_ImageTest extends PHPUnit_Framework_TestCase
{

	/**
	 * Tests we_ui_layout_Image::getPixel()
	 */
	public function testGetPixel()
	{
		$this->assertEquals(we_ui_layout_Image::getPixel(5,4), '<img src="/webEdition/lib/we/ui/layout/img/pixel.gif" width="5" height="4" alt=""/>');
	}
	
	/**
	 * Tests we_ui_layout_Image::getIconClass()
	 */
	public function testGetIconClass()
	{
		$this->assertEquals(we_ui_layout_Image::getIconClass('application/*','.pdf'), 'pdf');
	}

}

