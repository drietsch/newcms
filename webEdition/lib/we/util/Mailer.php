<?php
/**
 * webEdition SDK
 *
 * LICENSE_TEXT
 *
 * TODO insert license text
 *
 * @category   we
 * @package    we_util
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENCE_TYPE  TODO insert license type and url
 */

include_once $GLOBALS['__WE_LIB_PATH__'] . '/phpMailer/class.phpmailer.php';

/**
 * PHP email transport class
 * 
 */
class we_util_Mailer extends PHPMailer
{

	/**
	 * Flag for embed images
	 *
	 * @var Bool
	 */
	protected $isEmbedImages = false;

	/**
	 * Enter description here...
	 *
	 * @var unknown_type
	 */
	protected $basedir = '';

	/**
	 * Enter description here...
	 *
	 * @var unknown_type
	 */
	protected $embedImages = array('gif', 'jpg', 'jpeg', 'jpe', 'bmp', 'png', 'tif', 'tiff', 'swf');

	/**
	 * Enter description here...
	 *
	 * @param String || Array $to use Array for a list of users
	 * @param String $subject
	 * @param String $sender
	 * @param String $reply
	 * @param Bool $isEmbedImages
	 */
	public function __construct($to = "", $subject = "", $sender = "", $reply = "", $isEmbedImages = 0)
	{
		if (defined("WE_MAILER")) {
			switch (WE_MAILER) {
				case 'php' :
					$this->IsMail();
					break;
				
				case 'smtp' :
					$this->IsSMTP();
					if (defined('SMTP_SERVER'))
						$this->Host = SMTP_SERVER;
					if (defined('SMTP_PORT'))
						$this->Port = SMTP_PORT;
					if (defined('SMTP_AUTH'))
						$this->SMTPAuth = SMTP_AUTH;
					if (defined('SMTP_USERNAME'))
						$this->Username = SMTP_USERNAME;
					if (defined('SMTP_PASSWORD'))
						$this->Password = SMTP_PASSWORD;
					if (defined('SMTP_TIMEOUT') && SMTP_TIMEOUT != '')
						$this->Timeout = SMTP_TIMEOUT;
					if (defined('SMTP_HALO'))
						$this->Halo = SMTP_HALO;
					break;
				default :
					$this->IsMail();
					break;
			}
			;
		}
		
		if (is_array($to) && count($to) > 0) {
			foreach ($to as $_to) {
				$_to = $this->parseEmailUser($_to);
				$this->AddAddress($_to['email'], $_to['name']);
			}
		} else if ($to != "") {
			$_to = $this->parseEmailUser($to);
			$this->AddAddress($_to['email'], $_to['name']);
		}
		
		if (is_array($reply) && count($reply) > 0) {
			foreach ($reply as $_reply) {
				$_reply = $this->parseEmailUser($_reply);
				$this->AddReplyTo($_reply['email'], $_reply['name']);
			}
		} else if ($reply != "") {
			$_reply = $this->parseEmailUser($reply);
			$this->AddReplyTo($_reply['email'], $_reply['name']);
		}
		
		$_sender = $this->parseEmailUser($sender);
		
		$this->setClassVars(array('Subject' => $subject, 'Sender' => $_sender['email'], 'From' => $_sender['email'], 'FromName' => $_sender['name'], 'isEmbedImages' => $isEmbedImages, 'CharSet' => "UTF-8"));
	}

	public function parseEmailUser($user)
	{
		if (preg_match("/<(.)*>/", $user, $_user)) {
			$email = substr($_user[0], 1, strpos($_user[0], ">") - 1);
			$name = substr($user, 0, strpos($user, "<"));
		} else {
			$email = $user;
			$name = "";
		}
		return array("email" => trim($email), "name" => trim($name));
	}

	public function addHTMLPart($val)
	{
		$this->IsHTML(true);
		$this->Body .= $val;
	}

	public function addTextPart($val)
	{
		$this->AltBody .= $val;
	}

	public function addAddressList($list)
	{
		if (is_array($list) && count($list) > 0) {
			foreach ($list as $_to) {
				$_to = $this->parseEmailUser($_to);
				$this->AddAddress($_to['email'], $_to['name']);
			}
		}
	}

