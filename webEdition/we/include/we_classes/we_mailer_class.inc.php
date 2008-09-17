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


define("WE_MAIL_TEXT_ONLY",0);
define("WE_MAIL_HTML_ONLY",1);
define("WE_MAIL_TEXT_AND_HTML",2);

require_once($_SERVER['DOCUMENT_ROOT'] . "/webEdition/we/include/we_classes/smtp.class.php");

class we_mailer {

	var $recipient;
	var $subject;
	var $txt;
	var $from;
	var $reply;
	var $sendHTML = 0; // 0=normal, 1 = HTML only, 2 = HTML und Text
	var $multipart = false;
	var $attachments = array();
	var $charset = "iso-8859-1";
	var $out = "";
	var $alttext = "";
	var $basehref = "";
	var $addtional;
	var $mailer;
	var $wwrap = 998;

	var $SMTPMailer;
	var $SMTPKeepAlive = true;
	var $SMTPHelo;
	var $SMTPServer;
	var $SMTPPort;
	var $SMTPAuth;
	var $SMTPUsername;
	var $SMTPPassword;
	var $SMTPTimeout=30;
	
	function we_mailer($recipient,$subject,$txt,$from="",$reply="",$sendHTML=0,$charset = "iso-8859-1",$basehref="",$alttext="",$additional='',$wordwrap=998){
		$this->mailer = defined('WE_MAILER') ? WE_MAILER : "php";
		$this->recipient = $recipient;
		$this->subject = $subject;
		$this->txt = $txt;
		$this->from = $from;
		$this->reply = $reply;
		$this->sendHTML = $sendHTML;
		$this->charset = $charset;
		$this->alttext = $alttext;
		$this->basehref = $basehref;
		$this->addtional = $additional;
		
		//according to rfc2822 the line "MUST be no more than 998 characters"
		if($wordwrap){
			$this->wwrap = $wordwrap;
			$this->txt = wordwrap($this->txt, $wordwrap, "\n");
			$this->alttext = wordwrap($this->alttext, $wordwrap, "\n");
		}
		
		$this->out .= "Mime-Version: 1.0\n";
		if($this->reply){
			$this->out .= "Return-Path: ".$this->reply."\n";
			$this->out .= "Reply-To: ".$this->reply."\n";
		}
		if($this->from) $this->out .= "From: ".$this->from."\n";
		$this->out .= "X-Mailer: webEdition CMS\n";
		
		if($this->mailer=='smtp'){
			$this->setSMTPParams();
			$this->out .= "To: ".$this->recipient."\n";
			$this->out .= "Subject: ".$this->encode_subject($this->subject)."\n";
			if (preg_match('/<(.)+>/',$this->recipient,$_rcp)) {
				$this->recipient=substr($_rcp[0],1,-1);
			}
			
		}
		
	}
	
	
	function setSMTPParams() {
		
			if(defined('SMTP_SERVER')) $this->SMTPServer = SMTP_SERVER;
			if(defined('SMTP_PORT')) $this->SMTPPort = SMTP_PORT;
			if(defined('SMTP_AUTH')) $this->SMTPAuth = SMTP_AUTH;
			if(defined('SMTP_USERNAME')) $this->SMTPUsername = SMTP_USERNAME;
			if(defined('SMTP_PASSWORD')) $this->SMTPPassword = SMTP_PASSWORD;
			if(defined('SMTP_TIMEOUT') && SMTP_TIMEOUT!='') $this->SMTPTimeout = SMTP_TIMEOUT;
			if(defined('SMTP_HALO')) $this->SMTPHalo = SMTP_HALO;
			
	}
	
	function attachFile($path){
		$fp = @fopen($path,"rb");
		if($fp){
			$data = fread($fp,filesize($path));
			fclose($fp);
		}
		$this->attach($data,basename($path));
	}
	 
