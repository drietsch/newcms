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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
include_once $_SERVER['DOCUMENT_ROOT'].'/webEdition/lib/we/core/autoload.php';

define("WE_DEFAULT_EMAIL","mailserver@".SERVER_NAME);
define("WE_DEFAULT_SUBJECT","webEdition mailform");


$_blocked = false;

// check to see if we need to lock or block the formmail request

if (defined("FORMMAIL_LOG") && FORMMAIL_LOG) {
	$_ip = $_SERVER['REMOTE_ADDR'];
	$_now = time();

	// insert into log
	$GLOBALS["DB_WE"]->query("INSERT INTO " . FORMMAIL_LOG_TABLE . " (ip, unixTime) VALUES('".addslashes($_ip)."', " . abs($_now) . ")" );
	if (defined("FORMMAIL_EMPTYLOG") && (FORMMAIL_EMPTYLOG > -1)) {
		$GLOBALS["DB_WE"]->query("DELETE FROM " . FORMMAIL_LOG_TABLE . " WHERE unixTime < " . abs($_now - FORMMAIL_EMPTYLOG));
	}

	if (defined("FORMMAIL_BLOCK") && FORMMAIL_BLOCK) {

		$_num = 0;
		$_trials = (defined("FORMMAIL_TRIALS") ? FORMMAIL_TRIALS : 3);
		$_blocktime = (defined("FORMMAIL_BLOCKTIME") ? FORMMAIL_BLOCKTIME : 86400);

		// first delete all entries from blocktable which are older then now - blocktime
		$GLOBALS["DB_WE"]->query("DELETE FROM " . FORMMAIL_BLOCK_TABLE . " WHERE blockedUntil != -1 AND blockedUntil < " . abs($_now));

		// check if ip is allready blocked
		if (f("SELECT id FROM " . FORMMAIL_BLOCK_TABLE . " WHERE ip='" . addslashes($_ip) . "'","id",$GLOBALS["DB_WE"])) {
			$_blocked = true;
		} else {

			// ip is not blocked, so see if we need to block it
			$GLOBALS["DB_WE"]->query("SELECT * FROM " . FORMMAIL_LOG_TABLE . " WHERE unixTime > " . abs($_now - FORMMAIL_SPAN) . " AND ip='". addslashes($_ip) . "'");
			if ($GLOBALS["DB_WE"]->next_record()) {
				$_num = $GLOBALS["DB_WE"]->num_rows();
				if ($_num > $_trials) {
					$_blocked = true;
					// cleanup
					$GLOBALS["DB_WE"]->query("DELETE FROM " . FORMMAIL_BLOCK_TABLE . " WHERE ip='" . addslashes($_ip) . "'" );
					// insert in block table
					$blockedUntil = ($_blocktime == -1) ? -1 : abs($_now + $_blocktime);
					$GLOBALS["DB_WE"]->query("INSERT INTO " . FORMMAIL_BLOCK_TABLE . " (ip, blockedUntil) VALUES('".addslashes($_ip)."', " . $blockedUntil . ")" );
				}
			}
		}
	}


}

if(defined('FORMMAIL_VIAWEDOC') && FORMMAIL_VIAWEDOC){
	if($_SERVER['PHP_SELF'] == '/webEdition/we_formmail.php') $_blocked = true;
}

if ($_blocked) {
	print_error("Email dispatch blocked / Email Versand blockiert!");
}
	


function is_valid_email($email) {
	return preg_match('#^[a-z0-9.!\#$%&\'*+-/=?^_`{|}~]+@([0-9.]+|([^\s]+\.+[a-z]{2,6}))$#si', $email);
}

function contains_bad_str($str_to_test) {
	$str_to_test = trim($str_to_test);
	$bad_strings = array(
				"content-type:"
				,"mime-version:"
				,"Content-Transfer-Encoding:"
				,"bcc:"
				,"cc:"
				,"to:"
	);

	foreach($bad_strings as $bad_string) {
		if (preg_match('|^' . preg_quote($bad_string,"|").'|i',$str_to_test) || preg_match('|[\n\r]' . preg_quote($bad_string,"|").'|i',$str_to_test)) {
			print_error("Email dispatch blocked / Email Versand blockiert!");
		}
	}
	if (preg_match('|multipart/mixed|i', $str_to_test)) {
		print_error("Email dispatch blocked / Email Versand blockiert!");
	}
}

