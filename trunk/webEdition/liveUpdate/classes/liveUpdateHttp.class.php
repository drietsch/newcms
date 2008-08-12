<?php

class liveUpdateHttp {

	function getServerProtocol($addslashes=true) {
		return getServerProtocol($addslashes);
	}

	function connectFopen($server, $url, $parameters=array()) {

		// try fopen first
		$parameterStr = '';
		foreach ($parameters as $key => $value) {
			$parameterStr .= "$key=" . urlencode($value) . "&";
		}

		$address = 'http://' . $server . $url . ($parameterStr ? "?$parameterStr" : '');
		$response = false;

		$fh = @fopen($address,"rb");
		if($fh) {
			$response = "";
			while(!feof($fh)) {
				$response .= fgets($fh, 1024);
			}
			fclose($fh);
		}
		return $response;
	}

	function connectProxy($server, $url, $parameters) {

		global $error;

		$proxyhost = defined("WE_PROXYHOST") ? WE_PROXYHOST : "";
		$proxyport = (defined("WE_PROXYPORT") && WE_PROXYPORT) ? WE_PROXYPORT : "80";
		$proxy_user = defined("WE_PROXYUSER") ? WE_PROXYUSER : "";
		$proxy_pass = defined("WE_PROXYPASSWORD") ? WE_PROXYPASSWORD : "";

		$response = @fsockopen($proxyhost, $proxyport, $errno, $errstr,20);

		if( !$response ){

			return false;

		}else{

			$parameterStr = '';
			foreach ($parameters as $key => $value) {
				$parameterStr .= "$key=" . urlencode($value) . "&";
			}

			$address = 'http://' . $server . $url . ($parameterStr ? "?$parameterStr" : '');

			$realm = base64_encode($proxy_user.":".$proxy_pass);

			// send headers
			fputs($response, "GET $address HTTP/1.0\r\n");
			//fputs($response, "Proxy-Connection: Keep-Alive\r\n");
			fputs($response, "User-Agent: PHP ".phpversion()."\r\n");
			fputs($response, "Pragma: no-cache\r\n");
			if($proxy_user!=""){
				fputs($response, "Proxy-authorization: Basic $realm\r\n");
			}
			fputs($response, "\r\n");

			$zeile = "";
			while(!feof($response)){
				$zeile =$zeile.fread($response,4096);
			}
			fclose($response);

			return substr($zeile,strpos($zeile,"\r\n\r\n")+4);
		}

	}

	function getCurlHttpResponse($server, $url, $parameters) {

		$_address = $server . $url;

		$_parameters = '';
		foreach ($parameters as $key => $value) {
			$_parameters .= "$key=" . urlencode($value) . "&";
		}

		$session = curl_init();
		curl_setopt($session,CURLOPT_URL,$_address);
		curl_setopt($session, CURLOPT_RETURNTRANSFER,1);

		if($_parameters!='') {
			curl_setopt($session, CURLOPT_POST, 1);
			curl_setopt($session,CURLOPT_POSTFIELDS, $_parameters);
		}

		if (defined('WE_PROXYHOST') && WE_PROXYHOST != '') {

			$_proxyhost = defined('WE_PROXYHOST') ? WE_PROXYHOST : '';
			$_proxyport = (defined('WE_PROXYPORT') && WE_PROXYPORT) ? WE_PROXYPORT : '80';
			$_proxy_user = defined('WE_PROXYUSER') ? WE_PROXYUSER : '';
			$_proxy_pass = defined('WE_PROXYPASSWORD') ? WE_PROXYPASSWORD : '';

			if($_proxyhost!='') {
				curl_setopt ($session, CURLOPT_PROXY, $_proxyhost . ":" . $_proxyport);
				if($_proxy_user!='') {
					curl_setopt($session, CURLOPT_PROXYUSERPWD, $_proxy_user . ':' . $_proxy_pass);
				}
				curl_setopt ($session, CURLOPT_SSL_VERIFYPEER, FALSE);
			}
		}

		$_data = curl_exec($session);

		curl_close($session);

		return $_data;

	}

	function getHttpOption() {
		if(ini_get('allow_url_fopen') != 1 && strtolower(ini_get('allow_url_fopen')) != "on"){
			@ini_set('allow_url_fopen', '1');
			if(ini_get('allow_url_fopen') != 1 && strtolower(ini_get('allow_url_fopen')) != "on"){
				if(function_exists('curl_init')) {
						return 'curl';
				} else {
					return 'none';
				}
			}
		}
		return 'fopen';
	}

	function getHttpResponse($server, $url, $parameters=array()) {

		$_opt = liveUpdateHttp::getHttpOption();

		if($_opt=='fopen') {
			return liveUpdateHttp::getFopenHttpResponse($server, $url, $parameters);
		} else if($_opt=='curl') {
			return liveUpdateHttp::getCurlHttpResponse($server, $url, $parameters);
		} else {
			return null; // return null otherwise php error
			return 'Server error: Unable to open URL (php configuration directive allow_url_fopen=Off)';
		}

	}

	function getFopenHttpResponse($server, $url, $parameters=array()) {

		if (defined("WE_PROXYHOST") && WE_PROXYHOST != "") {

			return liveUpdateHttp::connectProxy($server, $url, $parameters);
		}

		return liveUpdateHttp::connectFopen($server, $url, $parameters);
	}

	/**
	 * returns html page with formular to init session on the server
	 *
	 * @return unknown
	 */
	function getServerSessionForm() {

		$params = '';
		foreach ($GLOBALS['LU_Variables'] as $LU_name => $LU_value) {

			if (is_array($LU_value)) {
				$params .= "\t<input type=\"hidden\" name=\"$LU_name\" value=\"" . urlencode( serialize($LU_value) ) . "\" />\n";
			} else {
				$params .= "\t<input type=\"hidden\" name=\"$LU_name\" value=\"" . urlencode( $LU_value ) . "\" />\n";
			}
		}

		$html = '<html>
<head>
	' . LIVEUPDATE_CSS . '
<head>
<body onload="document.getElementById(\'liveUpdateForm\').submit();">
<form id="liveUpdateForm" action="' . 'http://' . LIVEUPDATE_SERVER . LIVEUPDATE_SERVER_SCRIPT . '" method="post">
	<input type="hidden" name="update_cmd" value="startSession" /><br />
	<input type="hidden" name="next_cmd" value="' . $_REQUEST['update_cmd'] . '" />
	<input type="hidden" name="detail" value="' . $_REQUEST['detail'] . '" />
	' . $params . '
</form>
</body>
</html>';

		return $html;
	}
}

?>