	function attach($data,$name){
		$ext = ereg_replace(".*(\.[^\.]+)$",'\1',$name);
		$ct = $this->getMimeType($ext);
		$inline = (substr($ct,0,5) == "image");

		$_namesplit = split("/",$name);
		$_name = $_namesplit[count($_namesplit)-1];
		unset($_namesplit);
		
		$foo = "Content-Disposition: ".($inline ? "inline" : "attachment")."; filename=$_name\n";
		$foo .= "Content-Transfer-Encoding: base64\n";
		$foo .= "Content-Type: $ct;name=\"$_name\"\n";
		$foo .= "\n";
		$foo .= chunk_split(base64_encode($data),76,"\n");	
		$foo .= "\n";
		array_push($this->attachments,$foo);
	}
	
	function convertQuotedPrintable($txt){
		$txt = str_replace('�','=C4',$txt);
		$txt = str_replace('�','=D6',$txt);
		$txt = str_replace('�','=DC',$txt);
		$txt = str_replace('�','=E4',$txt);
		$txt = str_replace('�','=F6',$txt);
		$txt = str_replace('�','=FC',$txt);
		$txt = str_replace('�','=DF',$txt);
		$txt = str_replace('=','=3D',$txt);
		$txt = str_replace("\t",'=09',$txt);
		return $txt;
	}
	
	function HTML2QuotetPrintable($txt){
		$txt = str_replace('&Auml;','=C4',$txt);
		$txt = str_replace('&Ouml;','=D6',$txt);
		$txt = str_replace('&Uuml;','=DC',$txt);
		$txt = str_replace('&auml;','=E4',$txt);
		$txt = str_replace('&ouml;','=F6',$txt);
		$txt = str_replace('&uuml;','=FC',$txt);
		$txt = str_replace('&szlig;','=DF',$txt);
		$txt = str_replace('&lt;','<',$txt);
		$txt = str_replace("&gt;",'>',$txt);
		return $txt;
	}
	
	function Uml2HTML($txt){
		if($this->charset == "iso-8859-1"){
			$txt = str_replace('�','&Auml;',$txt);
			$txt = str_replace('�','&Ouml;',$txt);
			$txt = str_replace('�','&Uuml;',$txt);
			$txt = str_replace('�','&auml;',$txt);
			$txt = str_replace('�','&ouml;',$txt);
			$txt = str_replace('�','&uuml;',$txt);
			$txt = str_replace('�','&szlig;',$txt);
		}
		return $txt;
	}
	function HTML2Uml($txt){
		if($this->charset == "iso-8859-1"){
			$txt = str_replace('&Auml;','�',$txt);
			$txt = str_replace('&Ouml;','�',$txt);
			$txt = str_replace('&Uuml;','�',$txt);
			$txt = str_replace('&auml;','�',$txt);
			$txt = str_replace('&ouml;','�',$txt);
			$txt = str_replace('&uuml;','�',$txt);
			$txt = str_replace('&szlig;','�',$txt);
		}
		return $txt;
	}
	
	function HTML2Txt($txt){
		$txt = we_mailer::HTML2Uml($txt);
		$txt = eregi_replace('(<td[^>]*>)','\1 ',$txt);
		$txt = strip_tags($txt);
		$txt = trim($txt);
		return $txt;
	}
	
	function send(){
	
		if(sizeof($this->attachments) == 0){
			$this->createMailText();
		}else{
			$this->createMimeMail();
		}
		return $this->sendMail();
		
	}
	
	function createMimeMail(){
		$boundary = "webEdition_".md5(uniqid(rand()));
		$this->out .= "Content-Type: multipart/mixed; boundary=$boundary\n";
		$this->out .= "\n";
		$this->out .= "\n";
		$this->out .= "--$boundary\n";
		$this->createMailText();
		$this->out .= "\n";
		foreach($this->attachments as $a){
			$this->out .= "--$boundary\n";
			$this->out .= $a;
			$this->out .= "\n";
		}
		$this->out .= "--".$boundary."--\n";
	}
	
	function createMailText(){
		switch($this->sendHTML){
			case WE_MAIL_HTML_ONLY:
				$this->createPureHTMLMail();
				break;
			case WE_MAIL_TEXT_AND_HTML:
				$this->createAlternativeHTMLMail();
				break;
			default:
				$this->createNormalMail();
		}
	}
	
