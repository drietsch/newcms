<?php


class Captcha {


	/**
	 * display the image
	 *
	 * @return void
	 */
	function display($image, $type = "gif") {

		$code = "";
		$im = $image->get($code);

		header('Expires: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT');
		header('Cache-Control: no-cache, must-revalidate, max-age=0');
		header('Pragma: no-cache');

		switch($type) {
    		case 'jpg':
    			header("Content-type: image/jpeg");
    			imagejpeg($im);
    			imagedestroy($im);
    			break;
    		case 'png':
    			header("Content-type: image/png");
    			imagepng($im);
    			imagedestroy($im);
    			break;
    		case 'gif':
    		default:
    			header("Content-type: image/gif");
    			imagegif($im);
    			imagedestroy($im);
    			break;
    	}

    	// save the code to the memory
    	CaptchaMemory::save($code, Captcha::getStorage());

	} /* end: save */


	/**
	 * Clean the Memory
	 *
	 * @return boolean
	 */
	function check($captcha) {

		return CaptchaMemory::isValid($captcha, Captcha::getStorage());

	} /* end: check */


	/**
	 * get the filename
	 *
	 * @return boolean
	 */
	function getStorage() {
		return $_SERVER["DOCUMENT_ROOT"]."/webEdition/we/tmp/captchacodes.tmp";
	} /* end: check */

} /* end: Class */


?>