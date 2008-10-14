<?php
/**
 * webEdition CMS
 *
 * This source is part of webEdition CMS. webEdition CMS is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/we_image_edit.class.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_live_tools.inc.php");


define("WE_THUMB_OK",0);
define("WE_THUMB_USE_ORIGINAL",1);
define("WE_THUMB_BUILDERROR",2);
define("WE_THUMB_NO_GDLIB_ERROR",3);
define("WE_THUMB_INPUTFORMAT_NOT_SUPPORTED",4);

/**
 * Class we_thumbnail
 *
 * Provides functions for creating and handling webEdition thumbnails.
 */

class we_thumbnail {

	/**
	 * ID of the thumbnail
	 * @var int
	 */
	var $thumbID=0;

	/**
	 * Width of the thumbnail
	 * @var int
	 */
	var $thumbWidth="";

	/**
	 * Height of the thumbnail
	 * @var int
	 */
	var $thumbHeight="";

	/**
	 * Quality of the jpg thumbnail
	 * @var int
	 */
	var $thumbQuality=8;

	/**
	 * Ratio (keep ratio) of the thumbnail
	 * @var boolean
	 */
	var $thumbRatio=true;

	/**
	 * Maxsize of the thumbnail
	 * @var boolean
	 */
	var $thumbMaxsize=true;

	/**
	 * create thumbnail in interlaced mode
	 * @var boolean
	 */
	var $thumbInterlace=true;

	/**
	 * Format (jpg, png or gif) of the thumbnail
	 * @var string
	 */
	var $thumbFormat="";

	/**
	 * Name of the thumbnail
	 * @var string
	 */
	var $thumbName="";

	/**
	 * ID of the image
	 * @var int
	 */
	var $imageID=0;

	/**
	 * Filename of the image
	 * @var string
	 */
	var $imageFileName="";

	/**
	 * Path of the image
	 * @var string
	 */
	var $imagePath="";

	/**
	 * Extension of the image
	 * @var string
	 */
	var $imageExtension="";

	/**
	 * width of the image
	 * @var int
	 */
	var $imageWidth=0;

	/**
	 * height of the image
	 * @var int
	 */
	var $imageHeight=0;

	/**
	 * binaryData of the image (is mostly empty)
	 * @var string
	 */
	var $imageData="";


	/**
	 * date of the thumb last saved in thumbnails table
	 * @var int
	 */
	var $date="";


	/**
	 * db Object of the thumbnail
	 * @var object
	 */
	var $db;

	/**
	 * format (jpg, png or gif) of the generated thumbnail
	 * @var string
	 */
	var $outputFormat="jpg";

	/**
	 * path of the generated thumbnail
	 * @var string
	 */
	var $outputPath="";

	/**
	 * width of the generated thumbnail
	 * @var int
	 */
	var $outputWidth=0;

	/**
	 * height of the generated thumbnail
	 * @var int
	 */
	var $outputHeight=0;


	/**
	* Constructor of class
	*
	* @return we_thumbnail
	*/
	function we_thumbnail(){
		$this->db = new DB_WE();
	}