	function createNormalMail(){
		$this->out .= "Content-Type: text/plain; charset=".$this->charset."; format=flowed\n";
		$this->out .= "Content-Transfer-Encoding: 8bit\n";
		$this->out .= "\n";
		$this->out .= $this->txt;
	}
	
	function createPureHTMLMail(){
		$this->out .= "Content-Type: text/html; charset=".$this->charset."\n";
		$this->out .= "Content-Transfer-Encoding: quoted-printable\n";
		$this->out .= "\n";
		$this->out .= ((!eregi('<html', $this->txt)) ? $this->quoted_printable_encode($this->HTMLHeader()) : "").
			$this->quoted_printable_encode($this->txt) .
			((!eregi('</html>', $this->txt)) ? $this->HTMLFooter() : "");
	}

	function createAlternativeHTMLMail(){
		$boundary = "webEdition--".md5(uniqid(rand()));
		$this->out .= "Content-Type: multipart/alternative; boundary=$boundary\n";
		$this->out .= "\n";
		$this->out .= "\n";
		$this->out .= "--$boundary\n";
		$this->out .= "Content-Type: text/plain; charset=".$this->charset."; format=flowed\n";
		$this->out .= "Content-Transfer-Encoding: 8bit\n";
		$this->out .= "\n";
		if($this->alttext){
			$this->out .= $this->alttext;
		}else{
			$this->out .= we_mailer::HTML2Txt($this->txt);
		}
		$this->out .= "\n";
		$this->out .= "\n";
		$this->out .= "--$boundary\n";
		$this->out .= "Content-Type: text/html; charset=".$this->charset."\n";
		$this->out .= "Content-Transfer-Encoding: quoted-printable\n\n";
		$this->out .= ((!eregi('<html', $this->txt)) ? $this->quoted_printable_encode($this->HTMLHeader()) : "").
						$this->quoted_printable_encode($this->txt) .
						((!eregi('</html>', $this->txt)) ? $this->HTMLFooter() : "")."\n";
		$this->out = str_replace('</html>','<table style="width:0; height:0" width=0 height=0 border=0 cellpadding=0 cellspacing=0><tr style="width:0; height:0"><td style="width:0; height:0"></td></tr></table></html>',$this->out);  // workaround for entorage rendering bug
		$this->out .= "--$boundary--\n";
	}
	
	function HTMLHeader(){
		$ret = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
';
		if($this->basehref){
			//$ret .= '<base href="'.$this->basehref.'">
//';
		}
 		$ret .= '<meta http-equiv="Content-Type" content="text/html;charset='.$this->charset.'">
<title></title>
</head>
<body>
';
		return $ret;
	}
	
	function HTMLFooter(){
		return '</body>
</html>
';
	}
	
	function encode_subject($string){
		if(!$string) return "";
		$text = '=?'.$this->charset.'?Q?';
		for( $i = 0 ; $i < strlen($string) ; $i++ ){
			$val = ord($string[$i]);
			if($string[$i] == " "){
				$text .= "_";
			}else if($val < 128 && $val!=63){
				$text .= $string[$i];
			}else{
				$val = strtoupper(dechex($val));
				$text .= '='.$val;
			}
		}
		$text .= '?=';
		return $text;
	}

	
	function sendMail(){
	
		$tmp = explode("\n\n",$this->out);
		
		$header = $tmp[0];
		
		$body = "";
		
		for($i=1;$i<sizeof($tmp);$i++){
			$body .= $tmp[$i];
			if( $i < (sizeof($tmp)-1)){
				$body .= "\n\n";
			}
		}
		$body = str_replace("\r\n","\n",$body);
		$header = str_replace("\r\n","\n",$header);
		$body = str_replace("\r","\n",$body);
		$header = str_replace("\r","\n",$header);
		if(runAtWin()){ 
			$body = str_replace("\n","\r\n",$body);
			$header = str_replace("\n","\r\n",$header);
		}
		// remove possible NUL characters
		$header = str_replace(chr(0),'',$header);
		$body = str_replace(chr(0),'',$body);

		if($this->mailer=='smtp') {
			return $this->SMTPSend($header,$body);
		} else {
		
			$_is_safe_mode = ini_get('safe_mode');		
			$_is_safe_mode_ed = ini_get('safe_mode_exec_dir');
				
			if($_is_safe_mode=='1' || $_is_safe_mode_ed=='1') {
				return @mail($this->recipient,$this->encode_subject($this->subject),$body,$header);
			} else {
				return @mail($this->recipient,$this->encode_subject($this->subject),$body,$header,$this->addtional);
			}
		}		
	}
	