	public function buildMessage()
	{
		if ($this->isEmbedImages) {
			preg_match_all("/(src|background)=\"(.*)\"/Ui", $this->Body, $images);
			foreach ($images[2] as $i => $url) {
				// only images that from the own server will be embeded
				if (preg_match('/^[A-z][A-z]*:\/\/' . $_SERVER['HTTP_HOST'] . '/', $url) || !preg_match('/^[A-z][A-z]*:\/\//', $url)) {
					$filename = basename($url);
					$directory = dirname($url);
					($directory == '.') ? $directory = '' : '';
					$directory = str_replace("..", "", "$directory");
					if ($pos = stripos($directory, $_SERVER['HTTP_HOST'])) {
						$directory = substr($directory, (strlen($_SERVER['HTTP_HOST']) + $pos), strlen($directory));
					}
					
					$cid = 'cid:' . md5($filename);
					$fileParts = split("\.", $filename);
					$ext = $fileParts[1];
					$mimeType = $this->_mime_types($ext);
					if ($this->basedir == "") {
						$this->basedir = $_SERVER['DOCUMENT_ROOT'];
					}
					if (strlen($this->basedir) > 1 && substr($this->basedir, -1) != '/') {
						$this->basedir .= '/';
					}
					if (strlen($directory) > 1 && substr($directory, -1) != '/') {
						$directory .= '/';
					}
					if (in_array($ext, $this->embedImages)) {
						if ($this->AddEmbeddedImage($this->basedir . $directory . $filename, md5($filename), $filename, 'base64', $mimeType)) {
							$this->Body = preg_replace("/" . $images[1][$i] . "=\"" . preg_quote($url, '/') . "\"/Ui", $images[1][$i] . "=\"" . $cid . "\"", $this->Body);
						}
					}
				}
			}
		}
		$protocol = strtolower(str_replace(strstr($_SERVER['SERVER_PROTOCOL'],"/"),"",$_SERVER['SERVER_PROTOCOL']));
		
		if ($this->ContentType == 'text/html' && !strpos($this->Body,"<base")) {
			$this->Body = str_replace("</head>","<base href='".($protocol==""?"":$protocol."://").$_SERVER['HTTP_HOST']."' />\n</head>",$this->Body);
		}
		
		if ((!isset($this->AltBody) || $this->AltBody == "") && $this->ContentType == 'text/html') {
			$this->parseHtml2TextPart($this->Body);
		} else if (!isset($this->Body) || $this->Body == "") {
			$this->Body = $this->AltBody;
			$this->AltBody="";
		}
		$this->AltBody = trim($this->AltBody);
		$this->Body    = trim($this->Body);
		$this->messageBuilt = true;
	}

	public function parseHtml2TextPart($html)
	{
		$lineBreacks = array("\n" => "", "\r" => "", "</h1>" => "</h1>\n\n", "</h2>" => "</h2>\n\n", "</h3>" => "</h3>\n\n", "</h4>" => "</h4>\n\n", "</h5>" => "</h5>\n\n", "</h6>" => "</h6>\n\n", "</p>" => "</p>\n\n", "</div>" => "</div>\n", "</li>" => "</li>\n");
		
		$textpart = strtr($html, $lineBreacks);
		$textpart = preg_replace('/<br[^>]*>/s', "\n", $textpart);
		$textpart = preg_replace('/<(ul|ol)[^>]*>/s', "\n\n", $textpart);
		$this->AltBody = trim(strip_tags(preg_replace('/<(head|title|style|script)[^>]*>.*?<\/\\1>/s', '', $textpart)));
	}

	/********************************************
	 *                  SETTER                  *
	 ********************************************/
	
	/**
	 * Setter for more class vars at once
	 * The array keys represents the names of the class vars
	 *
	 * @param Array $vars
	 */
	public function setClassVars($vars)
	{
		if (is_array($vars) && count($vars) > 0) {
			foreach ($vars as $var => $val) {
				$this->set($var, $val);
			}
		}
	}

	public function setCharSet($val = 'UTF-8')
	{
		$this->CharSet = $val;
	}

	public function setContentType($val = 'text/plain')
	{
		$this->ContentType = $val;
	}

	public function setEncoding($val = '8bit')
	{
		$this->Encoding = $val;
	}

	public function setFrom($val = 'root@localhost')
	{
		$this->From = $val;
	}

	public function setFromName($val = 'Root User')
	{
		$this->FromName = $val;
	}

	public function setSender($val)
	{
		$this->Sender = $val;
	}

	public function setSubject($val)
	{
		$this->Subject = $val;
	}

	public function setBaseDir($val)
	{
		$this->basedir = $val;
	}

	public function setIsEmbedImages($val = false)
	{
		$this->isEmbedImages = $val;
	}

	public function setBody($val)
	{
		$this->Body = $val;
	}

}
?>