	/**
	* main initializer
	*
	* @return void
	* @param int $thumbID
	* @param int $thumbWidth
	* @param int $thumbHeight
	* @param boolean $thumbRatio
	* @param boolean $thumbMaxsize
	* @param boolean $thumbInterlace
	* @param string $thumbFormat
	* @param string $thumbName
	* @param int $imageID
	* @param string $imageFileName
	* @param string $imagePath
	* @param string $imageExtension
	* @param int $imageWidth
	* @param int $imageHeight
	* @param string $imageData
	* @param int $date
	* @public
	*/
	function init($thumbID,$thumbWidth,$thumbHeight,$thumbRatio,$thumbMaxsize,$thumbInterlace,$thumbFormat,$thumbName,$imageID,$imageFileName,$imagePath,$imageExtension,$imageWidth,$imageHeight,$imageData="",$date="",$thumbQuality=8){

		$this->thumbID = $thumbID;
		$this->thumbWidth=$thumbWidth;
		$this->thumbHeight=$thumbHeight;
		$this->thumbQuality=$thumbQuality;
		$this->thumbRatio=$thumbRatio;
		$this->thumbMaxsize=$thumbMaxsize;
		$this->thumbInterlace=$thumbInterlace;
		$this->thumbFormat=$thumbFormat;
		$this->thumbName=$thumbName;
		$this->imageID = $imageID;
		$this->imageFileName = $imageFileName;
		$this->imagePath = $imagePath;
		$this->imageExtension = $imageExtension;
		$this->imageWidth = $imageWidth;
		$this->imageHeight = $imageHeight;
		$this->imageData = $imageData;
		$this->date = $date;
		if($this->thumbID && $this->thumbName){
			$this->outputFormat = $this->thumbFormat ? $this->thumbFormat : (isset($GLOBALS["GDIMAGE_TYPE"][strtolower($this->imageExtension)]) ? $GLOBALS["GDIMAGE_TYPE"][strtolower($this->imageExtension)] : "jpg");
			$this->_checkAndGetImageSizeIfNeeded();
			$this->_setOutputPath();
			$this->_calculateOutsize();
		}
	}

	/**
	* initializer if you have all image data and a thumb ID
	*
	* @return void
	* @param int $thumbID
	* @param int $imageID
	* @param string $imageFileName
	* @param string $imagePath
	* @param string $imageExtension
	* @param int $imageWidth
	* @param int $imageHeight
	* @param string $imageData
	* @public
	*/
	function initByThumbID($thumbID,$imageID,$imageFileName,$imagePath,$imageExtension,$imageWidth,$imageHeight,$imageData=""){

		$_foo = getHash("SELECT * FROM ".THUMBNAILS_TABLE." WHERE ID='".abs($thumbID)."'",$this->db);

		$this->init(	$thumbID,
						isset($_foo["Width"]) ? $_foo["Width"] : "",
						isset($_foo["Height"]) ? $_foo["Height"] : "",
						isset($_foo["Ratio"]) ? $_foo["Ratio"] : "",
						isset($_foo["Maxsize"]) ? $_foo["Maxsize"] : "",
						isset($_foo["Interlace"]) ? $_foo["Interlace"] : "",
						isset($_foo["Format"]) ? $_foo["Format"] : "",
						isset($_foo["Name"]) ? $_foo["Name"] : "",
						$imageID,
						$imageFileName,
						$imagePath,
						$imageExtension,
						$imageWidth,
						$imageHeight,
						$imageData,
						isset($_foo["Date"]) ? $_foo["Date"] : "",
						isset($_foo["Quality"]) ? $_foo["Quality"] : ""
						);

	}


	/**
	* initializer if you have all image data and a thumb name
	*
	* @return void
	* @param int $thumbName
	* @param int $imageID
	* @param string $imageFileName
	* @param string $imagePath
	* @param string $imageExtension
	* @param int $imageWidth
	* @param int $imageHeight
	* @param string $imageData
	* @public
	*/
	function initByThumbName($thumbName,$imageID,$imageFileName,$imagePath,$imageExtension,$imageWidth,$imageHeight,$imageData=""){

		$_foo = getHash("SELECT * FROM ".THUMBNAILS_TABLE." WHERE Name='".mysql_real_escape_string($thumbName)."'",$this->db);

		$this->init(	isset($_foo["ID"]) ? $_foo["ID"] : 0,
						isset($_foo["Width"]) ? $_foo["Width"] : "",
						isset($_foo["Height"]) ? $_foo["Height"] : "",
						isset($_foo["Ratio"]) ? $_foo["Ratio"] : "",
						isset($_foo["Maxsize"]) ? $_foo["Maxsize"] : "",
						isset($_foo["Interlace"]) ? $_foo["Interlace"] : "",
						isset($_foo["Format"]) ? $_foo["Format"] : "",
						isset($_foo["Name"]) ? $_foo["Name"] : "",
						$imageID,
						$imageFileName,
						$imagePath,
						$imageExtension,
						$imageWidth,
						$imageHeight,
						$imageData,
						isset($_foo["Date"]) ? $_foo["Date"] : "",
						isset($_foo["Quality"]) ? $_foo["Quality"] : ""
					);



	}