	function getMimeType($ext){
		switch($ext){
			case ".ez":
				return "application/andrew-inset";
			case ".hqx":
				return "application/mac-binhex40";
			case ".cpt":
				return "application/mac-compactpro";
			case ".doc":
				return "application/msword";
			case ".bin":
				return "application/octet-stream";
			case ".dms":
				return "application/octet-stream";
			case ".lha":
				return "application/octet-stream";
			case ".lzh":
				return "application/octet-stream";
			case ".exe":
				return "application/octet-stream";
			case ".class":
				return "application/octet-stream";
			case ".so":
				return "application/octet-stream";
			case ".dll":
				return "application/octet-stream";
			case ".dmg":
				return "application/octet-stream";
			case ".oda":
				return "application/oda";
			case ".pdf":
				return "application/pdf";
			case ".ai":
				return "application/postscript";
			case ".eps":
				return "application/postscript";
			case ".ps":
				return "application/postscript";
			case ".smi":
				return "application/smil";
			case ".smil":
				return "application/smil";
			case ".mif":
				return "application/vnd.mif";
			case ".xls":
				return "application/vnd.ms-excel";
			case ".ppt":
				return "application/vnd.ms-powerpoint";
			case ".wbxml":
				return "application/vnd.wap.wbxml";
			case ".wmlc":
				return "application/vnd.wap.wmlc";
			case ".wmlsc":
				return "application/vnd.wap.wmlscriptc";
			case ".bcpio":
				return "application/x-bcpio";
			case ".vcd":
				return "application/x-cdlink";
			case ".pgn":
				return "application/x-chess-pgn";
			case ".cpio":
				return "application/x-cpio";
			case ".csh":
				return "application/x-csh";
			case ".dcr":
				return "application/x-director";
			case ".dir":
				return "application/x-director";
			case ".dxr":
				return "application/x-director";
			case ".dvi":
				return "application/x-dvi";
			case ".spl":
				return "application/x-futuresplash";
			case ".gtar":
				return "application/x-gtar";
			case ".hdf":
				return "application/x-hdf";
			case ".js":
				return "application/x-javascript";
			case ".jnlp":
				return "application/x-java-jnlp-file";
			case ".skp":
				return "application/x-koan";
			case ".skd":
				return "application/x-koan";
			case ".skt":
				return "application/x-koan";
			case ".skm":
				return "application/x-koan";
			case ".latex":
				return "application/x-latex";
			case ".nc":
				return "application/x-netcdf";
			case ".cdf":
				return "application/x-netcdf";
			case ".sh":
				return "application/x-sh";
			case ".shar":
				return "application/x-shar";
			case ".swf":
				return "application/x-shockwave-flash";
			case ".sit":
				return "application/x-stuffit";
			case ".sv4cpio":
				return "application/x-sv4cpio";
			case ".sv4crc":
				return "application/x-sv4crc";
			case ".tar":
				return "application/x-tar";
			case ".tcl":
				return "application/x-tcl";
			case ".tex":
				return "application/x-tex";
			case ".texinfo":
				return "application/x-texinfo";
			case ".texi":
				return "application/x-texinfo";
			case ".t":
				return "application/x-troff";
			case ".tr":
				return "application/x-troff";
			case ".roff":
				return "application/x-troff";
			case ".man":
				return "application/x-troff-man";
			case ".me":
				return "application/x-troff-me";
			case ".ms":
				return "application/x-troff-ms";
			case ".ustar":
				return "application/x-ustar";
			case ".src":
				return "application/x-wais-source";
			case ".xhtml":
				return "application/xhtml+xml";
			case ".xht":
				return "application/xhtml+xml";
			case ".zip":
				return "application/zip";
			case ".au":
				return "audio/basic";
			case ".snd":
				return "audio/basic";
			case ".mid":
				return "audio/midi";
			case ".midi":
				return "audio/midi";
			case ".kar":
				return "audio/midi";
			case ".mpga":
				return "audio/mpeg";
			case ".mp2":
				return "audio/mpeg";
			case ".mp3":
				return "audio/mpeg";
			case ".aif":
				return "audio/x-aiff";
			case ".aiff":
				return "audio/x-aiff";
			case ".aifc":
				return "audio/x-aiff";
			case ".m3u":
				return "audio/x-mpegurl";
			case ".ram":
				return "audio/x-pn-realaudio";
			case ".rm":
				return "audio/x-pn-realaudio";
			case ".rpm":
				return "audio/x-pn-realaudio-plugin";
			case ".ra":
				return "audio/x-realaudio";
			case ".wav":
				return "audio/x-wav";
			case ".pdb":
				return "chemical/x-pdb";
			case ".xyz":
				return "chemical/x-xyz";
			case ".bmp":
				return "image/bmp";
			case ".bmx":
				return "image/x-bmp";
			case ".gif":
				return "image/gif";
			case ".ief":
				return "image/ief";
			case ".jpeg":
				return "image/jpeg";
			case ".jpg":
				return "image/jpeg";
			case ".jpe":
				return "image/jpeg";
			case ".pict":
				return "image/pict";
			case ".pic":
				return "image/pict";
			case ".pct":
				return "image/pict";
			case ".png":
				return "image/png";
			case ".tiff":
				return "image/tiff";
			case ".tif":
				return "image/tiff";
			case ".djvu":
				return "image/vnd.djvu";
			case ".djv":
				return "image/vnd.djvu";
			case ".wbmp":
				return "image/vnd.wap.wbmp";
			case ".ras":
				return "image/x-cmu-raster";
			case ".pntg":
				return "image/x-macpaint";
			case ".pnt":
				return "image/x-macpaint";
			case ".mac":
				return "image/x-macpaint";
			case ".pnm":
				return "image/x-portable-anymap";
			case ".pbm":
				return "image/x-portable-bitmap";
			case ".pgm":
				return "image/x-portable-graymap";
			case ".ppm":
				return "image/x-portable-pixmap";
			case ".qtif":
				return "image/x-quicktime";
			case ".qti":
				return "image/x-quicktime";
			case ".rgb":
				return "image/x-rgb";
			case ".xbm":
				return "image/x-xbitmap";
			case ".xpm":
				return "image/x-xpixmap";
			case ".xwd":
				return "image/x-xwindowdump";
			case ".igs":
				return "model/iges";
			case ".iges":
				return "model/iges";
			case ".msh":
				return "model/mesh";
			case ".mesh":
				return "model/mesh";
			case ".silo":
				return "model/mesh";
			case ".wrl":
				return "model/vrml";
			case ".vrml":
				return "model/vrml";
			case ".css":
				return "text/css";
			case ".html":
				return "text/html";
			case ".htm":
				return "text/html";
			case ".asc":
				return "text/plain";
			case ".txt":
				return "text/plain";
			case ".rtx":
				return "text/richtext";
			case ".rtf":
				return "text/rtf";
			case ".sgml":
				return "text/sgml";
			case ".sgm":
				return "text/sgml";
			case ".tsv":
				return "text/tab-separated-values";
			case ".wml":
				return "text/vnd.wap.wml";
			case ".wmls":
				return "text/vnd.wap.wmlscript";
			case ".etx":
				return "text/x-setext";
			case ".xml":
				return "text/xml";
			case ".xsl":
				return "text/xml";
			case ".mp4":
				return "video/mp4";
			case ".mpeg":
				return "video/mpeg";
			case ".mpg":
				return "video/mpeg";
			case ".mpe":
				return "video/mpeg";
			case ".qt":
				return "video/quicktime";
			case ".mov":
				return "video/quicktime";
			case ".mxu":
				return "video/vnd.mpegurl";
			case ".dv":
				return "video/x-dv";
			case ".dif":
				return "video/x-dv";
			case ".avi":
				return "video/x-msvideo";
			case ".movie":
				return "video/x-sgi-movie";
			case ".ice":
				return "x-conference/x-cooltalk";
			default:
				return "application/octet-stream";			
		}
	}