function replace_bad_str($str_to_test) {
	$out = $str_to_test;
	$bad_strings = array(
				"(content-type)(:)"
				,"(mime-version)(:)"
				,"(multipart/mixed)"
				,"(Content-Transfer-Encoding)(:)"
				,"(bcc)(:)"
				,"(cc)(:)"
				,"(to)(:)"
	);


	foreach($bad_strings as $bad_string) {
		$out = preg_replace("#$bad_string#i","($1)$2",$out);
	}
	return $out;
}

function contains_newlines($str_to_test) {
	if(preg_match("/(%0A|%0D|\\n+|\\r+)/i", $str_to_test) != 0) {
		print_error("newline found in $str_to_test. Suspected injection attempt - mail not being sent.");
	}
}

function print_error($errortext){

	$headline = "Fehler / Error";
	$content =		$GLOBALS["l_global"]["formmailerror"].getHtmlTag("br")
				.	"&#8226; ".$errortext;

	$css = array(
		'media' => 'screen',
		'rel'	=> 'stylesheet',
		'type'	=> 'text/css',
		'href'	=> WEBEDITION_DIR."css/global.php?WE_LANGUAGE=".$GLOBALS["WE_LANGUAGE"],
	);

	print '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">';
	print htmlTop();
	print getHtmlTag("link", $css);
	print "</head>";
	print getHtmlTag("body", array("class"=>"weEditorBody"), "", false, true);
	print htmlDialogLayout(getHtmlTag("div", array("class" => "defaultgray"), $content),$headline);
	print "</body></html>";

	exit;

}

function check_required($required){
	if($required){
		$we_requiredarray = explode(",",$required);
		for($i=0;$i<sizeof($we_requiredarray);$i++){
			if(!$_REQUEST[$we_requiredarray[$i]]){
				return false;
			}
		}
	}
	return true;
}

function error_page(){
	if($_REQUEST["error_page"]){
		$errorpage = (get_magic_quotes_gpc() == 1) ? stripslashes($_REQUEST["error_page"]) : $_REQUEST["error_page"];
		redirect($errorpage);
	}else{
		print_error($GLOBALS["l_global"]["email_notallfields"]);
	}
}

function ok_page(){
	if($_REQUEST["ok_page"]){
		$ok_page = (get_magic_quotes_gpc() == 1) ? stripslashes($_REQUEST["ok_page"]) : $_REQUEST["ok_page"];
		redirect($ok_page);
	}else{
		print "Vielen Dank, Ihre Formulardaten sind bei uns angekommen! / Thank you, we received your form data!";
		exit;
	}
}

function redirect($url){
    $prot = (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) === 'on') ? "https://"  : "http://";
    header("Location: " . $prot . $_SERVER['HTTP_HOST'] . $url);
    exit;
}


function check_recipient($email){
	if(f("SELECT ID FROM ".RECIPIENTS_TABLE." WHERE Email='".addslashes($email)."'","ID",$GLOBALS["DB_WE"])){
	   return true;
	}else{
		return false;
	}
}

function check_captcha(){
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/captcha/captchaImage.class.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/captcha/captchaMemory.class.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/captcha/captcha.class.php");

	$name = $_REQUEST['captchaname'];

	if(isset($_REQUEST[$name]) && !empty($_REQUEST[$name])) {
		return Captcha::check($_REQUEST[$name]);
	} else {
		return false;
	}	
}

$_req = isset($_REQUEST["required"]) ? $_REQUEST["required"] : "";

if(!check_required($_req)){
	error_page();
}

if(isset($_REQUEST["email"]) && $_REQUEST["email"]){
	if(!we_check_email($_REQUEST["email"])){
		if($_REQUEST["mail_error_page"]){
			$foo = (get_magic_quotes_gpc() == 1) ? stripslashes($_REQUEST["mail_error_page"]) : $_REQUEST["mail_error_page"];
			redirect($foo);
		}else{
			print_error($GLOBALS["l_global"]["email_invalid"]);
		}
	}
}

$output = array();

$we_reserved=array("from","we_remove","captchaname","we_mode","charset","required","order","ok_page","error_page","captcha_error_page","mail_error_page","recipient","subject","mimetype","confirm_mail","pre_confirm","post_confirm","MAX_FILE_SIZE",session_name(),"cookie","recipient_error_page","forcefrom");