	/**
	* initializer if you have only a image ID and a thumb ID
	*
	* @return bool
	* @param int $imageID
	* @param int $thumbID
	* @param boolean $getBinary if set, also the binary image data will be loaded
	* @public
	*/
	function initByImageIDAndThumbID($imageID,$thumbID,$getBinary=false){

		$this->imageID = $imageID;

		if(!$this->_getImageData($getBinary)){
			return false;
		}
		$_foo = getHash("SELECT * FROM ".THUMBNAILS_TABLE." WHERE ID='".abs($thumbID)."'",$this->db);

		$this->init(	$thumbID,
						isset($_foo["Width"]) ? $_foo["Width"] : "",
						isset($_foo["Height"]) ? $_foo["Height"] : "",
						isset($_foo["Ratio"]) ? $_foo["Ratio"] : "",
						isset($_foo["Maxsize"]) ? $_foo["Maxsize"] : "",
						isset($_foo["Interlace"]) ? $_foo["Interlace"] : "",
						isset($_foo["Format"]) ? $_foo["Format"] : "",
						isset($_foo["Name"]) ? $_foo["Name"] : "",
						$imageID,
						$this->imageFileName,
						$this->imagePath,
						$this->imageExtension,
						$this->imageWidth,
						$this->imageHeight,
						$this->imageData,
						isset($_foo["Date"]) ? $_foo["Date"] : ""
					);
		return true;

	}


	/**
	* creates the thumbnail and saves it in $this->outputPath
	*
	* @return int (WE_THUMB_OK, WE_THUMB_BUILDERROR, WE_THUMB_USE_ORIGINAL or WE_THUMB_NO_GDLIB_ERROR;
	* @public
	*/
	function createThumb(){

		if(we_image_edit::gd_version() <= 0 ){
			return WE_THUMB_NO_GDLIB_ERROR;
		}

		if($this->_useOriginalSize() && $this->outputFormat == $GLOBALS["GDIMAGE_TYPE"][strtolower(ereg_replace('^.+(\..+)$','\1',$this->imagePath))]){
			return WE_THUMB_USE_ORIGINAL;
		}

		if(!we_image_edit::is_imagetype_read_supported($GLOBALS["GDIMAGE_TYPE"][strtolower(ereg_replace('^.+(\..+)$','\1',$this->imagePath))])){
			return WE_THUMB_INPUTFORMAT_NOT_SUPPORTED;
		}

		$_thumbdir = $this->getThumbDirectory(true);
		if (!file_exists($_thumbdir)) {
			createLocalFolder($_thumbdir);
		}
		$quality = $this->thumbQuality<1?10:($this->thumbQuality>10?100:$this->thumbQuality*10);
		$outarr = we_image_edit::edit_image(	$this->imageData ? $this->imageData : $_SERVER["DOCUMENT_ROOT"] . $this->imagePath,
												$this->outputFormat,
												$_SERVER["DOCUMENT_ROOT"] . $this->outputPath,
												$quality,
												$this->thumbWidth,
												$this->thumbHeight,
												$this->thumbRatio,
												$this->thumbInterlace);

		return $outarr[0] ? WE_THUMB_OK : WE_THUMB_BUILDERROR;

	}

