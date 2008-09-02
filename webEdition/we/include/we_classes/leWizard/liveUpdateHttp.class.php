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

		$fh = fopen($address,"rb");
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

		if(isset($_SESSION['le_proxy_use']) && $_SESSION['le_proxy_use']) {
			$proxyhost = $_SESSION['le_proxy_host'];
			$proxyport = (isset($_SESSION['le_proxy_port']) && $_SESSION['le_proxy_port']) ? $_SESSION['le_proxy_port'] : "80";
			$proxy_user = $_SESSION['le_proxy_username'];
			$proxy_pass = $_SESSION['le_proxy_password'];

		} else {
			$proxyhost = "";
			$proxyport = "80";
			$proxy_user = "";
			$proxy_pass = "";

		}

		$response = fsockopen($proxyhost, $proxyport, $errno, $errstr,30);

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
			fputs($response, "Proxy-Connection: Keep-Alive\r\n");
			fputs($response, "User-Agent: PHP ".phpversion()."\r\n");
			fputs($response, "Pragma: no-cache\r\n");
			if($proxy_user!=""){
				fputs($response, "Proxy-authorization: Basic $realm\r\n");
			}
			fputs($response, "\r\n");

			while(!feof($response)){
				$zeile =$zeile.fread($response,4096);
			}
			fclose($response);

			return substr($zeile,strpos($zeile,"\r\n\r\n")+4);
		}

	}

	function getHttpResponse($server, $url, $parameters=array()) {

		$_opt = liveUpdateHttp::getHttpOption();

		if($_opt=='fopen') {
			return liveUpdateHttp::getFopenHttpResponse($server, $url, $parameters);
		} else if($_opt=='curl') {
			return liveUpdateHttp::getCurlHttpResponse($server, $url, $parameters);
		} else {
			return 'Server error: Unable to open URL (php configuration directive allow_url_fopen=Off)';
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



		if(isset($_SESSION['le_proxy_use']) && $_SESSION['le_proxy_use']) {
			$_proxyhost = $_SESSION['le_proxy_host'];
			$_proxyport = (isset($_SESSION['le_proxy_port']) && $_SESSION['le_proxy_port']) ? $_SESSION['le_proxy_port'] : "80";
			$_proxy_user = $_SESSION['le_proxy_username'];
			$_proxy_pass = $_SESSION['le_proxy_password'];

			if($_proxyhost!='') {
				curl_setopt ($session, CURLOPT_HTTPPROXYTUNNEL, TRUE);
				curl_setopt ($session, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
				curl_setopt ($session, CURLOPT_PROXY, $proxyhost . ":" . $proxyport);
				if($proxy_user!='') {
					curl_setopt($session, CURLOPT_PROXYUSERPWD, $proxy_user . ':' . $proxy_pass);
				}
				curl_setopt ($session, CURLOPT_SSL_VERIFYPEER, FALSE);
			}

		}

		$_data = curl_exec($session);

		curl_close($session);

		return $_data;

	}

	function getHttpOption() {

		if(ini_get('allow_url_fopen') != 1){
			@ini_set('allow_url_fopen', '1');
			if(ini_get('allow_url_fopen') != 1){
				if(function_exists('curl_init')) {
						return 'curl';
				} else {
					return 'none';
				}
			}
		}
		return 'fopen';
	}

	function getFopenHttpResponse($server, $url, $parameters=array()) {

		if(isset($_SESSION['le_proxy_use']) && $_SESSION['le_proxy_use']) {
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
<head>
<body onload="document.getElementById(\'liveUpdateForm\').submit();">
<form id="liveUpdateForm" action="' . 'http://' . LE_ONLINE_INSTALLER_SERVER . LE_ONLINE_INSTALLER_SERVER_SCRIPT . '" method="post">
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