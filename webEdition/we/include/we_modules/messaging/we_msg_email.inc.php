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


include_once(WE_MESSAGING_MODULE_DIR . "we_msg_proto.inc.php");
include_once(WE_MESSAGING_MODULE_DIR . "messaging_std.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/messaging.inc.php");

/* messaging email send class */
class we_msg_email extends we_msg_proto {

    /*****************************************************************/
    /* Class Properties **********************************************/
    /*****************************************************************/

    /* Name of the class => important for reconstructing the class from outside the class */
    var $ClassName = 'we_msg_email';

    /* 0: send/receive */
    /* 1: send only    */
    var $msgclass_type = 1;

    /*****************************************************************/
    /* Class Methods *************************************************/
    /*****************************************************************/
    
    /* Constructor */
    function we_msg_email() {
	$this->Name = 'msg_email_' . md5(uniqid(rand()));
	$this->DB = new DB_WE();
    }

    function get_email_addr($userid) {
	$DB2 = new DB_WE();
	$DB2->query('SELECT Email FROM '.USER_TABLE.' WHERE ID=' . addslashes($userid) . ' LIMIT 1');
	$DB2->next_record();

	return $DB2->f('Email');
    }

    function rfc2047_encode($header) {
	if (!ereg('[����]', $header)) 
	    return $header;

	/* Quoted-Printable encoding (see RFC 2045) should be okay for iso-8859-1 */
	$charset = 'ISO-8859-1';
	$encoding = 'Q';

	$enc_header = "=?$charset?$encoding?";
	$chars = preg_split('//', $header, -1, PREG_SPLIT_NO_EMPTY);
	$pre_enc_len = strlen($enc_header);
	$ew_len = $pre_enc_len;
	foreach ($chars as $c) {
	    if ($ew_len >= 70) {
		/* PHP converts \n and \t into space characters, */
		/* thus making multi-line headers impossible. */
		$enc_header .= "?=\n\t=?$charset?$encoding?";
		$ew_len = $pre_enc_len;
	    }

	    $oc = ord($c);
	    if (($oc >= 33 && $oc <= 60) || ($oc >= 62 && $oc <= 126)) {
		$enc_header .= $c;
		$ew_len++;
	    } else {
		$enc_header .= sprintf("=%X", $oc);
		$ew_len += 3;
	    }

	}
	
	$enc_header .= "?=";
	
	return $enc_header;
    }

    function &send(&$rcpts, &$data) {
	$results = array();
	$results['err'] = array();
	$results['ok'] = array();
	$results['failed'] = array();

	$from = get_nameline($this->userid, 'email');
	$to = array_shift($rcpts);
	//$cc = join(',', $rcpts);

	if (we_mail($to, $data['subject'], $data['body'],$from)) {
	    $results['err'] = $l_messaging['error_occured'] . ': ' . $l_messaging['mail_not_sent'];
	    $results['failed'] = $rcpts;
	} else {
	    array_unshift($rcpts, $to);
	    $results['ok'] = $rcpts;
	}

	return $results;
    }
}

?>
