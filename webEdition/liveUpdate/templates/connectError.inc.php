<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_update
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

$errorMessage = "";
if(isset($Response)) {
	$errorMessage .= str_replace("</body></html>","",stristr($Response,"<body>"));
}
$errorMessage .= "<div id=\"contentHeadlineDiv\" style=\"height: 30px; margin-top:30px; \">
			<b>".$GLOBALS['l_liveUpdate']['connect']["connectionInfo"]."<hr /></b>
			</div><br />";
$errorMessage .= "<li>".$GLOBALS['l_liveUpdate']['connect']["availableConnectionTypes"].": ";
	$errorMessage .= "<ul>";
	if(ini_get("allow_url_fopen") == "1") {
		$errorMessage .= "<li>fopen</li>";
	}
	if(is_callable("curl_exec")) {
		$errorMessage .= "<li>curl</li>";
	}
	$errorMessage .= "</ul>";
$errorMessage .= "<li>".$GLOBALS['l_liveUpdate']['connect']["connectionType"].": ";
if (isset($_SESSION['le_proxy_use']) && $_SESSION['le_proxy_use']=="1") {
	$errorMessage .= "Proxy (fsockopen)".
	"<ul>".
	"<li>".$GLOBALS['l_liveUpdate']['connect']["proxyHost"].": ".$_SESSION["le_proxy_host"]."</li>".
	"<li>".$GLOBALS['l_liveUpdate']['connect']["proxyPort"].": ".$_SESSION["le_proxy_port"]."</li>";
	if(is_callable("gethostbynamel") && is_callable("gethostbyaddr")) {
		if(preg_match("/(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)/",$_SESSION["le_proxy_host"])) {
			$errorMessage .= "<li>".$GLOBALS['l_liveUpdate']['connect']["ipResolutionTest"]." (IPv4 only): ";
			$hostName = gethostbyaddr((string)$_SESSION["le_proxy_host"]);
			if($hostName != $_SESSION["le_proxy_host"]) {
				$errorMessage .= "".$GLOBALS['l_liveUpdate']['connect']["succeeded"].".</li>".
				"<li>".$GLOBALS['l_liveUpdate']['connect']["hostName"].": ".$hostName."</li>";
			} else {
				$errorMessage .= "".$GLOBALS['l_liveUpdate']['connect']["failed"].".</li>";
			}
		}
		// gethostbyaddr currently does not support ipv6 address resolution
		/*
		else if(preg_match("/^([0-9A-Fa-f]{1,4}:){7}[0-9A-Fa-f]{1,4}$/",$_SESSION["le_proxy_host"])) {
			$errorMessage .= "<li>".$GLOBALS['l_liveUpdate']['connect']["ipResolutionTest"]." (IPv6): ";
			$hostName = gethostbyaddr($_SESSION["le_proxy_host"],DNS_AAAA);
			if($hostName != $_SESSION["le_proxy_host"]) {
				$errorMessage .= "".$GLOBALS['l_liveUpdate']['connect']["succeeded"].".</li>".
				"<li>".$GLOBALS['l_liveUpdate']['connect']["ipAddresses"].": ".$hostName."</li>";
			} else {
				$errorMessage .= "".$GLOBALS['l_liveUpdate']['connect']["failed"].".</li>";
			}
		}
		*/
		else {
			$errorMessage .= "<li>".$GLOBALS['l_liveUpdate']['connect']["dnsResolutionTest"].": ";
			if($ipAddr = gethostbynamel($_SESSION["le_proxy_host"])) {
				$errorMessage .= "".$GLOBALS['l_liveUpdate']['connect']["succeeded"].".</li>".
				"<li>".$GLOBALS['l_liveUpdate']['connect']["ipAddresses"].": ".implode(",",$ipAddr)."</li>";
			} else {
				$errorMessage .= "".$GLOBALS['l_liveUpdate']['connect']["failed"].".</li>";
			}
		}
	}
	$errorMessage .= "</ul>";
} else {
	$errorMessage .= liveUpdateHttp::getHttpOption();
}
$errorMessage .= "</li>";
$errorMessage .= "<li>".$GLOBALS['l_liveUpdate']['connect']["addressResolution"]." ".$GLOBALS['l_liveUpdate']['connect']["updateServer"].":</li>";
$errorMessage .= "<ul>";
$errorMessage .= "<li>".$GLOBALS['l_liveUpdate']['connect']["hostName"].": ".LIVEUPDATE_SERVER."</li>";
if(is_callable("gethostbynamel")) {
	$errorMessage .= "<li>".$GLOBALS['l_liveUpdate']['connect']["dnsResolutionTest"].": ";
	if($ipAddr = gethostbynamel(LIVEUPDATE_SERVER)) {
		$errorMessage .= "".$GLOBALS['l_liveUpdate']['connect']["succeeded"].".</li>".
		"<li>".$GLOBALS['l_liveUpdate']['connect']["ipAddresses"].": ".implode(",",$ipAddr)."</li>";
	} else {
		$errorMessage .= "".$GLOBALS['l_liveUpdate']['connect']["failed"].".</li>";
	}
	$errorMessage .= "</ul>";
}

$we_button = new we_button();

$content = '

<div class="defaultfont">
	' . $GLOBALS['l_liveUpdate']['connect']['connectionError'] . '
</div>
<script type="text/javascript">
	alert("' . $GLOBALS['l_liveUpdate']['connect']['connectionErrorJs'] . '");
</script>
'.$errorMessage;
				
print liveUpdateTemplates::getHtml($GLOBALS['l_liveUpdate']['connect']['headline'], $content);

?>