if(isset($_REQUEST["we_remove"])){
	$removeArr = makeArrayFromCSV($_REQUEST["we_remove"]);
	foreach($removeArr as $val){
		array_push($we_reserved,$val);
	}
}

$we_txt = '';
$we_html = '<table>
';

$_order = isset($_REQUEST["order"]) ? $_REQUEST["order"] : "";
$we_orderarray = array();
if($_order){
	$we_orderarray = explode(",",$_order);
	for($i=0;$i<sizeof($we_orderarray);$i++){
		if(!in_array($we_orderarray[$i],$we_reserved)){
			$output[$we_orderarray[$i]] = $_REQUEST[$we_orderarray[$i]];
		}
	}
}

if(isset($_GET)){
	foreach($_GET as $n=>$v){
		if((!in_array($n,$we_reserved)) && (!in_array($n,$we_orderarray)) && (!is_array($v))){
			$output[$n] = $v;
		}
	}
}

if(isset($_POST)){
	foreach($_POST as $n=>$v){
		if((!in_array($n,$we_reserved)) && (!in_array($n,$we_orderarray)) && (!is_array($v))){
			$output[$n] = $v;
		}
	}
}

foreach($output as $n=>$v){
	if(is_array($v)){
		foreach($v as $n2=>$v2){
			if(!is_array($v2)){
				$foo = (get_magic_quotes_gpc() == 1) ? stripslashes($v2) : $v2;
				$n = replace_bad_str($n);
				$n2 = replace_bad_str($n2);
				$foo = replace_bad_str($foo);
				$we_txt .= "$n"."[".$n2."]: $foo\n".($foo ? "" : "\n");
				$we_html .= '<tr><td align="right"><b>'.$n.'['.$n2.']:</b></td><td>'.$foo.'</td></tr>
';
			}
		}
	}else{
			$foo = (get_magic_quotes_gpc() == 1) ? stripslashes($v) : $v;
			$n = replace_bad_str($n);
			$foo = replace_bad_str($foo);
			$we_txt .= "$n: $foo\n".($foo ? "" : "\n");
			if($n=="email"){
				$we_html .= '<tr><td align="right"><b>'.$n.':</b></td><td><a href="mailto:'.$foo.'">'.$foo.'</a></td></tr>
';
			}else{
				$we_html .= '<tr><td align="right"><b>'.$n.':</b></td><td>'.$foo.'</td></tr>
';
			}
	}
}

$we_html .= '</table>
';


$we_html_confirm = "";
$we_txt_confirm = "";

if(isset($_REQUEST["email"]) && $_REQUEST["email"]){
	if(isset($_REQUEST["confirm_mail"]) && $_REQUEST["confirm_mail"]){
		$we_html_confirm = $we_html;
		$we_txt_confirm = $we_txt;
		if(isset($_REQUEST["pre_confirm"]) && $_REQUEST["pre_confirm"]){
			contains_bad_str($_REQUEST["pre_confirm"]);
			$we_html_confirm = $_REQUEST["pre_confirm"] . "<br>" . $we_html_confirm;
			$we_txt_confirm = $_REQUEST["pre_confirm"] . "\n\n" . $we_txt_confirm;
		}
		if(isset($_REQUEST["post_confirm"]) && $_REQUEST["post_confirm"]){
			contains_bad_str($_REQUEST["post_confirm"]);
			$we_html_confirm = $we_html_confirm . "<br>" . $_REQUEST["post_confirm"];
			$we_txt_confirm = $we_txt_confirm . "\n\n" . $_REQUEST["post_confirm"];
		}
	}
}

$email = (isset($_REQUEST["email"]) && $_REQUEST["email"]) ?
			$_REQUEST["email"] :
			((isset($_REQUEST["from"]) && $_REQUEST["from"])  ?
				$_REQUEST["from"] :
				WE_DEFAULT_EMAIL);

$subject = (isset($_REQUEST["subject"]) && $_REQUEST["subject"]) ?
			$_REQUEST["subject"] :
			WE_DEFAULT_SUBJECT;

$charset = (isset($_REQUEST["charset"]) && $_REQUEST["charset"]) ?
			ereg_replace("[\r\n]","",$_REQUEST["charset"]) :
			$GLOBALS["_language"]["charset"];
$recipient = (isset($_REQUEST["recipient"]) && $_REQUEST["recipient"]) ?
			$_REQUEST["recipient"] :
			"";