	function quoted_printable_encode($text) {

		$_lines = explode("\r\n",$text);

		for ($i=0;$i<count($_lines);$i++) {
			$_line =& $_lines[$i];
			if (strlen($_line)!==0) {
				
				$_rege = '/[^\x20\x21-\x3C\x3E-\x7E]/e';
				$_rep = 'sprintf( "=%02X", ord ( "$0" ) ) ;';

				$_line = preg_replace($_rege, $_rep, $_line ); 
				$_len = strlen($_line);
				$_last = ord($_line{$_len-1});
				    
				if (($_last==0x09)||($_last==0x20)) {
					$_line{$_len-1}='=';
					$_line .= ($_last==0x09)?'09':'20';
				}

				$_line = str_replace(' =0D','=20=0D',$_line);
				$_match = array();
				preg_match_all( '/.{1,73}([^=]{0,2})?/', $_line, $_match);
				$_line = implode( '=' . "\r\n", $_match[0] );
			}

		}

		return implode("\r\n",$_lines);

	}	
	
	
	
	 function SMTPConnect() {
	 	
        if($this->SMTPMailer == NULL) { 
        	$this->SMTPMailer = new SMTP(); 
        }

        $this->SMTPMailer->do_debug = 0;
       
        if($this->SMTPMailer->do_debug>0) { 
        	ob_start();
        }
        
        if(!$this->SMTPMailer->Connected()) {
        	
	        if($this->SMTPMailer->Connect($this->SMTPServer, $this->SMTPPort, $this->SMTPTimeout)) {
	        
	            $this->SMTPMailer->Hello($this->SMTPHelo);
	            
	            if($this->SMTPAuth) {
	            	
	            	if(!$this->SMTPMailer->Authenticate($this->SMTPUsername,$this->SMTPPassword)) {
	                    return false;
	                }
	            }
	            
	        }
        }
        
        if($this->SMTPMailer->do_debug>0) {
	       error_log2(ob_get_contents());
		   ob_end_clean();
        }
        
        return true;
    }
    