	/**
	* creates the thumbnail and sets the binary data of the thumb to $thumbDataPointer
	*
	* @return int (WE_THUMB_OK, WE_THUMB_BUILDERROR, WE_THUMB_USE_ORIGINAL or WE_THUMB_NO_GDLIB_ERROR;
	* @param string &$thumbDataPointer Pointer to a string
	* @public
	*/
	function getThumb(&$thumbDataPointer){
		if(we_image_edit::gd_version() <= 0 ){
			return WE_THUMB_NO_GDLIB_ERROR;
		}

		if($this->_useOriginalSize()){
			return WE_THUMB_USE_ORIGINAL;
		}
		$quality = $this->thumbQuality<1?10:($this->thumbQuality>10?100:$this->thumbQuality*10);
		$outarr = we_image_edit::edit_image(	$this->imageData ? $this->imageData : $_SERVER["DOCUMENT_ROOT"] . $this->imagePath,
												$this->outputFormat,
												"",
												$quality,
												$this->thumbWidth,
												$this->thumbHeight,
												$this->thumbRatio,
												$this->thumbInterlace);
		if($outarr[0]){
			$thumbDataPointer = $outarr[0];
			return WE_THUMB_OK;
		}

		return WE_THUMB_BUILDERROR;

	}

	/**
	* Gets the Directory for thumbnails
	*
	* @static
	* @public
	* @return str
	* @param bool $realpath  if set to true, Document_ROOT will be appended before
	*/
	function getThumbDirectory($realpath=false){
		return getThumbDirectory($realpath);
	}

	/**
	* function will determine the size of any GIF, JPG, PNG.
	* This function uses the php Function with the same name.
	* But the php function doesn't work with some images created from some apps.
	* So this function uses the gd lib if nothing is returned from the php function
	*
	* @static
	* @public
	* @return array
	* @param $filename complete path of the image
	*/
	function getimagesize($filename){
		$arr = @getimagesize($filename);

		if(isset($arr) && is_array($arr) && (count($arr) >= 4)  && $arr[0] && $arr[1]){
			return $arr;
		}else{
			if(we_image_edit::gd_version()){
				return we_image_edit::getimagesize($filename);
			}
			return $arr;
		}
	}

	/**
	* returns the output path
	*
	* @return string
	* @public
	*/
	function getOutputPath($withDocumentRoot=false){
		return ($withDocumentRoot ? $_SERVER['DOCUMENT_ROOT'] : "") . $this->outputPath;
	}

	/**
	* returns the output width
	*
	* @return int
	* @public
	*/
	function getOutputWidth(){
		return $this->outputWidth;
	}

	/**
	* returns the output Height
	*
	* @return int
	* @public
	*/
	function getOutputHeight(){
		return $this->outputHeight;
	}

	/**
	* returns the name of tje thumbnail
	*
	* @return string
	* @public
	*/
	function getThumbName(){
		return $this->thumbName;
	}


	/**
	* returns true if thumbnail is the same as the original image
	*
	* @return boolean
	* @public
	*/
	function isOriginal(){
		return $this->outputPath == $this->imagePath;
	}

	/**
	* sets the output path for the thumbnail.
	* if image must not be resized, it will set the path of the original image
	*
	* @return void
	* @private
	*/
	function _setOutputPath(){
		if(	we_image_edit::gd_version() > 0 &&
			we_image_edit::is_imagetype_supported($this->outputFormat) &&
			we_image_edit::is_imagetype_read_supported(isset($GLOBALS["GDIMAGE_TYPE"][strtolower($this->imageExtension)]) ?
				$GLOBALS["GDIMAGE_TYPE"][strtolower($this->imageExtension)] : "")	&&
			( (!$this->_useOriginalSize()) || ( !$this->_hasOriginalType() ) ) ){
				$this->outputPath = getThumbDirectory() . "/" . $this->imageID . "_" . $this->thumbID . "_" . $this->imageFileName.".".$this->outputFormat;
		}else{
			$this->outputPath = $this->imagePath;
		}
	}