$from = (isset($_REQUEST["from"]) && $_REQUEST["from"]) ?
			$_REQUEST["from"] :
			WE_DEFAULT_EMAIL;

$mimetype = (isset($_REQUEST["mimetype"]) && $_REQUEST["mimetype"]) ? $_REQUEST["mimetype"] : "";

$wasSent = false;

if($recipient){
    if (isset($_REQUEST['forcefrom']) && $_REQUEST['forcefrom'] == "true"){
        $fromMail = $from;
    } else {
        $fromMail = $email;
    }
    $subject = preg_replace("/(%0A|%0D|\\n+|\\r+)/i","",$subject);
	$charset = preg_replace("/(%0A|%0D|\\n+|\\r+)/i","",$charset);
	$fromMail = preg_replace("/(%0A|%0D|\\n+|\\r+)/i","",$fromMail);
	$email = preg_replace("/(%0A|%0D|\\n+|\\r+)/i","",$email);
	$from = preg_replace("/(%0A|%0D|\\n+|\\r+)/i","",$from);
	
	contains_bad_str($email);
	contains_bad_str($from);
	contains_bad_str($fromMail);
	contains_bad_str($subject);
	contains_bad_str($charset);

	if (!is_valid_email($fromMail)) {
		print_error($GLOBALS["l_global"]["email_invalid"]);
	}

	$recipients = makeArrayFromCSV($recipient);
	$senderForename = isset($_REQUEST['forename']) && $_REQUEST['forename'] !="" ? $_REQUEST['forename'] : "";
	$senderSurname  = isset($_REQUEST['surname'])  && $_REQUEST['surname']  !="" ? $_REQUEST['surname']  : "";
	if ($senderForename !="" || $senderSurname!="") {
		$sender = "$senderForename $senderSurname<$fromMail>";
	} else{
		$sender = $fromMail;
	}
	 
	$phpmail = new we_util_Mailer("",$subject,$sender);
	$phpmail->setCharSet($charset);
	
	$recipientsList = array();
	
	foreach($recipients as $recipientID){
		
		if (is_numeric($recipientID)) {
			$recipient = f("SELECT Email FROM " . RECIPIENTS_TABLE . " WHERE ID=" . abs($recipientID), "Email", $GLOBALS["DB_WE"]);
		} else {
			// backward compatible
			$recipient = $recipientID;
		}
		if (!$recipient) {
			print_error($GLOBALS["l_global"]["email_no_recipient"]);
		}
		if (!is_valid_email($recipient)) {
			print_error($GLOBALS["l_global"]["email_invalid"]);
		}

  		$recipient = preg_replace("/(%0A|%0D|\\n+|\\r+)/i","",$recipient);

		if(we_check_email($recipient) && check_recipient($recipient)){
			$recipientsList[] = $recipient;
		}else{
			print_error($GLOBALS["l_global"]["email_recipient_invalid"]);
		}
	}
	
	if (count($recipientsList)>0) {
		if(sizeof($_FILES)){
			foreach($_FILES as $name => $file){
				if(isset($file["tmp_name"]) && $file["tmp_name"]){
					$tempName = TMP_DIR."/".$file["name"];
					move_uploaded_file($file["tmp_name"],$tempName);
					$phpmail->AddAttachment($tempName);
				}
			}
		}
		$phpmail->addAddressList($recipientsList);
		if($mimetype == "text/html"){
			$phpmail->addHTMLPart($we_html);
		} else {
			$phpmail->addTextPart($we_txt);
		}
		$phpmail->buildMessage();
		if ($phpmail->Send()) {
			$wasSent = true;
		}	
		
	}
	
	
	
	if (!defined("FORMMAIL_CONFIRM") || FORMMAIL_CONFIRM) {
		if($wasSent){
			// validation
			if (!is_valid_email($email)) {
				print_error($GLOBALS["l_global"]["email_invalid"]);
			}
			$phpmail = new we_util_Mailer($email,$subject,$from);
			$phpmail->setCharSet($charset);
			if($mimetype == "text/html"){
				$phpmail->addHTMLPart($we_html_confirm);
			} else {
				$phpmail->addTextPart($we_txt_confirm);
			}
			$phpmail->buildMessage();
			$phpmail->Send();
		}
	}

}else{
	print_error($GLOBALS["l_global"]["email_no_recipient"]);
}

ok_page();

?>