	function SMTPSend($header, $body) {

		$_result = true;
		
		if($this->SMTPMailer == NULL) { 
        	$this->SMTPMailer = new SMTP(); 
        }
		
		if($this->SMTPMailer->do_debug>0) { 
			ob_start();
       }
        
        if(!$this->SMTPConnect()) {
            return false;
        } else {

	        if(!$this->SMTPMailer->Mail($this->from)) {
	            $_result = false;
	        } else {
	
		        if(!$this->SMTPMailer->Recipient($this->recipient)) {
		        	$_result = false;
		        } else {

		        	if(runAtWin()){ 
		        		$mt = "\r\n\r\n";
		        	} else {
		        		$mt = "\n\n";
		        	}

			        if(!$this->SMTPMailer->Data($header . $mt . $body)) {
			            $this->SMTPMailer->Reset();
			            $_result = false;
			        }

		        }
	        }
        }
        
        if($this->SMTPKeepAlive == true) {
            $this->SMTPMailer->Reset();
		} else {
            $this->SMTPClose();
        }

        if($this->SMTPMailer->do_debug>0) { 
	       error_log2(ob_get_contents());
		   ob_end_clean();
        }

        return $_result;
    }
    
    
    function SMTPClose() {
       if($this->SMTPMailer->do_debug>0) { 
			ob_start();
       }
       if(isset($this->SMTPMailer) && $this->SMTPMailer->Connected()) {
            $this->SMTPMailer->Quit();
            $this->SMTPMailer->Close();
        }
        if($this->SMTPMailer->do_debug>0) { 
	       error_log2(ob_get_contents());
		   ob_end_clean();
        }
        
    }
    
	
	
}

?>