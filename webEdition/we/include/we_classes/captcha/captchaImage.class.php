<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

class CaptchaImage {
	
	/**
	 * @var integer
	 * @desc Length of the text
	 */
	var $textlength = 0;
	
	/**
	 * @var integer
	 * @desc Width of the image
	 */
	var $width = 0;
	
	/**
	 * @var integer
	 * @desc Height of the image
	 */
	var $height = 0;
	
	/**
	 * @var string
	 * @desc Backgroundcolor of the image
	 */
	var $background = 0;
	
	/**
	 * @var array
	 * @desc all informations about the used font
	 */
	var $font = array();
	
	/**
	 * @var string
	 * @desc path where font is located
	 */
	var $fontpath = "";
	
	/**
	 * @var array
	 * @desc range of the angle
	 */
	var $angle = array();
	
	/**
	 * @var string
	 * @desc vertical align of the code
	 */
	var $valign = "";
	
	/**
	 * @var string
	 * @desc align of the code
	 */
	var $align = "";
	
	/**
	 * @var array
	 * @desc strikeout
	 */
	var $style = array();
	
	/**
	 * @var array
	 * @desc ranges of the charactersubset
	 */
	var $charactersubset = array();
	
	/**
	 * @var boolean
	 * @desc transparent
	 */
	var $transparent = false;
	
	
	/**
	 * PHP4 Constuctor
	 *
	 * @param integer $width
	 * @param integer $height
	 * @param integer $textlength
	 * @return void
	 */
	function CaptchaImage($width, $height, $textlength = 6) {
		$this->__construct($width, $height, $textlength);
	} /* end: CaptchaImage */
	
	
	/**
	 * PHP5 Constructor
	 *
	 * @param integer $width
	 * @param integer $height
	 * @param integer $textlength
	 * @return void
	 */
	function __construct($width, $height, $textlength = 5) {
		
		$this->width = $width;
		$this->height = $height;
		
		if($textlength < 3) {
			$this->textlength = 3;
		//} else if($textlength > 20) {
		//	$this->textlength = 20;
		} else {
			$this->textlength = $textlength;
		}
		
		// init the font
		$this->setFont();
		
		// init the character subset
		$this->setCharacterSubset();
		
		// no signs to skip
		$this->skip = array();
		
		// init the anglerange
		$this->setAngleRange();
		
		// init the vertical align
		$this->setVerticalAlign();
		
		// init the align
		$this->setAlign();
		
		// init the vertical align
		$this->style = array(
			'strikeout' => false,
			'fullcircle' => false,
			'outlinecircle' => false,
			'fullrectangle' => false,
			'outlinerectangle' => false,
			'color' => false,
			'number' => false,
		);
		
		// init the anglerange
		$this->setBackground();
	} /* end: __construct */
	
	
	/**
	 * Destructor
	 * @return void
	 */
	function __destruct() {
		$this->width = 0;
		$this->height = 0;
	} /* end: __desctruct */
	
	
	/**
	 * Set the font family and size
	 *
	 * @param string $family
	 * @param string $size
	 * @param string $color
	 * @return void
	 */
	function setFont($family = "Times", $size = "15,20", $color = "#000000") {
		
		$this->font = array();
		
		// set the font families
		$families = explode(",", $family);
		$this->font['family'] = array();
		if(sizeof($families) > 1) {
			foreach($families as $idx => $family) {
				$this->font['family'][] = $family;
			}
		} else {
			$this->font['family'][] = $family;
		}
		
		// set the font size
		$sizes = explode(",", $size);
		$this->font['size'] = array();
		if(sizeof($sizes) > 1) {
			if($sizes[0] < $sizes[1]) {
				$this->font['size']['min'] = $sizes[0];
				$this->font['size']['max'] = $sizes[1];
			} else {
				$this->font['size']['min'] = $sizes[1];
				$this->font['size']['max'] = $sizes[0];
			}
		} else {
			$this->font['size']['min'] = $size;
			$this->font['size']['max'] = $size;
		}
		
		// set the font colors
		$colors = explode(",", $color);
		$this->font['color'] = array();
		if(sizeof($colors) > 1) {
			foreach($colors as $idx => $color) {
				$this->font['color'][] = $this->_hex2rgb($color);
			}
		} else {
			$this->font['color'][] = $this->_hex2rgb($color);
		}
	} /* setFont */
	
	
	/**
	 * Set the path where the fonts are located
	 *
	 * @param string $path
	 * @return void
	 */
	function setFontPath($path) {
		$this->fontpath = $path;
	} /* setFontPath */
	
	
	/**
	 * Set the font family and size
	 *
	 * @param string $subset
	 * @param string $casesensitivity
	 * @param string $skip
	 * @return void
	 */
	function setCharacterSubset($subset = "alphanum", $case = "mix", $skip = "") {
		switch(strtolower($subset)) {
			case 'alpha':
			case 'a-z':
				if($case == "upper") {
					$this->charactersubset = array(array(65,90));
				} elseif($case == "lower") {
					$this->charactersubset = array(array(97,122));
				} else {
					$this->charactersubset = array(array(65,90),array(97,122));
				}
				break;
			case 'num':
			case '0-9':
				$this->charactersubset = array(array(48,57));
				break;
			case 'alphanum':
			case 'a-z0-9':
			case '0-9a-z':
			default:
				if($case == "upper") {
					$this->charactersubset = array(array(48,57),array(65,90));
				} elseif($case == "lower") {
					$this->charactersubset = array(array(48,57),array(97,122));
				} else {
					$this->charactersubset = array(array(48,57),array(65,90),array(97,122));
				}
				break;				
		}
		$skips = explode(",", $skip);
		$this->skip = array();
		if(sizeof($skips)) {
			foreach($skips as $idx => $skip) {
				array_push($this->skip, ord($skip));
			}
		}
	} /* end: setCharacterSubset */
	
	
	/**
	 * Set the range of the angles
	 *
	 * @param string $angle
	 * @return void
	 */
	function setAngleRange($angle = "0") {
		$angles = explode(",", $angle);
		$this->angle = array();
		if(sizeof($angles) > 1) {
			$this->angle['left'] = (-1)*$angles[0];
			$this->angle['right'] = $angles[1];
		} else {
			$this->angle['left'] = (-1)*$angle;
			$this->angle['right'] = $angle;
		}
	} /* setAngleRange */
	
	
	/**
	 * Set the styles
	 *
	 * @param string $style
	 * @param string $color
	 * @return void
	 */
	function setStyle($style= "", $color = "#cccccc", $number = "10,20") {
		$this->style = array(
			'strikeout' => false,
			'fullcircle' => false,
			'fullrectangle' => false,
			'outlinecircle' => false,
			'outlinerectangle' => false,
			'color' => false,
			'number' => false,
		);

		$styles = explode(",", $style);
		if(sizeof($styles) > 0) {
			if(in_array("strikeout", $styles)) {
				$this->style['strikeout'] = true;
			}
			if(in_array("fullcircle", $styles)) {
				$this->style['fullcircle'] = true;
			}
			if(in_array("outlinecircle", $styles)) {
				$this->style['outlinecircle'] = true;
			}
			if(in_array("fullrectangle", $styles)) {
				$this->style['fullrectangle'] = true;
			}
			if(in_array("outlinerectangle", $styles)) {
				$this->style['outlinerectangle'] = true;
			}
			$colors = explode(",", $color);
			if(sizeof($colors) > 1) {
				foreach($colors as $idx => $color) {
					$this->style['color'][] = $this->_hex2rgb($color);
				}
			} else {
				$this->style['color'][] = $this->_hex2rgb($color);
			}
			$numbers = explode(",", $number);
			if(sizeof($numbers) > 1) {
				if($numbers[0] < $numbers[1]) {
					$this->style['number']['min'] = $numbers[0];
					$this->style['number']['max'] = $numbers[1];
				} else {
					$this->style['number']['min'] = $numbers[1];
					$this->style['size']['max'] = $numbers[0];
				}
			} else {
				$this->style['number']['min'] = $number;
				$this->style['number']['max'] = $number;
			}
		}
	} /* setStyle */
	
	
	/**
	 * Set the vertical position
	 *
	 * @param string $valign
	 * @return void
	 */
	function setVerticalAlign($valign = "random") {
		switch(strtolower($valign)) {
			case 'top':
				$this->valign = 'top';
				break;
			case 'bottom':
				$this->valign = 'bottom';
				break;
			case 'middle':
				$this->valign = 'middle';
				break;
			case 'random':
			default:
				$this->valign = 'random';
				break;
		}
	} /* setVerticalAlign */
	
	
	/**
	 * Set the position
	 *
	 * @param string $align
	 * @return void
	 */
	function setAlign($align = "random") {
		switch(strtolower($align)) {
			case 'center':
				$this->align = 'center';
				break;
			case 'left':
				$this->align = 'left';
				break;
			case 'right':
				$this->align = 'right';
				break;
			case 'random':
			default:
				$this->align = 'random';
				break;
		}
	} /* setAlign */
	
	
	/**
	 * Set the background color
	 *
	 * @param string $background
	 * @return void
	 */
	function setBackground($background = "#ffffff", $transparent = false) {
		$this->background = $this->_hex2rgb($background);
		$this->transparent = $transparent;
	} /* setBackground */
	
	
	/**
	 * Converts a Hex-code to rgb values
	 *
	 * @param string $hex
	 * @return array
	 */
	function _hex2rgb ($hex) {
		$hex = preg_replace("/[^a-fA-F0-9]/", "", $hex);
		$rgb = array();
		if (strlen($hex) == 3) {
			$rgb[0] = hexdec($hex[0] . $hex[0]);
			$rgb[1] = hexdec($hex[1] . $hex[1]);
			$rgb[2] = hexdec($hex[2] . $hex[2]);
		} elseif (strlen($hex) == 6) {
			$rgb[0] = hexdec($hex[0] . $hex[1]);
			$rgb[1] = hexdec($hex[2] . $hex[3]);
			$rgb[2] = hexdec($hex[4] . $hex[5]);
		} else {
			return -1;
		}
		return $rgb;
	} /* end: _hex2rgb */
	
	
	/**
	 * Displayes the captcha image
	 *
	 * @return void
	 */
	function get(&$code) {
		
		$image = imagecreate($this->width, $this->height);
		
		$bgcolor = imagecolorallocate($image, $this->background[0], $this->background[1], $this->background[2]);
		if($this->transparent) {
			imagecolortransparent($image, $bgcolor);
		}
		
		if($this->style['fullcircle'] || $this->style['fullrectangle'] || $this->style['outlinecircle'] || $this->style['outlinerectangle']) {
			
			$counter = rand($this->style['number']['min'], $this->style['number']['max']);
			
			$random = array();
			if($this->style['outlinecircle']) {
				array_push($random, 'outlinecircle');
			}
			if($this->style['outlinerectangle']) {
				array_push($random, 'outlinerectangle');
			}
			if($this->style['fullcircle']) {
				array_push($random, 'fullcircle');
			}
			if($this->style['fullrectangle']) {
				array_push($random, 'fullrectangle');
			}
			
			for($i = 0; $i < $counter; $i++) {
				
				$do = $random[rand(0, sizeof($random)-1)];
				
				if($do == 'fullcircle') {
					$cx = rand(0, $this->width);
					$cy = rand(0, $this->height);
					$w = rand(0, $this->width/2);
					$h = rand(0, $this->height/2);
					$color = $this->style['color'][rand(0, sizeof($this->style['color'])-1)];
					
					imagefilledarc(
						$image,
						$cx,
						$cy,
						$w,
						$h,
						0,
						360,
						imagecolorallocate($image, $color[0], $color[1], $color[1]),
						IMG_ARC_PIE
					);
				} elseif($do == 'fullrectangle') {
					$x1 = rand(0, $this->width);
					$y1 = rand(0, $this->height);
					$x2 = rand(0, $this->width/2);
					$y2 = rand(0, $this->height/2);
					$color = $this->style['color'][rand(0, sizeof($this->style['color'])-1)];
					
					imagefilledrectangle(
						$image,
						$x1,
						$y1,
						$x2,
						$y2,
						imagecolorallocate($image, $color[0], $color[1], $color[1])
					);
					
				} elseif($do == 'outlinecircle') {
					$cx = rand(0, $this->width);
					$cy = rand(0, $this->height);
					$w = rand(0, $this->width/2);
					$h = rand(0, $this->height/2);
					$color = $this->style['color'][rand(0, sizeof($this->style['color'])-1)];
					
					imagearc(
						$image,
						$cx,
						$cy,
						$w,
						$h,
						0,
						360,
						imagecolorallocate($image, $color[0], $color[1], $color[1])
					);
				} elseif($do == 'outlinerectangle') {
					$x1 = rand(0, $this->width);
					$y1 = rand(0, $this->height);
					$x2 = rand(0, $this->width/2);
					$y2 = rand(0, $this->height/2);
					$color = $this->style['color'][rand(0, sizeof($this->style['color'])-1)];
					
					imagerectangle(
						$image,
						$x1,
						$y1,
						$x2,
						$y2,
						imagecolorallocate($image, $color[0], $color[1], $color[1])
					);
					
				}
			}
		}
		
		$code = "";
		$xpos = 0;
		
		$signs = array();
		
		$sumwidth = 0;
		
		for($counter = 0; $counter < $this->textlength; $counter++) {
			
			// Sign
			$j = 0;
			$idx1 = rand(0, sizeof($this->charactersubset)-1);
			$sign = rand($this->charactersubset[$idx1][0], $this->charactersubset[$idx1][1]);
			if(sizeof($this->skip) > 0) {
				while(in_array($sign, $this->skip) || $j < 100) {
					$j++;
					$idx1 = rand(0, sizeof($this->charactersubset)-1);
					$sign = rand($this->charactersubset[$idx1][0], $this->charactersubset[$idx1][1]);
				}
			}
			$sign = chr($sign);
			
			// Size
			$size = rand($this->font['size']['min'], $this->font['size']['max']);
			
			// Color
			$color = $this->font['color'][rand(0, sizeof($this->font['color'])-1)];
			
			// Family
			$family = $this->font['family'][rand(0, sizeof($this->font['family'])-1)];
			
			$isWindows = (stristr(php_uname(), 'wind') == true) ? true : false;
			
			if(isset($this->fontpath) && file_exists($_SERVER['DOCUMENT_ROOT'] . $this->fontpath.$family.".ttf")) {
				$family = $_SERVER['DOCUMENT_ROOT'] . $this->fontpath.$family.".ttf";
				$use_fontfile = true;
				
				// Angle
				$angle = rand($this->angle['left'], $this->angle['right']);
			
				// Coordinates
				$coords = imagettfbbox($size, $angle, $family, $sign);
		 		$width = abs( ( (-1) * abs(min($coords[0],$coords[6])) ) + ( abs(max($coords[2],$coords[4])) ) );
		 		$height = abs( ( (-1) * abs(min($coords[1],$coords[7])) ) + ( abs(max($coords[3],$coords[5])) ) );
 			
			} else if(isset($this->fontpath) && file_exists($this->fontpath.$family.".ttf")) {
				$family = $this->fontpath.$family.".ttf";
				$use_fontfile = true;
				
				// Angle
				$angle = rand($this->angle['left'], $this->angle['right']);
			
				// Coordinates
				$coords = imagettfbbox($size, $angle, $family, $sign);
		 		$width = abs( ( (-1) * abs(min($coords[0],$coords[6])) ) + ( abs(max($coords[2],$coords[4])) ) );
		 		$height = abs( ( (-1) * abs(min($coords[1],$coords[7])) ) + ( abs(max($coords[3],$coords[5])) ) );
 			
			} else if($isWindows) {
				$use_fontfile = true;
				if(isset($_ENV['windir'])) {
					$windir = substr_replace('\\','/',$_ENV['windir']);
					if(file_exists($windir . "/fonts/" . $family."ttf")){
						$family = $windir . "/fonts/" . $family."ttf";
					} else if(file_exists(substr($windir,0,2) . "/fonts/" . $family."ttf")) {
						$family = substr($windir,0,2) . "/fonts/" . $family."ttf";
					} else {
						$family = $_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/fonts/DejaVuSans.ttf";
					}
				} else if(isset($_ENV['SystemRoot'])){
					$windir = substr_replace('\\','/',$_ENV['SystemRoot']);
					if(file_exists($windir . "/fonts/" . $family."ttf")){
						$family = $windir . "/fonts/" . $family."ttf";
					} else if(file_exists(substr($windir,0,2) . "/fonts/" . $family."ttf")) {
						$family = substr($windir,0,2) . "/fonts/" . $family."ttf";
					} else {
						$family = $_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/fonts/DejaVuSans.ttf";
					}
				} else if(isset($_ENV['SystemDrive'])){
					$windir = substr_replace('\\','/',$_ENV['SystemDrive']);
					if(file_exists($windir . "/windows/fonts/" . $family."ttf")){
						$family = $windir . "/windows/fonts/" . $family."ttf";
					} else if(file_exists($windir . "/winnt/fonts/" . $family."ttf")) {
						$family = $windir . "/winnt/fonts/" . $family."ttf";
					} else if(file_exists($windir . "/fonts/" . $family."ttf")) {
						$family = $windir . "/fonts/" . $family."ttf";
					} else {
						$family = $_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/fonts/DejaVuSans.ttf";
					}
				} else {
					$use_fontfile = false;
					$family = $_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/fonts/DejaVuSans.ttf";
				}
				$use_fontfile = true;
				
				// Angle
				$angle = rand($this->angle['left'], $this->angle['right']);
			
				// Coordinates
				$coords = imagettfbbox($size, $angle, $family, $sign);
		 		$width = abs( ( (-1) * abs(min($coords[0],$coords[6])) ) + ( abs(max($coords[2],$coords[4])) ) );
		 		$height = abs( ( (-1) * abs(min($coords[1],$coords[7])) ) + ( abs(max($coords[3],$coords[5])) ) );
 			
			} else {
				$family = 5;
				$use_fontfile = false;
				
				// Angle
				$angle = 0;
				$width = (int) imagefontwidth($family) * strlen($sign);
				$height = (int) imagefontheight($family);
				
			}
			
			
 			// Abstand X-Position
			if(($xpos + $width) <= $this->width) {
				

				if($use_fontfile) {
					$family = file_exists($family) ? $family : $_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/fonts/DejaVuSans.ttf";
					// Y-Position
					if($this->valign == 'top') {
						$ypos = $height+5;
					} elseif($this->valign == 'bottom') {
						$ypos = $this->height-5;
					} elseif($this->valign == 'middle') {
						$ypos = ($this->height/2) + ($height/2);
					} elseif($this->valign == 'random') {
						$max = $this->height-5;
						$min = $height+5;
						$ypos = rand($min, $max);
					}
					
					$tmp_sign = array(
						'size'		=> $size,
						'angle'		=> $angle,
						'xpos'		=> $xpos,
						'ypos'		=> $ypos,
						'color'		=> imagecolorallocate($image, $color[0], $color[1], $color[2]),
						'family'	=> $family,
						'sign'		=> $sign,
					);
					
				} else {
					
					// Y-Position
					if($this->valign == 'top') {
						$ypos = 0;
					} elseif($this->valign == 'bottom') {
						$ypos = $this->height - $height;
					} elseif($this->valign == 'middle') {
						$ypos = (($this->height)/2) - ($height/2);
					} elseif($this->valign == 'random') {
						$max = $this->height - $height;
						$min = 0;
						$ypos = rand($min, $max);
					}
					
					$tmp_sign = array(
						'xpos'		=> $xpos,
						'ypos'		=> $ypos,
						'color'		=> imagecolorallocate($image, $color[0], $color[1], $color[2]),
						'family'	=> $family,
						'sign'		=> $sign,
					);
				}
				
				array_push($signs, $tmp_sign);
				
				$space = rand(round($this->font['size']['min']/2), round($this->font['size']['max']/2));
			
				
				// X-Position
				$xpos += round($space);
				$xpos += $width;
				
				$code .= $sign;
			
				$sumwidth += round($space) + $width;
				
			}
			
		}
		
		if($this->align == 'random') {
			$temp = array('left', 'right', 'center');
			$this->align = $temp[rand(0, 2)];
		}
		
		// align
		if($use_fontfile) {
			if($this->align == 'left') {
				$xoffset = 5;
			} elseif($this->align == 'right') {
				$xoffset = $this->width-$sumwidth-5;
			} elseif($this->align == 'center') {
				$xoffset = ($this->width/2) - ($sumwidth/2);
			}
		} else {
			if($this->align == 'left') {
				$xoffset = 5;
			} elseif($this->align == 'right') {
				$xoffset = $this->width-$sumwidth;
			} elseif($this->align == 'center') {
				$xoffset = ($this->width/2) - ($sumwidth/2) + 3;
			}
		}
		
		foreach($signs as $sign) {
			
			if($use_fontfile) {
					
				imagettftext(
					$image,							// Imageressource
					$sign['size'],					// Fontsize
					$sign['angle'], 				// Angle
					$xoffset+$sign['xpos'], 		// X-Position
					$sign['ypos'],					// Y-Position
					$sign['color'], 				// Fontcolor
					$sign['family'], 				// Font Family (File)
					$sign['sign']					// Text
				);
					
			} else {
				
				imagestring(
					$image,
					$sign['family'],
					$xoffset+$sign['xpos'],
					$sign['ypos'],
					$sign['sign'],
					$sign['color']
				);
				
			}
			
		}
		
		if($this->style['strikeout']) {
			
			// Y-Position
			$max = ($this->height/2)+10;
			$min = ($this->height/2)-10;
			$y1 = $y2 = rand($min, $max);
			
			// X-Position
			$x1 = 0;
			$x2 = $this->width;
			
			$color = $this->font['color'][rand(0, sizeof($this->font['color'])-1)];
			
			imageline(
				$image,
				$x1,
				$y1,
				$x2,
				$y2,
				imagecolorallocate($image, $color[0], $color[1], $color[2])
			);
			
		}
		
		return $image;
    	
	} /* end: get */
	
} /* end: Class */


?>