	/**
	* calculates the real size of the thumbnail (width & height)
	*
	* @return void
	* @private
	*/
	function _calculateOutsize(){
		if($this->_useOriginalSize()){
			$this->outputWidth = $this->imageWidth;
			$this->outputHeight = $this->imageHeight;
			return;
		}

		$this->outputWidth = 0;
		$this->outputHeight = 0;


		// If width has been specified set it and compute new height based on source area aspect ratio
		if ($this->thumbWidth) {
			$this->outputWidth = $this->thumbWidth;
			$this->outputHeight = round($this->imageHeight * $this->thumbWidth / $this->imageWidth);
		}

		// If height has been specified set it.
		// If width has already been set and the new image is too tall, compute a new width based
		// on aspect ratio - otherwise, use height and compute new width
		if ($this->thumbHeight) {
			if ($this->outputHeight > $this->thumbHeight || $this->outputHeight == 0) {
				$this->outputWidth  = round($this->imageWidth * $this->thumbHeight / $this->imageHeight);
				$this->outputHeight = $this->thumbHeight;
			}
		}

		// Check, if we must discard aspect ratio
		if (!$this->thumbRatio && ($this->thumbWidth) && ($this->thumbHeight)) {
			$this->outputWidth  = $this->thumbWidth;
			$this->outputHeight = $this->thumbHeight;
		}
	}

	/**
	* checks if the thumbnail has the same size as the original image
	*
	* @return boolean
	* @private
	*/
	function _useOriginalSize(){
		$outvar = ($this->thumbMaxsize == false) && (($this->imageWidth <= $this->thumbWidth) || $this->thumbWidth==0) && (($this->imageHeight <= $this->thumbHeight) || $this->thumbHeight==0);
		return $outvar;
	}

	/**
	 * checks if the thumbnail has the same extension as the original image
	 *
	 * @return boolean
	 */
	function _hasOriginalType() {

		return (strtolower($this->imageExtension) == '.'.$this->outputFormat);
	}

	/**
	* get the image data
	*
	* @return void
	* @private
	*/
	function _getImageData($getBinary=false){

		$this->db->query("SELECT " .LINK_TABLE. ".Name as Name," . CONTENT_TABLE . ".Dat as Dat  FROM " . CONTENT_TABLE . "," . LINK_TABLE . " WHERE " . LINK_TABLE . ".DID='".abs($this->imageID).
				"' AND " . LINK_TABLE . ".DocumentTable='tblFile' AND " . CONTENT_TABLE . ".ID=" . LINK_TABLE . ".CID  AND " . CONTENT_TABLE . ".IsBinary=0");

		while($this->db->next_record()){
			if($this->db->f("Name") == "origwidth"){
				$this->imageWidth = $this->db->f("Dat");
			}else if($this->db->f("Name") == "origheight"){
				$this->imageHeight = $this->db->f("Dat");
			}
		}

		$imgdat = getHash("SELECT ID,Filename,Extension,Path FROM " . FILE_TABLE . " WHERE ID = '".abs($this->imageID)."'",$this->db);
		if(count($imgdat) == 0){
			return false;
		}
		$this->imageFileName = $imgdat["Filename"];
		$this->imagePath = $imgdat["Path"];
		$this->imageExtension = $imgdat["Extension"];

		if($getBinary){
			$this->_getBinaryData();
		}
		return true;
	}

	/**
	* sets width & height of the image if width & height are empty
	*
	* @return void
	* @private
	*/
	function _checkAndGetImageSizeIfNeeded(){
		if(!($this->imageWidth && $this->imageHeight)){
			$arr = $this->getimagesize($_SERVER["DOCUMENT_ROOT"].$this->imagePath);
			if(count($arr) >=2){
				$this->imageWidth = $arr[0];
				$this->imageHeight = $arr[1];
			}
		}
	}

	/**
	* loads the binary image data
	*
	* @return void
	* @private
	*/
	function _getBinaryData(){
		$_p = $_SERVER['DOCUMENT_ROOT']. $this->imagePath;
		$_fp = @fopen($_p,"rb");
		$this->imageData = @fread($_fp,filesize($_p));
		@fclose($_fp);
	}

}